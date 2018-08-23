<?=form_open_multipart('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Название сайта: <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" value="<?=set_value('title', $siteinfo['title']);?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Описание сайта:
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="descr" value="<?=set_value('descr', $siteinfo['descr']);?>" />
		<?=form_error('descr'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Логотип:
	</div>
	<div class="col-9 form-colinput">
		<div class="input-file">
			<input type="text" class="form-input" readonly placeholder="Файл не выбран" />
			<button class="btn">Обзор</button>
			<input type="file" name="img" class="none" accept="image/*"/>
			<h6 class="form-info"><a href="javascript:void(0)" id="delImg">Удалить изображение</a></h6>
		</div>
		<input type="hidden" name="oldImg" value="<?=$siteinfo['img'];?>" />
		<?=$this->upload->display_errors('<div class="form-error">', '</div>');?>
		<?=check_img('assets/uploads/settings/'.$siteinfo['img'], array('class' => 'block mt20', 'style' => 'max-width: 50px;'));?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Владелец сайта:
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="owner" value="<?=set_value('owner', $siteinfo['owner']);?>" />
		<?=form_error('owner'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Реквизиты:
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="details" rows="3"><?=set_value('details', $siteinfo['details']);?></textarea>
		<?=form_error('details'); ?>
	</div>
</div>

<hr class="mb20" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		E-mail: <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="email" value="<?=set_value('email', $siteinfo['email']);?>" />
		<?=form_error('email'); ?>
	</div>
</div>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Телефон (основной): <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<div class="row">
			<div class="col-6">
				<input type="text" class="form-input" name="phone" value="<?=set_value('phone', $siteinfo['phone']);?>" />
				<?=form_error('phone'); ?>
			</div>
			<div class="col-6">
				<input type="text" class="form-input" name="phoneMask" value="<?=set_value('phoneMask', htmlspecialchars_decode($siteinfo['phoneMask']));?>" />
				<?=form_error('phoneMask'); ?>
			</div>
		</div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Телефон (дополнительный):
	</div>
	<div class="col-9 form-colinput">
		<div class="row">
			<div class="col-6">
				<input type="text" class="form-input" name="phone2" value="<?=set_value('phone2', $siteinfo['phone2']);?>" />
				<?=form_error('phone2'); ?>
			</div>
			<div class="col-6">
				<input type="text" class="form-input" name="phone2Mask" value="<?=set_value('phone2Mask', htmlspecialchars_decode($siteinfo['phone2Mask']));?>" />
				<?=form_error('phone2Mask'); ?>
			</div>
		</div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Телефон (городской):
	</div>
	<div class="col-9 form-colinput">
		<div class="row">
			<div class="col-6">
				<input type="text" class="form-input" name="phoneCity" value="<?=set_value('phoneCity', $siteinfo['phoneCity']);?>" />
				<?=form_error('phoneCity'); ?>
			</div>
			<div class="col-6">
				<input type="text" class="form-input" name="phoneCityMask" value="<?=set_value('phoneCityMask', htmlspecialchars_decode($siteinfo['phoneCityMask']));?>" />
				<?=form_error('phoneCityMask'); ?>
			</div>
		</div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Адрес:
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="adres" rows="3"><?=set_value('adres', $siteinfo['adres']);?></textarea>
		<?=form_error('adres'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Код карты:
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="map" rows="3"><?=set_value('map', htmlspecialchars_decode($siteinfo['map']));?></textarea>
		<?=form_error('map'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Время работы:
		<div class="form-info text-gray">полное описание / сокращенное описание</div>
	</div>
	<div class="col-9 form-colinput">
		<div class="row">
			<div class="col-6">
				<input type="text" class="form-input" name="time" value="<?=set_value('time', $siteinfo['time']);?>" placeholder="Ежедневно с 9.00 до 18.00" />
				<?=form_error('time'); ?>
			</div>
			<div class="col-6">
				<input type="text" class="form-input" name="time_short" value="<?=set_value('time_short', $siteinfo['time_short']);?>" placeholder="Пн-Вс 8.00-18.00" />
				<?=form_error('time_short'); ?>
			</div>
		</div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Skype:
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="skype" value="<?=set_value('skype', $siteinfo['skype']);?>" />
		<?=form_error('skype'); ?>
	</div>
</div>

<hr class="mb20" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Title: <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="mTitle" value="<?=set_value('mTitle', $siteinfo['mTitle']);?>" />
		<?=form_error('mTitle'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Keywords:
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="mKeywords" rows="3"><?=set_value('mKeywords', $siteinfo['mKeywords']);?></textarea>
		<?=form_error('mKeywords'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Description:
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="mDescription" rows="3"><?=set_value('mDescription', $siteinfo['mDescription']);?></textarea>
		<?=form_error('mDescription'); ?>
	</div>
</div>

<hr class="mb20" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		Включить сайт:
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="enable" <? if($siteinfo['enable'] == 1) { ?>checked<? } ?> />
		<?=form_error('enable'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок для заглушки:
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="capTitle" value="<?=set_value('capTitle', $siteinfo['capTitle']);?>" />
		<?=form_error('capTitle'); ?>
	</div>
</div>
<div class="row form-group mb40">
	<div class="col-3 form-collabel">
		Описание для заглушки:
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="capDescr" rows="3"><?=set_value('capDescr', $siteinfo['capDescr']);?></textarea>
		<?=form_error('capDescr'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success" data-save="save">Сохранить</button>
	<button class="btn btn-info" data-save="close">Соxранить и выйти</button>
	<?=anchor('admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>

<script>
	$('[data-save]').click(function(){
		param = $(this).attr('data-save');
		
		if(param == 'save') src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4));?>';
		else src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4).'/close');?>';
		
		$('#mainForm').attr('action', src);
		return;
	});
</script>