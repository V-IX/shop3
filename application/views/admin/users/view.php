<div class="page-preview">
	<div class="img">
	<?=img('assets/uploads/nophoto/user.png');?>
	</div>
	<div class="descr">
		<div class="h4 mb5">
			<span class="medium"><?=$item['login'];?></span> -
			<?=$item['name'];?>
			<?=$item['lname'];?>
			<?=$item['sname'];?>
			<? if($item['idItem'] == $this->session->userdata('id')) { ?>
			<span class="text-gray h5 ml5">(мой профиль)</span>
			<? } ?>
		</div>
		<div class="text-gray mb10">
			<? if($item['access'] == "admin") { ?>
				Администратор
			<? } elseif($item['access'] == "moderator") { ?>
				Модератор
			<? } else { ?>
				Пользователь
			<? } ?>
		</div>
		<div><?=fa('at text-gray mr5');?> <?=$item['email'];?></div>
	</div>
</div>

<div class="form-actions">
	<?=anchor('admin/'.uri(2).'/edit/'.$item['idItem'], 'Редактировать', array('class' => 'btn btn-success'))?>
	<?=anchor('admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'))?>
	<? if($item['idItem'] != $this->session->userdata('id')) { ?>
		<?=anchor('#delModal', '<i class="fa fa-trash"></i>', array('class' => 'btn btn-icon btn-error right', 'data-toggle' => 'modal'))?>
	<? } ?>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w500">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title">Подтвердить удаление записи</div>
			</div>
			<?=form_open('admin/'.uri(2).'/delete/'.$item['idItem'], array('id' => 'delForm'))?>
			<div class="modal-body">
				Вы действительно хотите удалить запись <span class="medium">"<?=$item['title']?>"</span>?
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