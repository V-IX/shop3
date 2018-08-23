<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" value="<?=set_value('title');?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Стоимость доставки
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="price" value="<?=set_value('price', 0);?>" />
		<?=form_error('price'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Подсказка
	</div>
	<div class="col-9 form-colinput">
		<textarea name="text" class="form-input" rows="3"><?=set_value('text');?></textarea>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Номер по порядку
		<div class="h6 text-gray">На сайте выводится в обратном порядке</div>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="num" value="<?=set_value('num', 1);?>" />
		<?=form_error('num'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Запрашивать адрес
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="adres" checked />
		<?=form_error('adres'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Отображать на сайте
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="visibility" checked />
		<?=form_error('visibility'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success">Создать</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>