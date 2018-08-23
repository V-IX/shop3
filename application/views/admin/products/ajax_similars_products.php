<? if(empty($items)) { ?>
	
<div class="similars-empty">Категория пустая</div>

<? } else { ?>

<ul class="similars-list clearfix">
<? foreach($items as $item) { ?>
	<li>
		<a href="javascript:void(0)" class="similars-product <?=$item['current'] ? 'active' : '';?>" data-similar-product="<?=$item['idItem']?>">
			<div class="img">
				<div class="check"><?=fa('check');?></div>
				<?=check_img('assets/uploads/products/thumb/'.$item['img']);?>
			</div>
			<div class="title"><?=$item['title'];?></div>
			<div class="brief text-gray"><?=$item['brief'];?></div>
		</a>
	</li>
<? } ?>
</ul>

<? } ?>