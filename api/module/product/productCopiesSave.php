<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['产品管理']);
$enumAccountType = GetEnumAccountType();
CheckWidthOutAuthorizeType($enumAccountType['配置员']);
$authorize = GetAuthorize();
$enumProductType = GetEnumProductType();

$id = 0;
$baseCopies = 0;
$sortCopies = 0;
$noSort = 0;

$content = file_get_contents('php://input');
if (empty($content)) {
  JsonResultError('参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    JsonResultError('参数错误');
  }

  if (isset($json_data->Id))
    $id = $json_data->Id;

  if (empty($id)) {
    JsonResultError('参数错误');
  }

  if (isset($json_data->BaseCopies))
    $baseCopies = intval($json_data->BaseCopies);

  if (isset($json_data->SortCopies))
    $sortCopies = intval($json_data->SortCopies);

  if (isset($json_data->NoSort))
    $noSort = intval($json_data->NoSort);
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

try {
  $sql = 'update Product set BaseCopies = :BaseCopies, SortCopies = :SortCopies, NoSort = :NoSort where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindParam(':BaseCopies', $baseCopies, PDO::PARAM_INT);
  $sth->bindParam(':SortCopies', $sortCopies, PDO::PARAM_INT);
  $sth->bindParam(':NoSort', $noSort, PDO::PARAM_BOOL);
  $sth->execute();
  JsonResultSuccess($id);
} catch (PDOException $e) {
  JsonResultException($e);
}
