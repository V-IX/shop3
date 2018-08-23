<div style="border: 1px solid #d8d8d8;">
	<div style="padding: 20px; background: #f3f3f3; border-bottom: 2px solid #d8d8d8; text-align: left; font-family: Arial, sans-serif;">
		<span style="display: inline-block;">
			<img src="<?=base_url('assets/uploads/settings/'.$site['img']);?>" style="display: inline-block; vertical-align: middle; margin-right: 15px; height: 60px;" />
			<span style="display: inline-block; vertical-align: middle; ">
				<span style="font-size: 46px; font-weight: 700; line-height: 1;  display: block; "><?=$site['title']?></span>
				<span style="font-size: 16px; color: #808080;"><?=$site['descr'];?></span>
			</span>
		</span>
	</div>
	<div style="padding: 20px 20px 40px; font-size: 14px; line-height: 21px;">
		Отзыв к товару: <strong><?=$product;?></strong><br/>
		<br/>
		<? if(isset($product) and $product != "") { ?><strong>Товар:</strong> <a href="<?=base_url('products/'.$product_alias);?>" style="color: #db1c00"><?=$product;?></a><br/><? } ?>
		<? if(isset($name) and $name != "") { ?><strong>Имя:</strong> <?=$name;?><br/><? } ?>
		<? if(isset($city) and $city != "") { ?><strong>Город:</strong> <?=$city;?><br/><? } ?>
		<? if(isset($link) and $link != "") { ?><strong>Ссылка:</strong> <a href="<?=$link?>" style="color: #db1c00"><?=$link;?></a><br/><? } ?>
		<? if(isset($raiting) and $raiting != 0) { ?><strong>Оценка:</strong> <?=$raiting;?><br/><? } ?>
		<? if(isset($text) and $text != "") { ?><strong>Отзыв:</strong> <?=$text;?><br/><? } ?>
		<strong>Дата:</strong> <?=date('d.m.Y H:i');?><br/>
		<br/>
		Более подробная информацию Вы можете получить по ссылке<br/>
		<?=anchor('/admin/comments/view/'.$idItem, '', array('style' => 'color: #db1c00'));?>
	</div>
</div>