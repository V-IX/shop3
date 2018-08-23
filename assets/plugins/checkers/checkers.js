$(window).load(function(){
	
	$('input[type="checkbox"]').each(function(){
		if(!$(this).attr('data-toggle'))
		{
			c = '';
			if($(this).attr('data-class')) c = ' ' + $(this).attr('data-class');
			
			$(this).wrap('<div class="checker' + c + '"></div>');
			$(this).after('<div class="checker-view"></div>');
		}
	});
	
	$('input[type="radio"]').each(function(){
		if(!$(this).attr('data-toggle'))
		{
			c = '';
			if($(this).attr('data-class')) c = $(this).attr('data-class');
			
			$(this).wrap('<div class="radio ' + c + '"></div>');
			$(this).after('<div class="radio-view"></div>');
		}
	});
});