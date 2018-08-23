<?=form_open();?>


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
		<input type="text" class="form-input" name="alias" value="<?=set_value('alias');?>" />
		<?=form_error('alias'); ?>
		<a href="javascript:void(0)" class="h6" data-toggle="translate_title">перевести заголовок</a>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Артикул <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="articul" value="<?=set_value('articul');?>" />
		<?=form_error('articul'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Отображать на сайте
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="visibility" checked />
		<?=form_error('visibility'); ?>
	</div>
</div>

<hr class="mb20" />

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
	<button class="btn btn-success">Копировать</button>
	<?=anchor('/admin/'.uri(2).'/view/'.uri(4), 'Вернуться к товару', array('class' => 'btn'));?>
	<?=anchor('/admin/'.uri(2), 'Вернуться к списку товаров', array('class' => 'btn right'));?>
</div>

<?=form_close();?>