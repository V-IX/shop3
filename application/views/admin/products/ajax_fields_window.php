<? if(empty($items)) { ?>

	<?=action_result('info', fa('ban mr5').' Нет полей для добавления');?>

<? } else { ?>

<ul class="fields-window">
<? $i = 1; foreach($items as $group) { ?>
	<li class="fields-group">
		<a href="javascript:void(0)" class="fields-group-title">
			<?=fa('plus-square-o fa-fw mr5');?>
			<?=fa('minus-square-o fa-fw mr5');?>
			<?=$group['title'];?> <? if(!empty($group['child'])) { ?><span class="text-gray">(<?=count($group['child']);?>)</span><? } ?>
		</a>
		<ul class="fields-child">
		<? foreach($group['child'] as $child) { ?>
			<li>
				<label class="fields-item">
					<div class="checker">
						<input type="checkbox" data-field="<?=$child['idItem'];?>" <?=array_key_exists($child['idItem'], $rel) ? 'checked' : '';?> />
						<div class="checker-view"></div>
					</div>
					<?=$child['title'];?> <span class="text-gray h6">(<?=$type[$child['type']]['title']?>)</span>
				</label>
			</li>
		<? } ?>
		</ul>
	</li>
<? $i++;} ?>
</ul>

<? } ?>