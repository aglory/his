<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}
?>
<ul class="nav nav-list">
    <li class="active">
        <a href="<?php ActionLink('index', 'home') ?>">
            <span class="menu-text"> 首页 </span>
        </a>
    </li>

    <li>
        <a href="<?php ActionLink('manager', 'content', array('Type' => 1)) ?>">
            <span class="menu-text"> 新闻 </span>
        </a>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <span class="menu-text"> UI 组件 </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="elements.html">
                    <i class="icon-double-angle-right"></i> 组件
                </a>
            </li>

            <li>
                <a href="buttons.html">
                    <i class="icon-double-angle-right"></i> 按钮 &amp; 图表
                </a>
            </li>

            <li>
                <a href="treeview.html">
                    <i class="icon-double-angle-right"></i> 树菜单
                </a>
            </li>

            <li>
                <a href="jquery-ui.html">
                    <i class="icon-double-angle-right"></i> jQuery UI
                </a>
            </li>

            <li>
                <a href="nestable-list.html">
                    <i class="icon-double-angle-right"></i> 可拖拽列表
                </a>
            </li>

            <li>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-double-angle-right"></i> 三级菜单
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li>
                        <a href="#">
                            <i class="icon-leaf"></i> 第一级
                        </a>
                    </li>

                    <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-pencil"></i> 第四级
                            <b class="arrow icon-angle-down"></b>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a href="#">
                                    <i class="icon-plus"></i> 添加产品
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="icon-eye-open"></i> 查看商品
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <span class="menu-text"> 表格 </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="tables.html">
                    <i class="icon-double-angle-right"></i> 简单 &amp; 动态
                </a>
            </li>

            <li>
                <a href="jqgrid.html">
                    <i class="icon-double-angle-right"></i> jqGrid plugin
                </a>
            </li>
        </ul>
    </li>
</ul>