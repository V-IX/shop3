<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной записи. Вы можете '.anchor('admin/'.uri(2).'/item_create/'.uri(4), 'создать запись.'));?>

<? } else { ?>

<table class="table table-hover mb20">
	<thead>
		<tr>
			<th>#</th>
			<th>Название</th>
			<th>Тип</th>
			<th></th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $_item) { ?>
		<tr>
			<td class="w50"><?=$_item['num'];?></td>
			<td class="item-title"><?=$_item['title'];?></td>
			<td><?=$types[$_item['type']]['title'];?></td>
			<td class="text-right"><?=$_item['filter'] == 1 ? fa('filter text-success') : '';?></td>
			<td class="w125">
				<?=anchor('admin/'.uri(2).'/item_edit/'.$_item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/item_delete/'.$_item['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<div class="form-actions">
	<?=anchor('admin/'.uri(2).'/item_create/'.$item['idItem'], 'Добавить поле', array('class' => 'btn btn-success'))?>
	<?=anchor('admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'))?>
	<?=anchor('#delModal', '<i class="fa fa-trash"></i>', array('class' => 'btn btn-icon btn-error right', 'data-toggle' => 'modal'))?>
	<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], 'Редактировать', array('class' => 'btn btn-success right mr5'))?>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w500">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title">Подтвердить удаление записи</div>
			</div>
			<?=form_open('', array('id' => 'delForm'))?>
			<div class="modal-body">
				Вы действительно хотите удалить запись <span class="medium" id="delTitle"></span>?
			</div>
			<div class="modal-footer text-right">
				<button class="btn btn-success">Подтвердить</button>
				<span class="btn btn-error" data-dismiss="modal">Отмена</span>
				<input type="hidden" name="delete" value="delete" />
			</div>
			<?=form_close();?>
		</div>
	</div>
</div>


<script>
	$('.delete-btn').click(function(e){
		e.preventDefault();
		$('#delForm').attr('action', $(this).attr('href'));
		$('#delTitle').text('"' + $(this).closest('tr').find('.item-title').text() + '"');
		$('#delModal').modal('show');
		return false;
	})
</script>

<? } ?>