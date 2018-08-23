<?=form_open('', array('class' => 'responsive-form'));?>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Тема: <span class="required">*</span>
	</div>
	<div class="col-9 form-colinput">
		<select name="theme" class="form-input">
		<? foreach($themes as $theme) { ?>
			<option value="<?=$theme['alias'];?>" <?=set_select('theme', $theme['alias'], $theme['current'] == 1 ? true : false);?>><?=$theme['title'];?></option>
		<? } ?>
		</select>
		<?=form_error('theme'); ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-success">Сохранить</button>
	<?=anchor('admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>
<?=form_close();?>