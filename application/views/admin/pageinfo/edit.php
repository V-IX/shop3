<?=form_open('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Название <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="name" value="<?=set_value('name', $item['name']);?>" />
		<?=form_error('name'); ?>
	</div>
</div>
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
		Краткое описание
	</div>
	<div class="col-9 form-colinput">
		<textarea name="brief" class="form-input" rows="3"><?=set_value('brief', $item['brief']);?></textarea>
		<?=form_error('brief'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Описание страницы
		<div class="h6 text-gray">Рекомендуем заполнять это поле для СЕО-продвижения</div>
	</div>
	<div class="col-9 form-colinput">
		<textarea name="text" class="form-input" rows="3" id="editor"><?=set_value('text', $item['text']);?></textarea>
		<?=form_error('text'); ?>
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
<? if($item['thumb_enable']) { ?>
<hr class="mb15" />
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ширина эскизов (px)
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="thumb_x" value="<?=set_value('thumb_x', $item['thumb_x']);?>" />
		<?=form_error('thumb_x'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Высота эскизов (px)
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="thumb_y" value="<?=set_value('thumb_y', $item['thumb_y']);?>" />
		<?=form_error('thumb_y'); ?>
	</div>
</div>
<? } ?>
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