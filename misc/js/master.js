/** master js file **/

$(document).ready(function() {

});

// configure dropzone -> http://www.dropzonejs.com
Dropzone.options.dropzoneForm = {
	paramName: "file",
	maxFiles: 1,
	maxFilesize: 200, // MB
	accept: function(file, done) {
		if (file.name === "justinbieber.jpg") {
			done("Naha, you don't.");
		} else {
			done();
		}
	}
};