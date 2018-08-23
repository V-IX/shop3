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
		Код валюты <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="alias" value="<?=set_value('alias');?>" />
		<?=form_error('alias'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Сокращение <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="unit" value="<?=set_value('unit');?>" />
		<?=form_error('unit'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Значение <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="value" value="<?=set_value('value', 1.00);?>" />
		<?=form_error('value'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success">Создать</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>