<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">

<head>

	<title>Восстановление пароля - <?=$settings['title'];?> AdminPanel</title>

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
	<h3 class="mb20">Восстановление пароля</h3>
	<?=form_open('');?>
	<? if($error) { ?>
		<div class="form-error mb20"><?=$error;?></div>
	<? } ?>
	<? if($this->session->flashdata('result') != "") { ?>
		<div class="form-error mb20">
			<?=$this->session->flashdata('result'); ?>
		</div>
	<? } ?>
		<div class="form-group">
			<div class="form-caption">Логин:</div>
			<input type="text" name="login" class="form-input" value="<?=set_value('login');?>" />
			<?=form_error('login'); ?>
		</div>
		<button class="btn btn-info">Восстановить пароль</button>
	<?=form_close();?>
</div>
</body>
</html>