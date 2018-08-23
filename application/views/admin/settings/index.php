<div class="page-preview">
	<div class="img"><?=check_img('assets/uploads/settings/'.$siteinfo['img'], array());?></div>
	<div class="descr">
		<h3 class="mb5">
			<?=$siteinfo['title'];?>
			<i class="mr10"></i>
			<? if($siteinfo['enable'] == 1) { ?>
				<span class="tooltips" data-original-title="Сайт доступен всем"><?=fa('eye text-success');?></span>
			<? } else { ?>
				<span class="tooltips" data-original-title="Доступ к сайту ограничен"><?=fa('eye-slash text-error');?></span>
			<? } ?>
			
		</h3>
		<h4 class="mb15 text-gray">
			
			<?=$siteinfo['descr'];?>
		</h4>
		<?=fa('user fa-fw h4 text-gray mr5');?> <?=$siteinfo['owner'];?>
		<div class="mb5"></div>
		<?=fa('file-text-o fa-fw h4 text-gray mr5');?> <?=$siteinfo['details'];?>
	</div>
</div>

<hr class="mb20" />

<h3 class="text-info mb15">Контакты:</h3>

<div class="form-group row">
	<div class="col-6">
		<?=fa('at fa-fw h4 text-gray mr5');?> <?=$siteinfo['email'];?>
	</div>
	<div class="col-6">
		<?=fa('mobile fa-fw h4 text-gray mr5');?> <?=phone($siteinfo['phone'], $siteinfo['phoneMask']);?>
	</div>
</div>
<div class="form-group row">
	<div class="col-6">
		<?=fa('mobile fa-fw h4 text-gray mr5');?>
		<?=($siteinfo['phone2'] != '') ? phone($siteinfo['phone2'], $siteinfo['phone2Mask']) : '<span class="text-gray">(не указано)</span>';?>
	</div>
	<div class="col-6">
		<?=fa('phone-square fa-fw h4 text-gray mr5');?>
		<?=($siteinfo['phoneCity'] != '') ? phone($siteinfo['phoneCity'], $siteinfo['phoneCityMask']) : '<span class="text-gray">(не указано)</span>';?>
	</div>
</div>
<div class="form-group row">
	<div class="col-6">
		<?=fa('skype fa-fw h4 text-gray mr5');?>
		<?=($siteinfo['skype'] != '') ? $siteinfo['skype'] : '<span class="text-gray">(не указано)</span>';?>
	</div>
	<div class="col-6">
		<?=fa('clock-o fa-fw h4 text-gray mr5');?>
		<?=($siteinfo['time'] != '') ? $siteinfo['time'] : '<span class="text-gray">(не указано)</span>';?> /
		<?=($siteinfo['time_short'] != '') ? $siteinfo['time_short'] : '<span class="text-gray">(не указано)</span>';?>
	</div>
</div>
<div class="form-group">
	<?=fa('map-marker fa-fw h4 text-gray mr5');?>
	<?=($siteinfo['adres'] != '') ? $siteinfo['adres'] : '<span class="text-gray">(не указано)</span>';?>
</div>

<hr class="mb20" />

<h3 class="text-info mb15">SEO:</h3>

<div class="form-group">
	<?=fa('bullhorn fa-fw h4 text-gray mr5');?>
	<?=($siteinfo['mTitle'] != '') ? $siteinfo['mTitle'] : '<span class="text-gray">(не указано)</span>';?>
</div>
<div class="form-group">
	<?=fa('tag fa-fw h4 text-gray mr5');?>
	<?=($siteinfo['mKeywords'] != '') ? $siteinfo['mKeywords'] : '<span class="text-gray">(не указано)</span>';?>
</div>
<div class="form-group">
	<?=fa('tags fa-fw h4 text-gray mr5');?>
	<?=($siteinfo['mDescription'] != '') ? $siteinfo['mDescription'] : '<span class="text-gray">(не указано)</span>';?>
</div>

<hr class="mb20" />

<h3 class="text-info mb15">Заглушка:</h3>

<div class="form-group">
	<? if($siteinfo['enable'] == 1) { ?>
		<?=fa('eye fa-fw h4 text-gray mr5');?> Сайт доступен всем
	<? } else { ?>
		<?=fa('eye-slash fa-fw h4 text-gray mr5');?> Доступ к сайту ограничен
	<? } ?>
</div>
<div class="form-group">
	<?=fa('bullhorn fa-fw h4 text-gray mr5');?>
	<?=($siteinfo['capTitle'] != '') ? $siteinfo['capTitle'] : 'Сайт временно закрыт';?>
</div>
<div class="form-group">
	<?=fa('align-left fa-fw h4 text-gray mr5');?>
	<?=($siteinfo['capDescr'] != '') ? $siteinfo['capDescr'] : 'Приносим свои извинения и гарантируем в скором времени наладить работу';?>
</div>

<div class="form-actions">
	<?=anchor('admin/'.uri(2).'/edit', 'Изменить настройки', array('class' => 'btn btn-success'));?>
	<?=anchor('admin', 'Вернуться на главную', array('class' => 'btn'));?>
</div>