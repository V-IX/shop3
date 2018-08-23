<?=form_open_multipart('', array('class' => 'responsive-form'));?>

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
		Номер по порядку
		<div class="h6 text-gray">На сайте выводится в обратном порядке</div>
	</div>
	<div class="col-9 form-colinput">
		<input type="text" class="form-input" name="num" value="<?=set_value('num', $item['num']);?>" />
		<?=form_error('num'); ?>
	</div>
</div>

<div class="form-actions">
	<button class="btn btn-success">Сохранить</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>