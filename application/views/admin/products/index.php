<? function catalog_option($item) { ?>
	<? $_count_nbs = ($item['level'] - 1) * 3; ?>
	<option value="<?=$item['idItem']?>" <?=(isset($_GET['idParent']) and $_GET['idParent'] == $item['idItem']) ? 'selected' : null;?>>
		<?=nbs($_count_nbs);?>
		<?/* for($i = 1; $i < $item['level']; $i++) { ?>---<? } */?>
		<?=$item['title'];?>
	</option>
	<? if(isset($item['childs'])) { ?>
		<? foreach($item['childs'] as $childs) { ?>
			<?=catalog_option($childs);?>
		<? } ?>
	<? } ?>
<? } ?>

<form action="<?=base_url('admin/products');?>" method="GET" class="mb20">
	<div class="row mb15">
		<div class="col-4">
			<div class="form-caption">Поиск по названию</div>
			<input type="text" name="title" class="form-input" value="<?=$this->input->get('title');?>" />
		</div>
		<div class="col-4">
			<div class="form-caption">Категория</div>
			<select class="form-input" name="idParent">
			<option value="all" <?=(!isset($_GET['idParent']) or (isset($_GET['idParent']) and $_GET['idParent'] == 'all')) ? 'selected' : null;?>>Все категории</option>
			<? foreach($parents as $parent) { ?>
				<?=catalog_option($parent);?>
			<? } ?>
			</select>
		</div>
		<div class="col-4">
			<? $sorts = array(
				'title|ASC' => 'Название &uarr;',
				'title|DESC' => 'Название &darr;',
				'num|ASC' => 'Номер п/п &uarr;',
				'num|DESC' => 'Номер п/п &darr;',
				'addDate|ASC' => 'Дата добавления &uarr;',
				'addDate|DESC' => 'Дата добавления &darr;',
			);?>
			<div class="form-caption">Сортировка</div>
			<select class="form-input" name="sort">
			<? foreach($sorts as $value => $label) { ?>
				<option value="<?=$value;?>" <?=(isset($_GET['sort']) and $_GET['sort'] == $value) ? 'selected' : null;?>><?=$label;?></option>
			<? } ?>
			</select>
		</div>
	</div>
	<div class="">
		<button class="btn btn-success">Фильтровать</button>
		<? if(!empty($_GET)) { ?>
			<span class="text-gray h6 ml20">Найдено: <?=$count;?> товаров</span>
			<a href="<?=base_url('admin/products');?>" class="h6 ml10">сбросить фильтр</a>
		<? } ?>
	</div>
</form>

<hr class="mb20" />

<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной записи. Вы можете '.anchor('admin/'.uri(2).'/create', 'создать запись.'));?>

<? } else { ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Изображение</th>
			<th>Заголовок</th>
			<th>Добавлено</th>
			<th></th>
			<th class="w175">Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<tr>
			<td class="w100"><?=check_img('assets/uploads/'.$folder.'/thumb/'.$item['img'], array('class' => 'block w75'));?></td>
			<td>
				<div class="item-title"><?=$item['title'];?></div>
				<div class="h6 text-gray"><?=$item['brief'];?></div>
			</td>
			<td nowrap >
				<?=fa('calendar mr5 fa-fw text-gray');?> <?=date('d.m.Y', strtotime($item['addDate']));?><br/>
				<?=fa('clock-o mr5 fa-fw text-gray');?> <?=date('H:i:s', strtotime($item['addDate']));?>
			</td>
			<td class="text-right"><?=$item['visibility'] == 1 ? fa('eye text-success') : fa('eye-slash text-error');?></td>
			<td class="w200">
				<?=anchor('admin/'.uri(2).'/view/'.$item['idItem'], fa('eye'), array('class' => 'btn btn-info btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/imgs/'.$item['idItem'], fa('picture-o'), array('class' => 'btn btn-warning btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/delete/'.$item['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>

<?=$this->pagination->create_links(); ?>

<div class="form-actions mt20">
	<?=anchor('admin/'.uri(2).'/create', 'Добавить запись', array('class' => 'btn btn-success'));?>
	<div class="right">
		<?=anchor('admin/'.uri(2).'/import', fa('upload mr5').' Импорт позиций', array('class' => 'btn btn-info'));?>
		<?=anchor('admin/'.uri(2).'/import_mod', fa('upload mr5').' Импорт модификаций', array('class' => 'btn btn-info'));?>
	</div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w500">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title">Подтвердить удаление записи</div>
			</div>
			<?=form_open('', array('id' => 'delForm'))?>
			<div class="modal-body">
				Вы действительно хотите удалить запись <span class="medium" id="delTitle"></span>?
			</div>
			<div class="modal-footer text-right">
				<button class="btn btn-success">Подтвердить</button>
				<span class="btn btn-error" data-dismiss="modal">Отмена</span>
				<input type="hidden" name="delete" value="delete" />
			</div>
			<?=form_close();?>
		</div>
	</div>
</div>


<script>
	$('.delete-btn').click(function(e){
		e.preventDefault();
		$('#delForm').attr('action', $(this).attr('href'));
		$('#delTitle').text('"' + $(this).closest('tr').find('.item-title').text() + '"');
		$('#delModal').modal('show');
		return false;
	})
</script>

<? } ?>