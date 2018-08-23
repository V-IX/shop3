$(document).ready(function(){
	
	var tabs = '[data-toggle="tabs"]',
		tabsList = '[data-tabs="list"]',
		tabsItem = '[data-tabs="item"]';
		
	$(tabsList + ' a').click(function(event){
		event.preventDefault();
		
		el = $(this);
		if(el.hasClass('active')) return false;
		
		id = el.attr('href');
		par = el.closest(tabs);
		list = el.closest(tabsList);
		
		list.find('a').removeClass('active');
		el.addClass('active');
		
		par.find(tabsItem).hide();
		$(id).fadeIn(500);
		
		return false;
	});
	
	//--------------------------------------------------------
	
	$('.catalog-item').click(function(event){
		//if ($(event.target).closest('[data-toggle]').length) return false;
	});
	
	$('[data-hreftab]').click(function(){
		el = $(this);
		href = el.attr('data-hreftab');
		target = 'a[href="' + href + '"]';
		$(target).click();
		$('html,body').animate({scrollTop: $(target).offset().top - 50}, 500);
	});
	
	$('.cmenu-btn').click(function(){
		el = $('.cmenu');
		if(el.hasClass('_open')) el.removeClass('_open');
		else el.addClass('_open');
	});
	
	$('.filter-btn').click(function(){
		el = $('.filter-form');
		if(el.hasClass('_open')) el.removeClass('_open');
		else el.addClass('_open');
	});
	
	$('.header-center-btn').click(function(){
		$(this).remove();
		$('.header-center .cols').fadeIn(300);
	});
	
	//--------------------------------------------------------
	
	$('.tmenu-btn').click(function(){
		el = $('.tmenu');
		if(el.hasClass('_open')) el.removeClass('_open');
		else el.addClass('_open');
	});
	
	$('.tmenu .toggle').click(function(event){
		event.preventDefault();
		el = $(this).closest('li');
		if(el.hasClass('_open')) el.removeClass('_open');
		else el.addClass('_open');
		
		return false;
	});
	
	$(document).click(function(event) {
		
		if ($(event.target).closest('.tmenu').length) return;
		$('.tmenu, .tmenu-list > li').removeClass('_open');
		event.stopPropagation();
	});
	
});