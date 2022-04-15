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
$orderIndex = 0;

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

  if (isset($json_data->OrderIndex))
    $orderIndex = $json_data->OrderIndex;
}

if (empty($id)) {
  PageHelper::JsonResultError('参数错误');
}

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();

  $sql = "update Product set OrderIndex = :OrderIndex where Id = :Id and SiteId = :SiteId;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindValue(':OrderIndex', $orderIndex, PDO::PARAM_INT);
  $sth->execute();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
