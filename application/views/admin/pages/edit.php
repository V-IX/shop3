<?=form_open('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" data-toggle="translate_auto" value="<?=set_value('title', $item['title']);?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ссылка (ЧПУ) <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="alias" <?=$item['system'] == 1 ? 'readonly' : '';?> value="<?=set_value('alias', $item['alias']);?>" />
		<?=form_error('alias'); ?>
		<? if($item['system'] == 0) { ?>
			<a href="javascript:void(0)" class="h6" data-toggle="translate_title">перевести заголовок</a>
		<? } ?>
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
	<div class="col-3 form-collabel _nopadding">
		Отображать на сайте
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="visibility" <?=$item['visibility'] == 1 ? 'checked' : '';?> />
		<?=form_error('visibility'); ?>
	</div>
</div>
<hr class="mb15" />
<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Title <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="mTitle" value="<?=set_value('mTitle', $item['mTitle']);?>" />
		<?=form_error('mTitle'); ?>
		<a href="javascript:void(0)" class="h6" data-toggle="copy_title">скопировать заголовок</a>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Keywords
	</div>
	<div class="col-9 form-colinput">
		<textarea name="mKeywords" class="form-input" rows="3"><?=set_value('mKeywords', $item['mKeywords']);?></textarea>
		<?=form_error('mKeywords'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Description
	</div>
	<div class="col-9 form-colinput">
		<textarea name="mDescription" class="form-input" rows="3"><?=set_value('mDescription', $item['mDescription']);?></textarea>
		<?=form_error('mDescription'); ?>
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
	$('[data-save]').click(function(){
		param = $(this).attr('data-save');
		
		if(param == 'save') src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4));?>';
		else src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4).'/close');?>';
		
		$('#mainForm').attr('action', src);
		return;
	});
</script>