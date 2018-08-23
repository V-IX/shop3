<?=form_open_multipart('', array('class' => 'responsive-form', 'id' => 'mainForm'));?>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Изображение:
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
	<div class="col-3 form-collabel">
		Alt для изображения (SEO)
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="alt" value="<?=set_value('alt', $item['alt']);?>" />
		<?=form_error('alt'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Размеры баннера (px)
	</div>
	<div class="col-9 form-colinput">
		<div class="row">
			<div class="col-6">
				<input type="text" class="form-input" name="size_x" value="<?=set_value('size_x', $item['size_x']);?>" />
				<?=form_error('size_x'); ?>
			</div>
			<div class="col-6">
				<input type="text" class="form-input" name="size_y" value="<?=set_value('size_y', $item['size_y']);?>" />
				<?=form_error('size_y'); ?>
			</div>
		</div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ссылка
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="link" value="<?=set_value('link', $item['link']);?>" />
		<?=form_error('link'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Открыть ссылку
	</div>
	<div class="col-9 form-colinput">
		<? $targets = array(
			'_self' => 'В текущей вкладке',
			'_blank' => 'В новой вкладке',
		);?>
		<select name="target" class="form-input">
		<? foreach($targets as $value => $label) { ?>
			<option value="<?=$value?>" <?=set_select('target', $value, $item['target'] == $value ? true : false);?>><?=$label;?></option>
		<? } ?>
		</select>
		<?=form_error('target'); ?>
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

<script>
	$('#delImg').click(function(){
		$(this).closest('.input-file').find('.form-input, [name="img"]').val('');
	});
	
	$('[data-toggle="removeImg"]').click(function(){
		if(!confirm('Удалить изображение?')) return;
		csrf_test_name = "<?=$this->security->get_csrf_hash();?>";
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/'.uri(1).'/ajaxDeleteImg/'.uri(4));?>',
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