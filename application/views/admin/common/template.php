<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">

<head>

	<title><? if(isset($pageinfo['title']) and $pageinfo['title'] != "") { ?><?=$pageinfo['title'];?> - <? } ?><?=$siteinfo['title'];?> AdminPanel</title>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=1000" />
	
	<?=link_tag('assets/plugins/font-awesome/css/font-awesome.min.css');?>
	<?=link_tag('assets/plugins/bootstrap/css/modals.css');?>
	<?=link_tag('assets/admin/css/reset.css');?>
	<?=link_tag('assets/admin/css/template.css');?>
	<?=link_tag('assets/admin/css/content.css');?>
	
	<?=link_tag('favicon.ico', 'shortcut icon', 'image/ico');?>
	<?=link_tag('favicon.ico', 'shortcut', 'image/ico');?>
	
	<?=script('assets/plugins/jquery/jquery-1.9.1.min.js');?>
	<?=script('assets/plugins/bootstrap/js/bootstrap.min.js');?>
	<?=script('assets/plugins/jquery.formstyler/jquery.formstyler.js');?>
	<?=script('assets/admin/js/content.js');?>
	
</head>
<body>
<div class="super-wrapper">
	<div class="header">
		<div class="row">
			<div class="col-6">
				<div class="header-title">
					<?=anchor('/admin', '<span>'.$siteinfo['title'].'</span> admin-panel');?>
				</div>
			</div>
			<div class="col-6 text-right">
				<div class="header-user">
					Добро пожаловать, 
					<div class="header-dropdown">
						<a href="javascript:void(0)"><?=$this->session->userdata('login');?></a>
						<div class="header-dropdown-info">
							<div class="header-dropdown-info-in">
								<div class="row">
									<div class="col-10">
										<?=$userinfo['name'];?>
										<?=$userinfo['sname'];?>
										<br/>
										<span class="text-gray h6">
											<? if($this->session->userdata('access') == "admin") {?>
												Администратор
											<? } elseif($this->session->userdata('access') == "moderator") { ?>
												Модератор
											<? } else { ?>
												Пользователь
											<? } ?>
										</span>
									</div>
									<div class="header-dropdown-edit col-2 text-right">
										<?=anchor('/admin/users/edit/'.$this->session->userdata('id'), '<i class="fa fa-pencil"></i>', array('class' => 'btn btn-icon btn-info'));?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="header-nav">
					<?=anchor('/', fa('home'));?>
					<?=anchor('/admin', fa('th-list'));?>
					<?=anchor('/admin/login/logout', fa('sign-out'));?>
				</div>
			</div>
		</div>
	</div>
	<div class="content clearfix">
		<div class="left-side">
			<ul class="left-menu">
			<? foreach($left_nav as $nav) { ?>
				<li>
					<? $current = uri(2) == $nav['alias'] ? 'current' : '';?>
					<? $nav['link'] = $nav['link'] != '' ? 'admin/'.$nav['link'] : 'js'; ?>
					<?=anchor($nav['link'], fa($nav['icon'].' fa-fw').' '.$nav['name'], array('class' => $current));?>
					<? if(!empty($nav['child'])) { ?>
						<ul class="submenu">
						<? foreach($nav['child'] as $child) { ?>
							<li>
								<? $current = uri(2) == $child['alias'] ? 'current' : '';?>
								<? $child['link'] = $child['link'] != '' ? 'admin/'.$child['link'] : 'js';
									$_label = '';
									if(array_key_exists($child['alias'], $admin_bells) and $admin_bells[$child['alias']]['count'] != 0) {
									$_label = '<span class="label label-'.$admin_bells[$child['alias']]['color'].'">'.$admin_bells[$child['alias']]['count'].'</span>';
								} ?>
								<?=anchor($child['link'], fa($child['icon'].' fa-fw').' '.$child['name'].$_label, array('class' => 'submenu-item '.$current));?>
								<? if($child['create_btn']) { ?>
									<a href="<?=base_url($child['link'].'/create');?>" class="create_btn"><?=fa('plus')?></a>
								<? } ?>
							</li>
						<? } ?>
						</ul>
					<? } ?>
				</li>
			<? } ?>
			</ul>
		</div>
		<div class="right-side">
			<div class="right-side-in">
				<div class="right-side-top">
					<?=$this->breadcrumbs->create_admin_links(); ?>
					<h1 class="page-title">
						<? if(isset($item['title']) and $item['title'] != "") { ?>
							<?=fa($pageinfo['icon']);?> <?=$item['title'];?>
						<? } elseif(isset($pageinfo['title']) and $pageinfo['title'] != "") { ?>
							<?=fa($pageinfo['icon']);?> <?=$pageinfo['title'];?>
						<? } else { ?>
							Без названия
						<? } ?>
					</h1>
				</div>
				<div class="page-content">
					<?=$this->session->flashdata('result'); ?>
					<?=(isset($_error) and $_error) ? $_error : '';?>
					<? $this->load->view('admin/'.$view);?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="footer">
	<div class="col-6">
		<div class="cms-info">
			<span><?=$cms['title'];?></span> <?=$cms['version'];?>
		</div>
	</div>
	<div class="col-6 text-right">
		<div class="narisuem-info"><?=$cms['copyright'];?></div>
	</div>
</div>
</body>
</html>