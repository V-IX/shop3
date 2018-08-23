<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Старый пароль <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="password" class="form-input" name="old_password" />
		<?=form_error('old_password'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Новый пароль <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="password" class="form-input" name="password" />
		<?=form_error('password'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Подтверждение пароля <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="password" class="form-input" name="confirm_password" />
		<?=form_error('confirm_password'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success">Изменить пароль</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>