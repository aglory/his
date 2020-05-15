<?php
if (!defined('Execute')) {
	exit();
}
header("Content-Type: text/html;charset=utf-8");
include './config.php';
LoadClass('Pagination');
?>
<!DOCTYPE HTML>
<html>

<head>
	<link type="text/css" rel="stylesheet" href="/assets/css/base.css" />
	<script src="/assets/js/base.js"></script>
	<link type="text/css" rel="stylesheet" href="/assets/css/pagination.css" />
	<link rel="shortcut icon" href="assets/image/favicon.ico" type="image/x-icon" />
	<link rel="Bookmark" href="assets/image/favicon.ico" />
	<link type="text/css" rel="stylesheet" href="/page/cms/list/index.css" />
	<script src="/page/cms/list/index.js"></script>
</head>

<body>
	<?php Render('header') ?>
	<?php Render('search') ?>
	<?php Render('nav') ?>

	<div class="warpper crumb">
		<ul>
			<li><?php echo '<a href="', ActionLink('index', 'index', null, false), '">首页</a>' ?></li>
			<li><span>&gt;</span></li>
			<li><span>二级页面</span></li>
		</ul>
	</div>

	<div class="warpper content boxshadow">
		<div class="contenttitle">
			<h3>院内动态</h3>
		</div>
		<div class="contentbody block">
			<div class="item">
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
		<div class="contentbody block">
			<div class="item">
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
		<div class="contentbody block">
			<div class="item">
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
		<?php
		$pageIndex = 1;
		$pageSize = 20;
		if (array_key_exists('pageIndex', $_GET)) {
			$pageIndex = $_GET['pageIndex'];
		}
		if (array_key_exists('pageSize', $_GET)) {
			$pageSize = $_GET['pageSize'];
		}

		$page = new Pagination(2000, $pageIndex, $pageSize);
		$page->setQueryParams(
			array(
				'model' => Model,
				'action' => Action,
				'type' => $_GET['type']
			)
		);
		?>
		<div class="warpper pagination">
			<?php
			echo $page->links(['pager', 'prev', 'next', 'sizes']);
			?>
			<div style="clear: both"></div>
		</div>
	</div>
	<div class="warpper shade"></div>
	<?php Render('footlink') ?>
	<?php Render('footer') ?>
</body>

</html>