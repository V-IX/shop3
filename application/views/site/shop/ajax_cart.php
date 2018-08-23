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