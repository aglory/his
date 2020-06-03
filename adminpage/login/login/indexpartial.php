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
$sthUser = $pdo->prepare('SELECT * FROM `User` where Name = :Name;');
$sthUser->execute(array('Name' => $name));
$user = $sthUser->fetch(PDO::FETCH_ASSOC);
if (!empty($user)) {
	if ($user['Password'] == md5($password) && $user['Status'] == 1) {
		$ret = json_encode(array('Success' => true));
		$_SESSION['UserName'] = $user['Name'];

		$sthRole = $pdo->prepare('select Permissions from `Role` where Id in (select RoleId from RoleUser where UserId = :UserId);');
		$sthRole->execute(array('UserId' => $user['Id']));
		$Permissions = array();
		$roles = $sthRole->fetchAll(PDO::FETCH_ASSOC);
		foreach ($roles as $role) {
			$ps = explode(',', $role['Permissions']);
			foreach ($ps as $p) {
				if (!in_array($p, $Permissions)) {
					$Permissions[] = $p;
				}
			}
		}
		$_SESSION['UserNamePermissions'] = implode(',', $Permissions);

		die($ret);
	}
}

$ret = json_encode(array('Success' => false, 'Message' => '登录名或者密码错误'));
die($ret);
