<?=link_tag('assets/plugins/jquery-ui/jquery-ui.css');?>
<?=script('assets/plugins/jquery-ui/jquery-ui.min.js');?>

<form action="<?=current_url();?>" method="GET" class="filter-form">
	<ul class="filter-list">
		<li>
			<div class="title">Наши предложения</div>
			<div class="item">
				<ul class="chlist">
					<li>
						<label>
							<input type="checkbox" name="discount" <?=$this->input->get('discount') ? 'checked' : '';?> value="1" />
							Скидка
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="hit" <?=$this->input->get('hit') ? 'checked' : '';?> value="1" />
							Хит продаж
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="new" <?=$this->input->get('new') ? 'checked' : '';?> value="1" />
							Новинка
						</label>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<div class="title">Цена</div>
			<div class="item">
				<ul class="cols clearfix">
					<li class="col clearfix">
						<div class="c-label">от</div>
						<div class="c-input">
							<input type="text" name="price[from]" class="form-input" id="priceFrom" value="<?=$price['get_min'];?>" />
						</div>
					</li>
					<li class="col clearfix">
						<div class="c-label">до</div>
						<div class="c-input">
							<input type="text" name="price[to]" class="form-input" id="priceTo" value="<?=$price['get_max'];?>" />
						</div>
					</li>
				</ul>
				<div class="slider-ui" id="priceSlider"></div>
				<script>
					$('#priceSlider').slider({
						min: <?=$price['min'];?>,
						max: <?=$price['max'];?>,
						values: [<?=$price['get_min'];?>, <?=$price['get_max'];?>],
						orientation: "horizontal",
						range: true,
						animate: true,
						slide: function( event, ui ) {
							$('#priceFrom').val(ui.values[0]);
							$('#priceTo').val(ui.values[1]);
						}
					});
					
					$('#priceFrom').keyup(function() {$('#priceSlider').slider('values', 0, $(this).val());});
					$('#priceTo').keyup(function() {$('#priceSlider').slider('values', 1, $(this).val());});

				</script>
			</div>
		</li>
	<? if(isset($fields) and !empty($fields)) { ?>
	<? foreach($fields as $field) { ?>
		<? $id_field = $field['idItem']; ?>
		<li>
			<div class="title"><?=$field['title'];?></div>
			<div class="item">
			
			<? if($field['type'] == 'text') { ?>
				<input type="text" name="text[<?=$id_field;?>]" class="form-input" value="<?=isset($_GET['text'][$id_field]) ? $_GET['text'][$id_field] : '';?>" />
			<? } ?>
			
			<? if($field['type'] == 'number') { ?>
				<ul class="cols clearfix">
					<li class="col clearfix">
						<div class="c-label">от</div>
						<div class="c-input">
							<input type="text" name="num[<?=$field['idItem']?>][from]" class="form-input" id="rangeFrom<?=$field['idItem']?>" value="<?=intval($field['get_min']);?>" />
						</div>
					</li>
					<li class="col clearfix">
						<div class="c-label">до</div>
						<div class="c-input">
							<input type="text" name="num[<?=$field['idItem']?>][to]" class="form-input" id="rangeTo<?=$field['idItem']?>" value="<?=intval($field['get_max']);?>" />
						</div>
					</li>
				</ul>
				<div class="slider-ui" id="rangeSlider<?=$field['idItem']?>"></div>
				<script>
					$('#rangeSlider<?=$field['idItem']?>').slider({
						min: <?=$field['min'];?>,
						max: <?=$field['max'];?>,
						values: [<?=$field['get_min'];?>, <?=$field['get_max'];?>],
						orientation: "horizontal",
						range: true,
						animate: true,
						slide: function( event, ui ) {
							$('#rangeFrom<?=$field['idItem']?>').val(ui.values[0]);
							$('#rangeTo<?=$field['idItem']?>').val(ui.values[1]);
						}
					});
					
					$('#rangeFrom<?=$field['idItem']?>').keyup(function() {$('#rangeSlider<?=$field['idItem']?>').slider('values', 0, $(this).val());});
					$('#rangeTo<?=$field['idItem']?>').keyup(function() {$( "#rangeSlider<?=$field['idItem']?>" ).slider('values', 1, $(this).val());});

				</script>
			<? } ?>
			
			<? if($field['type'] == 'select') { ?>
				<select name="select[<?=$id_field;?>]" class="form-input">
				<? foreach($field['values'] as $value => $label) { ?>
					<option value="<?=$value;?>" <?=(isset($_GET['select'][$id_field]) and $_GET['select'][$id_field] == $value) ? 'selected' : '';?>><?=$label;?></option>
				<? } ?>
				</select>
			<? } ?>
			
			<? if($field['type'] == 'checkbox') { ?>
				<ul class="chlist">
				<? foreach($field['values'] as $value => $label) { ?>
					<li>
						<label>
							<input type="checkbox" name="checkbox[<?=$id_field;?>][<?=$value;?>]" <?=isset($_GET['checkbox'][$id_field][$value]) ? 'checked' : '';?> value="<?=$label;?>" />
							<?=$label;?>
						</label>
					</li>
				<? } ?>
				</ul>
			<? } ?>
			
			</div>
		</li>
	<? } ?>
	<? } ?>
	</ul>
	<div class="filter-actions">
		<button class="btn btn-xs">Показать</button>
		<? if(!empty($_GET)) { ?><a href="<?=current_url();?>" class="_reset color-blue">Сбросить</a><? } ?>
		<? if(!empty($_GET)) { ?><div class="count">Найдено: <?=$count;?></div><? } ?>
	</div>
</form>