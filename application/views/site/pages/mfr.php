<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title">
			<span class="_in"><?=$item['title'];?></span>
			<? if($item['img']) { ?>
				<?=check_img('assets/uploads/'.uri(1).'/thumb/'.$item['img'], array('alt' => $item['mTitle'], 'class' => 'mfrs-pageimg'));?>
			<? } ?>
		</h1>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
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
				<a href="<?=base_url(uri(1));?>">все производители</a>
			</div>
		</div>
	</div>
</section>

<? if(!empty($products)) { ?>

<section class="news-other">
	<div class="wrapper">
		<div class="home-title">Возможно Вас заинтересует:</div>

		<div class="products-slider-wrap">
			<div class="products-slider" id="hitsSlider">
				<ul class="slides clearfix">
				<? foreach($products as $product) { ?>
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

<?=script('assets/plugins/flexslider/jquery.flexslider-min.js');?>
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