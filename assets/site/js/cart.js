$(document).on('click', '[data-toggle="add2cart"]', function(event) {
	event.preventDefault();
	el = $(this);
	add2cart(el);
	return false;
});

$(document).on('click', '[data-cart-direction]', function() {
	var rowid    = $(this).closest('[data-cart-rowid]').attr('data-cart-rowid');
	var quantity = parseInt($(this).closest('[data-cart-rowid]').find('[data-toggle="cart-input"]').val());
	dir = parseInt($(this).attr('data-cart-direction'));
	quantity = quantity + dir;
	updateCart(rowid, quantity);
});

$(document).on('change', '._change', function() {
	this.value = this.value.replace(/[^0-9\.]/g,''); 
	var rowid    = $(this).closest('[data-cart-rowid]').attr('data-cart-rowid');
	var quantity = $(this).val();
	updateCart(rowid, quantity);
});

$(document).on('click', '[data-cart="remove"]', function() {
	var rowid = $(this).closest('[data-cart-rowid]').attr('data-cart-rowid');
	removeFromCart(rowid);
});


function add2cart(obj) {
	
	id = obj.attr('data-cart-id');
	
	mod = obj.attr('data-cart-mod')
	mod = ( mod !== undefined && mod !== false) ? mod : 0;
	
	qty = obj.attr('data-cart-qty')
	qty = ( qty !== undefined && qty !== false) ? qty : 1;
	
	if(qty < 1)
	{
		alert('Ошибка сервера!');
		return false;
	}
	
	$.ajax({
		type  : "POST",
		url   : base_url + 'cart/ajaxAddToCart',
		data  : {
			csrf_test_name 	: csrf_test_name,
			idProduct      	: id,
			quantity       	: qty,
			mod				: mod
		},
		cashe : false,
		async : false,
		error : function () {
			alert('Ошибка запроса');
		},
		success : function(data) {
			if (data.error) {
				alert ('Ошибка! Обновите страницу и попробуйте ещё раз');
			}
			updateInTotal(data);
			$('.popup._cart').bPopup({
				zIndex: 998,
				modalClose: true,
				closeClass: '_close'
			});
		},
	});  
	return false;   
}

function updateCart(rowid, quantity) {
	
	delivery_check = $('[name="delivery"]:checked').size();
	delivery = delivery_check != 0 ? $('[name="delivery"]:checked').val() : false;
	
	$.ajax({
		type  : "POST",
		url   : base_url + 'cart/ajaxUpdateCart',
		data  : {
			csrf_test_name	: csrf_test_name,
			quantity      	: quantity,
			rowid         	: rowid,
			delivery		: delivery
		},
		cashe : false,
		async : false,
		error : function () {
			alert('Ошибка запроса');
		},
		success : function(data) {
			if (data.error) {
				alert ('Ошибка! Обновите страницу и попробуйте ещё раз');
				return false;
			}
			if (data.content) {
				$("[data-cart-rowid=" + rowid +"]").replaceWith(data.content);
				//$("[data-cart-rowid=" + rowid +"]").replaceWith($( "#productTemplate" ).tmpl( data.product ));
			}
			else if (data.deleted) {
				$("[data-cart-rowid=" + rowid +"]").remove();
			}
			updateInTotal(data);
		},
	});      
}

function removeFromCart(rowid) {
	
	delivery_check = $('[name="delivery"]:checked').size();
	delivery = delivery_check != 0 ? $('[name="delivery"]:checked').val() : false;
	
	$.ajax({
		type  : "POST",
		url   : base_url + 'cart/ajaxUpdateCart',
		data  : {
			csrf_test_name	: csrf_test_name,
			quantity      	: 0,
			rowid         	: rowid,
			delivery		: delivery
		},
		cashe : false,
		async : false,
		error : function () {
			alert('Ошибка запроса');
		},
		success : function(data) {
			if (data.error) {
				alert ('Ошибка! Обновите страницу и попробуйте ещё раз');
				return false;
			}
			
			if (data.deleted) {
				$("[data-cart-rowid=" + rowid +"]").remove();
			}
			updateInTotal(data);
		},
	});      
}

function updateInTotal(data) {
	$('[data-cart="total_items"]').text(data.inTotalQuantity);
	if(data.inTotalQuantity == 0)
	{
		$('.minicart').addClass('_empty');
		$('.cart-form').after('<div class="note">В корзине нет товаров. <a href="' + base_url + 'catalog">Перейти в каталог</a>.</div>').remove();
	} else {
		$('.minicart').removeClass('_empty');
	}
	$('[data-cart="total_price"]').html(data.inTotalPrice);
	$('[data-cart="total_delivery"]').html(data.inTotalDelivery);
	$('[data-cart="total"]').html(data.inTotal);
	
	
	$('[data-cart="link"]').attr('href', data.url);
	$('[data-cart="img"]').attr('src', data.img);
	$('[data-cart="title"]').text(data.title);
	$('[data-cart="qty"]').text(data.qty);
	$('[data-cart="item_total"]').text(data.item_total);
	$('#cartTask').val('Заказ товара: ' + data.title);
}