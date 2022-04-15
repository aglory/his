<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumPermission;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::产品管理);

$id = 0;

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
}
if (empty($id))
PageHelper::JsonResultError('参数错误');

$columns = array('Id' => 0, 'MarketPrice' => 0, 'Price' => 0, 'SettlementPrice' => 0, 'Integral' => 0);

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();

  $sql = 'select ' . implode(',', array_keys($columns)) . ' from Product where Id = :Id and SiteId = :SiteId;';
  $sqlParams = array('Id' => $id, 'SiteId' => $authorize['SiteId']);
  $sth = $pdomysql->prepare($sql);
  $sth->execute($sqlParams);
  $model = $sth->fetch(PDO::FETCH_ASSOC);
  if ($model === false) {
    PageHelper::JsonResultError('参数错误');
  } else {
    PageHelper::JsonResultSuccess($model);
  }
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
