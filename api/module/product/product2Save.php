<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\EnumProductType;
use Aglory\EnumValidTimeUnitType;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::产品管理);
$authorization->CheckType(EnumAccountType::管理员, EnumAccountType::操作员);

$id = 0;
$type = 0;
$productIds = '';
$validCopies = 0;
$validTime = 0;
$validTimeUnitType = 0;
$validTimeActiveImmediate = true;
$priceDiscount = 0;
$priceReduce = 0;

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

  if (isset($json_data->Type))
    $type = $json_data->Type;

  if (isset($json_data->ProductIds))
    $productIds = $json_data->ProductIds;

  if (isset($json_data->ValidCopies))
    $validCopies = $json_data->ValidCopies;

  if (isset($json_data->ValidTime))
    $validTime = $json_data->ValidTime;

  if (isset($json_data->ValidTimeUnitType))
    $validTimeUnitType = $json_data->ValidTimeUnitType;

  if (isset($json_data->ValidTimeActiveImmediate))
    $validTimeActiveImmediate = $json_data->ValidTimeActiveImmediate;

  if (isset($json_data->PriceDiscount))
    $priceDiscount = $json_data->PriceDiscount;

  if (isset($json_data->PriceReduce))
    $priceReduce = $json_data->PriceReduce;
}

// 验证
switch ($type) {
  case EnumProductType::次卡产品:
    if (empty($validCopies)) {
      PageHelper::JsonResultError('使用次数必须大于0');
    }
    $validTime = 0;
    $validTimeUnitType = 0;
    $validTimeActiveImmediate = true;

    break;
  case EnumProductType::时段产品:
    if (!in_array($validTimeUnitType, EnumValidTimeUnitType::ToArray())) {
      PageHelper::JsonResultError('请选择正确的时段类型');
    }
    $validCopies = 0;
    break;
  default:
    PageHelper::JsonResultError('请选择正确的产品类型');
    break;
}

if (empty($priceDiscount) || empty($priceReduce)) {
  PageHelper::JsonResultError('抵扣金额或者打折数不能同时为0');
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

$sth = $pdomysql->prepare('select * from Product where Id = :Id and SiteId = :SiteId;');
$sth->execute(array(':Id' => $id, ':SiteId' => $authorization->SiteId));
$product = $sth->fetch(PDO::FETCH_ASSOC);
if ($product === false) {
  PageHelper::JsonResultError('参数错误');
}

if (empty($id)) {
  // 添加  
} else {
  // 修改
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare("insert Product2(ProductId, ProductIds, ValidCopies, ValidTime, ValidTimeUnitType, ValidTimeActiveImmediate, PriceDiscount, PriceReduce)values(:ProductId, :ProductIds, :ValidCopies, :ValidTime, :ValidTimeUnitType, :ValidTimeActiveImmediate, :PriceDiscount, :PriceReduce);");
  } else {
    $sth = $pdomysql->prepare('update Product2 set ProductIds = :ProductIds, ValidCopies = :ValidCopies, ValidTime = :ValidTime, ValidTimeUnitType = :ValidTimeUnitType, ValidTimeActiveImmediate = :ValidTimeActiveImmediate, PriceDiscount = :PriceDiscount, PriceReduce = :PriceReduce where ProductId = :ProductId;');
  }
  $sth->bindValue(':ProductId', $id, PDO::PARAM_INT);
  $sth->bindValue(':ValidCopies', $validCopies, PDO::PARAM_STR);
  $sth->bindValue(':ValidTime', $validTime, PDO::PARAM_INT);
  $sth->bindValue(':ValidTimeUnitType', $validTimeUnitType, PDO::PARAM_INT);
  $sth->bindValue(':ValidTimeActiveImmediate', $validTimeActiveImmediate, PDO::PARAM_BOOL);
  $sth->bindValue(':PriceDiscount', $priceDiscount, PDO::PARAM_INT);
  $sth->bindValue(':PriceReduce', $$priceReduce, PDO::PARAM_INT);
  $sth->execute();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
