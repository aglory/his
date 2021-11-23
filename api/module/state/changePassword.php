<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$authorize = GetAuthorize();

$password = '';

$content = file_get_contents('php://input');
if (empty($content)) {
  JsonResultError('参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    JsonResultError('参数错误');
  }
  if (isset($json_data->Password))
    $password = $json_data->Password;
}

if (empty($password)) {
  JsonResultError('密码不能为空');
}

include_once './lib/pdo.php';
include_once './lib/stringHelper.php';
$salt = GenerateRandomString(6);

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();

  $sql = "update Account set Password = :Password, Salt = :Salt where Id = :Id;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $authorize['Id'], PDO::PARAM_INT);
  $sth->bindValue(':Password', md5($password . $salt), PDO::PARAM_STR);
  $sth->bindValue(':Salt', $salt, PDO::PARAM_STR);
  $sth->execute();
  JsonResultSuccess();
} catch (PDOException $e) {
  JsonResultException($e);
}
