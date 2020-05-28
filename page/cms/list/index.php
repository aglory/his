<?php
if (!defined('Execute')) {
	exit();
}
header("Content-Type: text/html;charset=utf-8");
include './config.php';
LoadClass('Pagination');

$pageIndex = 1;
$pageSize = 20;
$type = 0;
if (array_key_exists('pageIndex', $_GET)) {
	$pageIndex = intval($_GET['pageIndex']);
}
if (array_key_exists('pageSize', $_GET)) {
	$pageSize = intval($_GET['pageSize']);
}
if (empty($pageSize))
	$pageSize = 20;
if (array_key_exists('type', $_GET)) {
	$type = intval($_GET['type']);
}
$pageStart = ($pageIndex - 1) * $pageSize;
$pageEnd = $pageStart  + $pageSize;


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
					$whereClause = "Type = $type and Status = 1";
					$sthContentList =  $pdo->prepare("select Id, Title, CreateDate from `Content` where $whereClause order by `Index` asc, CreateDate desc limit $pageStart, $pageSize;");
					$sthContentList->execute();
					$contents = $sthContentList->fetchAll(PDO::FETCH_ASSOC);
					foreach ($contents as  $content) {
						echo '<li><div class="title"><a href="', ActionLink('detail', 'cms', array('id' => $content['Id']), false), '">', $content['Title'], '</a></div><div class="createdate">', date_format(date_create($content['CreateDate']), "Y-m-d"), '</div></li>';
					}
					?>
				</ul>
			</div>
		</div>
		<?php
		$sthContentStatic = $pdo->prepare("select count(1) recordCount from `Content` where $whereClause;");
		$sthContentStatic->execute();
		$contentStatic = $sthContentStatic->fetch(PDO::FETCH_ASSOC);
		$page = new Pagination($contentStatic['recordCount'], $pageIndex, $pageSize);
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