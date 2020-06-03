<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}
?>
<ul class="nav nav-list">
    <li class="<?php echo Model == 'home' ? 'active' : '' ?>">
        <a href="<?php ActionLink('index', 'home') ?>">
            <span class="menu-text"> 首页 </span>
        </a>
    </li>
    <li class="<?php echo Model == 'content' ? 'active' : '' ?>">
        <a href="javascript:void(0)" class="dropdown-toggle">
            <span class="menu-text">内容</span>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
            <?php
            foreach (EnumContentTyp as $key => $val) {
                echo '<li><a href="', ActionLink('manager', 'content', array('Type' => $key), true), '"><span class="menu-text">', $val, '</span></a></li>';
            }
            ?>
        </ul>
    </li>
</ul>