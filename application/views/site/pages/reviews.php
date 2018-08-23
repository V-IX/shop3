<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageinfo['title'];?></span></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<? if(empty($items)) { ?>
		
			<div class="note">
				Отзывов о магазине нет. Вы можете стать первым!
			</div>
		
		<? } else { ?>
		
			<ul class="reviews-list clearfix">
			<? $i = 1; foreach($items as $item) { ?>
				<li>
					<div class="reviews-item clearfix">
						<div class="img">
							<?=check_img('assets/uploads/'.uri(1).'/thumb/'.$item['img'], array('alt' => $pageinfo['mTitle']), 'square.png');?>
						</div>
						<div class="descr">
							<div class="title">
								<?=$item['name'];?>
								<span><?=translate_date($item['addDate']);?></span>
							</div>
							<div class="text">
								<div class="text-editor">
									<?=$item['text'];?>
								</div>
								<? if($item['link'] != '') { ?>
									<div class="ulink">
										<noindex><a href="<?=$item['link'];?>" target="_blank" rel="follow"><?=$item['link'];?></a></noindex>
									</div>
								<? } ?>
							</div>
						</div>
					</div>
				</li>
			<? $i++;} ?>
			</ul>
			<?=$this->pagination->create_links();?>
		
		<? } ?>
		<div class="comments-form mt40">
			<div class="h3 bold mb20">Оставьте свой отзыв:</div>
			<?=form_open('reviews/ajaxSend', array('data-toggle' => 'ajaxForm', 'data-thanks' => '#thanksReviews'));?>
				<div class="row form-row">
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="name" class="form-input" data-rules="required" placeholder="Ваше имя" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="phone" class="form-input" data-rules="required" placeholder="Ваш телефон *" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="email" class="form-input" placeholder="Ваш e-mail" />
						</div>
					</div>
				</div>
				<div class="form-group mb10">
					<textarea class="form-input" name="text" rows="5" data-rules="required" placeholder="Текст отзыва *"></textarea>
				</div>
				<div class="form-group mb15">
					<input type="text" name="link" class="form-input" placeholder="Ссылка на соцсети" />
				</div>
				<button class="btn w200">Оставить отзыв</button>
			<?=form_close();?>
		</div>
	</div>
</section>

<div class="popup" id="thanksReviews">
	<div class="close"></div>
	<div class="h3 bold mb5">Спасибо за отзыв!</div>
	<div class="h5">Ваш отзыв будет опубликован<br/>после модерации</div>
</div>