<div class="h4 medium mb20">Вместе с этим покупают</div>

<div class="mt15">
	<a href="javascript:void(0)" id="addSimilars" class="text-success">Редактировать товары</a>
</div>

<ul class="similars-list clearfix mt30" id="similarsList">
<? foreach($similars as $similar) { ?>
	<li>
		<div class="similars-product" data-similar-item="<?=$similar['idProduct']?>">
			<div class="img">
				<a href="javascript:void(0)" data-similar-product="<?=$similar['idProduct']?>" class="remove"><?=fa('times');?></a>
				<?=check_img('assets/uploads/products/thumb/'.$similar['img']);?>
			</div>
			<div class="title"><?=$similar['title'];?></div>
			<div class="brief text-gray"><?=$similar['brief'];?></div>
		</div>
	</li>
<? } ?>
</ul>

<hr class="mt30 mb30" />

<div class="h4 medium mb20">Полезная информация</div>

<div class="mt15">
	<a href="javascript:void(0)" id="addArticle" class="text-success">Редактировать статьи</a>
</div>

<ul class="prod-articles small-preview mt30" id="articleList">
<? $i = 1; foreach($articles as $article) { ?>
	<li data-article-item="<?=$article['idArticle'];?>">
		<div class="clearfix">
			<div class="img">
				<?=check_img('assets/uploads/articles/thumb/'.$article['img']);?>
			</div>
			<div class="descr">
				<div class="medium mb5"><?=$article['title'];?></div>
				<div class="h6 text-gray"><?=$article['brief'];?></div>
			</div>
		</div>
	</li>
<? $i++;} ?>
</ul>

<hr class="mt30 mb30" />

<div class="h4 medium mb20">Описание</div>

<div class="mt15">
	<a href="javascript:void(0)" id="addDescr" class="text-success">Добавить описание</a>
</div>

<div class="mt30" id="descrList">
<? foreach($descrs as $descr) { ?>
<div id="descrWrap<?=$descr['idItem'];?>">
	<hr class="mb15" />
	<div class="row form-group">
		<div class="col-3 form-colinput">
			<div class="mb10">
				<input type="text" name="descr[<?=$descr['idItem'];?>][title]" class="form-input" value="<?=set_value('descr['.$descr['idItem'].'][title]', $descr['title']);?>" />
			</div>
			<div class="mb10">
				<input type="text" name="descr[<?=$descr['idItem'];?>][num]" class="form-input" value="<?=set_value('descr['.$descr['idItem'].'][num]', $descr['num']);?>" />
			</div>
			<label class="block mb10">
				<input type="checkbox" name="descr[<?=$descr['idItem'];?>][visibility]" <?=$descr['visibility'] ? 'checked' : '';?> />
				Отображать на сайте
			</label>
			<a href="<?=base_url('admin/products/ajaxDescrDelete/'.$descr['idItem']);?>" class="h6" data-descr-remove="<?=$descr['idItem'];?>">удалить описание</a>
		</div>
		<div class="col-9 form-colinput">
			<textarea name="descr[<?=$descr['idItem'];?>][text]" class="form-input" id="descr<?=$descr['idItem'];?>" rows="3"><?=set_value('descr['.$descr['idItem'].'][text]', $descr['text']);?></textarea>
		</div>
	</div>
	<script>
		CKEDITOR.replace('descr<?=$descr['idItem'];?>');
	</script>
</div>
<? } ?>
</div>

