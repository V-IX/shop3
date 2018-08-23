<section class="offer">
	<div class="wrapper">
		<div class="offer-slider" id="offerSlider">
			<ul class="slides">
			<? foreach($slider as $slide) { ?>
				<? $tag_class = 'offer-slide text-'.$slide['position'];?>
				<? $tag_open = $slide['link'] != '' ? '<a href="'.base_url($slide['link']).'" class="'.$tag_class.'" >' : '<div class="'.$tag_class.'">'?>
				<? $tag_close = $slide['link'] != '' ? '</a>' : '</div>'?>
				<li>
				<?=$tag_open;?>
					<div class="img" style="background-image: url('');">
						<img src="<?=base_url('assets/uploads/slider/thumb/'.$slide['img']);?>" alt="<?=htmlspecialchars($slide['title']);?>" />
					</div>
					<? if($slide['showText']) { ?>
						<div class="in">
							<div class="title"><?=$slide['title'];?></div>
							<? if($slide['text']) { ?><div class="descr"><?=nl2br($slide['text']);?></div><? } ?>
							<? if($slide['btn']) { ?>
							<div class="more">
								<span class="btn"><?=$slide['btn'];?></span>
							</div>
							<? } ?>
						</div>
					<? } ?>
				<?=$tag_close;?>
				</li>
			<? } ?>
			</ul>
		</div>
		<div class="offer-btns" id="offerSliderBtns">
			<a href="javascript:void(0)" class="flex-prev"><?=fa('angle-left');?></a>
			<a href="javascript:void(0)" class="flex-next"><?=fa('angle-right');?></a>
		</div>
	</div>
</section>
<script>
	$(window).load(function() {
		$('#offerSlider').flexslider({
			animation: "slide",
			controlNav: false,
			customDirectionNav: $("#offerSliderBtns a")
		});
	});
</script>