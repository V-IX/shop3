<? 

$_cb = '';

function catalog_tr($item) 
{
	//global $_cb;
	//if($item['idParent'] == 0) $_cb = $item['title'];
	//else $_cb .= ' '.fa('angle-right').' '.$item['title'];
	?>
		<tr class="cattree-tr <?=!empty($item['childs']) ? 'not_empty' : null; ?>" data-parent="<?=$item['idParent'];?>" data-id="<?=$item['idItem'];?>" style="<?=$item['idParent'] != 0 ? 'display: none;' : null;?>">
			<td class="w100"><?=check_img('assets/uploads/catalog/thumb/'.$item['img'], array('class' => 'block w75'));?></td>
			<td class="item-toggle-wrap">
			<? if(!empty($item['childs'])) { ?>
				<span class="item-toggle text-warning">
					<?=fa('folder fa-fw _t_close');?>
					<?=fa('folder-open fa-fw _t_open');?>
					<span class="counter"><?=count($item['childs']);?></span>
				</span>
			<? } else { ?>
				<?=fa('folder-o text-gray fa-fw');?>
			<? } ?>
			</td>
			<td>
				<div class="item-title" style="padding-left: <?=$item['level'] * 15 - 15;?>px;" data-toggle="item">
					<?=$item['title'];?>
				</div>
			</td>
			<td class="text-right" nowrap>
				<?=$item['visibility'] == 1 ? fa('eye text-success') : fa('eye-slash text-error');?>
			</td>
			<td class="w200">
				<?=anchor('admin/'.uri(2).'/view/'.$item['idItem'], fa('eye'), array('class' => 'btn btn-info btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/fields/'.$item['idItem'], fa('filter'), array('class' => 'btn btn-warning btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], fa('pencil'), array('class' => 'btn btn-success btn-icon'));?>
				<?=anchor('admin/'.uri(2).'/delete/'.$item['idItem'], fa('trash'), array('class' => 'btn btn-error btn-icon delete-btn'));?>
			</td>
		</tr>
		<? if(isset($item['childs'])) { ?>
			<? foreach($item['childs'] as $child) { ?>
				<?=catalog_tr($child);?>
			<? } ?>
		<?// } else { ?>
			<?// $_cb = str_replace(' '.fa('angle-right').' '.$item['title'], '', $_cb);?>
		<? } ?>
	<?
}
?>


<? if(empty($items)) { ?>

<?=action_result('info', 'У вас не создано еще ни одной записи. Вы можете '.anchor('admin/'.uri(2).'/create', 'создать запись.'));?>

<? } else { ?>

<table class="table table-hover cattree">
	<thead>
		<tr>
			<th>Изображение</th>
			<th colspan="2">Заголовок</th>
			<th></th>
			<th class="w175">Действия</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($items as $item) { ?>
		<?=catalog_tr($item);?>
	<? } ?>
	</tbody>
</table>

<div class="form-actions mt20">
	<?=anchor('admin/'.uri(2).'/create', 'Добавить запись', array('class' => 'btn btn-success'));?>
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
	function hide_tr(id)
	{
		f_items = $('[data-parent="' + id + '"]');
		f_size = f_items.size();
		if(f_size > 0)
		{
			f_items.each(function(){
				f_item = $(this);
				f_new_id = f_item.attr('data-id');
				f_item.hide();
				f_item.removeClass('_open');
				hide_tr(f_new_id);
			});
		}
	}

	$('.delete-btn').click(function(e){
		e.preventDefault();
		$('#delForm').attr('action', $(this).attr('href'));
		$('#delTitle').text('"' + $(this).closest('tr').find('.item-title').text() + '"');
		$('#delModal').modal('show');
		return false;
	});
	
	$('[data-toggle="item"]').click(function(){
		el = $(this);
		parent = el.closest('[data-id]');
		id = parent.attr('data-id');
		items = $('[data-parent="' + id + '"]');
		
		if(parent.hasClass('_open'))
		{
			parent.removeClass('_open');
			hide_tr(id);
		} else {
			parent.addClass('_open');
			items.show();
		}
	});
	
</script>

<? } ?>