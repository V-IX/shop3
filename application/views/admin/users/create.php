<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Логин <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="login" value="<?=set_value('login')?>" />
		<?=form_error('login'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Пароль <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="password" value="<?=set_value('password')?>" />
		<?=form_error('password'); ?>
		<a href="javascript:void(0)" class="h6" id="genPass">Сгенерировать пароль</a>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		E-mail <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="email" value="<?=set_value('email')?>" />
		<div class="form-info text-gray h6">Укажите действующий E-mail, на случай утери пароля</div>
		<?=form_error('email'); ?>
	</div>
</div>
<?/*
<div class="row form-group">
	<div class="col-3 form-collabel">
		Роль <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<select class="form-input" name="access">
			<option <?=set_select('access', 'moderator');?> value="moderator">Модератор</option>
			<option <?=set_select('access', 'admin');?> value="admin">Администратор</option>
		</select>
		<?=form_error('access'); ?>
	</div>
</div>*/?>
<input type="hidden" name="access" value="admin" />
<div class="row form-group">
	<div class="col-3 form-collabel">
		Имя <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="name" value="<?=set_value('name')?>" />
		<?=form_error('name'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Фамилия
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="sname" value="<?=set_value('sname')?>" />
		<?=form_error('sname'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success">Создать</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>

<script>
	$('#genPass').click(function(){
		var length = 6;
        var result = '';
        var symbols = new Array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M',1,2,3,4,5,6,7,8,9,0);
        for (i = 0; i < length; i++){
			result += symbols[Math.floor(Math.random() * symbols.length)];
        }
		$('[name="password"]').val(result);
	})
</script>