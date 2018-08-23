<div class="row form-group">
	<div class="col-3 form-collabel">
		Валюта
	</div>
	<div class="col-9 form-colinput">
		<select name="currency" class="form-input">
		<? foreach($units_currency as $value => $label) { ?>
			<option value="<?=$value;?>" <?=set_select('currency', $value, $item['currency'] == $value ? true : false);?>><?=$label;?> <?=$value == $siteinfo['currency'] ? '(по умолчанию)' : '';?></option>
		<? } ?>
		</select>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Цена
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="price_curr" value="<?=set_value('price_curr', $item['price_curr']);?>" />
		<?=form_error('price_curr'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Старая цена
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="oldPrice_curr" value="<?=set_value('oldPrice_curr', $item['oldPrice_curr']);?>" />
		<?=form_error('oldPrice_curr'); ?>
	</div>
</div>

<hr class="mt30 mb30" />

<div class="mb20 h4 medium">Модификации</div>

<? 
	$countMod = 1;
	$modifications = $this->input->post('modifications');
	if(!$modifications) $modifications = $modificationsArr;
	else $countMod = count($modifications);
?>

<? foreach($modifications as $_mod) { ?>

<div class="form-group">
	<div class="row">
		<div class="col-2 form-colinput">
			<input type="text" class="form-input" name="modifications[<?=$_mod['idItem'];?>][articul]" value="<?=$_mod['articul'];?>" placeholder="Артикул" />
		</div>
		<div class="col-4 form-colinput">
			<input type="text" class="form-input" name="modifications[<?=$_mod['idItem'];?>][title]" value="<?=$_mod['title'];?>" placeholder="Заголовок" />
			<input type="hidden" name="modifications[<?=$_mod['idItem'];?>][idItem]" value="<?=$_mod['idItem'];?>" />
		</div>
		<div class="col-4 form-colinput">
			<div class="row">
				<div class="col-6">
					<input type="text" class="form-input" name="modifications[<?=$_mod['idItem'];?>][price]" value="<?=$_mod['price'];?>" placeholder="Цена" />
				</div>
				<div class="col-6">
					<input type="text" class="form-input" name="modifications[<?=$_mod['idItem'];?>][oldPrice]" value="<?=$_mod['oldPrice'];?>" placeholder="Старая цена" />
				</div>
			</div>
		</div>
		<div class="col-2 form-colinput">
			<input type="text" class="form-input" name="modifications[<?=$_mod['idItem'];?>][count]" value="<?=$_mod['count'];?>" placeholder="Кол-во" />
		</div>
	</div>
	<div class="mt5"><a href="javascript:void(0)" data-modifications="delete" class="text-info h6">Удалить модификацию</a></div>
</div>

<? } ?>

<div class="mt15">
	<a href="javascript:void(0)" id="addMod" class="text-success">Добавить модификацию</a>
</div>

<script>
	countMod = <?=$countMod;?>;
	$('#addMod').click(function(){
		
		$('#addModModal').modal('show');
		
		/*modInputTitle = '<input type="text" class="form-input" name="modifications[new'+countMod+'][title]" placeholder="Заголовок" />';
		modInputHidden = '<input type="hidden" name="modifications[new'+countMod+'][idItem]" value="new'+countMod+'" />';
		modInputDelete = '<div class="mt5"><a href="javascript:void(0)" data-modifications="delete" class="text-info h6">Удалить модификацию</a></div>';
		modInputPrice = '<input type="text" class="form-input" name="modifications[new'+countMod+'][price]" placeholder="Цена" />';
		modInputOldprice = '<input type="text" class="form-input" name="modifications[new'+countMod+'][oldPrice]" placeholder="Цена" />';
		
		modHtml = '<div class="row form-group"><div class="col-6 form-colinput">' + modInputTitle + modInputHidden + modInputDelete + '</div><div class="col-6 form-colinput"><div class="row"><div class="col-6">' + modInputPrice + '</div><div class="col-6">' + modInputOldprice + '</div></div></div>';
		
		$(this).closest('div').before(modHtml);
		
		countMod++;*/
	});
	
	$(document).on('submit', '#addModForm', 'submit', function(event){
		event.preventDefault();
		if($('[name="articul"]').val() == '') return false;
		el = $(this);
		post = el.serialize();
		action = el.attr('action');
		
		$.ajax({
			type  		: "POST",
			url   		: action,
			data		: post,
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				if(data.error)
				{
					alert(data.text);
				} else {
					modInputArticul = '<input type="text" class="form-input" name="modifications['+data.id+'][articul]" value="' + $('[name="add_mod[articul]"]').val() + '" placeholder="Артикул" />';
					modInputTitle = '<input type="text" class="form-input" name="modifications['+data.id+'][title]" value="' + $('[name="add_mod[title]"]').val() + '" placeholder="Заголовок" />';
					modInputHidden = '<input type="hidden" name="modifications['+data.id+'][idItem]" value="'+data.id+'" />';
					modInputDelete = '<div class="mt5"><a href="javascript:void(0)" data-modifications="delete" class="text-info h6">Удалить модификацию</a></div>';
					modInputPrice = '<input type="text" class="form-input" name="modifications['+data.id+'][price]" value="' + $('[name="add_mod[price]"]').val() + '" placeholder="Цена" />';
					modInputOldprice = '<input type="text" class="form-input" name="modifications['+data.id+'][oldPrice]" value="' + $('[name="add_mod[oldPrice]"]').val() + '" placeholder="Цена" />';
					modInputCount = '<input type="text" class="form-input" name="modifications['+data.id+'][count]" value="' + $('[name="add_mod[count]"]').val() + '" placeholder="Кол-во" />';
					
					modHtml = '<div class="form-group"><div class="row"><div class="col-2 form-colinput">' + modInputArticul + '</div><div class="col-4 form-colinput">' + modInputTitle + modInputHidden + '</div><div class="col-4 form-colinput"><div class="row"><div class="col-6">' + modInputPrice + '</div><div class="col-6">' + modInputOldprice + '</div></div></div><div class="col-2 form-colinput">' + modInputCount + '</div></div>' + modInputDelete + '</div>';
					
					$('#addMod').closest('div').before(modHtml);
					$('#addModForm').find('input').val('');
					$('#addModModal').modal('hide');
				}
			},
		});
		return false;
	});
	
	$(document).on('click', '[data-modifications="delete"]', function(){
		el = $(this);
		parent = el.closest('.form-group');
		id = parent.find('input[type="hidden"]').val();
		if(confirm('Вы уверены что хотите удалить модификацию?'))
		{
			csrf_test_name = "<?=$this->security->get_csrf_hash();?>";
			$.ajax({
				type  		: "POST",
				url   		: '<?=base_url('admin/products/ajaxModDelete');?>/' + id,
				data		: {
					csrf_test_name : csrf_test_name,
					delete_mod : 'delete'
				},
				error 		: function () {
					alert('Ошибка запроса');
				},
				success		: function(data) {
					if(data.error)
					{
						alert(data.text);
					} else {
						parent.remove();
					}
				},
			});	
		} else {
			return false;
		}
	});
</script>