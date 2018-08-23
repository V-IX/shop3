<?=action_result('info', fa('info-circle mr5').' Размер слайда '.$size['x'].' х '.$size['y']);?>

<?=form_open_multipart('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" value="<?=set_value('title', 'Заголовок')?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Описание
	</div>
	<div class="col-9 form-colinput">
		<textarea class="form-input" name="text" rows="3"><?=set_value('text', 'краткое описание слайда');?></textarea>
		<?=form_error('text'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Текст кнопки
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="btn" value="<?=set_value('btn', 'Подробнее')?>" />
		<?=form_error('btn'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ссылка
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="link" value="<?=set_value('link')?>" />
		<?=form_error('link'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Номер по порядку
		<h6 class="form-info text-gray">На сайте выводится в обратном порядке</h6>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="num" value="<?=set_value('num', 1)?>" />
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
			<input type="file" name="img" id="upload-file" class="none _slide_img" accept="image/*" />
			<h6 class="form-info"><a href="javascript:void(0)" id="delImg">Удалить изображение</a></h6>
		</div>
		<?=$this->upload->display_errors('<div class="form-error">', '</div>');?>
		
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
			<option value="<?=$value;?>" <?=set_select('position', $value);?>><?=$label;?></option>
		<? } ?>
		</select>
	</div>
</div>
<div class="row form-group">
	<div class="col-3">
		Отображать текст
	</div>
	<div class="col-8">
		<input type="checkbox" name="showText" checked />
		<?=form_error('showText'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3">
		Отображать на сайте
	</div>
	<div class="col-8">
		<input type="checkbox" name="visibility" checked />
		<?=form_error('visibility'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success">Создать</button>
	<?=anchor('/admin/'.$this->uri->segment(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>

<script>
	$('#delImg').click(function(){
		$(this).closest('.input-file').find('input').val("");
		$('.slide').css({'background-image' : 'none'});
	});
</script>