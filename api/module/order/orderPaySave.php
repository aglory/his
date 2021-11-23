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
$enumMemberBalanceTransactionType =  GetEnumMemberBalanceTransactionType();
$enumMemberIntegralTransactionType =  GetEnumMemberIntegralTransactionType();
$enumEnterpriseCashTransactionType = GetEnumEnterpriseCashTransactionType();

$id = 0;
$amount = 0;                                        // 总金额
$preferenceAmount = 0;                              // 优惠金额
$balanceAmount = 0;                                 // 余额支付
$integralAmount = 0;                                // 积分支付
$onlineAmount = 0;                                  // 在线支付
$cashAmount = 0;                                    // 现金支付

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

  if (isset($json_data->PreferenceAmount))
    $preferenceAmount = $json_data->PreferenceAmount;

  if (isset($json_data->BalanceAmount))
    $balanceAmount = $json_data->BalanceAmount;

  if (isset($json_data->IntegralAmount))
    $integralAmount = $json_data->IntegralAmount;

  if (isset($json_data->OnlineAmount))
    $onlineAmount = $json_data->OnlineAmount;

  if (isset($json_data->CashAmount))
    $cashAmount = $json_data->CashAmount;
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

// 验证
$order = false;
try {
  $sth = $pdomysql->prepare('select * from `Order` where Id = :Id and SiteId = :SiteId;');
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->execute();
  $order = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  JsonResultException($e);
}
if ($order === false) {
  JsonResultError('参数错误');
}
if ($order['PayStatus'] !== $enumPayStatus['未支付']) {
  JsonResultError('错误的结算状态' . RenderEnum($enumPayStatus, $order['PayStatus']));
}
$amount = $order['Amount'];
if ($amount != $preferenceAmount + $balanceAmount + $integralAmount / 100 + $onlineAmount + $cashAmount)
  JsonResultError('总金额' . $amount . '≠[优惠(' . $preferenceAmount . ')+余额(' . $balanceAmount . '积分(' .  ($integralAmount / 100) . ')在线支付(' . $onlineAmount . ')现金支付(' . $cashAmount . ')');

$member = false;
if (!empty($order['MemberId'])) {
  try {
    $sth = $pdomysql->prepare('select * from Member where Id = :Id and SiteId = :SiteId;');
    $sth->bindValue(':Id', $order['MemberId'], PDO::PARAM_INT);
    $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    $sth->execute();
    $member = $sth->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    JsonResultException($e);
  }
}
if ($member === false)
  JsonResultError('未选择会员');

// 验证会员余额
if ($member['Balance'] < $balanceAmount)
  JsonResultError('余额为' . $member['Balance'] . '不足' . $balanceAmount);

// 验证会员积分
if ($member['Integral'] < $integralAmount)
  JsonResultError('积分为' . $member['Integral'] . '不足' . $integralAmount);

