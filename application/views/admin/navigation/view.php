<div class="h4 medium mb10"><?=$item['title'];?></div>
<div class="form-group">
	<?=fa('link mr5 text-gray fa-fw');?> 
	<?=anchor('pages/'.$item['alias'], '', array('target' => 'blank'));?>
</div>

<hr class="mb15" />

<div class="h4 medium mb10">Текст страницы</div>
<div class="text-editor form-group">
	<?=$item['text'] != '' ? $item['text'] : '<span class="text-gray">(не указано)</span>';?>
</div>

<hr class="mb15" />

<div class="h4 medium mb10">SEO</div>
<div class="form-group">
	<?=fa('bullhorn mr5 text-gray fa-fw');?> <?=$item['mTitle'];?>
</div>
<div class="form-group">
	<?=fa('tag mr5 text-gray fa-fw');?> 
	<?=$item['mKeywords'] != '' ? $item['mKeywords'] : '<span class="text-gray">(не указано)</span>';?>
</div>
<div class="form-group">
	<?=fa('tags mr5 text-gray fa-fw');?> 
	<?=$item['mDescription'] != '' ? $item['mDescription'] : '<span class="text-gray">(пусто)</span>';?>
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