<div class="mb15">
	<a href="javascript:void(0)" id="addFields" class="text-success">Редактировать поля</a>
</div>

<div id="fieldsList">
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
							<input type="checkbox" name="field[checkbox][<?=$field['idItem'];?>][<?=$value;?>]" value="<?=$value;?>" <?=array_key_exists($value, $field['value']) ? 'checked' : '';?> />
							<?=$label;?>
						</label>
					<? } ?>
				<? } ?>
			</div>
		</div>
		
	<? } ?>

	<? } ?>
<? } ?>
</div>

<script>
	$('#addFields').click(function(){
		
		if(!confirm('Сохраните поля перед редактированием!')) return false;
		
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/products/ajaxGetFields/'.uri(4));?>',
			data		: {
				csrf_test_name : csrf_test_name,
				fields : 'fields'
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				$('#fieldsWindow').html(data.html);
			},
		});
		
		$('#addFieldsModal').modal({
			show : true,
			backdrop : 'static',
			keyboard : false
		});
		return false;
	});
	
	$(document).on('click', '.fields-group-title', function(){
		el = $(this);
		el.closest('.fields-group').toggleClass('_open');
	});
	
	$(document).on('change', '[data-field]', function(event){
		event.preventDefault();
		el = $(this);
		id = el.attr('data-field');
		
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/products/ajaxUpdateField/'.uri(4));?>',
			data		: {
				csrf_test_name : csrf_test_name,
				id : id
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				if(data.error)
				{
					alert(data.text);
				} else {
					if(data.toggle == 'delete')
					{
						el.prop('checked', false);
					}
					if(data.toggle == 'insert')
					{
						el.prop('checked', true);
					}
				}
			},
		});
		
		return false;
	});
	
	$(document).on('click', '#fieldsRefresh', function(){
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/products/ajaxRefreshField/'.uri(4));?>',
			data		: {
				csrf_test_name : csrf_test_name
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				$('#fieldsList').html(data.html);
				setTimeout(function() {
				  $('select.form-input').trigger('refresh');
				}, 1)
				$('#addFieldsModal').modal('hide');
			},
		});
	});
</script>