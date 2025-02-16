jQuery(function($) {

	var performRequest = function(container, url, data) {
		data.widgetCacheId = container.data('widgetCacheId');
		if (url.indexOf('widgetCacheId=') == -1) {
		} else {
			// Remove widget cache id from URL because it will be added to the query params
			url = url.replace(/\&?widgetCacheId=[a-zA-Z0-9]+\&?/, '');
			//data.widgetCacheId = null;
		}

		if (url.indexOf('backlink=') == -1) {

		} else {
			data.backlink = null;
		}

		container.addClass('cma-loading');
		container.append($('<div/>', {"class":"cma-loader"}));
		$.ajax({
			method: "GET",
			url: url,
			data: data,
			success: function(response) {
				container.html($(response).find('.cma-wrapper,.cma-widget-ajax').html());
				container.find('.cma-loader').remove();
				container.removeClass('cma-loading');
				initHandlers(container);
				history.pushState(null, '', url);
				initTinyMCE();
				if (container.data('scrollaftersearch') != '0') {
					$('html, body').animate({
						scrollTop: container.offset().top
					}, 1000);
				}
			}
		});
	};

	var initHandlers = function($container) {
		if (typeof CMA_script_init == 'function') CMA_script_init($);
		paginationHandlerInit($container);
		loadThreadHandlerInit($container);
		backlinkHandlerInit($container);
		jQuery(document).trigger('glossaryTooltipReady');
		$('body').trigger('CMA:initHandlers', [$container])
	};

	var initTinyMCE = function(container) {
		if (typeof tinyMCE == 'undefined') return;
		$(container).find('.cma-form-content[data-tinymce=1]').each(function() {
			var obj = $(this);
			var textarea = obj;
			var id = textarea.attr('id').replace(/\-[0-9]+$/, '');

			//wp.editor.remove( this.id );
			//wp.editor.initialize( this.id, { mediaButtons: true, tinymce: true, quicktags:true } );
			tinyMCE.init({
				mode : "textareas",
				selector: '#' + this.id,
				menubar: true,
				branding: false,
				setup : function(ed) {
					ed.onChange.add(function(ed, l) {
						obj.val(tinyMCE.activeEditor.getContent());
					});
				}
			});

		});
	};

	var paginationHandlerInit = function(container) {
		$('.cma-pagination a', container).click(function() {
			link = $(this);
			var url = '';

			// Needed for exclude empty parameters that brokes pagination on experts dashboard page
			var checkUrlValue = ['category', 'backlink'];
			for (var i = 0; i < checkUrlValue.length; i++){
				if (link.attr('href').includes(checkUrlValue[i]) && !link.attr('href').includes(checkUrlValue[i] + '=')) {
					url = link.attr('href').replace(checkUrlValue[i], '');
					break;
				}
				else {
					url = link.attr('href');
				}
			}
			performRequest(container, url, {});
			return false;
		});
	};

	var backlinkHandlerInit = function(container) {
		$('.cma-backlink', container).click(function() {
			var link = $(this);

			performRequest(container, link.attr('href'), {});
			return false;

			var widgetContainer = link.parents('.cma-questions-widget');
			var data = {};
			data.widgetCacheId = container.data('widgetCacheId');
			container.addClass('cma-loading');
			container.append($('<div/>', {"class":"cma-loader"}));
			$.ajax({
				method: "GET",
				url: link.attr('href'),
				data: data,
				success: function(response) {
					var code = $('<div>' + response +'</div>');
					widgetContainer.replaceWith(code.find('#content .cma-questions-widget'));
					container.removeClass('cma-loading');
					initHandlers(container);
				}
			});
			return false;
		});
	};

	var loadThreadHandlerInit = function(container) {
		$('.cma-thread-title a', container).click(function(e) {
			if(CMA_Variables.enableAjaxOnQuestion == 1) {
				// Allow to use middle-button to open thread in a new tab:
				if (e.which > 1 || e.shiftKey || e.altKey || e.metaKey || e.ctrlKey) return;

				e.preventDefault();
				e.stopPropagation();

				var link = $(this);
				var data = {};
				var commentsContainer = link.parents('#comments');
				if (commentsContainer.length > 0) {
					data.post_id = commentsContainer.data('postId');
				}

				var container2 = $('body').find('div.cma-widget-ajax');

				let foundContainer = [];
				// container2.each(function() {
				// 	if ($(this).find('form.cma-filter').length) {
				// 		foundContainer = $(this);
				// 		return false;
				// 	}
				// });
				container = $('body').find('.cma-wrapper,.cma-widget-ajax');
				if(foundContainer.length){
					loadThread(foundContainer, link.attr('href'), data);
				} else {
					loadThread(container, link.attr('href'), data);
				}
				return false; // prevent default
			} else {
				var link = $(this);
				window.open(link.attr('href'));
				return false;
			}
		});
		$('.cma-thread-orderby a, .cma-thread-orderby li', container).click(function(e) {
			// Allow to use middle-button to open thread in a new tab:
			if(CMA_Variables.enableAjaxOnFilters == 1) {
				if (e.which > 1 || e.shiftKey || e.altKey || e.metaKey || e.ctrlKey) return;

				e.preventDefault();
				e.stopPropagation();

				var link = $(this);
				var data = {};
				var commentsContainer = link.parents('#comments');
				if (commentsContainer.length > 0) {
					data.post_id = commentsContainer.data('postId');
				}
				loadThread(container , link.attr('href') , data);
				return false; // prevent default
			}
		});
	};

	var loadThread = function(container, url, data) {
		if (url.indexOf('widgetCacheId=') == -1) {
			data.widgetCacheId = container.data('widgetCacheId');
		} else {
			//url = url.replace(/widgetCacheId=[^\#\&]+/, '');
		}
		container.addClass('cma-loading');
		container.append($('<div/>', {"class":"cma-loader"}));
		$.ajax({
			method: "GET",
			url: url,
			data: data,
			success: function(response) {

				/*
				if($(response).find('textarea.wp-editor-area').length > 0) {
					var temptextarea = $(response).find('textarea.wp-editor-area');
					temptextarea.removeClass('wp-editor-area').addClass('cma-form-content').attr('data-tinymce', '1');
					//alert(temptextarea.parent().html());
					var temp = $(response);
					temp.find('div.wp-editor-wrap').replaceWith(temptextarea);
					container.html(temp);
				} else {
					container.html(response);
				}
				container.find('.quicktags-toolbar').remove();
				*/

				container.html($(response).find('.cma-wrapper,.cma-widget-ajax').html());

				initHandlers(container);
				container.removeClass('cma-loading');
				history.pushState(null, '', url);
				if (container.data('scrollaftersearch') != '0') {
					$('html, body').animate({
						scrollTop: container.offset().top
					}, 1000);
				}
			}
		});
	};

	$('.cma-questions-widget, .cma-wrapper').each(function() {
		initHandlers($(this));
	});


	$('body').on('submit', '#cma-thread-add', function() {
		$('.cma-form-summary-submit-button').prop('disabled', true);
	} );

});

