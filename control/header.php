<?php
if (!defined('Execute')) {
	exit();
}
header("Content-Type: text/html;charset=utf-8");
?>
<header class="header">
	<div class="warpper">
		<ul class="toolbar">
			<li class="weixinicon">
				微信公众号
			</li>
			<li class="mailbox">
				公务邮箱
			</li>
			<li class="datenow">
				<?php echo date('Y年m月d日') ?>
				<?php $w = array('星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
				echo $w[date('w')] ?>
			</li>
		</ul>
	</div>
</header>