<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['公告管理']);
$authorize = GetAuthorize();
$enumAccountType = GetEnumAccountType();

$id = 0;
$isLocked = false;

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

  if (isset($json_data->IsLocked))
    $isLocked = $json_data->IsLocked;
}

if (empty($id) || !in_array($isLocked, array(false, true), true)) {
  JsonResultError('参数错误');
}

include_once './lib/pdo.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();

  $sql = 'update Message set IsLocked = :IsLocked where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->bindParam(':IsLocked',  $isLocked, PDO::PARAM_BOOL);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->execute();
  JsonResultSuccess();
} catch (PDOException $e) {
  JsonResultException($e);
}
