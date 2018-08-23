<?=script('assets/plugins/flexslider/jquery.flexslider-min.js');?>

<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$item['title'];?></span></h1>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<div class="product-left">
			<? $this->load->view('site/shop/tree'); ?>
			<?=isset($banners['product']) ? '<div class="catalog-lbanner">'.banner($banners['product']).'</div>' : null;?>
		</div>
		<div class="product-right">
			<div class="product-view-top clearfix">
				<div class="product-gallery">
					<div class="gallery">
						<a href="<?=base_url('assets/uploads/products/'.$item['img']);?>" class="img _big" <? if($item['img']) { ?>data-toggle="vix"<? } ?>>
							<?=check_img('assets/uploads/products/thumb/'.$item['img'], array('alt' => $item['mTitle']));?>
							<span class="zoom"><?=fa('search-plus');?></span>
						</a>
						<? if(!empty($imgs)) { ?>
							<div class="gallery-slider-wrap">
								<div class="gallery-slider" id="gallerySlider">
									<ul class="slides clearfix">
										<? foreach($imgs as $img) { ?>
											<li>
												<a href="<?=base_url('assets/uploads/products/'.$img['img']);?>" class="img _small" data-toggle="vix">
													<?=check_img('assets/uploads/products/thumb/'.$img['img'], array('alt' => $item['mTitle']));?>
													<span class="zoom"><?=fa('search-plus');?></span>
												</a>
											</li>
										<? } ?>
									</ul>
								</div>
								<? if(count($imgs) > 3) { ?>
								<div class="gallery-slider-btns" id="gallerySliderBtns">
									<a href="javascript:void(0)" class="flex-prev"><?=fa('angle-left');?></a>
									<a href="javascript:void(0)" class="flex-next"><?=fa('angle-right');?></a>
								</div>
								<script>
									$(window).load(function() {
										$('#gallerySlider').flexslider({
											animation: "slide",
											controlNav: false,
											customDirectionNav: $("#gallerySliderBtns a"),
											itemWidth: 112,
											minItems: 2,
											maxItems: 3
										});
									});
								</script>
								<? } ?>
							</div>
						<? } ?>
					</div>
				</div>
				
				<div class="product-info">
					<div class="clearfix">
						<div class="product-articul">
							Арт.: <?=$item['articul'];?>
						</div>
					<? if($siteinfo['reviews'] and count($comments)) { ?>
						<div class="product-raiting">
							<div class="stars-bar">
								<div class="stars-bar-in" style="width: <?=round($item['raiting'] * 100 / 5, 2);?>%;"></div>
							</div>
							<a href="javascript:void(0)" data-hreftab="#reviews">Отзывы: <strong><?=count($comments);?></strong></a>
						</div>
					<? } ?>
					</div>
					
					<hr class="product-info-sep"/>
				
					<? // ----- FEATURES -----?>
					<div class="product-features">
						<ul class="row">
							<? if(!empty($mfrs)) { ?>
								<li class="col-md-6"><span class="label">Производитель:</span> <a href="<?=base_url('mfrs/'.$mfrs['alias']);?>"><?=$mfrs['title']?></a></li>
							<? } ?>
							<? if($item['country']) { ?>
								<li class="col-md-6"><span class="label">Страна:</span> <?=$item['country'];?></li>
							<? } ?>
							<li class="floater"></li>
							<? if($item['text_garanty']) { ?>
								<li class="col-md-6"><span class="label">Гарантия:</span> <?=$item['text_garanty'];?></li>
							<? } ?>
							<? if($item['text_delivery']) { ?>
								<li class="col-md-6"><span class="label">Доставка:</span> <?=$item['text_delivery'];?></li>
							<? } ?>
							<? if($item['length'] != 0 or $item['width'] != 0 or $item['height'] != 0) { ?>
								<? $size_v = ''; $size_l = '';?>
								<? if($item['length'] != 0) { $size_v .= round($item['length'], 2).' x '; $size_l .= 'Д x '; } ?>
								<? if($item['width'] != 0) { $size_v .= round($item['width'], 2).' x '; $size_l .= 'Ш x '; } ?>
								<? if($item['height'] != 0) { $size_v .= round($item['height'], 2); $size_l .= 'В'; } ?>
								<li class="floater"></li>
								<li class="col-md-12">
									<span class="label">Габариты (<?=trim($size_l, ' x ');?>):</span>
									<?=trim($size_v, ' x ');?>
									<?=$p_length['alias'];?>
								</li>
							<? } ?>
							<? if($item['weight'] != 0) { ?>
								<li class="floater"></li>
								<li class="col-md-12">
									<span class="label">Вес:</span>
									<?=round($item['weight'], 2);?>
									<?=$p_weight['alias'];?>
								</li>
							<? } ?>
						</ul>
					</div>
					
					<hr class="product-info-sep"/>
				
					<? // ----- MODIFICATIONS -----?>
					
					<? if($siteinfo['shop'] == 1) {
						$_checked = false;
						$_start_id = false;
						$_start_price = 0;
						$_start_oldprice = 0;
						$_start_mod = 0;
						if(!$item['count_subtraction'] or ($item['count_subtraction'] and $item['count'] > 0))
						{
							$_start_id = $item['articul'];
							$_start_price = $item['price'];
							$_start_oldprice = $item['oldPrice'];
						}
					} ?>
					
					<? if(!empty($mods)) { ?>
						<div class="product-mods">
							<div class="title">Модификации</div>
							<ul class="product-mods-list <?=$siteinfo['shop'] == 1 ? 'active' : '';?>">
							<? if($siteinfo['shop'] == 1) { ?>
								<? $_dis = ($item['count_subtraction'] and $item['count'] < 1) ? 'disabled' : '';?>
								<li>
									<label>
										<input type="radio" name="mod" value="<?=$item['articul'];?>" data-mod="0" data-price="<?=price($item['price']);?>" data-old="<?=price($item['oldPrice']);?>" <?=$_dis;?> <?=(!$_dis and !$_checked) ? 'checked' : ''?> />
										<?=$item['title'];?> <span class="_articul">(<?=$item['articul'];?>)</span>
										<? if($_dis) { ?><span class="ml10">нет в наличии</span><? } ?>
									</label>
								</li>
								<? if(!$_dis and !$_checked) $_checked = true;?>
							<? } ?>
							<? foreach($mods as $mod) { ?>
								<? $_mod_price = price_calc($mod['price'], $currency['value'], $p_currency['value']);?>
								<? $_mod_oldprice = price_calc($mod['oldPrice'], $currency['value'], $p_currency['value']);?>
								
								<li>
									<label>
										<? if($siteinfo['shop'] == 1) { ?>
											<? $_dis = ($item['count_subtraction'] and $mod['count'] < 1) ? 'disabled' : '';?>
											<input type="radio" name="mod" value="<?=$mod['articul'];?>" data-mod="1" data-price="<?=price($_mod_price);?>" data-old="<?=price($_mod_oldprice);?>" <?=$_dis;?> <?=(!$_dis and !$_checked) ? 'checked' : ''?> />
										<? } ?>
										<?=$mod['title'];?> <span class="_articul">(<?=$mod['articul'];?>)</span>
										<? if($_dis) { ?><span class="ml10">нет в наличии</span><? } ?>
									</label>
								</li>
								<? if(!$_dis and !$_checked) {
									$_checked = true;
									$_start_id = $mod['articul'];
									$_start_price = $_mod_price;
									$_start_oldprice = $_mod_oldprice;
									$_start_mod = 1;
								} ?>
							<? } ?>
							</ul>
						</div>
					
						<hr class="product-info-sep"/>
					<? } ?>
					
					<? // ----- PRICES -----?>
					<? if($siteinfo['shop'] == 1) { ?>
						<? if($item['count_subtraction'] == 0 or ($item['count_subtraction'] == 1 and $_checked)) { ?>
							<div class="product-price">
								<div class="price" id="prodPrice"><?=price($_start_price);?> <?=$currency['unit'];?></div>
								<div class="oldprice">
									<span id="prodOldprice"><? if($_start_oldprice != 0) { ?><?=price($_start_oldprice);?> <?=$currency['unit'];?><? } ?></span>
								</div>
							</div>
							<div class="product-panel clearfix">
								<div class="cart-counter" data-toggle="cart-counter">
									<a href="javascript:void(0)" class="cart-counter-btn _prev" data-count-direction="-1">&minus;</a>
									<a href="javascript:void(0)" class="cart-counter-btn _next" data-count-direction="1">&plus;</a>
									<input type="text" name="qty" class="cart-counter-input" data-toggle="cart-input" value="1" />
								</div>
								<a href="javascript:void(0)" class="btn" data-toggle="add2cart" data-cart-mod="<?=$_start_mod;?>" data-cart-qty="1" data-cart-id="<?=$_start_id;?>">
									<?=fa('shopping-cart mr5');?> В корзину
								</a>
								<div class="mt5">
									<a href="javascript:void(0)" class="linkclick" data-toggle="order" data-task="Купить в один клик: <?=htmlspecialchars($item['title']);?>">Купить в один клик</a>
								</div>
							</div>
						<? } else { ?>
							<div class="product-discover">
								<a href="javascript:void(0)" class="btn" data-toggle="popup" data-task="Узнать стоимость: <?=htmlspecialchars($item['title']);?>">
									<?=fa('question-circle mr5');?>
									<span>Узнать стоимость</span>
								</a>
								<div class="_av"><?=fa('times mr5');?> нет в наличии</div>
							</div>
						<? } ?>
					<? } else { ?>
						<div class="product-discover">
							<a href="javascript:void(0)" class="btn" data-toggle="popup" data-task="Узнать стоимость: <?=htmlspecialchars($item['title']);?>">
								<?=fa('question-circle mr5');?>
								<span>Узнать стоимость</span>
							</a>
						</div>
					<? } ?>
					
						<hr class="product-info-sep"/>
				
					<? // ----- CHARS -----?>
					<? $chars = json_decode($item['charArr'], true);?>
					<? if(!empty($chars)) { ?>
						<ul class="product-chars">
						<? foreach($chars as $char) { ?>
							<li>
								<div class="row">
									<div class="col-sm-5"><strong><?=$char['label'];?>:</strong></div>
									<div class="col-sm-6"><?=$char['value'];?></div>
								</div>
							</li>
						<? } ?>
						</ul>
					<? } ?>
				</div>
			</div>
			
			<? // ----- TABS -----?>
			<div class="product-tabs" data-toggle="tabs">
				<ul class="product-tabs-list clearfix" data-tabs="list">
				<? $_tab_active = false;?>
					<? if($item['text'] != '') { ?><li><a href="#descr" class="active"><span>Описание</span></a></li><? $_tab_active = true;} ?>
					<? foreach($descrs as $descr) { ?>
						<li><a href="#descr<?=$descr['idItem'];?>" class="<?=!$_tab_active ? 'active' : '';?>"><span><?=$descr['title'];?></span></a></li>
					<? $_tab_active = true;} ?>
					<? if($siteinfo['reviews']) { ?>
						<li><a href="#reviews" class="<?=!$_tab_active ? 'active' : '';?>"><span>Отзывы <?=!empty($comments) ? '('.count($comments).')' : '';?></span></a></li>
					<? } ?>
				</ul>
				
				<? $_tab_active = false;?>
				<? if($item['text'] != '') { ?>
					<div class="product-tabs-item active" data-tabs="item" id="descr">
						<div class="text-editor"><?=$item['text'];?></div>
					</div>
				<? $_tab_active = true;} ?>
				<? foreach($descrs as $descr) { ?>
					<div class="product-tabs-item <?=!$_tab_active ? 'active' : '';?>" data-tabs="item" id="descr<?=$descr['idItem'];?>">
						<div class="text-editor"><?=$descr['text'];?></div>
					</div>
				<? $_tab_active = true;} ?>
				<? if($siteinfo['reviews']) { ?>
					<div class="product-tabs-item <?=!$_tab_active ? 'active' : '';?>" data-tabs="item" id="reviews">
						<? if(empty($comments)) { ?>
							<?=action_result('info', 'Нет ни одного отзыва о товаре. Вы можете стать первым!');?>
						<? } else { ?>
							<ul class="product-comments">
							<? foreach($comments as $comment) { ?>
								<li>
									<div class="title">
										<?=$comment['title'];?>
										<span><?=translate_date($comment['addDate']);?></span>
										<div class="stars _<?=$comment['raiting'];?>"></div>
									</div>
									<div class="text">
										<?=nl2br($comment['text']);?>
										<? if($comment['link'] != '') { ?>
										<div class="ulink">
											<noindex><a href="<?=$comment['link'];?>" target="_blank" rel="nofollow"><?=$comment['link'];?></a></noindex>
										</div>
										<? } ?>
									</div>
								</li>
							<? } ?>
							</ul>
						<? } ?>
						
						<?=form_open('contacts/ajaxComment', array('data-toggle' => 'ajaxForm', 'class' => 'comments-form', 'data-thanks' => '#commentThanks'));?>
							<div class="comments-form-title">Оставить отзыв</div>
							<div class="form-row row">
								<div class="col-sm-6">
									<div class="form-group">
										<input type="text" name="title" placeholder="Представьтесь пожалуйста *" data-rules="required" class="form-input" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input type="text" name="phone" placeholder="Ваш телефон" class="form-input" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<textarea name="text" placeholder="Текст вашего отзыва *" class="form-input" rows="3" data-rules="required"></textarea>
							</div>
							<div class="form-group">
								<input type="text" name="link" placeholder="Ссылка на соцсети" class="form-input" />
							</div>
							<div class="row mt15">
								<div class="col-sm-6 product-comments-label">
									<div class="form-label mr10">Оценка товару</div>
									<div class="" data-toggle="stars" data-default="4"></div>
								</div>
								<div class="col-sm-6 product-comments-btn">
									<button class="btn">Оставить отзыв</button>
									<input type="hidden" name="idParent" value="<?=$item['idItem']?>" />
								</div>
							</div>
						<?=form_close();?>
					</div>
				<? } ?>
			</div>
		</div>
	</div>
