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
$unit = '';
$baseCopies = 0;
$sortCopies = 0;
$noSort = 0;

$content = file_get_contents('php://input');
if (empty($content)) {
  PageHelper::JsonResultError('参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    PageHelper::JsonResultError('参数错误');
  }

  if (isset($json_data->Id))
    $id = $json_data->Id;

  if (empty($id)) {
    PageHelper::JsonResultError('参数错误');
  }
  
  if (isset($json_data->Unit))
    $unit  = intval($json_data->Unit);

  if (isset($json_data->BaseCopies))
    $baseCopies = intval($json_data->BaseCopies);

  if (isset($json_data->SortCopies))
    $sortCopies = intval($json_data->SortCopies);

  if (isset($json_data->NoSort))
    $noSort = intval($json_data->NoSort);
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

try {
  $sql = 'update Product set Unit = :Unit, BaseCopies = :BaseCopies, SortCopies = :SortCopies, NoSort = :NoSort where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':Unit', $unit, PDO::PARAM_STR);
  $sth->bindParam(':BaseCopies', $baseCopies, PDO::PARAM_INT);
  $sth->bindParam(':SortCopies', $sortCopies, PDO::PARAM_INT);
  $sth->bindParam(':NoSort', $noSort, PDO::PARAM_BOOL);
  $sth->execute();
  PageHelper::JsonResultSuccess($id);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
