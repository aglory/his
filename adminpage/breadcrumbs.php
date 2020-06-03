<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}
?>
<ul class="breadcrumb">
    <li>
        <i class="icon-home home-icon"></i>
        <a href="<?php ActionLink('index', 'home') ?>">首页</a>
    </li>
    <?php
    if (Model == 'content') {
        $type = GetGetParam('Type', 0);
        echo '<li>', EnumContentTyp[$type], '</li>';
    }
    ?>
</ul>