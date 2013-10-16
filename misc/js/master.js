/** master js file **/

$(document).ready(function() {

});

// configure dropzone -> http://www.dropzonejs.com
Dropzone.options.dropzoneForm = {
	paramName: "file",
	maxFiles: 1,
	maxFilesize: 200, // MB
	init: function() {
		// TODO: event listener to show generated file url
		this.on('complete', function(file) {
			console.log(file);
			//alert("File transfer is complete. Your url is http://tiny.bla.com/?123adsfasdf");
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