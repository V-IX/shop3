<section class="page-top">
	<div class="wrapper">
		<?=$this->breadcrumbs->create_links();?>
		<h1 class="page-title"><span class="_in"><?=$pageinfo['title'];?></span></h1>
		<? if($pageinfo['brief']) { ?><div class="page-brief"><?=$pageinfo['brief'];?></div><? } ?>
	</div>
</section>
<section class="page-content">
	<div class="wrapper">
		<? if($siteinfo['map']) { ?>
			<div class="contacts-map"><?=htmlspecialchars_decode($siteinfo['map']);?></div>
		<? } ?>
		<div class="clearfix">
			<div class="contacts-left">
				<div class="contacts-title">Контакты</div>
				<ul class="contacts-list">
					<li class="phone"><?=phone($siteinfo['phone'], $siteinfo['phoneMask']);?></li>
					<? if($siteinfo['phone2']) { ?><li class="phone"><?=phone($siteinfo['phone2'], $siteinfo['phone2Mask']);?></li><? } ?>
					<? if($siteinfo['phoneCity']) { ?><li class="phone"><?=phone($siteinfo['phoneCity'], $siteinfo['phoneCityMask']);?></li><? } ?>
					<li class="email"><div class="contacts-icon"><?=fa('envelope-o fa-fw mr5');?> <span><?=$siteinfo['email'];?></span></div></li>
					<? if($siteinfo['skype']) { ?><li class="skype"><div class="contacts-icon"><?=fa('skype fa-fw mr5');?> <?=$siteinfo['skype'];?></div></li><? } ?>
				</ul>				
				<div class="contacts-title">Реквизиты</div>
				<div class="contacts-text">
					<div class="contacts-icon mb5">
						<?=fa('map-marker fa-fw');?>
						<?=nl2br($siteinfo['adres']);?>
					</div>
					<div class="contacts-icon">
						<?=fa('clock-o fa-fw');?>
						<?=$siteinfo['time'];?>
					</div>
				</div>
				<div class="contacts-text _small mt15">
					<div class="mb5"><strong><?=$siteinfo['owner'];?></strong></div>
					<?=nl2br($siteinfo['details']);?>
				</div>
			</div>
			<div class="contacts-right">
				<div class="contacts-title">Обратная связь</div>
				<?=form_open('contacts/ajaxSend', array('data-toggle' => 'ajaxForm', 'class' => 'comments-form'));?>
					<div class="row form-row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="name" class="form-input" data-rules="required" placeholder="Представьтесь, пожалуйста *" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="phone" class="form-input" data-rules="required" placeholder="Контакты *" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<textarea class="form-input" name="text" rows="5" placeholder="Комментарий"></textarea>
					</div>
					<button class="btn btn-orange w150">Отправить</button>
					<input type="hidden" name="title" value="Контакты" />
				<?=form_close();?>
			</div>
		</div>
	</div>
</section>