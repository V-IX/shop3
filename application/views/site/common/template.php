<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<title><?=$seo['title'];?></title>
	<meta name="keywords" content="<?=$seo['keywords'];?>" />
	<meta name="description" content="<?=$seo['description'];?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	
	<?=link_tag('assets/plugins/font-awesome/css/font-awesome.min.css');?>
	<?=link_tag('assets/plugins/grid/grid.css');?>
	<?=link_tag('assets/plugins/checkers/checkers.css');?>
	<?=link_tag('assets/site/css/reset.css');?>
	<?=link_tag('assets/site/css/template.css');?>
	<?=link_tag('assets/site/css/content.css');?>
	<?=link_tag('assets/site/css/mobile.css');?>
	
	<?=link_tag('favicon.ico', 'shortcut icon', 'image/ico');?>
	<?=link_tag('favicon.ico', 'shortcut', 'image/ico');?>
	
	<? $csrf = $this->security->get_csrf_hash();?>
	<script>
		base_url = "<?=base_url()?>"
		csrf_test_name = "<?=$csrf;?>"
	</script>
	
	<?=script('assets/plugins/jquery/jquery-1.9.1.min.js');?>
	<?=script('assets/plugins/jquery.mask/jquery.maskedinput.js');?>
	<?=script('assets/plugins/bpopup/jquery.bpopup.min.js');?>
	<?=script('assets/plugins/ajaxForm/form.js');?>
	<?=script('assets/site/js/cart.js');?>
	<?=script('assets/site/js/js.js');?>
	
</head>
<body>

<div class="super-wrapper">

<header class="header">
	<div class="wrapper">
		<div class="header-left">
			<a href="<?=base_url();?>" class="logo-wrap">
				<?=img(array('src' => 'assets/uploads/settings/'.$siteinfo['img'], 'alt' => $seo['title'], 'class' => 'logo'));?>
				<div class="logo-text">
					<div class="logo-title"><?=$siteinfo['title'];?></div>
					<div class="logo-descr"><?=$siteinfo['descr'];?></div>
				</div>
			</a>
		</div>
		<div class="header-right">
			<? if($siteinfo['shop'] == 1) { ?>
			<a href="<?=base_url('cart');?>" class="header-cart minicart <?=$this->cart->total_items() == 0 ? '_empty' : '';?>">
				<?=fa('shopping-cart');?>
				<span class="label">Корзина</span>
				<span data-cart="total_items" class="count"><?=$this->cart->total_items();?></span>
			</a>
			<? } ?>
			<a href="javascript:void(0)" class="btn header-btn" data-toggle="popup" data-task="Заказать звонок: шапка">Заказать звонок</a>
		</div>
		<div class="floater"></div>
		<div class="header-center">
			<a href="javascript:void(0)" class="header-center-btn">Показать контакты</a>
			<div class="cols clearfix">
				<li class="col">
					<ul class="header-phones">
						<li>
							<i class="_mts"></i>
							<?=phone($siteinfo['phone'], $siteinfo['phoneMask']);?>
						</li>
						<li>
							<i class="_vel"></i>
							<?=phone($siteinfo['phone2'], $siteinfo['phone2Mask']);?>
						</li>
					</ul>
				</li>
				<li class="col">
					<ul class="header-info">
						<li>
							<?=fa('map-marker fa-fw');?>
							<div class="header-adres"><?=$siteinfo['adres'];?></div>
						</li>
						<li class="_email">
							<?=fa('envelope-o fa-fw');?>
							<div class="header-email"><?=$siteinfo['email'];?></div>
						</li>
					</ul>
				</li>
			</div>
		</div>
	</div>
</header>
<nav class="tmenu">
	<div class="wrapper">
		<a href="javascript:void(0)" class="tmenu-btn">Меню сайта <?=fa('bars right');?></a>
		<div class="tmenu-wrap">
			<ul class="tmenu-list">
			<? foreach($tmenu as $_tmenu) { ?>
				<li>
					<div class="tmenu-item">
						<a href="<?=base_url($_tmenu['link']);?>" target="<?=$_tmenu['target'];?>" class="<?=$_tmenu['current'] ? 'current' : null;?>">
							<?=$_tmenu['title'];?>
						</a>
						<? if(!empty($_tmenu['child'])) { ?>
							<span class="toggle"><?=fa('chevron-down');?></span>
							<ul class="tmenu-child">
							<? foreach($_tmenu['child'] as $child) { ?>
								<li>
									<a href="<?=base_url($child['link']);?>" target="<?=$child['target'];?>"><?=$child['title'];?></a>
								</li>
							<? } ?>
							</ul>
						<? } ?>
					</div>
				</li>
			<? } ?>
			</ul>
		</div>
	</div>
</nav>

<main class="content">
	<? $this->load->view('site/'.$view); ?>
</main>

</div>

