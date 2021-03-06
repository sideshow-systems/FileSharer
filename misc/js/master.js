/** master js file **/

$(document).ready(function() {

});

var maxFiles = 25;
var maxFilesizeInMb = 200;

// configure dropzone -> http://www.dropzonejs.com
Dropzone.options.dropzoneForm = {
	paramName: "file",
	maxFiles: maxFiles,
	maxFilesize: maxFilesizeInMb, // MB
	addRemoveLinks: false,
	uploadMultiple: true,
	parallelUploads: maxFiles,
	init: function() {
		// success handler
		this.on('success', function(file, responseText) {
			var $viewBox = $('#url_viewbox');
			$viewBox.find('.hl').html(responseText).selectText();
			$viewBox.fadeIn(200);
		});

		// error handler
		this.on('error', function(file, errorMessage) {
			var $viewBox = $('#error_viewbox');
			$viewBox.find('.info').html(errorMessage);
			$viewBox.fadeIn(200);
		});

		// remove all files except first one
		this.on('maxfilesexceeded', function(file) {
			this.removeFile(file);
		});

		// hide notify boxes
		this.on('processing', function(file) {
			$('.notify').fadeOut(200);
		});
		
		this.on('processingmultiple', function() {
			//console.log(arguments);
		});
	},
	accept: function(file, done) {
		done();
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