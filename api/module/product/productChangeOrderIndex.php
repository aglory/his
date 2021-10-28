<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['帐号管理']);
$enumAccountType = GetEnumAccountType();
CheckWidthOutAuthorizeType($enumAccountType['配置员']);
$authorize = GetAuthorize();

$id = 0;
$orderIndex = 0;

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
    
  if (isset($json_data->OrderIndex))
    $orderIndex = $json_data->OrderIndex;
}

if (empty($id)) {
  JsonResultError('参数错误');
}

include_once './lib/pdo.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();

  $sql = "update Product set OrderIndex = :OrderIndex where Id = :Id and SiteId = :SiteId;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':OrderIndex', $orderIndex, PDO::PARAM_INT);
  $sth->execute();
  JsonResultSuccess();
} catch (PDOException $e) {
  JsonResultException($e);
}

