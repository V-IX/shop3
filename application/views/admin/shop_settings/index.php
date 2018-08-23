<h3 class="text-info mb15">Магазин:</h3>

<div class="form-group">
	<?=fa('shopping-basket fa-fw text-gray h4 mr5');?> Режим магазина: <?=$siteinfo['shop'] == 1 ? '<span class="text-success">включен</span>' : '<span class="text-error">отключен</span>';?>
</div>
<div class="form-group">
	<?=fa('usd fa-fw text-gray h4 mr5');?> <?=$currency['title'];?> (<?=$currency['alias'];?>)
</div>

<hr class="mb20" />

<h3 class="text-info mb15">Единицы измерения:</h3>

<div class="form-group">
	<?=fa('balance-scale fa-fw text-gray h4 mr5');?> <?=$weight['title'];?>
</div>
<div class="form-group">
	<?=fa('list-ol fa-fw text-gray h4 mr5');?> <?=$length['title'];?>
</div>

<hr class="mb20" />

<h3 class="text-info mb15">Магазин:</h3>

<div class="form-group">
	<?=fa('list fa-fw text-gray h4 mr5');?> Товаров на странице: <?=$siteinfo['count_front'];?>
</div>
<div class="form-group">
	<?=fa('list fa-fw text-gray h4 mr5');?> Товаров в админ панели: <?=$siteinfo['count_admin'];?>
</div>
<div class="form-group">
	<?=fa('comments-o fa-fw text-gray h4 mr5');?> Отзывы к товарам: <?=$siteinfo['reviews'] == 1 ? '<span class="text-success">включены</span>' : '<span class="text-error">отключены</span>';?>
</div>

<div class="form-actions">
	<?=anchor('admin/'.uri(2).'/edit', 'Изменить настройки', array('class' => 'btn btn-success'));?>
	<?=anchor('admin', 'Вернуться на главную', array('class' => 'btn'));?>
</div>