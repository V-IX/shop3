<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной записи. Вы можете '.anchor('admin/'.uri(2).'/create', 'создать запись.'));?>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th><span style="font-size: 10px;"><?=fa('circle text-warning');?></span></th>
			<th>#</th>
			<th>Заказчик</th>
			<th>Товаров / Сумма</th>
			<th>Доставка / Оплата</th>
			<th>Дата</th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td><?=$item['isRead'] == 0 ? '<span style="font-size: 10px;">'.fa('circle text-warning').'</span>' : '';?></td>
			<td class="medium item-title"><?=$item['alias'];?></td>
			<td>
				<? if($item['name']) { ?><div><?=fa('user fa-fw text-gray mr5');?> <?=$item['name'];?></div><? } ?>
				<div><?=fa('phone fa-fw text-gray mr5');?> <?=$item['phone'];?></div>
				<? if($item['email']) { ?><div><?=fa('at fa-fw text-gray mr5');?> <?=$item['email'];?></div><? } ?>
			</td>
			<td>
				<div><?=$item['count'];?> шт. / <?=price($item['price']);?> <?=$currency['unit'];?></div>
				<? if($item['delivery_price'] != 0) { ?><div class="h6 text-info">Стоимость доставки: <?=price($item['delivery_price']);?> <?=$currency['unit'];?></div><? } ?>
			</td>
			<td>
				<div><?=fa('truck fa-fw text-gray mr5');?> <?=$item['delivery'];?></div>
				<div><?=fa('credit-card fa-fw text-gray mr5');?> <?=$item['pay'];?></div>
			</td>
			<td nowrap >
				<?=fa('calendar mr5 fa-fw text-gray');?> <?=date('d.m.Y', strtotime($item['addDate']));?><br/>
				<?=fa('clock-o mr5 fa-fw text-gray');?> <?=date('H:i:s', strtotime($item['addDate']));?>
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