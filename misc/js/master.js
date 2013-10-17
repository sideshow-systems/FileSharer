/** master js file **/

$(document).ready(function() {

});

// configure dropzone -> http://www.dropzonejs.com
Dropzone.options.dropzoneForm = {
	paramName: "file",
	maxFiles: 1,
	maxFilesize: 200, // MB
	init: function() {
		this.on('success', function(file, responseText) {
			var $viewBox = $('#url_viewbox');
			$viewBox.find('.url_val').html(responseText).selectText();
			$viewBox.fadeIn(200);
		});
	},
	accept: function(file, done) {
		if (file.name === "justinbieber.jpg") {
			done("Naha, you don't.");
		} else {
			done();
		}
	}
};



// http://stackoverflow.com/questions/9975707/use-jquery-select-to-select-contents-of-a-div
jQuery.fn.selectText = function(){
	this.find('input').each(function() {
		if($(this).prev().length === 0 || !$(this).prev().hasClass('p_copy')) {
			$('<p class="p_copy" style="position: absolute; z-index: -1;"></p>').insertBefore($(this));
		}
		$(this).prev().html($(this).val());
	});
	var doc = document;
	var element = this[0];
	if (doc.body.createTextRange) {
		var range = document.body.createTextRange();
		range.moveToElementText(element);
		range.select();
	} else if (window.getSelection) {
		var selection = window.getSelection();
		var range = document.createRange();
		range.selectNodeContents(element);
		selection.removeAllRanges();
		selection.addRange(range);
	}
};