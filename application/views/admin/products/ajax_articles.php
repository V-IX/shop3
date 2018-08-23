<? if(empty($items)) { ?>

	<?=action_result('info', fa('ban mr5').' Нет статей для добавления');?>

<? } else { ?>

<ul class="ajax-articles small-preview">
<? $i = 1; foreach($items as $item) { ?>
	<li>
		<a href="javascript:void(0)" class="ajax-article <?=$item['current'];?> <?=$item['current'] ? 'active' : '';?>" data-article="<?=$item['idItem']?>">
			
			<div class="clearfix">
				<div class="img">
					<?=check_img('assets/uploads/articles/thumb/'.$item['img']);?>
				</div>
				<div class="descr">
					<div class="medium mb5"><?=$item['title'];?></div>
					<div class="h6 text-gray"><?=$item['brief'];?></div>
				</div>
			</div>
		</a>
	</li>
<? $i++;} ?>
</ul>

<? } ?>