<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}

$ret = json_encode(array('Success' => true));
die($ret);
