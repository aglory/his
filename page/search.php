<?php
if (!defined('Execute')) {
	exit();
}
header("Content-Type: text/html;charset=utf-8");
$keyWord = '';
if (array_key_exists('keyWord', $_GET)) {
	$keyWord = $_GET['keyWord'];
}
?>
<div class="warpper search">
	<div class="inputgroup">
		<input type="text" id="txtKeyWord" value="<?php echo htmlspecialchars($keyWord) ?>" placeholder="请输入关键字" />
		<button type="button" onclick="btnsearchclick(this);">收 索</button>
	</div>
</div>