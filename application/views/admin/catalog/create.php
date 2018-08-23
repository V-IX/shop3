<? function catalog_option($item) { ?>
	<? $_count_nbs = ($item['level'] - 1) * 3; ?>
	<option value="<?=$item['idItem']?>" <?=set_select('idParent', $item['idItem']);?>>
		<?=nbs($_count_nbs);?>
		<?/* for($i = 1; $i < $item['level']; $i++) { ?>---<? } */?>
		<?=$item['title'];?>
	</option>
	<? if(isset($item['childs'])) { ?>
		<? foreach($item['childs'] as $childs) { ?>
			<?=catalog_option($childs);?>
		<? } ?>
	<? } ?>
<? } ?>

<?=form_open_multipart('', array('class' => 'responsive-form'));?>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" data-toggle="translate_auto" value="<?=set_value('title');?>" />
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
		Родительская категория <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<select class="form-input" name="idParent">
			<option value="0" <?=set_select('idParent', 0, true);?>>Корень</option>
		<? foreach($parents as $parent) { ?>
			<?=catalog_option($parent);?>
		<? } ?>
		</select>
		<?=form_error('idParent'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Краткое описание
	</div>
	<div class="col-9 form-colinput">
		<textarea name="brief" class="form-input" rows="3"><?=set_value('brief');?></textarea>
		<?=form_error('brief'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Текст
	</div>
	<div class="col-9 form-colinput">
		<textarea name="text" class="form-input" rows="3" id="editor"><?=set_value('text');?></textarea>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Изображение:
		<div class="h6 text-gray">Рекомендуемый размер не меньше <?=$size['x'];?>х<?=$size['y'];?>рх</div>
	</div>
	<div class="col-9 form-colinput">
		<div class="input-file">
			<input type="text" class="form-input" readonly placeholder="Файл не выбран" />
			<button class="btn">Обзор</button>
			<input type="file" name="img" class="none" accept="image/*"/>
			<h6 class="form-info"><a href="javascript:void(0)" id="delImg">очистить</a></h6>
		</div>
		<?=$this->upload->display_errors('<div class="form-error">', '</div>');?>
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
		<input type="text" class="form-input" name="mTitle" value="<?=set_value('mTitle');?>" />
		<?=form_error('mTitle'); ?>
		<a href="javascript:void(0)" class="h6" data-toggle="copy_title">скопировать заголовок</a>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Keywords
	</div>
	<div class="col-9 form-colinput">
		<textarea name="mKeywords" class="form-input" rows="3"><?=set_value('mKeywords');?></textarea>
		<?=form_error('mKeywords'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Meta Description
	</div>
	<div class="col-9 form-colinput">
		<textarea name="mDescription" class="form-input" rows="3"><?=set_value('mDescription');?></textarea>
		<?=form_error('mDescription'); ?>
	</div>
</div>

<div class="form-actions">
	<button class="btn btn-success">Добавить</button>
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