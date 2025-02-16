(function($) {

  const ajaxRequest = function(request, callback) {
    $.ajax(request.url, {
      type: request.type,
      data: request.data,
      success: callback,
    });
  };

  const object2url = function(obj) {
    var url = '';
    for (var name in obj) {
      if (obj.hasOwnProperty(name)) {
        if (url.length > 0) url += '&';
        url += encodeURIComponent(name) + '=' + encodeURIComponent(obj[name]);
      }
    }
    return url;
  };

  const combineUrlWithData = function(request) {
    var url = request.url;
    if (typeof (request.type) == 'undefined' || request.type.toLowerCase() == 'get') {
      if (typeof (request.data) != 'undefined') {
        url += (url.indexOf('?') >= 0 ? '&' : '?');
        url += object2url(request.data);
      }
    }
    return url;
  };

  const pushState = function(request, wrapper) {
    var url = combineUrlWithData(request);
    var stateObj = {wrapperId: wrapper.attr('id'), currentUrl: location.href, newUrl: url, request: request};
    history.pushState(stateObj, url, url);
  };

  const loadContent = function(request, wrapper, preventPushState, backurl) {
    if (!preventPushState) pushState(request, wrapper);
    createLoader(wrapper);
    ajaxRequest(request, function(response) {
      response = $(response);
      $.getScript('https://platform.linkedin.com/in.js');
      $.getScript('https://platform.twitter.com/widgets.js');
      var responseWrapper = response.find('.cma-questions-widget.cma-main-query, .cma-thread-wrapper');

      if ($(responseWrapper.html()).find('textarea.wp-editor-area').length > 0) {
        var temptextarea = $(responseWrapper.html()).find('textarea.wp-editor-area');
        temptextarea.removeClass('wp-editor-area').addClass('cma-form-content').attr('data-tinymce', '1');
        //alert(temptextarea.parent().html());
        var temp = $(responseWrapper.html());
        temp.find('div.wp-editor-wrap').replaceWith(temptextarea);
        wrapper.html(temp);
      } else {
        wrapper.html(responseWrapper.html());
      }
      wrapper.find('.quicktags-toolbar').remove();
      $('.cma-loader').remove();

      if (backurl != '') {
        wrapper.find('a.cma-backlink').attr('href', backurl);
      }
      if (typeof CMA_script_init == 'function') {
        CMA_script_init($);
      }

      wrapper.trigger('CMA.initHandlers');

      if (typeof tinyMCE == 'undefined') return;
      $(wrapper).find('.cma-form-content[data-tinymce=1]').each(function() {
        const obj = $(this);
        tinyMCE.init({
          mode: 'textareas',
          selector: '#' + this.id,
          menubar: true,
          branding: false,
          setup: function(ed) {
            ed.onChange.add(function(ed, l) {
              obj.val(tinyMCE.activeEditor.getContent());
            });
          },
        });
      });

    });
  };

  const stopEvent = function(ev) {
    ev.stopPropagation();
    ev.preventDefault();
  };

  const createLoader = function(wrapper) {
    const loader = $('<div>', {'class': 'cma-loader'});
    wrapper.append(loader);
    wrapper.addClass('cma-loading');
  };

  const createRequestDataObject = function(form) {
    let data = {};
    const inputs = form.find('input[name], select[name], textarea[name]');
    let input;
    for (let i = 0; i < inputs.length; i++) {
      input = $(inputs[i]);
      data[input.attr('name')] = input.val();
    }
    return data;
  };

  const initHandlers = function(event, $wrapper) {
    if (!$wrapper.hasClass('cma-questions-widget')) {
      $wrapper = $('.cma-questions-widget', $wrapper);
    }

    const handleFormSubmit = function(ev) {
      stopEvent(ev);
      const form = $(this);
      createLoader($wrapper);
      const data = createRequestDataObject(form);
      const callurl = form.attr('action');

      loadContent({url: callurl, type: form.attr('method'), data: data},
          $wrapper, false, '');
    };

    if (CMAVariables.enableAjaxOnFilters == '1') {
      $('.cma-filter', $wrapper).submit(handleFormSubmit);
    }
  };

  $('body').on('CMA.initHandlers', initHandlers);

  $(window).on('popstate', function(event) {
    // console.log('CMA.popstate', location.href, event.originalEvent.state, event);
    var state = event.originalEvent.state;
    if (!state) {
      loadContent({url: location.href}, $('.cma-questions-widget.cma-main-query'), preventPushState = true, '');
    } else {
      loadContent({url: location.href}, $('#' + state.wrapperId), preventPushState = true, '');
    }
  });

  $('body').trigger('CMA.initHandlers', [$('body')]);

})(jQuery);
