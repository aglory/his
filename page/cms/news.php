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
	<link type="text/css" rel="stylesheet" href="assets/css/base.css" />
	<link type="text/css" rel="stylesheet" href="assets/js/base.js" />
</head>

<body>
	<?php Render('header') ?>
	<div class="blockborder wrap body">
		<ul class="SchoolList">
		</ul>
	</div>
	<?php Render('footer') ?>
</body>

</html>