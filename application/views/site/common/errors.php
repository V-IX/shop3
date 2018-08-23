<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageinfo['title'];?></span></h1>
	</div>
</section>

<section class="page-content">
	<div class="wrapper">
		<div class="errors">
			<div class="num">404</div>
			<? if($pageinfo['brief']) { ?><div class="text"><?=$pageinfo['brief'];?></div><? } ?>
		</div>
		
		<? if(strip_tags($pageinfo['text']) != '') { ?>
		<div class="page-text">
			<div class="text-editor"><?=$pageinfo['text'];?></div>
		</div>
		<? } ?>
	</div>
</section>