try {
  // 1:跟新订单主表
  $sql = 'update `Order` set PreferenceAmount = :PreferenceAmount, BalanceAmount = :BalanceAmount, IntegralAmount = :IntegralAmount, OnlineAmount = :OnlineAmount, CashAmount = :CashAmount, Balance = :Balance, PayStatus = :PayStatus where Id = :Id and SiteId = :SiteId;';
  $sthOrder = $pdomysql->prepare($sql);
  $sthOrder->bindValue(':Id', $id, PDO::PARAM_STR);
  $sthOrder->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sthOrder->bindValue(':PreferenceAmount', $preferenceAmount, PDO::PARAM_INT);
  $sthOrder->bindValue(':BalanceAmount', $balanceAmount, PDO::PARAM_INT);
  $sthOrder->bindValue(':IntegralAmount', $integralAmount, PDO::PARAM_INT);
  $sthOrder->bindValue(':OnlineAmount', $onlineAmount, PDO::PARAM_INT);
  $sthOrder->bindValue(':CashAmount', $cashAmount, PDO::PARAM_INT);
  $sthOrder->bindValue(':Balance', $member['Balance'], PDO::PARAM_INT);
  if ($onlineAmount > 0) {
    $sthOrder->bindParam(':PayStatus', $enumPayStatus['付款中'], PDO::PARAM_INT);
  } else {
    $sthOrder->bindParam(':PayStatus', $enumPayStatus['已支付'], PDO::PARAM_INT);
  }

  // 2:修改产品销量,库存(有库存的修改,无库存的不修改)
  $sql = 'update OrderItem oi, Product p set p.SaleCopies = p.SaleCopies + oi.Copies, p.SortCopies = case p.NoSort when 1 then  p.SortCopies else p.SortCopies - oi.Copies end where oi.ProductId = p.Id and oi.OrderId = :OrderId;';
  $sthProduct = $pdomysql->prepare($sql);
  $sthProduct->bindValue(':OrderId', $id, PDO::PARAM_INT);
  // 3:修改会员余额，积分
  $sql = 'update Member set Balance = Balance - :Balance, Integral = Integral - :Integral where Id = :Id;';
  $sthMember = $pdomysql->prepare($sql);
  $sthMember->bindValue(':Id', $order['MemberId'], PDO::PARAM_INT);
  // 4:添加余额流水
  $sql = 'insert into MemberBalanceHistory(SiteId, Type, TypeSign, MemberId, OperatorId, OperatorLoginName, Amount, Balance, Remark, CreateTime) values(:SiteId, :Type, :TypeSign, :MemberId, :OperatorId, :OperatorLoginName, :Amount, :Balance, :Remark, now());';
  $sthMemberBalanceHistory = $pdomysql->prepare($sql);
  $sthMemberBalanceHistory->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sthMemberBalanceHistory->bindValue(':MemberId', $order['MemberId'], PDO::PARAM_INT);
  $sthMemberBalanceHistory->bindValue(':OperatorId', $authorize['Id'], PDO::PARAM_INT);
  $sthMemberBalanceHistory->bindValue(':OperatorLoginName', $authorize['LoginName'], PDO::PARAM_INT);
  $sthMemberBalanceHistory->bindValue(':Remark', '', PDO::PARAM_STR);
  // 5:添加积分流水
  $sql = 'insert into MemberIntegralHistory(SiteId, Type, TypeSign, MemberId, OperatorId, OperatorLoginName, Amount, Balance, Remark, CreateTime) values(:SiteId, :Type, :TypeSign, :MemberId, :OperatorId, :OperatorLoginName, :Amount, :Integral, :Remark, now());';
  $sthMemberIntegralHistory = $pdomysql->prepare($sql);
  $sthMemberIntegralHistory->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sthMemberIntegralHistory->bindValue(':MemberId', $order['MemberId'], PDO::PARAM_INT);
  $sthMemberIntegralHistory->bindValue(':OperatorId', $authorize['Id'], PDO::PARAM_INT);
  $sthMemberIntegralHistory->bindValue(':OperatorLoginName', $authorize['LoginName'], PDO::PARAM_INT);
  $sthMemberIntegralHistory->bindValue(':Remark', '', PDO::PARAM_STR);
  // 5:添加现金流水
  $sql = 'insert into EnterpriseCashHistory(SiteId, Type, TypeSign, OperatorId, OperatorLoginName, Amount, Remark, CreateTime) values(:SiteId, :Type, :TypeSign, :OperatorId, :OperatorLoginName, :Amount, :Remark, now());';
  $sthEnterpriseCashHistory = $pdomysql->prepare($sql);
  $sthEnterpriseCashHistory->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sthEnterpriseCashHistory->bindValue(':OperatorId', $authorize['Id'], PDO::PARAM_INT);
  $sthEnterpriseCashHistory->bindValue(':OperatorLoginName', $authorize['LoginName'], PDO::PARAM_INT);
  $sthEnterpriseCashHistory->bindValue(':Remark', '', PDO::PARAM_STR);

  // 包含有事务的数据库操作
  $pdomysql->beginTransaction();
  $sthOrder->execute();

  if ($onlineAmount == 0) {
    if (!empty($cashAmount)) {
      $sthEnterpriseCashHistory->bindValue(':Type', $enumEnterpriseCashTransactionType['消费'], PDO::PARAM_INT);
      $sthEnterpriseCashHistory->bindValue(':TypeSign', 1, PDO::PARAM_INT);
      $sthEnterpriseCashHistory->bindValue(':Amount', $cashAmount, PDO::PARAM_INT);
      $sthEnterpriseCashHistory->execute();
    }
    if (!empty($balanceAmount) || !empty($integralAmount) || !empty($order['ProduceIntegral'])) {
      $sthMember->bindValue(':Balance', $balanceAmount, PDO::PARAM_INT);
      $sthMember->bindValue(':Integral', $integralAmount - $order['ProduceIntegral'], PDO::PARAM_INT);
      $sthMember->execute();
    }
    if (!empty($balanceAmount)) {
      $sthMemberBalanceHistory->bindValue(':Type', $enumMemberBalanceTransactionType['用户消费'], PDO::PARAM_INT);
      $sthMemberBalanceHistory->bindValue(':TypeSign', -1, PDO::PARAM_INT);
      $sthMemberBalanceHistory->bindValue(':Amount', $balanceAmount, PDO::PARAM_INT);
      $sthMemberBalanceHistory->bindValue(':Balance', $member['Balance'] - $balanceAmount, PDO::PARAM_INT);
      $sthMemberBalanceHistory->execute();
    }
    if (!empty($integralAmount)) {
      $sthMemberIntegralHistory->bindValue('Type', $enumMemberIntegralTransactionType['积分支付'], PDO::PARAM_INT);
      $sthMemberIntegralHistory->bindValue(':TypeSign', -1, PDO::PARAM_INT);
      $sthMemberIntegralHistory->bindValue(':Amount', $integralAmount, PDO::PARAM_INT);
      $sthMemberIntegralHistory->bindValue(':Integral',  $member['Integral'] - $integralAmount, PDO::PARAM_INT);
      $sthMemberIntegralHistory->execute();
    }
    if (!empty($order['ProduceIntegral'])) {
      $sthMemberIntegralHistory->bindValue('Type', $enumMemberIntegralTransactionType['购物积分'], PDO::PARAM_INT);
      $sthMemberIntegralHistory->bindValue(':TypeSign', 1, PDO::PARAM_INT);
      $sthMemberIntegralHistory->bindValue(':Amount', $order['ProduceIntegral'], PDO::PARAM_INT);
      $sthMemberIntegralHistory->bindValue(':Integral',  $member['Integral'] - $integralAmount + $order['ProduceIntegral'], PDO::PARAM_INT);
      $sthMemberIntegralHistory->execute();
    }

    $sthProduct->execute();
  }
  $pdomysql->commit();
  JsonResultSuccess($id);
} catch (PDOException $e) {
  JsonResultException($e);
}
