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
				Вопросов нет. Вы можете задать первый!
			</div>
		
		<? } else { ?>
		
			<ul class="faq-list clearfix">
			<? foreach($items as $item) { ?>
				<li>
					<div class="faq-item" data-faq="item">
						<div class="title" data-faq="title">
							<a href="javascript:void(0)"><?=$item['title'];?></a>
						</div>
						<div class="text" data-faq="text">
							<div class="text-editor"><?=$item['text'];?></div>
						</div>
					</div>
				</li>
			<? } ?>
			</ul>
			<?=$this->pagination->create_links();?>
		
		<? } ?>
		<div class="comments-form mt40">
			<div class="h3 bold mb20">Задайте свой вопрос:</div>
			<?=form_open('faq/ajaxSend', array('data-toggle' => 'ajaxForm', 'data-thanks' => '#thanksReviews'));?>
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
				<div class="form-group mb15">
					<textarea class="form-input" name="title" rows="5" data-rules="required" placeholder="Ваш вопрос *"></textarea>
				</div>
				<button class="btn">Задать вопрос</button>
			<?=form_close();?>
		</div>
	</div>
</section>

<div class="popup" id="thanksReviews">
	<div class="popup-close close"></div>
	<div class="title">Спасибо за вопрос!</div>
	<div class="descr">Наши специалисты свяжутся с Вами в ближайшее время!</div>
</div>

<script>
	$('[data-faq="title"] a').click(function(){
		el = $(this).closest('[data-faq="item"]');
		t = el.find('[data-faq="text"]');
		
		if(el.hasClass('_open'))
		{
			el.removeClass('_open');
			t.hide();
		} else {
			el.addClass('_open');
			t.fadeIn(300);
		}
	});
</script>