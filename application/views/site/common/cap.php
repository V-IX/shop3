<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<title><?=$seo['title'];?></title>
	<meta name="keywords" content="<?=$seo['keywords'];?>" />
	<meta name="description" content="<?=$seo['description'];?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	
	<?=link_tag('assets/plugins/grid/grid.css');?>
	<?=link_tag('assets/site/css/reset.css');?>
	<?=link_tag('assets/site/css/template.css');?>
	<?=link_tag('assets/site/css/content.css');?>
	<?=link_tag('assets/site/css/mobile.css');?>
	
	<?=link_tag('favicon.ico', 'shortcut icon', 'image/ico');?>
	<?=link_tag('favicon.ico', 'shortcut', 'image/ico');?>
	
</head>
<body class="cap">
	<div class="cap-form">
		<div class="img">
			<?=img('assets/uploads/settings/'.$siteinfo['img']);?>
		</div>
		<h1 class="title"><?=$siteinfo['title'];?></h1>
		<div class="subtitle"><?=$siteinfo['capTitle'];?></div>
		<div class="text"><?=nl2br($siteinfo['capDescr']);?></div>
		
		<div class="info">
			<div class="left">
				<?=phone($siteinfo['phone'], $siteinfo['phoneMask']);?>
			</div>
			<div class="right">
				<span><?=$siteinfo['email'];?></span>
			</div>
			<div class="floater"></div>
		</div>
	</div>
</body>
</html>