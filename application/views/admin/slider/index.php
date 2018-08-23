<? if(empty($items)) { ?>

<div class="note note-info">
	У вас не создано еще ни одного слайда. Вы можете <?=anchor('admin/'.$this->uri->segment(2).'/create', 'создать слайд', array('class' => 'medium'))?>.
</div>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Изображение</th>
			<th>Заголовок</th>
			<th>Ссылка</th>
			<th></th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="w50"><?=$item['num'];?></td>
			<td class="w150"><?=check_img('assets/uploads/slider/'.$item['img'], array('class' => 'block w125'));?></td>
			<td>
				<div class="item-title"><?=$item['title'];?></div>
				<div class="h6 text-gray"><?=$item['text'];?></div>
			</td>
			<td><?=$item['link'];?></td>
			<td class="text-right"><?=$item['visibility'] == 1 ? fa('eye text-success') : fa('eye-slash text-error');?></td>
			<td class="w125">
				<?=anchor('admin/'.$this->uri->segment(2).'/edit/'.$item['idItem'], '<i class="fa fa-pencil"></i>', array('class' => 'btn btn-success btn-icon'));?>
				<?=anchor('admin/'.$this->uri->segment(2).'/delete/'.$item['idItem'], '<i class="fa fa-trash"></i>', array('class' => 'btn btn-error btn-icon delete-btn'));?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<?=$this->pagination->create_links(); ?>

<div class="form-actions mt20">
	<?=anchor('admin/'.$this->uri->segment(2).'/create', 'Добавить слайд', array('class' => 'btn btn-success'));?>
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