</section>

<? if(!empty($articles)) { ?>
<section class="product-section">
	<div class="wrapper">
		<div class="home-title">Полезные статьи</div>

		<div class="news-slider-wrap">
			<div class="news-slider" id="newsSlider">
				<ul class="slides clearfix">
				<? foreach($articles as $new) { ?>
					<li>
						<div class="news-slider-item">
							<a href="<?=base_url('articles/'.$new['alias']);?>" class="news-item clearfix">
								<div class="img">
									<?=check_img('assets/uploads/articles/thumb/'.$new['img'], array('alt' => $new['title']), 'news.png');?>
								</div>
								<div class="descr">
									<div class="title"><?=$new['title'];?></div>
									<div class="brief"><?=$new['brief'];?></div>
								</div>
							</a>
						</div>
					</li>
				<? } ?>
				</ul>
			</div>
			<div class="products-slider-nav" id="newsSliderNav"></div>
		</div>
	</div>
</section>
<script>
	$(window).load(function() {
		$('#newsSlider').flexslider({
			animation: "slide",
			controlsContainer: $('#newsSliderNav'),
			directionNav: false,
			itemWidth: 380,
			minItems: 1,
			maxItems: 3
		});
	});
</script>
<? } ?>

<? if(!empty($similars)) { ?>
<section class="product-section">
	<div class="wrapper">
		<div class="home-title">Вместе с этим покупают</div>

		<div class="products-slider-wrap">
			<div class="products-slider" id="hitsSlider">
				<ul class="slides clearfix">
				<? foreach($similars as $product) { ?>
					<li>
						<div class="products-slider-item">
							<? $this->load->view('site/shop/product-item', array('product' => $product, 'paths' => $paths));?>
						</div>
					</li>
				<? } ?>
				</ul>
			</div>
			<div class="products-slider-btns" id="hitsSliderBtns">
				<a href="javascript:void(0)" class="flex-prev"><?=fa('angle-left');?></a>
				<a href="javascript:void(0)" class="flex-next"><?=fa('angle-right');?></a>
			</div>
		</div>
	</div>
</section>
<script>
	$(window).load(function() {
		$('#hitsSlider').flexslider({
			animation: "slide",
			controlNav: false,
			customDirectionNav: $("#hitsSliderBtns a"),
			itemWidth: 228,
			minItems: 2,
			maxItems: 5
		});
	});
</script>
<? } ?>

