<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['会员管理']);
$enumAccountType = GetEnumAccountType();
CheckWidthOutAuthorizeType($enumAccountType['配置员']);
$authorize = GetAuthorize();
$enumPayStatus = GetEnumPayStatus();

$id = 0;                                            // 订单编号
$memberId = '';
$amount = 0;                                        // 总金额
$remark = '';                                       // 备注
$products = [];                                     // 产品信息 [{Id : number, Copies : number}]

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

  if (isset($json_data->MemberId))
    $memberId = $json_data->MemberId;

  if (isset($json_data->Remark))
    $remark = $json_data->Remark;

  if (isset($json_data->Products))
    $products = $json_data->Products;
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

// 验证
$order = false;
if (!empty($id)) {
  $sth = $pdomysql->prepare('select * from `Order` where Id = :Id and SiteId = :SiteId;');
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->execute();
  $order = $sth->fetch(PDO::FETCH_ASSOC);
  if ($order === false)
    JsonResultError('订单错误');
  if ($order['PayStatus'] != $enumPayStatus['未支付']) {
    JsonResultError(RenderEnum($enumPayStatus, $order['PayStatus']) . '不能结算');
  }
}

$member = false;
if (!empty($memberId)) {
  try {
    $sth = $pdomysql->prepare('select * from Member where Id = :Id and SiteId = :SiteId;');
    $sth->bindValue(':Id', $memberId, PDO::PARAM_INT);
    $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    $sth->execute();
    $member = $sth->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    JsonResultException($e);
  }
}
if ($member === false)
  JsonResultError('未选择会员');

if (empty($products))
  JsonResultError('未选择产品');
