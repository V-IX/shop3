<? if(empty($items)) { ?>

<div class="note note-info">
	У вас не создано еще ни одного пользователя. Вы можете <?=anchor('admin/'.uri(2).'/create', 'создать пользователя', array('class' => 'medium'))?>.
</div>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Логин</th>
			<th>ФИО</th>
			<th>E-mail</th>
			<th class="w150">Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="item-title"><?=$item['login'];?></td>
			<td><?=$item['name'];?> <?=$item['sname'];?></td>
			<td><?=$item['email'];?></td>
			<td class="w175">
				<?=anchor('admin/'.uri(2).'/view/'.$item['idItem'], fa('eye'), array('class' => 'btn btn-info btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
				<? if($item['idItem'] != $this->session->userdata('id')) { ?>
					<?=anchor('admin/'.uri(2).'/delete/'.$item['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
				<? } ?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<?=$this->pagination->create_links(); ?>

<div class="form-actions mt20">
	<?=anchor('admin/'.uri(2).'/create', 'Добавить пользователя', array('class' => 'btn btn-success'));?>
	<?=anchor('admin/'.uri(2).'/password', 'Изменить пароль', array('class' => 'btn btn-info'));?>
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