<? if($siteinfo['reviews'] == 1) { ?>
<?=script('assets/plugins/stars/stars.js');?>
<?=link_tag('assets/plugins/stars/stars.css');?>

<div class="popup _popup_comments" id="commentThanks">
	<div class="popup-close close"></div>
	<div class="title">Спасибо За Ваш отзыв!</div>
	<div class="descr">Ваше мнение очень важно для нас!<br/>Комментарий будет опубликован после модерацию</div>
</div>
<? } ?>

<? if($siteinfo['shop'] == 1) { ?>

<script>
	$('[name="mod"]').change(function(){
		el = $(this);
		add = $('.product-panel').find('[data-toggle="add2cart"]');
		
		articul = el.val();
		price = el.attr('data-price');
		price2 = el.attr('data-price2');
		oldprice = el.attr('data-old');
		mod = el.attr('data-mod');
		
		unit = '<?=$currency['unit'];?>';
		
		add.attr('data-cart-mod', mod);
		add.attr('data-cart-id', articul);
		
		$('#prodPrice').text(price + ' ' + unit);
		$('#prodOldprice').text(parseFloat(oldprice) ? oldprice + ' ' + unit : '');
	});

	$('[data-toggle="cart-input"]').bind("change keyup input click", function() {
		el = $(this);
		
		if (this.value.match(/[^0-9]/g)) {
			this.value = this.value.replace(/[^0-9]/g, '');
		}
		
		el.closest('.product-panel').find('[data-toggle="add2cart"]').attr('data-cart-qty', el.val());
	});

	$('[data-count-direction]').click(function(){
		el = $(this);
		counter = el.closest('[data-toggle="cart-counter"]');
		input = counter.find('[data-toggle="cart-input"]');
		val = parseInt(input.val());
		dir = parseInt(el.attr('data-count-direction'));
		
		val = val + dir;
		if(val < 1) val = 1;
		
		input.val(val);
		
		el.closest('.product-panel').find('[data-toggle="add2cart"]').attr('data-cart-qty', val);
	});
</script>

<? } ?>

<?=script('assets/plugins/checkers/checkers.js');?>
<?=link_tag('assets/plugins/checkers/checkers.css');?>

<?=script('assets/plugins/vix-gallery/js/jquery.vix-gallery.js');?>
<?=link_tag('assets/plugins/vix-gallery/css/gallery.css');?>
<script>$('[data-toggle="vix"]').gallery();</script>