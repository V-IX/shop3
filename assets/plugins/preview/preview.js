document.getElementById('upload-file').addEventListener('change', function() {
	var file;
	for(var x = 0, xlen = this.files.length; x < xlen; x++) {
		file = this.files[x];
		if(file.type.indexOf('image') != -1) {

			var reader = new FileReader();

			reader.onload = function(e) {
				$('#preview').css({'background-image' : 'url('+e.target.result+')'});
			};
			
			reader.readAsDataURL(file);
		}
	}
});