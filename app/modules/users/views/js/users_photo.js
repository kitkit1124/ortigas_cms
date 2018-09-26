$(function() {
	// Dropzone.autoDiscover = false;
	$("#dropzone").dropzone({
		maxFiles: 1,
	}).on("complete", function(file) {
		console.log(file);
		if (file.xhr.responseText){
			var error = file.xhr.responseText;
			alert(error.replace(/(<([^>]+)>)/ig,""))
		}
	});
});