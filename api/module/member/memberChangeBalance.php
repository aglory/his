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
$enumMemberBalanceTransactionType =  GetEnumMemberBalanceTransactionType();

$id = 0;
$amount = 0;
$remark = '';

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
  if (isset($json_data->Amount))
    $amount = $json_data->Amount;
  if (isset($json_data->Remark))
    $remark  = $json_data->Remark;
}

if (empty($id)) {
  JsonResultError('参数错误');
}
if ($amount <= 0) {
  JsonResultError('充值金额必须大于0');
}

include_once './lib/pdo.php';

/**
 * 1：更改用户余额
 * 2：添加用户流水
 */
try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  $pdomysql->beginTransaction();
  $sql = "update Member set Balance = Balance + :Amount where Id = :Id and SiteId = :SiteId;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':Amount', $amount, PDO::PARAM_INT);
  $sth->execute();
  if (!$sth->rowCount()) {
    JsonResultError('参数错误');
  }
  $sql = 'insert into MemberBalanceHistory(SiteId, Type, TypeSign, MemberId, OperatorId, OperatorLoginName, Amount, Balance, Remark, CreateTime) select SiteId, :Type, 1, Id, :OperatorId, :OperatorLoginName, :Amount, Balance, :Remark, now() from Member where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':Type', $enumMemberBalanceTransactionType['用户充值'], PDO::PARAM_INT);
  $sth->bindValue(':OperatorId', $authorize['Id'], PDO::PARAM_INT);
  $sth->bindValue(':OperatorLoginName', $authorize['LoginName'], PDO::PARAM_INT);
  $sth->bindValue(':Amount', $amount, PDO::PARAM_INT);
  $sth->bindValue(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  $pdomysql->commit();
  JsonResultSuccess();
} catch (PDOException $e) {
  $pdomysql->rollBack();
  JsonResultException($e);
}
