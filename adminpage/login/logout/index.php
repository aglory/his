<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}
$link = ActionLink('login', 'login', null, false);
session_destroy();
header("Location: $link", TRUE, 301);
