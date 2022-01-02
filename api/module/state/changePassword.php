<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\PageHelper;
use Aglory\StringHelper;

$authorization = new Authorization();
$authorization->CheckCode();

$password = '';

$content = file_get_contents('php://input');
if (empty($content)) {
  PageHelper::JsonResultError('参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    PageHelper::JsonResultError('参数错误');
  }
  if (isset($json_data->Password))
    $password = $json_data->Password;
}

if (empty($password)) {
  PageHelper::JsonResultError('密码不能为空');
}

$salt = StringHelper::GenerateRandomString(6);

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();

  $sql = "update Account set Password = :Password, Salt = :Salt where Id = :Id;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $authorization->Id, PDO::PARAM_INT);
  $sth->bindValue(':Password', md5($password . $salt), PDO::PARAM_STR);
  $sth->bindValue(':Salt', $salt, PDO::PARAM_STR);
  $sth->execute();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
