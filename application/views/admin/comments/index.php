<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной записи. Вы можете '.anchor('admin/'.uri(2).'/create', 'создать запись.'));?>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th><span style="font-size: 10px;"><?=fa('circle text-warning');?></span></th>
			<th colspan="2">Товар</th>
			<th>Имя</th>
			<th></th>
			<th>Добавлено</th>
			<th></th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="w50"><?=$item['isRead'] == 0 ? '<span style="font-size: 10px;">'.fa('circle text-warning').'</span>' : '';?></td>
			<td class="w50"><?=check_img('assets/uploads/products/thumb/'.$item['img'], array('class' => 'block w50'))?></td>
			<td class="item-title"><?=$item['product']?></td>
			<td>
				<div><?=fa('user fa-fw text-gray mr5');?> <?=$item['title'];?></div>
				<div><?=fa('phone fa-fw text-gray mr5');?> <?=$item['phone'] ? $item['phone'] : '<span class="text-gray">(не указан)</span>';?></div>
			</td>
			<td nowrap>
				<? $color = array('error', 'error', 'warning', 'info', 'success');?>
				<div class="text-<?=$color[$item['raiting'] - 1];?>">
					<? for($r = 0; $r < $item['raiting']; $r++) { ?><?=fa('star')?> <? } ?>
					<? if($item['raiting'] < 5) { ?><? for($r; $r < 5; $r++) { ?><?=fa('star-o')?> <? } ?><? } ?>
				</div>
			</td>
			<td nowrap >
				<?=fa('calendar mr5 fa-fw text-gray');?> <?=date('d.m.Y', strtotime($item['addDate']));?><br/>
				<?=fa('clock-o mr5 fa-fw text-gray');?> <?=date('H:i:s', strtotime($item['addDate']));?>
			</td>
			<td class="text-right"><?=$item['visibility'] == 1 ? fa('eye text-success') : fa('eye-slash text-error');?></td>
			<td class="w125">
				<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/delete/'.$item['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<?=$this->pagination->create_links(); ?>

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