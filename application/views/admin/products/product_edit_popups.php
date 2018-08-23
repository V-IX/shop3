<? //---------- MODIFICATIONS ---------- ?>

<div class="modal fade" id="addModModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w500">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title">Добавить модификацию</div>
			</div>
			<?=form_open('admin/products/ajaxInsertMod/'.$item['idItem'], array('id' => 'addModForm'))?>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-caption">Артикул <span class="required">*</span></div>
					<input type="text" class="form-input" name="add_mod[articul]" />
				</div>
				<div class="form-group">
					<div class="form-caption">Заголовок</div>
					<input type="text" class="form-input" name="add_mod[title]" />
				</div>
				<div class="form-group">
					<div class="form-caption">Цена</div>
					<input type="text" class="form-input" name="add_mod[price]" value="0" />
				</div>
				<div class="form-group">
					<div class="form-caption">Старая цена</div>
					<input type="text" class="form-input" name="add_mod[oldPrice]" value="0" />
				</div>
				<div class="form-group">
					<div class="form-caption">Количество на складе</div>
					<input type="text" class="form-input" name="add_mod[count]" value="1" />
				</div>
			</div>
			<div class="modal-footer text-right">
				<button class="btn btn-success">Подтвердить</button>
				<span class="btn btn-error" data-dismiss="modal">Отмена</span>
			</div>
			<?=form_close();?>
		</div>
	</div>
</div>

<? //---------- ARTICLES ---------- ?>

<div class="modal fade" id="addArticleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-medium">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title"><div class="h4 medium">Редактировать статьи</div></div>
			</div>
			<?#=form_open('admin/products/ajaxInsertArticles/'.$item['idItem'], array('id' => 'addArticleForm'))?>
			<div class="modal-body">
				<div class="" id="articleListModal">
					
				</div>
			</div>
			<div class="modal-footer text-right">
				<a href="javascript:void(0)" class="btn btn-success" data-dismiss="modal">Готово</a>
				<a href="javascript:void(0)" class="btn btn-error" data-dismiss="modal">Отмена</a>
			</div>
			<?#=form_close();?>
		</div>
	</div>
</div>

<? //---------- SIMILARS ---------- ?>

<div class="modal fade" id="addSimilarsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-similars">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title"><div class="h4 medium">Редактировать товары</div></div>
			</div>
			<div class="modal-body">
				<div id="similarsWindow">
					
				</div>
			</div>
			<div class="modal-footer text-right">
				<a href="javascript:void(0)" class="btn btn-success" data-dismiss="modal">Готово</a>
				<a href="javascript:void(0)" class="btn btn-error" data-dismiss="modal">Отмена</a>
			</div>
		</div>
	</div>
</div>

<? //---------- FIELDS ---------- ?>

<div class="modal fade" id="addFieldsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<?/*<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>*/?>
				<div class="modal-title"><div class="h4 medium">Редактировать поля</div></div>
			</div>
			<div class="modal-body">
				<div id="fieldsWindow">
					
				</div>
			</div>
			<div class="modal-footer text-right">
				<a href="javascript:void(0)" class="btn btn-success" id="fieldsRefresh">Сохранить изменения</a>
			</div>
		</div>
	</div>
</div>

<? //---------- DESCR ---------- ?>

<div class="modal fade" id="addDescrModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title"><div class="h4 medium">Редактировать поля</div></div>
			</div>
			<?=form_open('admin/products/ajaxInsertDescr/'.$item['idItem'], array('id' => 'addDescrForm'))?>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-caption">Заголовок</div>
					<input type="text" class="form-input" name="title" />
				</div>
			</div>
			<div class="modal-footer text-right">
				<button class="btn btn-success">Подтвердить</button>
				<a href="javascript:void(0)" class="btn btn-error" data-dismiss="modal">Отмена</a>
			</div>
			<?=form_close();?>
		</div>
	</div>
</div>