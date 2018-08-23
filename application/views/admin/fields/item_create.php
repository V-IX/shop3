<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" value="<?=set_value('title');?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Тип поля <span class="required">*</span>
	</div>
	<div class="col-9">
		<select name="type" class="form-input">
		<? foreach($types as $type) { ?>
			<option value="<?=$type['alias'];?>"><?=$type['title'];?></option>
		<? } ?>
		</select>
		<?=form_error('type'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Номер по порядку
		<div class="h6 text-gray">На сайте выводится в обратном порядке</div>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="num" value="<?=set_value('num', 1);?>" />
		<?=form_error('num'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Фильтр
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="filter" />
		<?=form_error('filter'); ?>
	</div>
</div>

<div class="none" id="valueVariable">

<hr class="mb20"/>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Значения
		<div class="h6"><a href="javascript:void(0)" id="valueAdd">добавить пункт</a></div>
	</div>
	<div class="col-9" id="valueItems">
		<div data-toggle="parent">
			<input type="text" name="value[0]" class="form-input" placeholder="Пункт 1" />
		</div>
	</div>
</div>

</div>

<div class="form-actions">
	<button class="btn btn-success">Создать</button>
	<?=anchor('/admin/'.uri(2).'/view/'.uri(4), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>

<script>
	$('[name="type"]').change(function(){
		el = $(this);
		if(el.val() == 'select' || el.val() == 'checkbox') $('#valueVariable').show();
		else $('#valueVariable').hide();
	});
	
	valueCounter = 1;
	$('#valueAdd').click(function(){
		item_input = '<input type="text" name="value[' + valueCounter + ']" class="form-input" placeholder="Пункт ' + (valueCounter + 1) + '" />';
		item_delete = '<div class="mt5 h6"><a href="javascript:void(0)" data-toggle="delete">удалить пункт</a></div>';
		item_div = '<div class="mt15" data-toggle="parent">' + item_input + item_delete + '</div>';
		$('#valueItems').append(item_div);
		valueCounter++;
	});
	
	$(document).on('click', '[data-toggle="delete"]', function() {
		el = $(this);
		el.closest('[data-toggle="parent"]').remove();
	});
	
	$('.responsive-form').submit(function(){
		title = $('[name="title"]');
		if(title.val() == '')
		{
			title.addClass('input-error');
			return false;
		}
	});
</script>