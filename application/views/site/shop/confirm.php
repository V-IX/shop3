<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageinfo['title'];?></span></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<div class="cart-left">
			<ul class="cart-confirm">
				<? if(isset($order['name']) and $order['name'] != '') { ?>
				<li>
					<div class="clearfix">
						<div class="label">Имя:</div>
						<div class="value"><?=$order['name'];?></div>
					</div>
				</li>
				<? } ?>
				<li>
					<div class="clearfix">
						<div class="label">Телефон:</div>
						<div class="value"><?=$order['phone'];?></div>
					</div>
				</li>
				<? if(isset($order['email']) and $order['email'] != '') { ?>
				<li>
					<div class="clearfix">
						<div class="label">E-mail:</div>
						<div class="value"><?=$order['email'];?></div>
					</div>
				</li>
				<? } ?>
				<? if(isset($order['text']) and $order['text'] != '') { ?>
				<li>
					<div class="clearfix">
						<div class="label">Комментарий:</div>
						<div class="value"><?=nl2br($order['text']);?></div>
					</div>
				</li>
				<? } ?>
				<li>
					<div class="clearfix">
						<div class="label">Способ доставки:</div>
						<div class="value"><?=$order['delivery'];?></div>
					</div>
				</li>
				<? if(isset($order['adres']) and $order['adres'] != '') { ?>
				<li>
					<div class="clearfix">
						<div class="label">Адрес доставки:</div>
						<div class="value"><?=$order['adres'];?></div>
					</div>
				</li>
				<? } ?>
				<li>
					<div class="clearfix">
						<div class="label">Оплата:</div>
						<div class="value"><?=$order['pay'];?></div>
					</div>
				</li>
			</ul>
			<div class="cart-total">
				<ul class="cart-total-list">
					<li class="clearfix">
						<div class="label">Итого:</div>
						<div class="value"><?=price($this->cart->total());?> <?=$currency['unit'];?></div>
					</li>
					<li class="clearfix">
						<div class="label">Доставка:</div>
						<div class="value"><?=price($order['delivery_price']);?> <?=$currency['unit'];?></div>
					</li>
					<li class="clearfix _big">
						<div class="label">К оплате:</div>
						<div class="value"><?=price($this->cart->total() + $order['delivery_price']);?> <?=$currency['unit'];?></div>
					</li>
				</ul>
			</div>
			<div class="cart-actions">
				<?=form_open('');?>
					<button class="btn btn-xl"><?=fa('check mr5');?> Подтвердить заказ</button>
					<a href="<?=base_url('cart');?>" class="color-gray">Изменить заказ</a>
					<input type="hidden" name="confirm" value="confirm" />
				<?=form_close();?>
			</div>
		</div>
		<div class="cart-right">
			<div class="cart-list-wrap">
				<ul class="cart-list">
				<? foreach($items as $item) { ?>
					<li class="cart-list-li">
						<div class="cart-list-item clearfix">
							<div class="img">
								<?=check_img('assets/uploads/products/thumb/'.$item['img'], array('alt' => $item['name']));?>
							</div>
							<div class="descr">
								<div class="articul">Арт.: <?=$item['id'];?></div>
								<div class="title _2"><?=$item['name'];?></div>
								<div class="counter">
									<div class="price"><?=price($item['price']);?> <?=$currency['unit'];?></div>
									<div class="count"><?=$item['qty'];?></div>
									<div class="subtotal"><?=price($item['subtotal']);?> <?=$currency['unit'];?></div>
								</div>
							</div>
						</div>
					</li>
				<? } ?>
				</ul>
			</div>
		</div>
	</div>
</section>