<h3 class="text-info mb25">Внешний вид:</h3>

<div class="page-preview">
	<div class="img"><?=check_img('assets/uploads/theme/'.$theme['alias'].'.png', array());?></div>
	<div class="descr">
		<div class="h3 medium mb5">
			<?=$theme['title'];?>
		</div>
		<div class="mb15 text-gray">
			<?=$theme['brief'];?>
		</div>
		<a href="<?=base_url('admin/panel/edit_theme');?>" class="btn btn-success">Изменить внешний вид</a>
	</div>
</div>

<hr/>