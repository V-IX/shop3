<div class="row mb15">
	<div class="col-3 medium">Тема:</div>
	<div class="col-9"><?=$item['title'];?></div>
</div>
<div class="row mb15">
	<div class="col-3 medium">Имя:</div>
	<div class="col-9"><?=$item['name'];?></div>
</div>
<div class="row mb15">
	<div class="col-3 medium">Телефон:</div>
	<div class="col-9"><?=$item['phone'];?></div>
</div>
<div class="row mb15">
	<div class="col-3 medium">E-mail:</div>
	<div class="col-9"><?=$item['email'];?></div>
</div>
<div class="row mb15">
	<div class="col-3 medium">Комментарий:</div>
	<div class="col-9"><?=nl2br($item['text']);?></div>
</div>
<div class="form-actions">
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>