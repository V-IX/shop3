<?#=form_open_multipart();?>

<script>
	base_url = '<?=base_url()?>';
	csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
</script>

<form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data" class="responsive-form" id="mainForm">

<input type="hidden" name="csrf_test_name" value="<?=$this->security->get_csrf_hash()?>" />

<div class="tabs mb20">
	<div class="tabs-list">
		<ul>
			<li>
				<a href="#main" class="active">Основное <span class="required">*</span></a>
			</li>
			<li>
				<a href="#descr">Описание</a>
			</li>
			<li>
				<a href="#price">Ценообразование</a>
			</li>
			<li>
				<a href="#fields">Настраивамые поля</a>
			</li>
			<li>
				<a href="#info">Дополнительная информация</a>
			</li>
		</ul>
	</div>
	<div class="tab-content">
		<? # ОСНОВНОЕ ?>
		<div class="tab-content-in active" id="main">
			<? $this->load->view('admin/products/product_edit_main');?>
		</div>
		<? # ОПИСАНИЕ ?>
		<div class="tab-content-in" id="descr">
			<? $this->load->view('admin/products/product_edit_descr');?>
		</div>
		<? # ЦЕНООБРАЗОВАНИЕ ?>
		<div class="tab-content-in" id="price">
			<? $this->load->view('admin/products/product_edit_price');?>
		</div>
		<? # НАСТРАИВАМЫЕ ПОЛЯ ?>
		<div class="tab-content-in" id="fields">
			<? $this->load->view('admin/products/product_edit_fields');?>
		</div>
		<? # ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ ?>
		<div class="tab-content-in" id="info">
			<? $this->load->view('admin/products/product_edit_info');?>
		</div>
	</div>
</div>

<div class="form-actions">
	<button class="btn btn-success" data-save="save">Сохранить</button>
	<button class="btn btn-info" data-save="close">Соxранить и выйти</button>
	<?=anchor('/admin/'.uri(2), 'Вернуться назад', array('class' => 'btn'));?>
</div>

</form>
<?#=form_close();?>

<? $this->load->view('admin/products/product_edit_popups');?>

<script>
	$('[data-save]').click(function(){
		param = $(this).attr('data-save');
		
		if(param == 'save') src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4));?>';
		else src = '<?=base_url('admin/'.uri(2).'/edit/'.uri(4).'/close');?>';
		
		$('#mainForm').attr('action', src);
		return;
	});
</script>