<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной страницы. Страницы создаются в базе данных.');?>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Alias</th>
			<th>Название</th>
			<th>Заголовок</th>
			<th class="w100">Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="item-title"><?=$item['alias'];?></td>
			<td><?=$item['name'];?></td>
			<td><?=$item['title'];?></td>
			<td class="w100">
				<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<?=$this->pagination->create_links(); ?>

<? } ?>