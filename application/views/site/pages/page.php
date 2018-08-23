<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$item['title'];?></span></h1>
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
				<a href="<?=base_url();?>">вернуться на главную</a>
			</div>
		</div>
	</div>
</section>