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
$marketPrice = 0;
$price = '';
$settlementPrice = '';
$integral = 0;

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

  if (isset($json_data->MarketPrice))
    $marketPrice = floatval($json_data->MarketPrice);

  if (isset($json_data->Price))
    $price = floatval($json_data->Price);

  if (isset($json_data->SettlementPrice))
    $settlementPrice = floatval($json_data->SettlementPrice);

  if (isset($json_data->Integral))
    $integral = floatval($json_data->Integral);
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

try {
  $sql = 'update Product set MarketPrice = :MarketPrice, Price = :Price, SettlementPrice = :SettlementPrice, Integral = :Integral where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':MarketPrice', $marketPrice, PDO::PARAM_INT);
  $sth->bindParam(':Price', $price, PDO::PARAM_INT);
  $sth->bindParam(':SettlementPrice', $settlementPrice, PDO::PARAM_INT);
  $sth->bindParam(':Integral', $integral, PDO::PARAM_INT);
  $sth->execute();
  PageHelper::JsonResultSuccess($id);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
