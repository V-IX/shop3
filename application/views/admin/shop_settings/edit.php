<?=form_open_multipart('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>

<h3 class="text-info mb15">Магазин:</h3>

<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Режим магазина
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="shop" <?=$siteinfo['shop'] == 1 ? 'checked' : '';?> />
		<?=form_error('shop'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Валюта:
	</div>
	<div class="col-9 form-colinput">
		<select name="currency" class="form-input">
		<? foreach($currency as $value => $label) { ?>
			<option value="<?=$value?>" <?=set_select('currency', $value, $siteinfo['currency'] == $value ? true : false);?>><?=$label;?></option>
		<? } ?>
		</select>
		<?=form_error('currency'); ?>
	</div>
</div>

<hr class="mb20" />

<h3 class="text-info mb15">Единицы измерения:</h3>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Длина:
	</div>
	<div class="col-9 form-colinput">
		<select name="length" class="form-input">
		<? foreach($length as $value => $label) { ?>
			<option value="<?=$value?>" <?=set_select('length', $value, $siteinfo['length'] == $value ? true : false);?>><?=$label;?></option>
		<? } ?>
		</select>
		<?=form_error('length'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Вес:
	</div>
	<div class="col-9 form-colinput">
		<select name="weight" class="form-input">
		<? foreach($weight as $value => $label) { ?>
			<option value="<?=$value?>" <?=set_select('weight', $value, $siteinfo['weight'] == $value ? true : false);?>><?=$label;?></option>
		<? } ?>
		</select>
		<?=form_error('weight'); ?>
	</div>
</div>

<hr class="mb20" />

<h3 class="text-info mb15">Товары:</h3>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Количество товаров на сайте <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="count_front" value="<?=set_value('count_front', $siteinfo['count_front']);?>" />
		<?=form_error('count_front'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Количество товаров в админ-панели <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="count_admin" value="<?=set_value('count_admin', $siteinfo['count_admin']);?>" />
		<?=form_error('count_admin'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Отзывы к товарам:
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="reviews" <? if($siteinfo['reviews'] == 1) { ?>checked<? } ?> />
		<?=form_error('reviews'); ?>
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