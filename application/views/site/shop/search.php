<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><?=$pageinfo['title'];?></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		
		<form action="<?=base_url('search');?>" class="search-form2">
			<input type="text" name="search" class="form-input" placeholder="Поиск по сайту" value="<?=$search;?>" />
			<button class="btn"><?=fa('search');?></button>
			<? if($search != '') { ?>
				<div class="label">Найдено <?=$count;?> результатов</div>
			<? } ?>
		</form>
		
		<? if(!empty($products)) { ?>
			<div class="products-list">
				<ul class="list">
				<? foreach($products as $product) { ?>
					<li>
						<table>
							<tr class="hide-title">
								<td <? if($siteinfo['shop']) { ?>colspan="2"<? } ?>>
									<a href="<?=base_url("catalog/".$paths[$product['idParent']]."/".$product['alias']);?>" class="title"><?=$product['title'];?></a>
								</td>
							</tr>
							<tr>
								<td class="td-img">
									<a href="<?=base_url("catalog/".$paths[$product['idParent']]."/".$product['alias']);?>" class="img">
										<div class="stickers">
											<? if($product['oldPrice'] != 0) { ?><div class="sticker _share"></div><? } ?>
											<? if($product['sticker_best']) { ?><div class="sticker _best"></div><? } ?>
											<? if($product['sticker_hit']) { ?><div class="sticker _hit"></div><? } ?>
											<? if($product['sticker_new']) { ?><div class="sticker _new"></div><? } ?>
										</div>
										<?=check_img('assets/uploads/products/thumb/'.$product['img'], array('alt' => $product['mTitle']));?>
									</a>
								</td>
								<td class="td-descr">
									<a href="<?=base_url("catalog/".$paths[$product['idParent']]."/".$product['alias']);?>" class="title"><?=$product['title'];?></a>
									<div class="brief"><?=$product['brief'];?></div>
								</td>
								<? if($siteinfo['shop']) { ?>
									<td class="td-actions">
										<div class="aval">
										<? if($product['count'] == 0) { ?>
											<span class="icon _no"></span>
											нет в наличии
										<? } else { ?>
											<span class="icon _yes"></span>
											в наличии
										<? } ?>
										</div>
										<div class="price"><?=price($product['price']);?> <?=$currency['unit'];?></div>
										<? if($product['oldPrice'] != 0) { ?>
											<div class="oldprice">
												Цена без скидки:
												<strike><?=price($product['oldPrice']);?> <?=$currency['unit'];?></strike>
											</div>
										<? } ?>
										<div class="more">
										<? if($product['count'] == 0) { ?>
											<a href="javascript:void(0)" class="btn" data-toggle="popup" data-task="Узнать стоимость: <?=htmlspecialchars($product['title']);?>">Под заказ</a>
										<? } else { ?>
											<a href="javascript:void(0)" class="btn" data-toggle="add2cart" data-cart-id="<?=$product['articul'];?>"><?=fa('shopping-cart mr5');?> В корзину</a>
										<? } ?>
										</div>
									</td>
								<? } ?>
							</tr>
						</table>
						
					</li>
				<? } ?>
				</ul>
			</div>
			<?=$this->pagination->create_links();?>
		<? } ?>
	</div>
</section>