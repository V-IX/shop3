<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageinfo['title'];?> №<?=$item['alias'];?></span></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<? if($this->session->userdata('site')) { ?>
			<?=$this->session->userdata('site');?>
			<div class="mb30"></div>
		<? } ?>
		<div class="cart-left">
			<ul class="cart-confirm">
				<li>
					<div class="clearfix">
						<div class="label">Способ доставки:</div>
						<div class="value"><?=$item['delivery'];?></div>
					</div>
				</li>
				<li>
					<div class="clearfix">
						<div class="label">Оплата:</div>
						<div class="value"><?=$item['pay'];?></div>
					</div>
				</li>
			</ul>
			<div class="cart-total">
				<ul class="cart-total-list">
					<li class="clearfix">
						<div class="label">Итого:</div>
						<div class="value"><?=price($item['price']);?> <?=$currency['unit'];?></div>
					</li>
					<li class="clearfix">
						<div class="label">Доставка:</div>
						<div class="value"><?=price($item['delivery_price']);?> <?=$currency['unit'];?></div>
					</li>
					<li class="clearfix _big">
						<div class="label">К оплате:</div>
						<div class="value"><?=price($item['total']);?> <?=$currency['unit'];?></div>
					</li>
				</ul>
			</div>
			<div class="cart-actions">
				<button class="btn btn-xl btn-gray">Вернуться в каталог</button>
			</div>
		</div>
		<div class="cart-right">
			<div class="cart-list-wrap">
				<ul class="cart-list">
				<? foreach($item['child'] as $child) { ?>
					<li class="cart-list-li">
						<div class="cart-list-item clearfix">
							<div class="img">
								<?=check_img('assets/uploads/products/thumb/'.$child['img'], array('alt' => $child['title']));?>
							</div>
							<div class="descr">
								<div class="articul">Арт.: <?=$child['articul'];?></div>
								<div class="title _2"><?=$child['title'];?></div>
								<div class="counter">
									<div class="price"><?=price($child['price']);?> <?=$currency['unit'];?></div>
									<div class="count"><?=$child['count'];?></div>
									<div class="subtotal"><?=price($child['total']);?> <?=$currency['unit'];?></div>
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