<?=action_result('info', fa('info-circle mr5').' Размер слайда '.$size['x'].' х '.$size['y']);?>

<?=form_open_multipart('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" data-html="title" value="<?=set_value('title', $item['title'])?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Описание
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="text" data-html="text" rows="3"><?=set_value('text', $item['text']);?></textarea>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Текст кнопки
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="btn" data-html="btn" value="<?=set_value('btn', $item['btn'])?>" />
		<?=form_error('btn'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ссылка
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="link" value="<?=set_value('link', $item['link'])?>" />
		<?=form_error('link'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Номер по порядку
		<h6 class="form-info text-gray">На сайте выводится в обратном порядке</h6>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="num" value="<?=set_value('num', $item['num'])?>" />
		<?=form_error('num'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Изображение
		<h6 class="form-info text-gray">Максимальный размер 2Mb</h6>
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

<hr class="mb20" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		Выравнивание
	</div>
	<div class="col-9 form-colinput">
		<? $aligns = array('left' => 'По левому краю', 'center' => 'По центру', 'right' => 'По правому краю');?>
		<select name="position" class="form-input">
		<? foreach($aligns as $value => $label) { ?>
			<option value="<?=$value;?>" <?=set_select('position', $value, $value == $item['position'] ? true : false);?>><?=$label;?></option>
		<? } ?>
		</select>
	</div>
</div>
<div class="row form-group">
	<div class="col-3">
		Отображать на сайте
	</div>
	<div class="col-8">
		<input type="checkbox" name="visibility" <?=$item['visibility'] == 1 ? 'checked' : '';?> />
		<?=form_error('visibility'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3">
		Текст на слайде
	</div>
	<div class="col-8">
		<input type="checkbox" name="showText" data-check="stext" <?=$item['showText'] == 1 ? 'checked' : '';?> />
		<?=form_error('showText'); ?>
	</div>
</div>

<div class="form-actions">
	<button class="btn btn-success" data-save="save">Сохранить</button>
	<button class="btn btn-info" data-save="close">Соxранить и выйти</button>
	<?=anchor('/admin/'.$this->uri->segment(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>

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