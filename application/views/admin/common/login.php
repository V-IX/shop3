<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">

<head>

	<title>Авторизация - <?=$settings['title'];?> AdminPanel</title>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=1000" />
	
	<?=link_tag('assets/plugins/font-awesome/css/font-awesome.min.css');?>
	<?=link_tag('assets/plugins/font-roboto/font.css');?>
	<?=link_tag('assets/admin/css/reset.css');?>
	<?=link_tag('assets/admin/css/template.css');?>
	<?=link_tag('assets/admin/css/content.css');?>
	
	<?=link_tag('favicon.ico', 'shortcut icon', 'image/ico');?>
	<?=link_tag('favicon.ico', 'shortcut', 'image/ico');?>
	
</head>
<body class="login">
<div class="login-form">
	<h3 class="mb20">Вход в админ-панель</h3>
	<?=form_open('');?>
	<? if($error) { ?>
		<div class="form-error mb20"><?=$error;?></div>
	<? } ?>
	<? if($this->session->flashdata('result') != "") { ?>
		<?=$this->session->flashdata('result'); ?>
	<? } ?>
		<div class="form-group">
			<div class="form-caption">Логин:</div>
			<input type="text" name="login" class="form-input" value="<?=set_value('login');?>" />
			<?=form_error('login', '<div class="form-error h6">', '</div>'); ?>
		</div>
		<div class="form-group">
			<div class="form-caption">Пароль:</div>
			<input type="password" name="password" class="form-input" value="<?=set_value('password');?>" />
			<?=form_error('password', '<div class="form-error h6">', '</div>'); ?>
		</div>
		<div class="row">
			<div class="col-6">
				<button class="btn btn-info">Войти</button>
			</div>
			<div class="col-6 form-collabel text-right">
				<?=anchor('/admin/login/password', 'Забыли пароль?', array('class' => 'text-gray'));?>
			</div>
		</div>
	<?=form_close();?>
</div>
</body>
</html>