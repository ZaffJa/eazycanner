function hideMetaboxes() {
	var format = jQuery('#post-formats-select input:checked').val();
	jQuery('div[id^="post_format_metabox_"]').hide();
	jQuery('div[id^="post_format_metabox_"][id*="' + format + '"]').show();
}
function printValue(name){
	var val = jQuery('input[type="range"][name="'+ name +'"]').val();
	jQuery('input[type="text"][name="'+ name +'"]').val(val);
}
jQuery(function($){
    "use strict";
	jQuery(document).ready(function($) {
		jQuery('input[type="range"]').trigger('change');
		hideMetaboxes();
		jQuery('#post-formats-select input').click(function() {
			hideMetaboxes();
		});
		jQuery('body').on('click', '.tlg-icons i', function() {
			jQuery('.tlg-icons i').removeClass('active');
			jQuery(this).addClass('active').parents('.tlg-icons').find('input').attr('value', jQuery(this).attr('data-icon-class'));
			jQuery(jQuery(this).attr('data-icon-input')).attr('value', jQuery(this).attr('data-icon-class'));
		});
		jQuery('body').on('click', '.tlg-icon-trigger', function() {
			jQuery(jQuery(this).attr('data-target')).toggleClass('active');
			return false;
		});
		jQuery('body').on('click', '.tlg-icon-clear', function() {
			jQuery(jQuery(this).attr('data-target')).attr('value', '');
			return false;
		});
	});
});