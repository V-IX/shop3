<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$item['title'];?></span></h1>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<div class="news-date"><?=translate_date($item['addDate']);?></div>
		<div class="text-editor">
			<?=$item['text'];?>
		</div>
		<div class="page-bottom clearfix">
			<div class="page-social">
				<div class="social">
					<div class="social-label">Поделиться:</div>
					<div class="social-init" data-toggle="social"></div>
					<?=script('assets/plugins/share42/share.js');?>
				</div>
			</div>
			<div class="page-return">
				<a href="<?=base_url(uri(1));?>">все новости и акции</a>
			</div>
		</div>
	</div>
</section>

<? if(!empty($news)) { ?>
<section class="news-other">
	<div class="wrapper">
		<div class="home-title">Читайте также</div>

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
	</div>
</section>

<?=script('assets/plugins/flexslider/jquery.flexslider-min.js');?>
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