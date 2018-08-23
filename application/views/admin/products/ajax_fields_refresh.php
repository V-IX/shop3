<? foreach($fields as $group) { ?>
	<? if(!empty($group['child'])) { ?>

	<hr class="mt20 mb20" />

	<div class="h4 medium mb20"><?=$group['title'];?></div>
	
	<? foreach($group['child'] as $field) { ?>
	
		<div class="row form-group">
			<div class="col-3 form-collabel">
				<?=$field['title'];?>
			</div>
			<div class="col-9 form-colinput">
				<? if($field['type'] == 'text') { ?>
					<input type="text" class="form-input" name="field[text][<?=$field['idItem'];?>]" value="<?=set_value('field[text]['.$field['idItem'].']', $field['value']);?>" />
				<? } ?>
				<? if($field['type'] == 'number') { ?>
					<input type="text" class="form-input" name="field[number][<?=$field['idItem'];?>]" value="<?=set_value('field[number]['.$field['idItem'].']', $field['value']);?>" data-input="num" />
				<? } ?>
				<? if($field['type'] == 'select') { ?>
					<select name="field[select][<?=$field['idItem'];?>]" class="form-input">
					<? foreach($field['values'] as $value => $label) { ?>
						<option value="<?=$value;?>" <?=$value == $field['value'] ? 'selected' : '';?>><?=$label;?></option>
					<? } ?>
					</select>
				<? } ?>
				<? if($field['type'] == 'checkbox') { ?>
					<?
						$field['value'] = json_decode($field['value'], true);
						if(!is_array($field['value'])) $field['value'] = array();
					?>
					<? foreach($field['values'] as $value => $label) { ?>
						<label class="block mb10">
							<div class="checker">
								<input type="checkbox" name="field[checkbox][<?=$field['idItem'];?>][<?=$value;?>]" value="<?=$value;?>" <?=array_key_exists($value, $field['value']) ? 'checked' : '';?> />
								<div class="checker-view"></div>
							</div>
							<?=$label;?>
						</label>
					<? } ?>
				<? } ?>
			</div>
		</div>
		
	<? } ?>

	<? } ?>
<? } ?>