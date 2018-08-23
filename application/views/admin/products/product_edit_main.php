<?
	$mainPost = $this->input->post('parents');
	if(!empty($mainPost)) $mainArr = $mainPost;
	else $mainArr = $catalogArr;
?>

<? function catalog_tr($item, $mainArr) { ?>
	<li class="tag-li">
		<a href="javascript:void(0)" class="btn btn-success btn-small btn-icon _prev" data-toggle="add" data-target="main" data-id="<?=$item['idItem'];?>" <?=array_key_exists($item['idItem'], $mainArr) ? 'style="display: none;"' : ''?>><?=fa('plus')?></a>
		<i  style="margin-left: <?=$item['level'] * 15 - 15;?>px;"></i>
		<?=$item['title'];?>
	</li>
	<? if(isset($item['childs'])) { ?>
		<? foreach($item['childs'] as $child) { ?>
			<?=catalog_tr($child, $mainArr);?>
		<? } ?>
	<? } ?>
<? } ?>

<? #=============================================================================================================== ?>

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
		Артикул <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="articul" value="<?=set_value('articul', $item['articul']);?>" />
		<?=form_error('articul'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Родительская категория <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<div class="tags" id="mainTags">
			<div class="tag tag-empty" <?=!empty($mainArr) ? 'style="display: none;"' : ''?>><?=fa('warning mr5')?> Категории не выбраны</div>
			<? foreach($mainArr as $_ma) { ?>
				<? if(isset($catalog[$_ma])) { ?>
				<div class="tag" data-tag="<?=$_ma?>" data-type="main">
					<?=$catalog[$_ma];?>
					<a href="javascript:void(0)" class="tag-remove"><i class="fa fa-times"></i></a>
					<input type="hidden" name="parents[<?=$_ma;?>]" value="<?=$_ma;?>" />
				</div>
				<? } ?>
			<? } ?>
		</div>
		<ul class="tag-list mb20" style="max-height: 370px;">
			<li class="tag-list-empty"><?=fa('angle-down mr5')?> Выберите категории</li>
		<? foreach($catalogs as $cat) { ?>
			<?=catalog_tr($cat, $mainArr);?>
		<? } ?>
		</ul>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Главная категория <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<select class="form-input" name="idParent">
			<?/*<option value="0" <?=set_select('idParent', 0, $item['idParent'] == 0 ? true : false);?>>Корень</option>*/?>
		<? foreach($catalog as $value => $label) { ?>
            <option value="<?=$value?>" <?=set_select('idParent', $value, $item['idParent'] == $value ? true : false);?>><?=$label?></option>
			
		<? } ?>
		</select>
		<?=form_error('idParent'); ?>
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
		Номер по порядку
		<div class="h6 text-gray">На сайте выводится в обратном порядке</div>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="num" value="<?=set_value('num', $item['num']);?>" />
		<?=form_error('num'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Основное изображение:
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

<hr class="mt20 mb20" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		Количество на складе
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="count" value="<?=set_value('count', $item['count']);?>" />
		<?=form_error('count'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Подсчет количества
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="count_subtraction" <?=$item['count_subtraction'] == 1 ? 'checked' : '';?> />
		<?=form_error('count_subtraction'); ?>
	</div>
</div>

<hr class="mt20 mb20" />

<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Новинка
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="sticker_new" <?=$item['sticker_new'] == 1 ? 'checked' : '';?> />
		<?=form_error('sticker_new'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Хит продаж
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="sticker_hit" <?=$item['sticker_hit'] == 1 ? 'checked' : '';?> />
		<?=form_error('sticker_hit'); ?>
	</div>
</div>
<?/*<div class="row form-group">
	<div class="col-3 form-collabel _nopadding">
		Лучшее предложение
	</div>
	<div class="col-9 form-colinput">
		<input type="checkbox" name="sticker_best" <?=$item['sticker_best'] == 1 ? 'checked' : '';?> />
		<?=form_error('sticker_best'); ?>
	</div>
</div>*/?>
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

<script>
	$('#delImg').click(function(){
		$(this).closest('.input-file').find('.form-input, [name="img"]').val('');
	});
	
	$('[data-toggle="removeImg"]').click(function(){
		if(!confirm('Удалить изображение?')) return;
		csrf_test_name = "<?=$this->security->get_csrf_hash();?>";
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/publications/ajaxDeleteImg/'.uri(4));?>',
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
	$('[data-toggle="add"]').click(function(){
		
		el = $(this);
		id = el.attr('data-id');
		label = el.closest('li').text();
		target = el.attr('data-target');
		tags = $('#' + target + 'Tags');
		
		html_remove = '<a href="javascript:void(0)" class="tag-remove"><i class="fa fa-times"></i></a>';
		html_input = '<input type="hidden" name="parents[' + id + ']" value="' + id + '" />';
		
		html_div = '<div class="tag" data-tag="' + id + '" data-type="' + target + '">' + label + html_remove + html_input + '</div>';
		
		tags.append(html_div);
		
		size = tags.find('[data-tag]').size();
		if(size > 0) tags.find('.tag-empty').hide();
		
		el.hide();
	});
	
	$(document).on('click', '.tag-remove', function() {
		el = $(this);
		parent = el.closest('.row.form-group');
		tag = el.closest('[data-tag]');
		id = tag.attr('data-tag');
		
		if(confirm('Вы уверены что хотите удалить категорию?'))
		{
			csrf_test_name = "<?=$this->security->get_csrf_hash();?>";
			$.ajax({
				type  		: "POST",
				url   		: '<?=base_url('admin/products/ajaxCatalogDelete/'.uri(4));?>',
				data		: {
					csrf_test_name : csrf_test_name,
					delete_mod : 'delete',
					parent : id
				},
				error 		: function () {
					alert('Ошибка запроса');
				},
				success		: function(data) {
					if(data.error)
					{
						alert(data.text);
					} else {
						tag.remove();
						$('[data-id="'+id+'"][data-target="' + target + '"]').show();
					}
				},
			});	
		} else {
			return false;
		}
		
		
		id = tag.attr('data-tag');
		target = tag.attr('data-type');
		tags = $('#' + target + 'Tags');
		
		tag.remove();
		$('[data-id="'+id+'"][data-target="' + target + '"]').show();
		
		size = tags.find('[data-tag]').size();
		if(size == 0) tags.find('.tag-empty').show();
	});
	
	$('[type="search"]').bind("change keyup input click", function() {
		el = $(this);
		val = el.val();
		
		list = $('.tag-list');
		li = list.find('.tag-li');
		
		if(val == '')
		{
			li.removeClass('_hidden');
		} else {
			li.each(function(){
				li_el = $(this);
				li_text = li_el.text();
				li_check = val.indexOf(li_text) + 1;
				if(li_check) li_el.removeClass('_hidden');
				else li_el.addClass('_hidden');
			});
		}
	});
</script>