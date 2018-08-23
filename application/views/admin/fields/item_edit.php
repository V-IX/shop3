<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" value="<?=set_value('title', $item['title']);?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Родительская группа <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" readonly value="<?=$parent['title'];?>" />
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Тип поля <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" readonly value="<?=$types[$item['type']]['title'];?>" />
		<input type="hidden" name="type" value="<?=$item['type'];?>" />
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Номер по порядку
		<div class="h6 text-gray">На сайте выводится в обратном порядке</div>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="num" value="<?=set_value('num', $item['num']);?>" />
		<?=form_error('num'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Фильтр
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="filter" <?=$item['filter'] == 1 ? 'checked' : '';?> />
		<?=form_error('filter'); ?>
	</div>
</div>

<? if($item['type'] == 'select' or $item['type'] == 'checkbox') { ?>

<hr class="mb20"/>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Значения
		<div class="h6"><a href="javascript:void(0)" id="valueAdd">добавить пункт</a></div>
	</div>
	<div class="col-9" id="valueItems">
	<? foreach($values as $value) { ?>
		<div class="mb15" data-toggle="parent">
			<input type="text" name="value[<?=$value['idItem'];?>]" data-id="<?=$value['idItem'];?>" class="form-input" value="<?=$value['title'];?>" />
			<div class="mt5 h6"><a href="javascript:void(0)" data-toggle="delete_existing">удалить пункт</a></div>
		</div>
	<? } ?>
	</div>
</div>

<? } ?>

<div class="form-actions">
	<button class="btn btn-success">Редактировать</button>
	<?=anchor('/admin/'.uri(2).'/view/'.$item['idParent'], 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>

<? if($item['type'] == 'select' or $item['type'] == 'checkbox') { ?>

<script>
	
	valueCounter = 0;
	$('#valueAdd').click(function(){
		item_input = '<input type="text" name="value_new[' + valueCounter + ']" class="form-input" placeholder="Новый пункт ' + (valueCounter + 1) + '" />';
		item_delete = '<div class="mt5 h6"><a href="javascript:void(0)" data-toggle="delete">удалить пункт</a></div>';
		item_div = '<div class="mt15" data-toggle="parent">' + item_input + item_delete + '</div>';
		$('#valueItems').append(item_div);
		valueCounter++;
	});
	
	$(document).on('click', '[data-toggle="delete"]', function() {
		el = $(this);
		el.closest('[data-toggle="parent"]').remove();
	});
	
	$(document).on('click', '[data-toggle="delete_existing"]', function() {
		el = $(this);
		par = el.closest('[data-toggle="parent"]');
		input = par.find('input');
		id = input.attr('data-id');
		input.attr('name', 'value_delete['+id+']');
		input.addClass('input-deleted');
		input.prop('readonly', true);
		el.attr('data-toggle', 'reestablish').text('восстановить пункт');
	});
	
	$(document).on('click', '[data-toggle="reestablish"]', function() {
		el = $(this);
		par = el.closest('[data-toggle="parent"]');
		input = par.find('input');
		id = input.attr('data-id');
		input.attr('name', 'value['+id+']');
		input.removeClass('input-deleted');
		input.prop('readonly', false);
		el.attr('data-toggle', 'delete_existing').text('удалить пункт');
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

<? } ?>