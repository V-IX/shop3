<? if(empty($items)) { ?>

<?=action_result('info', 'У вас нет ни одного входящего сообщения.');?>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th><span style="font-size: 10px;"><?=fa('circle text-warning');?></span></th>
			<th>Тема</th>
			<th>ФИО</th>
			<th>Контакты</th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="w50"><?=$item['isRead'] == 0 ? '<span style="font-size: 10px;">'.fa('circle text-warning').'</span>' : '';?></td>
			<td class="item-title"><?=$item['title'];?></td>
			<td><?=$item['name'];?></td>
			<td>
				<div><?=fa('phone text-gray fa-fw mr5')?> <?=$item['phone'];?></div>
				<div><?=$item['email'] != '' ? fa('at text-gray fa-fw mr5').' '.$item['email'] : '';?></div>
			</td>
			<td class="w125">
				<?=anchor('admin/'.uri(2).'/view/'.$item['idItem'], fa('eye'), array('class' => 'btn btn-info btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/delete/'.$item['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<?=$this->pagination->create_links(); ?>

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