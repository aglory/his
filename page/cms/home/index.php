<?php
if (!defined('Execute')) {
	exit();
}
header("Content-Type: text/html;charset=utf-8");
include './config.php';
?>
<!DOCTYPE HTML>
<html>

<head>
	<link type="text/css" rel="stylesheet" href="/assets/css/base.css" />
	<script src="/assets/js/base.js"></script>
	<link rel="shortcut icon" href="assets/image/favicon.ico" type="image/x-icon" />
	<link rel="Bookmark" href="assets/image/favicon.ico" />
	<link type="text/css" rel="stylesheet" href="/page/cms/home/index.css" />
	<script src="/page/cms/home/index.js"></script>
</head>

<body>
	<?php Render('header') ?>
	<?php Render('search') ?>
	<div class="warpper titlebar">
		<img src="/assets/image/titlebar.jpg" />
	</div>
	<div class="warpper marqueenews">
		<marquee>
			<ul>
				<?php
				$sth =  $pdo->prepare('select Id, Title from `Content` where Type = 1 and Status = 1 order by `Index` asc, CreateDate desc;');
				$sth->execute();
				$news = $sth->fetchAll(PDO::FETCH_ASSOC);
				foreach ($news as  $new) {
					echo '<li>', $new['Title'], '</li>';
				}
				?>
			</ul>
		</marquee>
	</div>
	<div class="warpper blocktabs boxshadow">
		<div class="nav">
			<ul>
				<li class="item1 active" onclick="btnblocktabsnavclick(this, 1);">首页</li>
				<li class="item2" onclick="btnblocktabsnavclick(this, 2);">政策</li>
				<li class="item3" onclick="btnblocktabsnavclick(this, 3);">申报</li>
				<li class="item4" onclick="btnblocktabsnavclick(this, 4);">新闻</li>
				<li class="item5" onclick="btnblocktabsnavclick(this, 5);">介绍</li>
				<li class="item6" onclick="btnblocktabsnavclick(this, 6);">学术</li>
				<li class="item7" onclick="btnblocktabsnavclick(this, 7);">其它</li>
			</ul>
		</div>
		<div class="content">
			<div id="contentitem1" class="contentitem active">
				<div class="slide">
					<div class="slides">
						<?php
						$sth =  $pdo->prepare('select Id, Images from `Content` where Type = 1 and Status = 1 order by `Index` asc, CreateDate desc limit 1;');
						$sth->execute();
						$news = $sth->fetchAll(PDO::FETCH_ASSOC);
						foreach ($news as  $new) {
							$imgs = explode(',', $new['Images']);
							foreach ($imgs as $img) {
								echo '<div class="slider"><div class="images"><img src="/upload/content/', $new['Id'], '/', $img, '" /></div></div>';
							}
						}
						?>
					</div>
				</div>
				<div class="list">
					<h3><a href="<?php ActionLink('list', 'cms',  array("type" => 1)) ?>">重要动态</a></h3>
					<ul>
						<?php
						$sth =  $pdo->prepare('select Id, Title, CreateDate from `Content` where Type = 1 and Status = 1 order by `Index` asc, CreateDate desc;');
						$sth->execute();
						$news = $sth->fetchAll(PDO::FETCH_ASSOC);
						foreach ($news as  $new) {
							echo '<li><div class="title"><a href="', ActionLink('detail', 'cms', array('id' => $new['Id']), false), '">', $new['Title'], '</a></div><div class="createdate">', date_format(date_create($new['CreateDate']), "Y-m-d"), '</div></li>';
						}
						?>
					</ul>
				</div>
			</div>
			<div id="contentitem5" class="contentitem">

			</div>
		</div>
	</div>
	<div class="warpper banner">
		<img src="/page/cms/home/banner.jpg" alt="banner" />
	</div>
	<div class="warpper block">
		<div class="item boxshadow left">
			<h3><a href="<?php ActionLink('list', 'cms',  array("type" => 1)) ?>">相关政策</a></h3>
			<ul>
				<?php
				$sth =  $pdo->prepare('select Id, Title, CreateDate from `Content` where Type = 1 and Status = 1 order by `Index` asc, CreateDate desc;');
				$sth->execute();
				$news = $sth->fetchAll(PDO::FETCH_ASSOC);
				foreach ($news as  $new) {
					echo '<li><div class="title"><a href="', ActionLink('detail', 'cms', array('id' => $new['Id']), false), '">', $new['Title'], '</a></div><div class="createdate">', date_format(date_create($new['CreateDate']), "Y-m-d"), '</div></li>';
				}
				?>
			</ul>
		</div>
		<div class="item boxshadow right">
			<h3><a href="<?php ActionLink('list', 'cms',  array("type" => 1)) ?>">人才扶持</a></h3>
			<ul>
				<?php
				$sth =  $pdo->prepare('select Id, Title, CreateDate from `Content` where Type = 1 and Status = 1 order by `Index` asc, CreateDate desc;');
				$sth->execute();
				$news = $sth->fetchAll(PDO::FETCH_ASSOC);
				foreach ($news as  $new) {
					echo '<li><div class="title"><a href="', ActionLink('detail', 'cms', array('id' => $new['Id']), false), '">', $new['Title'], '</a></div><div class="createdate">', date_format(date_create($new['CreateDate']), "Y-m-d"), '</div></li>';
				}
				?>
			</ul>
		</div>
	</div>
	<div class="warpper shade"></div>

	<?php Render('footlink') ?>
	<?php Render('footer') ?>
</body>

</html>