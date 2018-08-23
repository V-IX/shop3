<div style="border: 1px solid #d8d8d8;">
	<div style="padding: 20px; background: #f3f3f3; border-bottom: 2px solid #d8d8d8; text-align: left; font-family: 'Open Sans', Arial, sans-serif;">
		<span style="display: inline-block;">
			<img src="<?=base_url('assets/uploads/settings/'.$site['img']);?>" style="display: inline-block; vertical-align: middle; margin-right: 15px; height: 60px;" />
			<span style="display: inline-block; vertical-align: middle; ">
				<span style="font-size: 46px; font-weight: 700; line-height: 1;  display: block; "><?=$site['title']?></span>
				<span style="font-size: 16px; color: #808080;"><?=$site['descr'];?></span>
			</span>
		</span>
	</div>
	<div style="padding: 20px 20px 40px; font-size: 14px; line-height: 21px;">
		<? if(isset($name) and $name) { ?>Ув. <strong><?=$name;?></strong><br/><? } ?>
		Спасибо за Ваш заказ.<br/>
		<br/>
		
		<? if(isset($delivery)) { ?><strong>Доставка</strong>: <?=$delivery;?><br/><? } ?>
		<? if(isset($delivery_price)) { ?><strong>Стоимость доставки</strong>: <?=price($delivery_price);?> <?=$currency['unit'];?><br/><? } ?>
		<? if(isset($pay)) { ?><strong>Оплата</strong>: <?=$pay;?><br/><? } ?>
		
		<strong>Товаров</strong>: <?=$count;?><br/>
		<strong>На сумму</strong>: <?=price($price);?> <?=$currency['unit'];?><br/><br/>
		<strong>ИТОГО</strong>: <?=price($total);?> <?=$currency['unit'];?><br/>
		<br/>
		
		<table style="width: 100%; border-collapse: collapse; border-spacing: 0; border: 1px solid #d8d8d8;">
			<thead style="border-bottom: 2px solid #d8d8d8;">
				<tr>
					<th style="border: 1px solid #d8d8d8; padding: 10px 15px;">Наименование</th>
					<th style="border: 1px solid #d8d8d8; padding: 10px 15px;">Цена</th>
					<th style="border: 1px solid #d8d8d8; padding: 10px 15px;">Количество</th>
					<th style="border: 1px solid #d8d8d8; padding: 10px 15px;">Сумма</th>
				</tr>
			</thead>
			<tbody>
			<? foreach($products as $item) { ?>
				<tr>
					<td style="border: 1px solid #d8d8d8; padding: 10px 15px;">
						<div><strong><?=$item['title'];?></strong></div>
					</td>
					<td style="border: 1px solid #d8d8d8; padding: 10px 15px;"><?=price($item['price']);?> <?=$currency['unit'];?></td>
					<td style="border: 1px solid #d8d8d8; padding: 10px 15px;"><?=$item['count'];?></td>
					<td style="border: 1px solid #d8d8d8; padding: 10px 15px;"><?=price($item['total']);?> <?=$currency['unit'];?></td>
				</tr>
			<? } ?>
			</tbody>
		</table>
		
		Номер вашего заказа <strong>#<?=$alias;?></strong><br/>
		Более подробная информацию Вы можете получить по ссылке<br/>
		<?=anchor('/order/'.$alias, '', array('style' => 'color: #f02c3e'));?>
	</div>
</div>