<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной записи. Вы можете '.anchor('admin/'.uri(2).'/create', 'создать запись.'));?>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Изображение</th>
			<th>Заголовок</th>
			<th>Размеры</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="w100"><?=check_img('assets/uploads/'.$folder.'/thumb/'.$item['img'], array('class' => 'block w75'));?></td>
			<td>
				<div><?=$item['title'];?></div>
				<?=$item['link'] ? anchor($item['link'], '', array('target' => '_blank', 'class' => 'h6')) : ''; ?>
			</td>
			<td nowrap >
				<?=$item['size_x'];?>x<?=$item['size_y'];?>
			</td>
			<td class="text-right"><?=$item['visibility'] == 1 ? fa('eye text-success') : fa('eye-slash text-error');?></td>
			<td class="w50">
				<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<?=$this->pagination->create_links(); ?>

<? } ?>