<?php
if (!defined('Execute')) {
	exit();
}
header("Content-Type: text/html;charset=utf-8");
include './config.php';
LoadClass('Pagination');

$id = 0;
if (array_key_exists('id', $_GET))
	$id = intval($_GET['id']);

$sth =  $pdo->prepare('select * from `Content` where id = :id');
$sth->execute(array('id' => $id));
$model = $sth->fetch(PDO::FETCH_ASSOC);
if (!$model)
	exit();
?>
<!DOCTYPE HTML>
<html>

<head>
	<link type="text/css" rel="stylesheet" href="/assets/css/base.css" />
	<script src="/assets/js/base.js"></script>
	<link rel="shortcut icon" href="assets/image/favicon.ico" type="image/x-icon" />
	<link rel="Bookmark" href="assets/image/favicon.ico" />
	<link type="text/css" rel="stylesheet" href="/page/cms/detail/index.css" />
	<script src="/page/cms/detail/index.js"></script>
</head>

<body>
	<?php Render('header') ?>
	<?php Render('search') ?>
	<?php Render('nav') ?>

	<div class="warpper crumb">
		<ul>
			<li><?php echo '<a href="', ActionLink('index', 'index', null, false), '">首页</a>' ?></li>
			<li><span>&gt;</span></li>
			<li><?php echo '<a href="',  ActionLink('list', 'cms',  array("type" => $model['Type'])), '">', EnumContentTyp[$model['Type']], '</a>' ?></li>
			<li><span>&gt;</span></li>
			<li><span><?php echo $model['Title']?></span></li>
		</ul>
	</div>

	<div class="warpper content boxshadow">
		<div class="contenttitle">
			<h3><?php echo EnumContentTyp[$model['Type']] ?></h3>
		</div>
		<div class="contentbody block">
			<div class="item">
				<h4><?php echo $model['Title'] ?></h4>
				<div class="createdate">
					发布时间：<?php echo  date_format(date_create($model['CreateDate']), "Y-m-d") ?>
				</div>
			</div>
		</div>

		<div class="contentbody block">
			<div class="item">
				<div class="detail">
					<?php echo str_replace("\n", '<br />', $model['Content']) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="warpper shade"></div>
	<?php Render('footlink') ?>
	<?php Render('footer') ?>
</body>

</html>