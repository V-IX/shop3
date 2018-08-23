$(document).ready(function(){
	$('[data-css]').bind("change keyup input click", function() {
		if ($(this).val().match(/[^0-9]/g)) {
			value = $(this).val().replace(/[^0-9]/g, '');
			$(this).val(value);
		}
		
		t = $(this).attr('data-target');
		css = $(this).attr('data-css');
		$(t).css(css, $(this).val() + 'px');
	});
	
	$('[data-togglecss]').bind("click", function() {
		//alert('1');
		if($(this).hasClass('_active'))
		{
			attr = 'data-default';
			$(this).removeClass('_active');
		} else {
			attr = 'data-value';
			$(this).addClass('_active');
		}
		
		t = $(this).attr('data-target');
		css = $(this).attr('data-togglecss');
		val = $(this).attr(attr);
		
		if(t == '#slideTitle') $('[name="title_css['+css+']"]').val(val);
		if(t == '#slideText') $('[name="text_css['+css+']"]').val(val);
		
		//alert(val);
		$(t).css(css, val);
	});
	
	$('[data-html]').bind("change keyup input click", function() {
		target = $(this).attr('data-html');
		insert = $(this).val();
		if(target == 'text') insert = insert.replace(/\n/g, "<br />");
		$('.scontent .' + target).html(insert);
	});
	
	$('[data-check]').change(function(){
		target = $(this).attr('data-check');
		if($(this).prop("checked")) $('.'+target).show();
		else $('.'+target).hide();
	});
	
});
	
document.getElementById('upload-file').addEventListener('change', function() {
	var file;

	// Looping in case they uploaded multiple files
	for(var x = 0, xlen = this.files.length; x < xlen; x++) {
		file = this.files[x];
		if(file.type.indexOf('image') != -1) { // Very primitive "validation"

			var reader = new FileReader();

			reader.onload = function(e) {
				//var img = new Image();
				//img.src = e.target.result; // File contents here
				
				$('.slide').css({'background-image' : 'url('+e.target.result+')'});
				
				//destination.appendChild(img);
			};
			
			reader.readAsDataURL(file);
		}
	}
});