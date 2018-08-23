<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><?=$pageinfo['title'];?></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<div class="parents-list">
			<ul class="row">
			<? $i = 1; foreach($items as $_parent) { ?>
				<li class="col-sm-4">
					<div class="parents-item">
						<div class="head clearfix">
							<div class="img">
								<?=check_img('assets/uploads/catalog/thumb/'.$_parent['img'], array('alt' => $_parent['title']));?>
							</div>
							<div class="descr">
								<a href="<?=base_url('catalog/'.$_parent['alias']);?>" class="title"><?=$_parent['title']?></a>
								<? if(!empty($_parent['childs'])) { ?>
									<div class="childs">
									<? foreach($_parent['childs'] as $child) { ?>
										<a href="<?=base_url('catalog/'.$paths[$child['idItem']]);?>"><?=$child['title'];?></a>
									<? } ?>
									</div>
								<? } ?>
							</div>
						</div>
						<div class="text">
							<?=$_parent['brief'];?>
						</div>
					</div>
				</li>
				<? if($i%3 == 0) { ?><li class="floater"></li><? } ?>
			<? $i++;} ?>
			</ul>
		</div>
		
		
		<? if(strip_tags($pageinfo['text']) != '') { ?>
		<div class="page-text">
			<div class="home-shadow _shadow"></div>
			<div class="text-editor"><?=$pageinfo['text'];?></div>
		</div>
		<? } ?>
	</div>
</section>