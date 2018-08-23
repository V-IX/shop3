<div class="descr">
	<div class="form-group">
		<?=fa('user fa-fw text-gray mr5')?> <?=$item['name'] != '' ? $item['name'] : '<span class="text-gray">(не указано)</span>';?>
	</div>
	<div class="form-group">
		<?=fa('phone fa-fw text-gray mr5')?> <?=$item['phone'] != '' ? $item['phone'] : '<span class="text-gray">(не указано)</span>';?>
	</div>
	<div class="form-group">
		<?=fa('at fa-fw text-gray mr5')?> <?=$item['email'] != '' ? $item['email'] : '<span class="text-gray">(не указано)</span>';?>
	</div>
</div>

<hr class="mb15" />

<div class="h4 medium mb15">Текст страницы</div>
<div class="form-group">
	<div class="text-editor">
		<?=$item['text'] != '' ? $item['text'] : '<span class="text-gray">(не указано)</span>';?>
	</div>
</div>

<div class="form-actions">
	<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], 'Редактировать', array('class' => 'btn btn-success'))?>
	<?=anchor('admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'))?>
	<?=anchor('#delModal', '<i class="fa fa-trash"></i>', array('class' => 'btn btn-icon btn-error right', 'data-toggle' => 'modal'))?>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w500">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title">Подтвердить удаление записи</div>
			</div>
			<?=form_open('admin/'.uri(2).'/delete/'.$item['idItem'], array('id' => 'delForm'))?>
			<div class="modal-body">
				Вы действительно хотите удалить запись <span class="medium">"<?=$item['title']?>"</span>?
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