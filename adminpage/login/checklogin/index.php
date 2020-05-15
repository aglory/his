<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}

header('Content-type: application/json');


$verifyCode = '';
if (array_key_exists('verifyCode', $_POST)) {
	$verifyCode = $_POST['verifyCode'];
}
if (!$verifyCode || $verifyCode != $_SESSION['VerifyCode']) {
	$ret = json_encode(array('Success' => false, 'Message' => '请输入正确的验证'));
	die($ret);
}

$name = GetPostParam('name', '');
$password = GetPostParam('password', '');

include './config.php';
$sth = $pdo->prepare('SELECT * FROM `user` where name = :Name;');
$sth->execute(array('Name' => $name));
$users = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $user) {
	if ($user['Password'] == md5($password) && $user['Status'] == 1) {
		$ret = json_encode(array('Success' => true));
		$_SESSION['UserName'] = $user['Name'];

		die($ret);
	}
}
$ret = json_encode(array('Success' => false, 'Message' => '登录名或者密码错误'));
die($ret);
