<div class="h4 medium mb25">Информация о заказе</div>

<div class="row mb10">
	<div class="col-3 medium">ФИО:</div>
	<div class="col-9"><?=$item['name'] ? $item['name'] : '<span class="text-gray">(не указано)</span>';?></div>
</div>
<div class="row mb10">
	<div class="col-3 medium">Телефон:</div>
	<div class="col-9"><?=$item['phone'];?></div>
</div>
<div class="row mb10">
	<div class="col-3 medium">Email:</div>
	<div class="col-9"><?=$item['email'] ? $item['email'] : '<span class="text-gray">(не указано)</span>';?></div>
</div>
<div class="row mb10">
	<div class="col-3 medium">Комментарий:</div>
	<div class="col-9"><?=$item['text'] ? $item['text'] : '<span class="text-gray">(не указано)</span>';?></div>
</div>

<hr class="mt25 mb25" />

<div class="h4 medium mb25">Доставка / оплата</div>

<div class="row mb10">
	<div class="col-3 medium">Доставка:</div>
	<div class="col-9"><?=$item['delivery'];?></div>
</div>
<div class="row mb10">
	<div class="col-3 medium">Адрес:</div>
	<div class="col-9"><?=$item['adres'] ? $item['adres'] : '<span class="text-gray">(не указано)</span>';?></div>
</div>
<div class="row mb10">
	<div class="col-3 medium">Оплата:</div>
	<div class="col-9"><?=$item['pay'];?></div>
</div>

<hr class="mt25 mb25" />

<div class="h4 medium mb25">Заказ</div>

<div class="row mb10">
	<div class="col-3 medium">Товаров:</div>
	<div class="col-9"><?=$item['count'];?></div>
</div>
<div class="row mb10">
	<div class="col-3 medium">Стоимость:</div>
	<div class="col-9"><?=price($item['price']);?> <?=$currency['unit'];?></div>
</div>
<div class="row mb20">
	<div class="col-3 medium">Стоимость доставки:</div>
	<div class="col-9"><?=price($item['delivery_price']);?> <?=$currency['unit'];?></div>
</div>
<div class="row mb10 h3">
	<div class="col-3 bold">Итого:</div>
	<div class="col-9 medium"><?=price($item['total']);?> <?=$currency['unit'];?></div>
</div>

<hr class="mt25 mb25" />

<table class="table mb20">
	<thead>
		<tr>
			<th colspan="2">Товар</th>
			<th>Цена</th>
			<th>Количество</th>
			<th>Сумма</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($item['child'] as $product) { ?>
		<tr>
			<td class="img w150">
				<div class="img-show">
					<?=check_img('assets/uploads/products/thumb/'.$product['img'], array('class' => 'w100'), 'catalog.png')?>
				</div>
			</td>
			<td class="title">
				<div class="medium mb5"><?=$product['articul'];?> <? if($product['modification'] == 1) { ?><span class="text-gray regular h6 ml5">(модификация)</span><? } ?></div>
				<div class="medium h4 mb5"><?=$product['title'];?></div>
				<div class="text-gray h6"><?=$product['brief'];?></div>
			</td>
			<td class="w150">
				<div class="h4 medium"><?=price($product['price']);?> <?=$currency['unit'];?></div>
				<div class="h6 text-gray"><?=price_old($product['price']);?> byr</div>
			</td>
			<td class="w150">
				<div class="h4 medium ml30"><?=$product['count'];?></div>
			</td>
			<td class="w150">
				<div class="h4 medium"><?=price($product['total']);?> <?=$currency['unit'];?></div>
				<div class="h6 text-gray"><?=price_old($product['total']);?> byr</div>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<div class="form-actions">
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