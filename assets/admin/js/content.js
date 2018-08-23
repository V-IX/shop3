function rightHeight() {
	h = $(window).height() - $('.header').outerHeight() - $('.footer').outerHeight() - 30;
	if($('.left-side').height() > h) {
		h = $('.left-side').height()
	}
	$('.right-side-in').css('min-height', h);
}

$(window).load(function(){
	rightHeight()
})

$(window).resize(function(){
	rightHeight()
})

$(document).ready(function(){
	$('select.form-input').styler();
	
	$('[data-toggle="tooltip"], .tooltips').tooltip();
	
	$('input[type="checkbox"]').each(function(){
		$(this).wrap('<div class="checker '+$(this).attr('data-class')+'"></div>');
		$(this).after('<div class="checker-view"></div>');
	});
	
	$('input[type="radio"]').each(function(){
		$(this).wrap('<div class="radio '+$(this).attr('data-class')+'"></div>');
		$(this).after('<div class="radio-view"></div>');
	});
	
	$('.input-file .btn').click(function(e){
		e.preventDefault();
		$(this).closest('.input-file').find('input[type="file"]').click();
		return false;
	});
	
	$('.input-file input[type="file"]').change(function(){
		val = $(this).val().split("\\");
		$(this).closest('.input-file').find('.form-input').val(val[val.length-1]);
	});
	
	$('.note-close').click(function(){
		$(this).closest('.note').hide();
	});
	
	$('[data-toggle="translate_title"]').click(function(){
		$('[name="alias"]').val(translit($('[name="title"]').val(), true));
	});
	
	$('[data-toggle="copy_title"]').click(function(){
		$('[name="mTitle"]').val($('[name="title"]').val());
	});
	
	$('.tabs-list a').click(function(event){
		//event.preventDefault;
		t = $(this).attr('href');
		$(this).closest('.tabs-list').find('a').removeClass('active');
		$(this).addClass('active');
		$(t).fadeIn(300).siblings().hide();
		return;
	});
	
	hash = window.location.hash;
	if(hash.length)
	{
		$('[href="'+hash+'"]').click();
	}
	
	$('[data-input="int"]').bind("change keyup input click", function() {
		if (this.value.match(/[^0-9]/g)) {
			this.value = this.value.replace(/[^0-9]/g, '');
		}
	});
	
	$('[data-input="num"]').bind("change keyup input click", function() {
		if (this.value.match(/[^0-9.]/g)) {
			this.value = this.value.replace(/[^0-9]/g, '');
		}
	});
	
})


function translit(str, lower)
{
	// Символ, на который будут заменяться все спецсимволы
	var space = '-'; 
	// Берем значение из нужного поля и переводим в нижний регистр
	
	if(lower) str = str.toLowerCase();
		 
	// Массив для транслитерации
	var transl = {
		'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',  'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya', 'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'E', 'Ж': 'ZH',  'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C', 'Ч': 'CH', 'Ш': 'SH', 'Щ': 'SH', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'YU', 'Я': 'YA', ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space, '#': space, '$': space, '%': space, '^': space, '&': space, '*': space, '(': space, ')': space, '-': space, '\=': space, '+': space, '[': space, ']': space, '\\': space, '|': space, '/': space, '.': space, ',': space, '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space, '?': space, '<': space, '>': space, '№':	space, '»':	space, '«':	space
	}

	var result = '';
	var curent_sim = '';
					
	for(i=0; i < str.length; i++) {
		// Если символ найден в массиве то меняем его
		if(transl[str[i]] != undefined) {
			 if(curent_sim != transl[str[i]] || curent_sim != space){
				 result += transl[str[i]];
				 curent_sim = transl[str[i]];
															}                                                                             
		}
		// Если нет, то оставляем так как есть
		else {
			result += str[i];
			curent_sim = str[i];
		}                              
	}          
					
	result = TrimStr(result);               
					
	// Выводим результат 
	return result;
    
}

function TrimStr(s) {
    s = s.replace(/^-/, '');
    return s.replace(/-$/, '');
}