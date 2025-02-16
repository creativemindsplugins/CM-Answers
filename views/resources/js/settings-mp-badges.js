jQuery(function($) {
	
	$('.cma-mp-badges-list .cma-mp-badge-add a').click(function(ev) {
		ev.stopPropagation();
		ev.preventDefault();
		var btn = $(this);
		var list = btn.parents('.cma-mp-badges-list');
		var maxBadgeItem = list.find('.cma-mp-badge-item').last();
		var item = list.find('.cma-mp-badge-item[data-badge=1]').clone(true);
		btn.parents('.cma-mp-badge-add').before(item);
		var nextBadge = parseInt(maxBadgeItem.attr('data-badge')) + 1;
		item.attr('data-badge', nextBadge);
		item.find('span').text(nextBadge);
		item.find('input[name*=points]').val(parseInt(maxBadgeItem.find('input[name*=points]').val())+1);
		item.find('input[name*=title]').val('Badge '+ nextBadge);
		item.find('input[name*=image]').val('');
		item.find('img').hide();
	});
	
	
	$('.cma-mp-badges-list .cma-mp-badge-remove').click(function(ev) {
		ev.stopPropagation();
		ev.preventDefault();
		var btn = $(this);
		var item = btn.parents('.cma-mp-badge-item');
		item.remove();
	});
	
	
	jQuery('.cma-mp-badge-upload').click(function() {
		
		var btn = $(this);
		var item = btn.parents('.cma-mp-badge-item');
		
//		 formfield = jQuery('#upload_default_screenshot').attr('name');
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 
		 window.send_to_editor = function(html) {
				var match = html.match(/<img.+src="([^"]+)"/);
				if (match && typeof match[1] == 'string') {
					imgurl = match[1];
					// var imgurl = jQuery('img',html).attr('src');
					item.find('input[name*=image]').val(imgurl);
//					jQuery('#upload_default_screenshot').val(imgurl);
					var img = item.find('img');
					if (img.length == 0) {
						var img = $('<img />');
						item.find('li[data-field=image]').append(img);
					}
					img.attr('src', imgurl);
					tb_remove();
				}
			}
		 
		 return false;
		});
		
		
	
});
