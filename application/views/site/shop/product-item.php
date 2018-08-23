<a href="<?=path($product['idParent'], $paths, $product['alias']);?>" class="products-item">
	<div class="img">
		<?=check_img('assets/uploads/products/thumb/'.$product['img'], array('alt' => $product['mTitle']), 'product.png');?>
		<? if($product['sticker_new'] == 1) { ?>
			<div class="sticker _new">Новинка</div>
		<? } elseif($product['sticker_hit'] == 1) { ?>
			<div class="sticker _hit">Хит продаж</div>
		<? } elseif($product['oldPrice'] != 0) { ?>
			<div class="sticker _discount">Скидка</div>
		<? } ?>
	</div>
	<div class="title"><?=$product['title'];?></div>
	<div class="brief"><?=$product['brief'];?></div>
	<div class="price">
		<span class="price-new"><?=price($product['price']);?> <?=$currency['unit'];?></span>
		<? if($product['oldPrice'] != 0) { ?>
			<span class="price-old"><strike><?=price($product['oldPrice']);?> <?=$currency['unit'];?></strike></span>
		<? } ?>
	</div>
	<? if($siteinfo['shop'] == 1) { ?>
	<span class="btn btn-xxs" data-toggle="add2cart" data-cart-id="<?=$product['articul'];?>"><?=fa('shopping-cart');?> В корзину</span>
	<? } ?>
</a>