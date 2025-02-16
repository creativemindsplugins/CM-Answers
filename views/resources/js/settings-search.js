jQuery(function($) {
	
	var highlightTextInNode = function(node, text) {
//		console.log(node);
		if (!text || text.length == 0) return;
		if (!node) return;
		if (node.parentNode.nodeName == 'SPAN' && node.parentNode.className == 'cma-hl' || node.parentNode.nodeName == 'TEXTAREA') {
			return;
		}
		else if (node.nodeType == document.ELEMENT_NODE) {
			if (node.nodeName == 'SPAN' && node.className == 'cma-hl') {
				// do nothing
			}
			else for (var i=0; i<node.childNodes.length; i++) {
				highlightTextInNode(node.childNodes[i], text);
			}
		}
		else if (node.nodeType == document.TEXT_NODE) {
//			console.log(node.textContent);
			var pos = node.textContent.toLowerCase().indexOf(text.toLowerCase());
			if (pos > -1) {
//				console.log(node.textContent);
				var html = node.textContent.substr(0, pos) + '<span class="cma-hl">'
					+ node.textContent.substr(pos, text.length) + '</span>' + node.textContent.substr(pos+text.length, node.textContent.length);
				$(node).replaceWith(html);
			}
		}
	};
	var clearHighlight = function(node) {
		$(node).find('.cma-hl').each(function() {
			var text = $(this).text();
			var outerHTML = $(this).parent().html();
//			console.log(outerHTML);
			if (outerHTML) {
				outerHTML = outerHTML.replace(/<span class="cma-hl">(.+)<\/span>/g, text);
				$(this).parent().html(outerHTML);
			}
//			$(this).replaceWith(this.textContent);
		});
	};
	
	var settingsSearchTimeout = null;
	$('#cma_settings_search').keyup(function() {
		if (this.lastValue == this.value) return;
		this.lastValue = this.value;
		var input = $(this);
		clearTimeout(settingsSearchTimeout);
		settingsSearchTimeout = setTimeout(function() {
			clearHighlight(document.getElementById('cm-answers-settings-form'));
			highlightTextInNode(document.getElementById('cm-answers-settings-form'), input.val());
			runSettingsSearch(input);
		}, 500);
	});
	
	var runSettingsSearch = function(input) {
		
//		console.log(input.val());
		
		// Show or hide clear btn
		if (input.val().length == 0) {
			$('#cma_settings_search_clear').hide();
		} else {
			$('#cma_settings_search_clear').show();
		}
		// Search in rows
		$('#cm-answers-settings-form .cm-settings-row').each(function() {
			var row = $(this);
			if (input.val().length == 0 || this.textContent.toLowerCase().indexOf(input.val().toLowerCase()) > -1) {
//				console.log(row);
				row.show();
			} else {
				row.hide();
			}
		});
		// Hide sections
		$('#cm-answers-settings-form .cma-settings-section').each(function() {
			var section = $(this);
			if (input.val().length == 0 || this.textContent.toLowerCase().indexOf(input.val().toLowerCase()) > -1) {
				section.show();
				if (input.val().length > 0) {
					console.log('open')
					section.find('.cm-settings-collapse-container').show().removeClass('cm-settings-collapse-close').addClass('cm-settings-collapse-open');
					section.find('.cm-settings-collapse-btn .dashicons-arrow-right').removeClass('dashicons-arrow-right').addClass('dashicons-arrow-down');
				} else {
					console.log('close')
					section.find('.cm-settings-collapse-container').hide().removeClass('cm-settings-collapse-open').addClass('cm-settings-collapse-close');
					section.find('.cm-settings-collapse-btn.dashicons-arrow-down').removeClass('dashicons-arrow-down').addClass('dashicons-arrow-right');
				}
			} else {
				section.hide();
			}
		});
		// Hide tabs
		$('#cm-answers-settings-form .cma-tab-content').each(function() {
			var tab = $('#cma-tab-menu a[href="#'+ this.id +'"]');
			if (input.val().length == 0 || this.textContent.toLowerCase().indexOf(input.val().toLowerCase()) > -1) {
				tab.show();
			} else {
				tab.hide();
			}
		});
		if ($('#cma-tab-menu .ui-state-active a:visible').length == 0) {
			$('#cma-tab-menu li a:visible').first().click();
		}
	};
	$('#cma_settings_search_clear').click(function() {
		$('#cma_settings_search').val('');
		$('#cma_settings_search').trigger('keyup');
	});
	
	

	$('.cm-settings-collapse-btn').click(function(ev) {
		var time = 300;
		var btn = $(this);
		var content = btn.next();
		if (content.hasClass('cm-settings-collapse-open')) {
			btn.find('.dashicons').removeClass('dashicons-arrow-down').addClass('dashicons-arrow-right');
			content.slideUp(time, function() {
				content.removeClass('cm-settings-collapse-open');
				content.addClass('cm-settings-collapse-close');
			});
		} else {
			btn.find('.dashicons').removeClass('dashicons-arrow-right').addClass('dashicons-arrow-down');
			content.slideDown(time, function() {
				content.addClass('cm-settings-collapse-open');
				content.removeClass('cm-settings-collapse-close');
			});
		}
	});
	
	
	$('.cm-settings-collapse-toggle').click(function() {
		var container = $(this).parents('.cma-tab-content');
		if (container.find('.cm-settings-collapse-open').length == 0) {
			container.find('.cm-settings-collapse-btn').click();
		} else {
			container.find('.cm-settings-collapse-open').parents('.cma-settings-section').find('.cm-settings-collapse-btn').click();
		}
	});

	var $split_input = $('input[name="cma_split_between_admin_and_author"]');
	if ($split_input.length > 0 ){
		var value = parseInt($split_input.val());
		$('.admin-value').text(value);
		$('.author-value').text(100-value);
		
		$split_input.on('input', function(e){
			value = parseInt($(e.target).val());
			$('.admin-value').text(value);
			$('.author-value').text(100-value);
		});
	}
		
});
