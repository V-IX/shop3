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
		Обратная связь: <strong><?=$title;?></strong><br/>
		<br/>
		<? if(isset($name) and $name != "") { ?><strong>Имя:</strong> <?=$name;?><br/><? } ?>
		<? if(isset($phone) and $phone != "") { ?><strong>Телефон:</strong> <?=$phone;?><br/><? } ?>
		<? if(isset($email) and $email != "") { ?><strong>E-mail:</strong> <?=$email;?><br/><? } ?>
		<? if(isset($text) and $text != "") { ?><strong>Комментарий:</strong> <?=$text;?><br/><? } ?>
		<strong>Дата:</strong> <?=date('d.m.Y H:i');?><br/>
		<br/>
		Более подробная информацию Вы можете получить по ссылке<br/>
		<?=anchor('/admin/feedback/view/'.$idItem, '', array('style' => 'color: #0051a4'));?>
	</div>
</div>