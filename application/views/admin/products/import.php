<?=form_open_multipart();?>
	<div class="row form-group">
		<div class="col-3 form-collabel">
			CSV-файл
		</div>
		<div class="col-9">
			<div class="input-file">
				<input type="text" class="form-input" readonly placeholder="Файл не выбран" />
				<button class="btn">Обзор</button>
				<input type="file" name="file" class="none" accept="" />
			</div>
		</div>
	</div>
	
	<div class="form-actions">
		<button class="btn btn-success">Загрузить</button>
		<?=anchor('/admin/'.$this->uri->segment(2), 'Вернуться назад', array('class' => 'btn'));?>
		<?=anchor('/assets/uploads/example_products.csv', 'Пример CSV-файла', array('class' => 'btn btn-info right'));?>
	</div>
	<input type="hidden" name="hidden" value="import" />
<?=form_close();?>