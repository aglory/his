<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['产品管理']);
$authorize = GetAuthorize();
$enumAccountType = GetEnumAccountType();

$id = 0;

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
}

if (empty($id))
  JsonResultError('参数错误');

$columns = array('Id' => 0, 'SaleCopies' => 0, 'BaseCopies' => 0, 'SortCopies' => 0);

include_once './lib/pdo.php';
include_once './lib/stringHelper.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  $sql = 'select ' . implode(',', array_keys($columns)) . ' from Product where Id = :Id and SiteId = :SiteId;';
  $sqlParams = array('Id' => $id, 'SiteId' => $authorize['SiteId']);
  $sth = $pdomysql->prepare($sql);
  $sth->execute($sqlParams);
  $model = $sth->fetch(PDO::FETCH_ASSOC);
  if ($model === false) {
    JsonResultError('参数错误');
  } else {
    JsonResultSuccess($model);
  }
} catch (PDOException $e) {
  JsonResultException($e);
}
