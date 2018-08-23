$(document).ready(function(){
	
	$('[data-toggle="popup"]').click(function(e){
		t = $(this).attr('data-task');
		$('#popupTask').val(t);
		
		$('#feedback').bPopup({
			zIndex: 998,
			modalClose: true,
			closeClass: 'close',
		});
	});
	
	$('[data-toggle="order"]').click(function(e){
		t = $(this).attr('data-task');
		$('#orderTask').val(t);
		
		$('#order').bPopup({
			zIndex: 998,
			modalClose: true,
			closeClass: 'close',
		});
	});
	
	$('[data-toggle="ajaxForm"]').submit(function(e){
		e.preventDefault();
		obj = $(this);
		
		if(obj.attr('data-thanks')) thanks = obj.attr('data-thanks');
		else thanks = '#thanks';
		
		er = 0;
		$(this).find('[data-rules="required"]').each(function(){
			v = $.trim($(this).val());
			$(this).val(v);
			if($(this).val() == ""){
				$(this).addClass('input-error');
				er = 1;
			}
		});
		
		$(this).find('[data-input="email"]').each(function(){
			
			v = $.trim($(this).val());
			$(this).val(v);
			var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
			if($(this).val() != "" && !pattern.test($(this).val())){
				$(this).addClass('input-error');
				er = 1;
			}
		});
		
		if(er == 0)
		{
			action = $(this).attr('action');
			data = $(this).serialize();
			$.post(action, data, function(){
				$('.close').click();
				obj.find('.form-input').val('');
				
				$(thanks).bPopup({
					zIndex: 998,
					modalClose: true,
					closeClass: 'close',
				});
			})
		}
		
		return false;
	});
	
	$('[data-rules="required"]').change(function(){
		$(this).removeClass('input-error');
	});
	
	$('[data-input="email"]').change(function(){
		var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		if(pattern.test($(this).val())){
			$(this).removeClass('input-error');
		}
	});
	
	$('[data-input="num"]').bind("change keyup input click", function() {
		if (this.value.match(/[^0-9]/g)) {
			this.value = this.value.replace(/[^0-9]/g, '');
		}
	});
	
	$('[data-input="text"]').bind("change keyup input click", function() {
		if (this.value.match(/[^a-zA-Zа-яА-ЯёЁ .]/g)) {
			this.value = this.value.replace(/[^a-zA-Zа-яА-ЯёЁ .]/g, '');
		}
	});
	
	$('[name="phone"]').mask('+375 (99) 999-99-99');
	
	
});