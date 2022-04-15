<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::产品管理);
$authorization->CheckType(EnumAccountType::管理员, EnumAccountType::操作员);

$id = 0;
$isLocked = false;

$content = file_get_contents('php://input');
if (empty($content)) {
  PageHelper::JsonResultError('参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    PageHelper::JsonResultError('参数错误');
  }
  if (isset($json_data->Id))
    $id = intval($json_data->Id);

  if (isset($json_data->IsLocked))
    $isLocked = $json_data->IsLocked;
}

if (empty($id) || !in_array($isLocked, array(false, true), true)) {
  PageHelper::JsonResultError('参数错误');
}

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();

  $sql = 'update Product set IsLocked = :IsLocked where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindParam(':IsLocked',  $isLocked, PDO::PARAM_BOOL);
  $sth->execute();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