<script>
	$('#addSimilars').click(function(){
		
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/products/ajaxGetSimilarsFull');?>',
			data		: {
				csrf_test_name : csrf_test_name,
				similar : 'similar'
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				$('#similarsWindow').html(data.html);
			},
		});
		
		$('#addSimilarsModal').modal('show');
		return false;
	});
	
	$(document).on('click', '[data-similar-catalog]', function(){
		el = $(this);
		id = el.attr('data-similar-catalog');
		if(!el.hasClass('_current'))
		{
			$.ajax({
				type  		: "POST",
				url   		: '<?=base_url('admin/products/ajaxSimilarsProduct');?>/' + id,
				data		: {
					csrf_test_name : csrf_test_name,
					id : id,
					product : '<?=uri(4)?>'
				},
				error 		: function () {
					alert('Ошибка запроса');
				},
				success		: function(data) {
					$('#similarsProducts').html(data.html);
					$('#similarsTree .similars-tree-item').removeClass('_open');
					$('#similarsTree .similars-tree-item').removeClass('_current');
					$('#similarsTree .similars-tree-child').hide();
					
					el.addClass('_current');
					a = el;
					li = el.closest('li');
					ul = el.closest('ul');
					
					while(!ul.hasClass('similars-tree-parent'))
					{
						a.addClass('_open');
						li.children('.similars-tree-child').show();
						
						li = ul.closest('li');
						a = li.children('.similars-tree-item');
						ul = ul.closest('li').closest('ul');
					}
					a.addClass('_open');
					li.children('.similars-tree-child').show();
				},
			});
		}
	});
	
	$(document).on('click', '[data-similar-product]', function(){
		el = $(this);
		id = el.attr('data-similar-product');
		//el.toggleClass('active');
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/products/ajaxUpdateSimilars/'.uri(4));?>',
			data		: {
				csrf_test_name : csrf_test_name,
				id : id
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				if(data.error)
				{
					alert(data.text);
				} else {
					if(data.toggle == 'delete')
					{
						el.removeClass('active');
						$('[data-similar-item="'+id+'"]').closest('li').remove();
					}
					if(data.toggle == 'insert')
					{
						el.addClass('active');
						$('#similarsList').append('<li><div class="similars-product" data-similar-item="' + id + '">' + el.html() + '</div></li>');
						$('[data-similar-item="'+id+'"] .img').append('<a href="javascript:void(0)" data-similar-product="'+id+'" class="remove"><?=fa('times');?></a>');
					}
				}
			},
		});
	});

</script>

<script>
	$('#addArticle').click(function(){
		
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/products/ajaxGetArticles/'.uri(4));?>',
			data		: {
				csrf_test_name : csrf_test_name,
				articles : 'articles'
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				$('#articleListModal').html(data.html);
			},
		});
		
		$('#addArticleModal').modal('show');
		return false;
	});
	
	$(document).on('click', '[data-article]', function(){
		el = $(this);
		id = el.attr('data-article');
		
		$.ajax({
			type  		: "POST",
			url   		: '<?=base_url('admin/products/ajaxUpdateArticles/'.uri(4));?>',
			data		: {
				csrf_test_name : csrf_test_name,
				id : id
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				if(data.error)
				{
					alert(data.text);
				} else {
					if(data.toggle == 'delete')
					{
						el.removeClass('active');
						$('[data-article-item="'+id+'"]').remove();
					}
					if(data.toggle == 'insert')
					{
						el.addClass('active');
						$('#articleList').append('<li data-article-item="' + id + '">' + el.html() + '</li>');
					}
				}
			},
		});
	});

</script>

<script>
	$('#addDescr').click(function(){
		$('#addDescrModal').modal('show');
	});
	
	$(document).on('submit', '#addDescrForm', 'submit', function(event){
		event.preventDefault();
		
		if($('#addDescrForm [name="title"]').val() == '') return false;
		
		el = $(this);
		post = el.serialize();
		action = el.attr('action');
		
		$.ajax({
			type  		: "POST",
			url   		: action,
			data		: post,
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				if(data.error)
				{
					alert(data.text);
				} else {
					$('#descrList').append(data.html);
					$('#addDescrModal').modal('hide');
					$('#addDescrForm [name="title"]').val('');
					CKEDITOR.replace('descr' + data.id);
				}
			},
		});
		return false;
	});
	
	$(document).on('click', '[data-descr-remove]', function(event){
		event.preventDefault();
		if(!confirm('Удалить описание?')) return false;
		
		el = $(this);
		id = el.attr('data-descr-remove');
		action = el.attr('href');
		
		$.ajax({
			type  		: "POST",
			url   		: action,
			data		: {
				csrf_test_name : csrf_test_name,
				id : id,
				delete_descr : 'delete'
			},
			error 		: function () {
				alert('Ошибка запроса');
			},
			success		: function(data) {
				if(data.error)
				{
					alert(data.text);
				} else {
					$('#descrWrap' + id).remove();
				}
			},
		});
		return false;
	});
</script>