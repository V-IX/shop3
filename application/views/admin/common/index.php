<div class="row dashboard-stat-row">
	<div class="col-3">
		<div class="dashboard-stat success">
			<div class="icon"><?=fa('envelope-o');?></div>
			<div class="details">
				<div class="num"><?=$counter['feedback'];?></div>
				<div class="descr"><div class="text-overflow">новых сообщений</div></div>
			</div>
			<a href="<?=base_url('admin/feedback');?>" class="link">
				Подробнее
				<?=fa('arrow-circle-o-right');?>
			</a>
		</div>
	</div>
	<div class="col-3">
		<div class="dashboard-stat info">
			<div class="icon"><?=fa('bullhorn');?></div>
			<div class="details">
				<div class="num"><?=$counter['publications'];?></div>
				<div class="descr"><div class="text-overflow">публикаций</div></div>
			</div>
			<a href="<?=base_url('admin/publications/create');?>" class="link">
				Добавить публикацию
				<?=fa('plus-square-o');?>
			</a>
		</div>
	</div>
	<div class="col-3">
		<div class="dashboard-stat warning">
			<div class="icon"><?=fa('files-o');?></div>
			<div class="details">
				<div class="num"><?=$counter['pages'];?></div>
				<div class="descr"><div class="text-overflow">страниц</div></div>
			</div>
			<a href="<?=base_url('admin/pages/create');?>" class="link">
				Добавить страницу
				<?=fa('plus-square-o');?>
			</a>
		</div>
	</div>
	<div class="col-3">
		<div class="dashboard-stat error">
			<div class="icon"><?=fa('cog');?></div>
			<div class="details">
				<div class="num"><?=$siteinfo['title']?></div>
				<div class="descr"><div class="text-overflow"><?=$siteinfo['descr']?></div></div>
			</div>
			<a href="<?=base_url('admin/settings/edit');?>" class="link">
				Изменить настройки
				<?=fa('plus-square-o');?>
			</a>
		</div>
	</div>
</div>
<hr class="mb25" />

<div class="row messages-row">
<? if(!empty($feedbacks)) { ?>
	<div class="col-6">
		<div class="panel">
			<div class="panel-head">
				<?=fa('envelope-o');?> Новые сообщения
			</div>
			<div class="panel-body">
				<ul class="messages">
				<? foreach($feedbacks as $feedback) { ?>
					<li>
						<a href="<?=base_url('admin/feedback/view/'.$feedback['idItem']);?>" class="message">
							<div class="clearfix">
								<div class="icon"><?=fa('envelope-o');?></div>
								<div class="text">
									<span class="bold"><?=$feedback['phone'];?></span>
									<? if($feedback['name'] != '') { ?><span class="text-gray">- <?=$feedback['name'];?></span><? } ?>
									<span class="text-gray">- <?=$feedback['title'];?></span>
								</div>
								<div class="date">
									<div><?=date('d.m.Y', strtotime($feedback['addDate']));?></div>
									<div><?=date('H:i:s', strtotime($feedback['addDate']));?></div>
								</div>
							</div>
						</a>
					</li>
				<? } ?>
				</ul>
				<div class="text-right mt15">
					<a href="<?=base_url('admin/feedback');?>">Перейти ко всем заказам</a>
				</div>
			</div>
		</div>
	</div>
<? } ?>
</div>