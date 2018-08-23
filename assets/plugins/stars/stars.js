$(window).load(function(){
	$('[data-toggle="stars"]').each(function(){
		el = $(this);
		def = el.attr('data-default');
		el.addClass('stars-select');
		for(i = 1; i < 6; i++)
		{
			if(i <= def)
			{
				active = 'active';
			} else {
				active = "";
			};
			$('[data-toggle="stars"]').append('<div class="star ' + active + '" data-toggle="star"></div>');
		}
		$('[data-toggle="stars"]').append('<input type="hidden" name="stars" value="' + def + '" />');
	});
	
	$('[data-toggle="star"]').click(function(){
		eq = $(this).index();
		for(i = eq; i < 5; i++)
		{
			$('[data-toggle="star"]').eq(i).removeClass('active');
		}
		for(j = 0; j < eq + 1; j++)
		{
			$('[data-toggle="star"]').eq(j).addClass('active');
		}
		$('[name="stars"]').val(eq + 1);
	})
	
})