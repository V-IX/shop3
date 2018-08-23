<? if(empty($catalogs)) { ?>

	<?=action_result('info', fa('ban mr5').' Нет категорий для добавления');?>

<? } else { ?>

<? function catalog($item) 
{ ?>
		<li>
			<a href="javascript:void(0)" class="similars-tree-item" data-similar-catalog="<?=$item['idItem']?>" style="padding-left: <?=$item['level'] * 15;?>px;">
				<?=fa('plus-square-o fa-fw');?>
				<?=fa('minus-square-o fa-fw');?>
				<?=$item['title'];?>
			</a>
			<? if(isset($item['childs'])) { ?>
			<ul class="similars-tree-child">
				<? foreach($item['childs'] as $child) { ?>
					<?=catalog($child);?>
				<? } ?>
			</ul>
			<? } ?>
		</li>
<? } ?>

<div class="similars-window clearfix">
	<div class="similars-left">
		<div class="similars-title">Категории</div>
		<div class="similars-inner">
			<div class="similars-tree" id="similarsTree">
				<ul class="similars-tree-parent">
				<? foreach($catalogs as $catalog) { ?>
					<?=catalog($catalog);?>
				<? } ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="similars-right">
		<div class="similars-title">Товары</div>
		<div class="similars-inner">
			<div class="similars-products" id="similarsProducts">
				<div class="similars-empty">Категория пустая</div>
			</div>
		</div>
	</div>
	<div class="similars-sep"></div>
</div>

<? } ?>