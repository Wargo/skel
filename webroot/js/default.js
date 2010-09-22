;(function($) {
/**
 * Global app object
 */
	APP = (typeof APP == "undefined" ? {} : APP);

	$('div.message').each(function() {
		var message = {};
		var _this = $(this);

		var text = _this.text();
		message['title'] = text;
		message['text'] = ' ';
		message['class_name'] = _this.attr('class');
		$.gritter.add(message);
		_this.remove();
	});

/**
 * For anything that needs to wait for document ready
 */
	$(function() {
	});
})(jQuery);