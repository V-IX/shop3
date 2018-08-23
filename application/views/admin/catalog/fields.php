<? $fieldsArr = json_decode($item['fields'], true);
$fieldsArr = is_array($fieldsArr) ? $fieldsArr : array();?>

<?=form_open('', array('class' => 'responsive-form'));?>
<? $i = 1; foreach($fields as $group) { ?>
	<div class="h4 medium mb15"><?=$group['title'];?></div>
	<? if(!empty($group['child'])) { ?>
	<div class="row">
	<? foreach($group['child'] as $child) { ?>
		<div class="col-4 mb15">
			<label class="block">
				<input type="checkbox" name="field[<?=$child['idItem'];?>]" value="<?=$child['idItem'];?>" <?=array_key_exists($child['idItem'], $fieldsArr) ? 'checked' : '';?> />
				<?=$child['title'];?>
			</label>
		</div>
	<? } ?>
	</div>
	<? } ?>
	<? if($i != count($fields)) { ?><hr class="mb25 mt10"/><? } ?>
<? $i++;} ?>

<div class="form-actions mt20">
	<button class="btn btn-success">Редактировать</button>
	<?=anchor('admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'))?>
</div>
<?=form_close();?>