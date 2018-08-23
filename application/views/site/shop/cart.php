<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageinfo['title'];?></span></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
	<? if(empty($items)) { ?>
		<?=action_result('info', 'В корзине нет товаров. ' . anchor('catalog', 'Перейти в каталог') . '.');?>
	<? } else { ?>
		<?=form_open('', array('class' => 'cart-form clearfix'));?>
			<div class="cart-left">
				<div class="cart-panels">
					<ul class="cart-panels-list">
						<li>
							<div class="cart-panels-item">
								<div class="cart-panels-title">Персональные данные</div>
								<div class="form-group">
									<div class="caption">Ф.И.О.</div>
									<input type="text" name="name" class="form-input" value="<?=set_value('name');?>" />
									<?=form_error('name');?>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<div class="caption">Ваш телефон: <span class="required">*</span></div>
											<input type="text" name="phone" class="form-input" value="<?=set_value('phone');?>" data-rules="required" />
											<?=form_error('phone');?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="caption">Ваш e-mail:</div>
											<input type="text" name="email" class="form-input" value="<?=set_value('email');?>" />
											<?=form_error('email');?>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="cart-panels-item">
								<div class="cart-panels-title">Способ доставки</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="cart-checkers">
											<ul class="cart-checkers-list">
											<? $_del_adres = 1;?>
											<? foreach($delivery as $_del) { ?>
												<li>
													<label class="cart-checkers-item" data-checker="delivery" data-hint="hintDelivery<?=$_del['idItem'];?>">
														<input type="radio" name="delivery" value="<?=$_del['idItem'];?>" <?=set_radio('delivery', $_del['idItem']);?> data-adres="<?=$_del['adres'];?>" />
														<div class="title"><?=$_del['title'];?></div>
														<div class="brief">(<?=$_del['price'] == 0 ? 'бесплатно' : price($_del['price']).' '.$currency['unit'];?>)</div>
														<?=fa('check');?>
													</label>
												</li>
											<? } ?>
											</ul>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb15 none" id="cartAdres">
											<div class="caption">Введите Ваш адрес:</div>
											<input type="text" name="adres" class="form-input" value="<?=set_value('adres');?>" />
										</div>
										<? foreach($delivery as $_del) { ?>
											<? if($_del['text'] != '') { ?>
											<div class="cart-hint" data-delivery-hint="hintDelivery<?=$_del['idItem'];?>">
												<?=nl2br($_del['text']);?>
											</div>
											<? } ?>
										<? } ?>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="cart-panels-item">
								<div class="cart-panels-title">Способ оплаты</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="cart-checkers">
											<ul class="cart-checkers-list">
											<? $i = 1; foreach($pay as $_pay) { ?>
												<li>
													<label class="cart-checkers-item" data-checker="pay" data-hint="hintPay<?=$_pay['idItem'];?>">
														<input type="radio" name="pay" value="<?=$_pay['idItem'];?>" <?=set_radio('pay', $_pay['idItem']);?> />
														<div class="title"><?=$_pay['title'];?></div>
														<? if($_pay['brief']) { ?><div class="brief">(<?=$_pay['brief'];?>)</div><? } ?>
														<?=fa('check');?>
													</label>
												</li>
											<? $i++;} ?>
											</ul>
										</div>
									</div>
									<div class="col-sm-6">
										<? foreach($pay as $_pay) { ?>
											<? if($_pay['text'] != '') { ?>
											<div class="cart-hint" data-pay-hint="hintPay<?=$_pay['idItem'];?>">
												<?=nl2br($_pay['text']);?>
											</div>
											<? } ?>
										<? } ?>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="cart-panels-item">
								<div class="cart-panels-title">Комментарий к заказу</div>
								<textarea name="text" class="form-input" rows="3"><?=set_value('text');?></textarea>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="cart-right">
				<div class="cart-list-wrap">
					<ul class="cart-list">
					<? foreach($items as $item) { ?>
						<li class="cart-list-li" data-cart-rowid="<?=$item['rowid'];?>">
							<div class="cart-list-item clearfix">
								<div class="img">
									<a href="<?=path($item['idParent'], $paths, $item['alias']);?>">
										<?=check_img('assets/uploads/products/thumb/'.$item['img'], array('alt' => $item['name']));?>
									</a>
								</div>
								<div class="descr">
									<a href="<?=path($item['idParent'], $paths, $item['alias']);?>" class="item">
										<div class="articul">Арт.: <?=$item['id'];?></div>
										<div class="title"><?=$item['name'];?></div>
										<div class="brief"><?=$item['brief'];?></div>
									</a>
									<div class="counter">
										<div class="price"><?=price($item['price']);?> <?=$currency['unit'];?></div>
										<div class="cart-counter" data-toggle="cart-counter">
											<a href="javascript:void(0)" class="cart-counter-btn _prev" data-cart-direction="-1">&minus;</a>
											<a href="javascript:void(0)" class="cart-counter-btn _next" data-cart-direction="1">&plus;</a>
											<input type="text" name="qty" class="cart-counter-input _change" data-toggle="cart-input" value="<?=$item['qty'];?>" />
										</div>
										<div class="subtotal"><?=price($item['subtotal']);?> <?=$currency['unit'];?></div>
									</div>
								</div>
								<a href="javascript:void(0)" class="remove" data-cart="remove"><?=fa('times');?></a>
							</div>
						</li>
					<? } ?>
					</ul>
				</div>
				<div class="cart-total">
					<ul class="cart-total-list">
						<li class="clearfix">
							<div class="label">Итого:</div>
							<div class="value"><span data-cart="total_price"><?=price($this->cart->total());?></span> <?=$currency['unit'];?></div>
						</li>
						<li class="clearfix">
							<div class="label">Доставка:</div>
							<div class="value"><span data-cart="total_delivery"><?=price(0);?></span> <?=$currency['unit'];?></div>
						</li>
						<li class="clearfix _big">
							<div class="label">К оплате:</div>
							<div class="value"><span data-cart="total"><?=price($this->cart->total());?></span> <?=$currency['unit'];?></div>
						</li>
					</ul>
				</div>
				<div class="cart-actions">
					<button class="btn btn-xl"><?=fa('check mr5');?> Оформить заказ</button>
					<a href="<?=base_url('catalog');?>" class="color-gray">Вернуться к покупкам</a>
				</div>
			</div>
		<?=form_close()?>
	<? } ?>
	</div>
</section>

<script>
	$('[name="delivery"]').change(function(){
		el = $(this);
		
		el.closest('.cart-checkers-list').find('label').removeClass('current');
		label = el.closest('label');
		label.addClass('current');
		
		hint = label.attr('data-hint');
		$('[data-delivery-hint]').hide();
		$('[data-delivery-hint=' + hint + ']').fadeIn(300);
		
		if(el.attr('data-adres') == 1) $('#cartAdres').fadeIn(300);
		else $('#cartAdres').hide();
		
		$.ajax({
			type  : "POST",
			url   : base_url + 'cart/ajaxUpdateDelivery',
			data  : {
				csrf_test_name	: csrf_test_name,
				delivery		: el.val()
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
				
				$('[data-cart="total_delivery"]').html(data.inTotalDelivery);
				$('[data-cart="total"]').html(data.inTotal);
			},
		});
	});
	
	$('[name="pay"]').change(function(){
		el = $(this);
		
		el.closest('.cart-checkers-list').find('label').removeClass('current');
		label = el.closest('label');
		label.addClass('current');
		
		hint = label.attr('data-hint');
		$('[data-pay-hint]').hide();
		$('[data-pay-hint=' + hint + ']').fadeIn(300);
	});
</script>