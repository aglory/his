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
$marketPrice = 0;
$price = '';
$settlementPrice = '';

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

  if (isset($json_data->MarketPrice))
    $marketPrice = floatval($json_data->MarketPrice);

  if (isset($json_data->Price))
    $price = floatval($json_data->Price);

  if (isset($json_data->SettlementPrice))
    $settlementPrice = floatval($json_data->SettlementPrice);
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

try {
  $sql = 'update Product set MarketPrice = :MarketPrice, Price = :Price, SettlementPrice = :SettlementPrice where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':MarketPrice', $marketPrice, PDO::PARAM_INT);
  $sth->bindParam(':Price', $price, PDO::PARAM_INT);
  $sth->bindParam(':SettlementPrice', $settlementPrice, PDO::PARAM_INT);
  $sth->execute();
  JsonResultSuccess($id);
} catch (PDOException $e) {
  JsonResultException($e);
}