<footer class="footer">
	<section class="footer-top">
		<div class="wrapper">
			<div class="footer-left">
				<div class="copyright">
					<strong><?=date('Y');?> &copy; <?=$siteinfo['title'];?>.</strong> Все права защищены.
				</div>
				<ul class="header-phones">
					<li>
						<i class="_mts"></i>
						<?=phone($siteinfo['phone'], $siteinfo['phoneMask']);?>
					</li>
					<li>
						<i class="_vel"></i>
						<?=phone($siteinfo['phone2'], $siteinfo['phone2Mask']);?>
					</li>
				</ul>
				<div class="footer-email">
					<?=fa('envelope-o fa-fw');?>
					<div class="header-email"><?=$siteinfo['email'];?></div>
				</div>
			</div>
			<div class="footer-right">
				<nav class="footer-menu">
					<ul class="list clearfix">
					<? foreach($fmenu as $_fmenu) { ?>
						<li>
							<div class="title"><?=$_fmenu['title'];?></div>
							<ul class="child">
							<? foreach($_fmenu['child'] as $child) { ?>
								<li>
									<a href="<?=base_url($child['link']);?>" target="<?=$child['target'];?>"><?=$child['title'];?></a>
								</li>
							<? } ?>
							</ul>
						</li>
					<? } ?>
					</ul>
				</nav>
			</div>
		</div>
	</section>
	<section class="footer-bottom">
		<div class="wrapper">
			Разработка сайта - веб-студия
			<noindex><a href="http://narisuemvse.by" target="blank" class="text-inherit">Narisuemvse.by</a></noindex>
		</div>
	</section>
</footer>

<div class="popup" id="feedback">
	<div class="popup-close close"></div>
	<div class="title">Заказать звонок</div>
	<div class="descr">Оставьте заявку и наши специалисты свяжутся с Вами!</div>
	<?=form_open(base_url('contacts/ajaxSend', null, true), array('data-toggle' => 'ajaxForm', 'class' => 'form'));?>
		<div class="form-group">
			<input type="text" name="name" class="form-input" placeholder="Ваше имя" />
		</div>
		<div class="form-group mb15">
			<input type="text" name="phone" class="form-input" placeholder="Ваш телефон *" data-rules="required" />
		</div>
		<button class="btn btn-xl wide">Заказать звонок</button>
		<input type="hidden" name="title" id="popupTask" value="Обратная связь" />
	<?=form_close();?>
</div>
<div class="popup" id="thanks">
	<div class="popup-close close"></div>
	<div class="title">Спасибо за заявку!</div>
	<div class="descr">Наши специалисты свяжутся<br/>с Вами в ближайшее время!</div>
</div>


<div class="popup" id="order">
	<div class="popup-close close"></div>
	<div class="title">Быстрый заказ</div>
	<div class="descr">Оставьте заявку и наши специалисты свяжутся с Вами!</div>
	<?=form_open(base_url('contacts/ajaxOrder', null, true), array('data-toggle' => 'ajaxForm', 'class' => 'form', 'data-thanks' => '#thanksSpeed'));?>
		<div class="form-group">
			<input type="text" name="name" class="form-input" placeholder="Ваше имя" />
		</div>
		<div class="form-group mb15">
			<input type="text" name="phone" class="form-input" placeholder="Ваш телефон *" data-rules="required" />
		</div>
		<button class="btn btn-xl wide">Оставить заявку</button>
		<input type="hidden" name="title" id="orderTask" value="Купить в один клик" />
	<?=form_close();?>
</div>
<div class="popup" id="thanksSpeed">
	<div class="popup-close close"></div>
	<div class="title">Спасибо за заказ!</div>
	<div class="descr">Наши специалисты свяжутся<br/>с Вами для уточнения данных!</div>
</div>


<div class="popup _cart popup-cart">
	<div class="popup-cart-top">
		<div class="popup-close close _close"></div>
		<div class="title">Товар добавлен в корзину!</div>
		<div class="descr">В корзине <span data-cart="total_items"><?=$this->cart->total_items();?></span> товара на сумму <span data-cart="total_price"><?=$this->cart->total();?></span> руб.</div>
		
		<div class="row mt25">
			<div class="col-sm-5 popup-cart-img">
				<img src="" data-cart="img" class="block wide" alt="" />
			</div>
			<div class="col-sm-7 popup-cart-descr">
				<div class="h4 semibold mb10 _cart_title" data-cart="title">Название товара</div>
				<div class="mb15"><span class="" data-cart="qty">1</span> шт. = <span class="" data-cart="item_total">0</span> руб.</div>
				<div class="mb5"><a href="<?=base_url('cart');?>" class="btn btn-small"><?=fa('shopping-cart mr5');?> Перейти в корзину</a></div>
				<div class=""><a href="javascript:void(0)" class="color-gray h6 _close">Продолжить покупки</a></div>
			</div>
		</div>
	</div>
	<div class="popup-cart-bottom">
		<div class="title">Не хотите заполнять никаких форм?</div>
		<div class="descr">Просто оставьте свой номер телефона и консультант решит все вопросы по оформлению заказа.</div>
		<?=form_open('contacts/ajaxOrder', array('data-toggle' => 'ajaxForm', 'class' => 'form clearfix', 'data-thanks' => '#thanksSpeed'));?>
			<input type="text" name="phone" class="form-input" placeholder="Ваш телефон *" data-rules="required" data-input="phone" />
			<input type="hidden" name="title" id="cartTask" value="" />
			<button class="btn">Жду звонка</button>
		<?=form_close();?>
	</div>
</div>

</body>
</html>