try {
  $productIds = array_map(function ($item) {
    return isset($item->Id) ? intval($item->Id) : 0;
  }, $products);
  $sth = $pdomysql->prepare('select Id, ShortName, Type, MarketPrice, Price, SettlementPrice, Integral, SortCopies, NoSort from Product where Id in(' . implode(',', $productIds) . ') and SiteId = :SiteId;');
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->execute();
  $dbProducts = $sth->fetchAll(PDO::FETCH_ASSOC);
  $validateProducts = [];
  /**
   * 购物产生的积分
   */
  $integralTotal = 0;
  foreach ($dbProducts as $dbProduct) {
    foreach ($products as $product) {
      if ($dbProduct['Id'] === $product->Id) {
        if (empty($product->Copies))
          continue;                                                                                     // 过滤掉空数据

        if (!$dbProduct['NoSort'] && $dbProduct['SortCopies'] >= 0 && $dbProduct['SortCopies'] < $product->Copies)
          JsonResultError($dbProduct['ShortName'] . '库存不足' . $product->Copies);

        $integral = $dbProduct['Integral'] * $product->Copies;
        $validateProducts[] = array(
          'Id' => $product->Id,
          'Copies' => $product->Copies,
          'ShortName' => $dbProduct['ShortName'],
          'Type' => $dbProduct['Type'],
          'MarketPrice' => $dbProduct['MarketPrice'],
          'Price' => $dbProduct['Price'],
          'SettlementPrice' => $dbProduct['SettlementPrice'],
          'Integral' => $integral,
          'ChangeSortCopies' => $dbProduct['SortCopies'] > 0
        );
        $integralTotal +=  $integral;                                                                   // 累计购物成功后获取的积分
        $amount += $dbProduct['Price'] * $product->Copies;                                              // 累计购物金额
      }
    }
  }
  if (empty($validateProducts))
    JsonResultError('未选择有效的产品');

  // 产生流水序号 (目前是一天9999单)
  $sql = 'select count(1) total from `Order` where SiteId = :SiteId and CreateTime = now();';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->execute();
  $orderStatistics = $sth->fetch(PDO::FETCH_ASSOC);
  // 1:订单主表
  if (empty($id)) {
    include_once './lib/stringHelper.php';
    $no = GenerateNumber($orderStatistics['total'] + 1, 4, '0', STR_PAD_LEFT);
    $sql = 'insert into `Order`(No, SiteId, OperatorId, OperatorLoginName, MemberId, Amount, PreferenceAmount, BalanceAmount, IntegralAmount, OnlineAmount, CashAmount, ProduceIntegral, Balance, Remark, PayStatus, CreateTime)values(:No, :SiteId, :OperatorId, :OperatorLoginName, :MemberId, :Amount, 0, 0, 0, 0, 0, :ProduceIntegral, 0, :Remark, :PayStatus, now());';
    $sthOrder = $pdomysql->prepare($sql);
    $sthOrder->bindValue(':No', $no, PDO::PARAM_STR);
    $sthOrder->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    $sthOrder->bindValue(':OperatorId', $authorize['Id'], PDO::PARAM_INT);
    $sthOrder->bindValue(':OperatorLoginName', $authorize['LoginName'], PDO::PARAM_STR);
    $sthOrder->bindValue(':MemberId', $memberId, PDO::PARAM_INT);
    $sthOrder->bindValue(':Amount', $amount, PDO::PARAM_INT);
    $sthOrder->bindValue(':ProduceIntegral', $integralTotal, PDO::PARAM_INT);
    $sthOrder->bindValue(':Remark', $remark, PDO::PARAM_STR);
    $sthOrder->bindParam(':PayStatus', $enumPayStatus['未支付'], PDO::PARAM_INT);
  } else {
    $sql = 'update `Order` set OperatorId = :OperatorId, OperatorLoginName = :OperatorLoginName, MemberId = :MemberId, Amount = :Amount, ProduceIntegral = :ProduceIntegral, Remark = :Remark where Id = :Id and SiteId = :SiteId;';
    $sthOrder = $pdomysql->prepare($sql);
    $sthOrder->bindValue(':Id', $id, PDO::PARAM_INT);
    $sthOrder->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    $sthOrder->bindValue(':OperatorId', $authorize['Id'], PDO::PARAM_INT);
    $sthOrder->bindValue(':OperatorLoginName', $authorize['LoginName'], PDO::PARAM_STR);
    $sthOrder->bindValue(':MemberId', $memberId, PDO::PARAM_INT);
    $sthOrder->bindValue(':Amount', $amount, PDO::PARAM_INT);
    $sthOrder->bindValue(':ProduceIntegral', $integralTotal, PDO::PARAM_INT);
    $sthOrder->bindValue(':Remark', $remark, PDO::PARAM_STR);
  }

  // 2:添加订单项
  $sql = 'insert into OrderItem(SiteId, OrderId, ProductId, ProductShortName, ProductMarketPrice, ProductPrice, ProductSettlementPrice, Copies, CreateTime)values(:SiteId, :OrderId, :ProductId, :ProductShortName, :ProductMarketPrice, :ProductPrice, :ProductSettlementPrice, :Copies, now());';
  $sthOrderItemInsert = $pdomysql->prepare($sql);
  $sthOrderItemInsert->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);

  $sthOrderItemDelete =  $pdomysql->prepare('delete from OrderItem where SiteId = :SiteId and OrderId = :OrderId;');
  $sthOrderItemDelete->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);

  $pdomysql->beginTransaction();
  $sthOrder->execute();
  if (empty($id)) {
    $id = $pdomysql->lastInsertId();
  } else {
    // 修改时先删除订单项，然后再添加
    $sthOrderItemDelete->bindValue(':OrderId', $id, PDO::PARAM_INT);
    $sthOrderItemDelete->execute();
  }
  foreach ($validateProducts as $validateProduct) {
    $sthOrderItemInsert->bindValue(':OrderId', $id, PDO::PARAM_INT);
    $sthOrderItemInsert->bindValue(':ProductId', $validateProduct['Id'], PDO::PARAM_INT);
    $sthOrderItemInsert->bindValue(':ProductShortName', $validateProduct['ShortName'], PDO::PARAM_STR);
    $sthOrderItemInsert->bindValue(':ProductMarketPrice', $validateProduct['MarketPrice'], PDO::PARAM_INT);
    $sthOrderItemInsert->bindValue(':ProductPrice', $validateProduct['Price'], PDO::PARAM_INT);
    $sthOrderItemInsert->bindValue(':ProductSettlementPrice', $validateProduct['SettlementPrice'], PDO::PARAM_INT);
    $sthOrderItemInsert->bindValue(':Copies', $validateProduct['Copies'], PDO::PARAM_INT);
    $sthOrderItemInsert->execute();
  }
  $pdomysql->commit();
  JsonResultSuccess($id);
} catch (PDOException $e) {
  JsonResultException($e);
}
