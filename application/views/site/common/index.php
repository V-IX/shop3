<?=script('assets/plugins/flexslider/jquery.flexslider-min.js');?>

<? if(!empty($slider)) { ?>
	<? $this->load->view('site/common/slider'); ?>
<? } ?>

<section class="home-catalogs">
	<div class="wrapper">
		<? $_c = 1; $catalogs = array(
			array('title' => 'Тренажеры', 'link' => 'catalog/trenazhery'),
			array('title' => 'Тяжелая<br/> атлетика', 'link' => 'catalog/tyazhelaya-atletika'),
			array('title' => 'Спортивный<br/> инвентарь', 'link' => 'catalog/sportivnyj-inventar'),
			array('title' => 'Спортивная<br/> одежда', 'link' => 'catalog/sportivnaya-odezhda'),
		);?>
		<ul class="list clearfix">
		<? foreach($catalogs as $catalog) { ?>
			<li>
				<a href="<?=base_url($catalog['link']);?>" class="item _<?=$_c;?>">
					<div class="in">
						<div class="title"><span><?=$catalog['title'];?></span></div>
						<span class="btn btn-gray">Жмите!</span>
					</div>
				</a>
			</li>
		<? $_c++;} ?>
		</ul>
	</div>
</section>

<? if(!empty($hits)) { ?>
<section class="home-products">
	<div class="wrapper">
		<div class="home-title">Лучшие предложения</div>

		<div class="products-slider-wrap">
			<div class="products-slider" id="hitsSlider">
				<ul class="slides clearfix">
				<? foreach($hits as $product) { ?>
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

<? if(!empty($news)) { ?>
<section class="home-news">
	<div class="wrapper">
		<div class="home-title">Новости и акции</div>

		<div class="news-slider-wrap">
			<div class="news-slider" id="newsSlider">
				<ul class="slides clearfix">
				<? foreach($news as $new) { ?>
					<li>
						<div class="news-slider-item">
							<a href="<?=base_url('news/'.$new['alias']);?>" class="news-item clearfix">
								<div class="img">
									<?=check_img('assets/uploads/news/thumb/'.$new['img'], array('alt' => $new['mTitle']), 'news.png');?>
								</div>
								<div class="descr">
									<div class="title"><?=$new['title'];?></div>
									<div class="brief"><?=$new['brief'];?></div>
									<div class="date"><?=translate_date($new['addDate']);?></div>
								</div>
							</a>
						</div>
					</li>
				<? } ?>
				</ul>
			</div>
			<div class="products-slider-nav" id="newsSliderNav"></div>
		</div>
		
		<div class="home-news-bottom">
			<a href="<?=base_url('news');?>">все новости</a>
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

<section class="home-about">
	<div class="wrapper">
		<h1 class="home-title"><?=$pageinfo['title'];?></h1>
		<div class="clearfix">
			<div class="img">
				<img src="<?=base_url('assets/site/img/about.jpg');?>" alt="<?=htmlspecialchars($pageinfo['mTitle']);?>" />
			</div>
			<div class="descr">
				<div class="text-editor">
					<?=$pageinfo['text'];?>
				</div>
				<div class="home-about-bottom">
					<a href="<?=base_url('pages/about');?>">подробнее</a>
				</div>
			</div>
		</div>
	</div>
</section>

<? if(!empty($mfrs)) { ?>
<section class="home-mfrs">
	<div class="wrapper">
		<div class="home-title">Наши бренды</div>

		<div class="mfrs-slider-wrap">
			<div class="mfrs-slider" id="mfrsSlider">
				<ul class="slides clearfix">
				<? foreach($mfrs as $mfr) { ?>
					<li>
						<div class="mfrs-slider-item">
							<a href="<?=base_url('mfrs/'.$mfr['alias']);?>" class="mfrs-img clearfix">
								<?=check_img('assets/uploads/mfrs/thumb/'.$mfr['img'], array('alt' => $mfr['mTitle']));?>
							</a>
						</div>
					</li>
				<? } ?>
				</ul>
			</div>
			<div class="products-slider-nav" id="mfrsSliderNav"></div>
		</div>
	</div>
</section>
<script>
	$(window).load(function() {
		$('#mfrsSlider').flexslider({
			animation: "slide",
			controlsContainer: $('#mfrsSliderNav'),
			directionNav: false,
			itemWidth: 162,
			minItems: 2,
			maxItems: 7
		});
	});
</script>
<? } ?>