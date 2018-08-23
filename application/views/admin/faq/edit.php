<?=form_open_multipart('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>

<? if($item['name'] != '') { ?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Имя
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" value="<?=$item['name'];?>" readonly />
	</div>
</div>
<? } ?>
<? if($item['phone'] != '') { ?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Телефон
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" value="<?=$item['phone'];?>" readonly />
	</div>
</div>
<? } ?>
<? if($item['phone'] != '') { ?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		E-mail
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" value="<?=$item['email'];?>" readonly />
	</div>
</div>
<? } ?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Вопрос <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" value="<?=set_value('title', $item['title']);?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ответ
	</div>
	<div class="col-9 form-colinput">
		<textarea name="text" class="form-input" rows="3" id="editor"><?=set_value('text', $item['text']);?></textarea>
		<?=form_error('text'); ?>
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
		Отображать на сайте
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="visibility" <?=$item['visibility'] == 1 ? 'checked' : '';?> />
		<?=form_error('visibility'); ?>
	</div>
</div>

<div class="form-actions">
	<button class="btn btn-success" data-save="save">Сохранить</button>
	<button class="btn btn-info" data-save="close">Соxранить и выйти</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>

<?=script('assets/plugins/ckeditor-standart/ckeditor.js');?>
<script>CKEDITOR.replace('editor');</script>

<script>
	$('#delImg').click(function(){
		$(this).closest('.input-file').find('.form-input, [name="img"]').val('');
	});
</script>

<script>
	$('[data-save]').click(function(){
		param = $(this).attr('data-save');
		
		if(param == 'save') src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4));?>';
		else src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4).'/close');?>';
		
		$('#mainForm').attr('action', src);
		return;
	});
</script>