CMA_Utils = {};

CMA_Utils.addSingleHandler = function(handlerName, selector, action, func) {
	jQuery(selector).each(function() {
		var obj = jQuery(this);
		if (obj.data(handlerName) != '1') {
			obj.data(handlerName, '1');
			obj.on(action, func);
		}
	});
};

CMA_script_init = function ($) {

	$.limitify = function() {
		if (typeof CMA_LIMITIFY == 'undefined') return;
		$('*[data-limitify]').filter(function() {
			return ($(this).attr('data-limitify') > 0 && !this.limitifyWorking);
		}).each(function() {
			this.limitifyWorking = true;
			var obj = $(this);
			var limit = obj.data('limitify');
			var tooltip = $(document.createElement('div'));
			tooltip.addClass('cma-limitify');
			obj.after(tooltip);

			var update = function() {
				var len = obj.val().length;
				if (len > limit) {
					obj.val(obj.val().substr(0, limit));
					len = limit;
				}
				tooltip.text(len +"/"+ limit);
			};
			update();
			obj.keyup(update);

			return this;
		});

	};

	$.limitify();

	CMA_Utils.addSingleHandler('cmaFilterHandler', 'form.cma-filter', 'submit', function(ev) {
		// Set form action to the chosen category (or subcategory) URL
		var form = $(this);
		var primarySelect = form.find('.cma-filter-category-primary');

		var secondaryCategoryUrl = form.find('.cma-filter-category-secondary').find(":selected").data('url');

		if (secondaryCategoryUrl) {

			form.attr('action', secondaryCategoryUrl);
		} else {
			var primaryCategoryUrl = form.find('.cma-filter-category-primary').find(":selected").data('url');

			if (primaryCategoryUrl) {
				form.attr('action', primaryCategoryUrl);
			} else {
				var categoryUrl = form.find('.cma-filter-category').find(':selected').data('url');
				if (categoryUrl) {
					form.attr('action', categoryUrl);
				}
			}
		}
	});

	var answersWidgetPaginationHandler = function() {
		var link = $(this);
		var container = link.parents('.cma-answers-widget');
		container.addClass('cma-loading');
		container.append($('<div/>', {"class":"cma-loader"}));
		$.ajax({
			url: this.href,
			success: function(response) {
				var html = $(response);
				container.find('.cma-loader').remove();
				container.removeClass('cma-loading');
				container.html(html.find('.cma-answers-widget').html());
				container.html(html.closest('.cma-answers-widget').html());
				container.find('.cma-pagination a').click(answersWidgetPaginationHandler);
			}
		});
		return false;
	};

	var answersPaginationHandler = function(e) {
		e.preventDefault();
		e.stopPropagation();

		// Add loader
		var link = $(this);
		var container = link.parents('.cma-thread-wrapper');

		container.addClass('cma-loading');
		container.append($('<div/>', {"class":"cma-loader"}));

		var $pagination = $('.cma-answers-pagination');
		var $currentSpan = $(this).parent().find('.current');
		var answersPerPost = $pagination.data('answersperpost');
		var questionId = $pagination.data('questionid');
		var pageNumber = '';
		var offset;
		var $link_to_change;

		if ( $.isNumeric($(this).text()) ) {

			handlePrevNextLogic($(this));

			pageNumber = $(this).text();
			$currentSpan.replaceWith($('<a class="page-numbers" href="#">' + $currentSpan.text() + '</a>'));

			$(this).replaceWith($('<span aria-selected="page" class="page-numbers current">' + this.innerHTML + '</span>'));

			// Count the query offset
			offset = pageNumber * answersPerPost - answersPerPost;
		} else {

			if ($(this).hasClass('next')) {
				$link_to_change = $currentSpan.next();
			} else {
				$link_to_change = $currentSpan.prev();
			}

			handlePrevNextLogic($link_to_change);

			pageNumber = $('.current').text();

			$currentSpan.replaceWith($('<a class="page-numbers" href="#">' + $currentSpan.text() + '</a>'));
			$link_to_change.replaceWith($('<span aria-selected="page" class="page-numbers current">' + $link_to_change.text() + '</span>'));

			if($(this).hasClass('next')) {
				pageNumber = parseInt(pageNumber) + 1;
			} else if($(this).hasClass('prev')) {
				pageNumber= parseInt(pageNumber) - 1;
			}

			// Count the query offset
			offset = pageNumber * answersPerPost - answersPerPost;
		}

		$.ajax({
			url: $pagination.data('ajaxurl'),
			method: "POST",
			data: {
				page: pageNumber,
				answersPerPost: answersPerPost,
				questionId: questionId,
				answersOffset: offset,
				action: 'cma_answers_pagination',
			},
			beforeSend: function( xhr ) {

			},
			success: function(response) {
				var html = $(response);
				container.find('.cma-loader').remove();
				container.removeClass('cma-loading');
				$('.cma-answers-list tbody').html(response.data);
				$('body').off('click', '.cma-answers-pagination a', answersPaginationHandler);
				$('body').on('click', '.cma-answers-pagination a', answersPaginationHandler);
			}
		});
		return false;
	};

	var handlePrevNextLogic = function($this) {

		var prevButton = '<a href="#" class="prev page-numbers">« Previous</a>';
		var nextButton = '<a href="#" class="next page-numbers">Next »</a>';
		var $wrapper = $('.cma-answers-pagination')

		if ($this.hasClass('prev') || $this.hasClass('next')) {
			$this = $(this).parent().find('.current');
		}

		// If last page
		if($this.next().hasClass('next')) {
			$this.next().remove();
		}

		// If first page
		if($this.prev().hasClass('prev')) {
			$this.prev().remove();
		}

		// Restore Next button
		if(!$('.cma-answers-pagination .next').length && $this.next().length) {
			$wrapper.append(nextButton);
		}

		// Restore Prev button
		if(!$('.cma-answers-pagination .prev').length && $this.prev().length) {
			$wrapper.prepend(prevButton);
		}
	}

	CMA_Utils.addSingleHandler('answersWidgetPaginationHandler', '.cma-answers-widget[data-ajax=1] .cma-pagination a', 'click', answersWidgetPaginationHandler);
	CMA_Utils.addSingleHandler('answersWidgetPaginationHandler', '.cma-answers-pagination a', 'click', answersPaginationHandler);

	var dragCounter = 0;
	$('.cma-file-upload').parents('form').on('dragenter', function(e) {
		e.stopPropagation();
		e.preventDefault();
		$(this).addClass('cma-dragover');
		dragCounter++;
	});

	$('.cma-file-upload').parents('form').on('dragleave', function(e) {
		e.stopPropagation();
		e.preventDefault();
		dragCounter--;
		if (dragCounter == 0) {
			$(this).removeClass('cma-dragover');
		}
	});

	$('.cma-question-table:not(.cma-count-view-sent)').each(function() {
		var obj = $(this);
		obj.addClass('cma-count-view-sent');
		$.post(obj.data('permalink'), {"cma-action":"count-view"}, function() {
			//console.log('count-view-ok');
		});
	});

};


jQuery(CMA_script_init);
