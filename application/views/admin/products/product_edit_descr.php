<div class="row form-group">
	<div class="col-3 form-collabel">
		Производитель
	</div>
	<div class="col-9 form-colinput">
		<select name="idMfrs" class="form-input">
			<option value="0" <?=set_select('idMfrs', 0, $item['idMfrs'] == 0 ? true : false);?>>Не указан</option>
			<? foreach($mfrs as $value => $label) { ?>
				<option value="<?=$value;?>" <?=set_select('idMfrs', $value, $item['idMfrs'] == $value ? true : false);?>><?=$label;?></option>
			<? } ?>
		</select>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Страна
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="country" value="<?=set_value('country', $item['country']);?>" />
		<?=form_error('country'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Текст
	</div>
	<div class="col-9 form-colinput">
		<textarea name="text" class="form-input" rows="3" id="editor"><?=set_value('text', $item['text']);?></textarea>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Доставка
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="text_delivery" value="<?=set_value('text_delivery', $item['text_delivery']);?>" />
		<?=form_error('text_delivery'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Гарантия
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="text_garanty" value="<?=set_value('text_garanty', $item['text_garanty']);?>" />
		<?=form_error('text_garanty'); ?>
	</div>
</div>

<hr class="mb20" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		Габариты (ДхШхВ)
	</div>
	<div class="col-9 form-colinput">
		<div class="row">
			<div class="col-4">
				<input type="text" class="form-input" name="length" value="<?=set_value('length', $item['length']);?>" placeholder="Длина" />
				<?=form_error('length'); ?>
			</div>
			<div class="col-4">
				<input type="text" class="form-input" name="width" value="<?=set_value('width', $item['width']);?>" placeholder="Ширина" />
				<?=form_error('width'); ?>
			</div>
			<div class="col-4">
				<input type="text" class="form-input" name="height" value="<?=set_value('height', $item['height']);?>" placeholder="Высота" />
				<?=form_error('height'); ?>
			</div>
		</div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Единица длины
	</div>
	<div class="col-9 form-colinput">
		<select name="unit_length" class="form-input">
		<? foreach($units_length as $value => $label) { ?>
			<option value="<?=$value;?>" <?=set_select('unit_length', $value, $item['unit_length'] == $value ? true : false);?>><?=$label;?> <?=$value == $siteinfo['length'] ? '(по умолчанию)' : '';?></option>
		<? } ?>
		</select>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Вес
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="weight" value="<?=set_value('weight', $item['weight']);?>" />
		<?=form_error('weight'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Единица длины
	</div>
	<div class="col-9 form-colinput">
		<select name="unit_weight" class="form-input">
		<? foreach($units_weight as $value => $label) { ?>
			<option value="<?=$value;?>" <?=set_select('unit_weight', $value, $item['unit_weight'] == $value ? true : false);?>><?=$label;?> <?=$value == $siteinfo['length'] ? '(по умолчанию)' : '';?></option>
		<? } ?>
		</select>
		<?=form_error('text'); ?>
	</div>
</div>

<hr class="mt30 mb30" />

<h3 class="mb20">Характеристики</h3>

<? $post = $this->input->post('chars');?>

<? if($post) $chars = $this->input->post('chars');
else $chars = json_decode($item['charArr'], true);?>

<? $i = 0;  #var_dump($this->input->post('faq'));?>
<? if(is_array($chars) and !empty($chars)) { ?>
	<? foreach($chars as $t) { ?>
		<div class="form-group">
			<div class="row">
				<div class="col-3">
					<input type="text" name="chars[<?=$i;?>][label]" class="form-input" value="<?=$t['label'];?>" placeholder="Характеристика" />
					<div class="form-info h6"><a href="javascript:void(0)" onclick="delefeChar($(this))">Удалить характеристику</a></div>
				</div>
				<div class="col-9">
					<input type="text" name="chars[<?=$i;?>][value]" class="form-input" value="<?=$t['value'];?>" placeholder="Значение" />
				</div>
			</div>
		</div>
	<? $i++;} ?>
<? } ?>

<a href="javascript:void(0)" id="addChar" class="text-success">Добавить характеристику</a>

<script>
	var chars = <?=$i;?>;
	
	function delefeChar(obj) {
		if(confirm('Вы уверены, что хотите удалить характеристику?')) obj.closest('.form-group').remove();
	}
	
	$('#addChar').click(function(){
		iLabel = '<input type="text" name="chars[' + chars + '][label]" class="form-input" placeholder="Характеристика" />';
		ifaq = '<input type="text" name="chars[' + chars + '][value]" class="form-input" placeholder="Значение" />';
		divDelete = '<div class="form-info h6"><a href="javascript:void(0)" onclick="delefeChar($(this))">Удалить характеристику</a></div>';
		divLabel = '<div class="col-3">' + iLabel + divDelete + '</div>';
		divfaq = '<div class="col-9">' + ifaq + '</div>';
		row = '<div class="form-group"><div class="row">' + divLabel + divfaq + '</div></div>';
		$(this).before(row);
		chars++;
	});
</script>

<?=script('assets/plugins/ckeditor-standart/ckeditor.js');?>
<script>CKEDITOR.replace('editor');</script>