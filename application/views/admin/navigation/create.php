<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="title" value="<?=set_value('title');?>" />
		<?=form_error('title'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Категория <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<select class="form-input" name="idParent">
			<option value="0" <?=set_select('idParent', 0);?>>Корень</option>
		<? foreach($parents as $value => $label) { ?>
			<option value="<?=$value;?>" <?=set_select('idParent', $value);?>>&nbsp;&nbsp;&nbsp;<?=$label;?></option>
		<? } ?>
		</select>
		<?=form_error('idParent'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ссылка
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="link" value="<?=set_value('link');?>" />
		<?=form_error('link'); ?>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Открыть ссылку
	</div>
	<div class="col-9 form-colinput">
		<select class="form-input" name="target">
			<option value="_self" <?=set_select('target', '_self');?>>В текущем окне</option>
			<option value="_blank" <?=set_select('target', '_blank');?>>В новом окне</option>
		</select>
		<?=form_error('target'); ?>
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
	<div class="col-3">
		Отображать на сайте
	</div>
	<div class="col-9">
		<input type="checkbox" name="visibility" checked />
		<?=form_error('visibility'); ?>
	</div>
</div>

<div class="form-actions">
	<button class="btn btn-success">Создать</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
	<input type="hidden" name="position" value="<?=$position;?>" />
</div>
<?=form_close();?>