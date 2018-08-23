<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageinfo['title'];?></span></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<div class="news-list">
			<ul class="row">
			<? $i = 1; foreach($items as $item) { ?>
				<li class="col-sm-6 col-md-4">
					<a href="<?=base_url(uri(1).'/'.$item['alias']);?>" class="news-item clearfix">
						<div class="img">
							<?=check_img('assets/uploads/'.uri(1).'/thumb/'.$item['img'], array('alt' => $item['mTitle']));?>
						</div>
						<div class="descr">
							<div class="title"><?=$item['title'];?></div>
							<div class="brief"><?=$item['brief'];?></div>
						</div>
					</a>
				</li>
				<? if($i%3 == 0) { ?><li class="lg-show-only floater"></li><? } ?>
				<? if($i%2 == 0) { ?><li class="sm-show-only floater"></li><? } ?>
			<? $i++;} ?>
			</ul>
		</div>
		
		<?=$this->pagination->create_links();?>
			
		<? if(strip_tags($pageinfo['text']) != '') { ?>
		<div class="page-text">
			<div class="text-editor"><?=$pageinfo['text'];?></div>
		</div>
		<? } ?>
	</div>
</section>