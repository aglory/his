<?php
if (!defined('Execute')) {
	exit();
}
$type = 0;
if (array_key_exists('type', $_GET)) {
	$type = intval($_GET['type']);
}
?>
<nav>
	<ul class="warpper nav">
		<li class="<?php echo (Model == 'index' && Action == 'index') ? "active" : "" ?>">
			<a href="<?php ActionLink('index', 'index') ?>">首页</a>
		</li>
		<?php
		foreach (EnumContentTyp as $key => $val) {
			echo '<li class="', ($type == $key ? 'active' : ''), '"><a href="', ActionLink('list', 'cms', array('type' => $key), false), '">', $val, '</a>';
		}
		?>
		<!-- <li class="<?php echo (Model == 'cms' && Action == 'detail') ? "active" : "" ?>">
			<a href="<?php ActionLink('detail', 'cms') ?>">三级页面</a>
		</li> -->
	</ul>
</nav>