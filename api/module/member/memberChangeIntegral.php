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
$enumMemberIntegralTransactionType =  GetEnumMemberIntegralTransactionType();

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
if (empty($amount)) {
  JsonResultError('调整积分不能为0');
}

include_once './lib/pdo.php';

/**
 * 1：更改用户积分
 * 2：添加用户流水
 */
try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  $pdomysql->beginTransaction();
  $sql = "update Member set Integral = Integral + :Amount where Id = :Id and SiteId = :SiteId;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':Amount', $amount, PDO::PARAM_INT);
  $sth->execute();
  if (!$sth->rowCount()) {
    JsonResultError('参数错误');
  }
  $sql = 'insert into MemberIntegralHistory(SiteId, Type, TypeSign, MemberId, OperatorId, OperatorLoginName, Amount, Balance, Remark, CreateTime) select SiteId, :Type, :TypeSign, Id, :OperatorId, :OperatorLoginName, :Amount, Integral, :Remark, now() from Member where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':Type', $amount > 0 ? $enumMemberIntegralTransactionType['上分'] : $enumMemberIntegralTransactionType['下分'], PDO::PARAM_INT);
  $sth->bindValue(':TypeSign', $amount > 0 ? 1 : -1, PDO::PARAM_INT);
  $sth->bindValue(':OperatorId', $authorize['Id'], PDO::PARAM_INT);
  $sth->bindValue(':OperatorLoginName', $authorize['LoginName'], PDO::PARAM_INT);
  $sth->bindValue(':Amount', abs($amount), PDO::PARAM_INT);
  $sth->bindValue(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  $pdomysql->commit();
  JsonResultSuccess();
} catch (PDOException $e) {
  $pdomysql->rollBack();
  JsonResultException($e);
}
