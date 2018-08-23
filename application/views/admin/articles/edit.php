<?=form_open_multipart('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>

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
		<input type="text" class="form-input" name="alias" value="<?=set_value('alias', $item['alias']);?>" />
		<?=form_error('alias'); ?>
		<a href="javascript:void(0)" class="h6" data-toggle="translate_title">перевести заголовок</a>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Краткое описание <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<textarea name="brief" class="form-input" rows="3"><?=set_value('brief', $item['brief']);?></textarea>
		<?=form_error('brief'); ?>
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
	<div class="col-3 form-collabel">
		Изображение:
		<div class="h6 text-gray">Рекомендуемый размер не меньше <?=$size['x'];?>х<?=$size['y'];?>рх</div>
	</div>
	<div class="col-9 form-colinput">
		<div class="input-file">
			<input type="text" class="form-input" readonly placeholder="Файл не выбран" />
			<button class="btn">Обзор</button>
			<input type="file" name="img" class="none" accept="image/*"/>
			<input type="hidden" name="oldImg" value="<?=$item['img'];?>" />
			<h6 class="form-info"><a href="javascript:void(0)" id="delImg">очистить</a></h6>
		</div>
		<?=$this->upload->display_errors('<div class="form-error">', '</div>');?>
		<? if($item['img']) { ?>
			<div id="imgWrap">
				<?=check_img('assets/uploads/'.$folder.'/thumb/'.$item['img'], array('class' => 'block mt20', 'style' => 'max-width: 100px;'));?>
				<div class="mt5 form-info"><a href="javascript:void(0)" data-toggle="removeImg">Удалить изображение</a></div>
			</div>
		<? } ?>
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

<hr class="mt20 mb20" />

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
	$('#delImg').click(function(){
		$(this).closest('.input-file').find('.form-input, [name="img"]').val('');
	});
	
	$('[data-toggle="removeImg"]').click(function(){
		if(!confirm('Удалить изображение?')) return;
		csrf_test_name = "<?=$this->security->get_csrf_hash();?>";
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/'.uri(2).'/ajaxDeleteImg/'.uri(4));?>',
			data		: {
				csrf_test_name : csrf_test_name,
				delete_img : 'delete'
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				if(data.error)
				{
					alert(data.text);
				} else {
					$('#imgWrap').remove();
				}
			},
		});	
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