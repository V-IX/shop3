<? $pageTop = isset($item) ? $item : $pageinfo;?>
<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageTop['title'];?></span></h1>
		<? if($pageTop['brief']) { ?><div class="page-brief"><?=$pageTop['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<div class="catalog-left">
			<div class="catalog-mobile clearfix">
				<a href="javascript:void(0)" class="cmenu-btn">Каталог товаров</a>
				<a href="javascript:void(0)" class="filter-btn"><?=fa('filter');?></a>
			</div>
			<? $this->load->view('site/shop/tree'); ?>
			<? $this->load->view('site/shop/filter'); ?>
			<?=isset($banners['catalog_left']) ? '<div class="catalog-lbanner">'.banner($banners['catalog_left']).'</div>' : null;?>
		</div>
		<div class="catalog-right">
			<? if(empty($products)) { ?>
				<div class="note">
					В категории нет товаров. <a href="<?=base_url('catalog');?>">Перейти в каталог</a>.
				</div>
			<? } else { ?>
				<div class="products-list">
					<ul class="clearfix">
					<? $i = 1; foreach($products as $product) { ?>
						<li>
							<? $this->load->view('site/shop/product-item', array('product' => $product, 'paths' => $paths));?>
						</li>
						<? if($i%4 == 0) { ?><li class="floater _1"></li><? } ?>
						<? if($i%3 == 0) { ?><li class="floater _2"></li><? } ?>
						<? if($i%2 == 0) { ?><li class="floater _3"></li><? } ?>
					<? $i++;} ?>
					</ul>
				</div>
				<?=$this->pagination->create_links();?>
			<? } ?>
			
			<div class="catalog-banner">
				<?=isset($banners['catalog_bottom']) ? banner($banners['catalog_bottom']) : null;?>
			</div>
			
			<? if(strip_tags($pageTop['text']) != '') { ?>
			<div class="page-text">
				<div class="home-shadow _shadow"></div>
				<div class="text-editor"><?=$pageTop['text'];?></div>
			</div>
			<? } ?>
		</div>
	</div>
</section>

<?=script('assets/plugins/checkers/checkers.js');?>
<?=link_tag('assets/plugins/checkers/checkers.css');?>