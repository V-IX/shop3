<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		E-mail <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="email" value="<?=set_value('email', $item['email']);?>" />
		<div class="form-info text-gray h6">Укажите действующий E-mail, на случай утери пароля</div>
		<?=form_error('email'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Имя <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="name" value="<?=set_value('email', $item['name']);?>" />
		<?=form_error('name'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Фамилия
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="sname" value="<?=set_value('email', $item['sname']);?>" />
		<?=form_error('sname'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success">Редактировать</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>