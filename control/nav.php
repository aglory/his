<?php
if (!defined('Execute')) {
	exit();
}
?>
<nav>
	<ul class="warpper nav">
		<li class="<?php echo (Model == 'index' && Action == 'index') ? "active" : "" ?>">
			<a href="<?php ActionLink('index', 'index') ?>">首页</a>
		</li>
		<li class="<?php echo (Model == 'cms' && Action == 'list') ? "active" : "" ?>">
			<a href="<?php ActionLink('list', 'cms', array('type' => 1)) ?>">二级页面</a>
		</li>
		<li class="<?php echo (Model == 'cms' && Action == 'detail') ? "active" : "" ?>">
			<a href="<?php ActionLink('detail', 'cms') ?>">三级页面</a>
		</li>
	</ul>
</nav>