<? function navs($item) { ?>
		<li>
			<? $_pl = $item['level'] < 3 ? 20 : ($item['level']) * 10;?>
			<a href="<?=base_url('catalog/'.$item['path']);?>" class="cmenu-item <?=$item['toggle'] == 'open' ? '_open' : '';?> <?=$item['toggle'] == 'current' ? '_open _current' : '';?>" style="padding-left: <?=$_pl;?>px;">
				<?=$item['title'];?>
				<? if(isset($item['childs'])) { ?>
				<span class="toggle">
					<? $_toggle = ($item['toggle'] == 'open' or $item['toggle'] == 'current') ? 'down' : 'left';?>
					<?=fa('angle-'.$_toggle.' fa-fw');?>
				</span>
				<? } ?>
			</a>
			<? if(isset($item['childs']) and ($item['toggle'] == 'current' or $item['toggle'] == 'open')) { ?>
			<ul class="cmenu-child">
				<? foreach($item['childs'] as $child) { ?>
					<?=navs($child);?>
				<? } ?>
			</ul>
			<? } ?>
		</li>
<? } ?>

<nav class="cmenu">
	<div class="cmenu-title">Каталог товаров</div>
	<div class="cmenu-list">
	<? foreach($navs as $nav) { ?>
		<?=navs($nav);?>
	<? } ?>
	</div>
</nav>