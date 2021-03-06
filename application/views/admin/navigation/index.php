<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной записи. Вы можете '.anchor('admin/'.uri(2).'/create', 'создать запись.'));?>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th></th>
			<th>Название</th>
			<th>Ссылка</th>
			<th></th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="w75"><?=fa('folder text-warning h3 fa-fw');?></td>
			<td class="item-title medium h4"><?=$item['title'];?></td>
			<td><?=$item['link'];?></td>
			<td class="text-right"><?=$item['visibility'] == 1 ? fa('eye text-success') : fa('eye-slash text-error');?></td>
			<td class="w125">
				<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/delete/'.$item['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
			</td>
		</tr>
		<? if(!empty($item['child'])) { foreach($item['child'] as $child) { ?>
			<tr>
				<td class="text-right"><?=fa('link text-gray h3 fa-fw');?></td>
				<td class="item-title"><?=$child['title'];?></td>
				<td><?=$child['link'];?></td>
				<td class="text-right"><?=$child['visibility'] == 1 ? fa('eye text-success') : fa('eye-slash text-error');?></td>
				<td class="w125">
					<?=anchor('admin/'.uri(2).'/edit/'.$child['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
					<?=anchor('admin/'.uri(2).'/delete/'.$child['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
				</td>
			</tr>
		<? } }?>
	<? } ?>
	</tbody>
</table>

<div class="form-actions mt20">
	<?=anchor('admin/'.uri(2).'/create', 'Добавить запись', array('class' => 'btn btn-success'));?>
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