<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}
header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>叁伍伍叁健康科学研究院</title>
    <meta name="keywords" content="叁伍伍叁健康科学研究院" />
    <meta name="description" content="叁伍伍叁健康科学研究院" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/image/favicon.ico" type="image/x-icon" />

    <!-- basic styles -->

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!-- ace styles -->

    <link rel="stylesheet" href="assets/css/ace.min.css" />
    <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="/assets/js/jquery-2.0.3.min.js"></script>
    <script src="/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <?php if (isMobile()) { ?>
        <script src='assets/js/jquery.mobile.custom.min.js'>
        </script>
    <?php } ?>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/typeahead-bs2.min.js"></script>

    <script src="assets/js/ace-elements.min.js"></script>
    <script src="assets/js/ace.min.js"></script>

    <script src="assets/js/bootbox.min.js"></script>

    <script src="assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
        <![endif]-->

    <link rel="stylesheet" href="assets/sticky/sticky.css" />
    <script src="assets/sticky/sticky.js"></script>
    <link rel="stylesheet" href="assets/page/page.css" />
    <script src="assets/page/page.js"></script>

    <script src="assets/My97DatePicker/WdatePicker.js"></script>

    <link rel="stylesheet" href="assets/css/adminbase.css" />
    <script src="assets/js/adminbase.js"></script>