<div id="descrWrap<?=$id;?>">
	<hr class="mb15" />
	<div class="row form-group">
		<div class="col-3 form-collabel">
			<div class="mb10">
				<input type="text" name="descr[<?=$id;?>][title]" class="form-input" value="<?=$this->input->post('title');?>" />
			</div>
			<div class="mb10">
				<input type="text" name="descr[<?=$id;?>][num]" class="form-input" value="1" />
			</div>
			<label class="block mb10">
				<div class="checker">
					<input type="checkbox" name="descr[<?=$id;?>][visibility]" checked />
					<div class="checker-view"></div>
				</div>
				Отображать на сайте
			</label>
			<a href="<?=base_url('admin/products/ajaxDescrDelete/'.$id);?>" class="h6" data-descr-remove="<?=$id;?>">удалить описание</a>
		</div>
		<div class="col-9 form-colinput">
			<textarea name="descr[<?=$id;?>][text]" class="form-input" id="descr<?=$id;?>" rows="3"></textarea>
		</div>
	</div>
</div>