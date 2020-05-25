<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}

header('Content-type: application/json');

include './config.php';

$id = intval(GetPostParam('Id', 0));
$status = intval(GetPostParam('Status', 0));
if ($id > 0 && in_array($status, array(1, 2,))) {
	$sth = $pdo->prepare('update `content` set Status = :Status where Id = :Id;');
	$sth->execute(array('Id' => $id, 'Status' => $status));

	$error = $sth->errorInfo();
	if (empty($error[2])) {
		die(json_encode(array('Success' => true)));
	} else {
		die(json_encode(array('Success' => false, 'Error' => $error[2])));
	}
} else {
	die(json_encode(array('Success' => false, 'Message' => '参数错误')));
}