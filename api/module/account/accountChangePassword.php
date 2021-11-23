<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['帐号管理']);
$authorize = GetAuthorize();
$enumAccountType = GetEnumAccountType();

$id = 0;
$password = '';

$content = file_get_contents('php://input');
if (empty($content)) {
  JsonResultError('参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    JsonResultError('参数错误');
  }
  if (isset($json_data->Id))
    $id = intval($json_data->Id);
  if (isset($json_data->Password))
    $password = $json_data->Password;
}

if (empty($id)) {
  JsonResultError('参数错误');
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

  $sql = "update Account set Password = :Password, Salt = :Salt where Id = $id";
  if ($authorize['Type'] == $enumAccountType['配置员']) {
    $sql .= ' and Type = ' . $enumAccountType['管理员'];
  } else {
    $sql .= ' and SiteId = ' . $authorize['SiteId'];
    $sql .= ' and Type in(' . $enumAccountType['员工'] . ')';
  }
  $sql .= ';';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Password', md5($password . $salt), PDO::PARAM_STR);
  $sth->bindValue(':Salt', $salt, PDO::PARAM_STR);
  $sth->execute();
  JsonResultSuccess();
} catch (PDOException $e) {
  JsonResultException($e);
}
