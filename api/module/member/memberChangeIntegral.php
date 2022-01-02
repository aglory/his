<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumMemberIntegralTransactionType;
use Aglory\EnumPermission;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::会员管理);
$authorization->CheckType(EnumAccountType::管理员, EnumAccountType::操作员);

$id = 0;
$amount = 0;
$remark = '';

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
  if (isset($json_data->Amount))
    $amount = $json_data->Amount;
  if (isset($json_data->Remark))
    $remark  = $json_data->Remark;
}

if (empty($id)) {
  PageHelper::JsonResultError('参数错误');
}
if (empty($amount)) {
  PageHelper::JsonResultError('调整积分不能为0');
}

/**
 * 1：更改用户积分
 * 2：添加用户流水
 */
try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();
  $pdomysql->beginTransaction();
  $sql = "update Member set Integral = Integral + :Amount where Id = :Id and SiteId = :SiteId;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindValue(':Amount', $amount, PDO::PARAM_INT);
  $sth->execute();
  if (!$sth->rowCount()) {
    PageHelper::JsonResultError('参数错误');
  }
  $sql = 'insert into MemberIntegralHistory(SiteId, Type, TypeSign, MemberId, OperatorId, OperatorLoginName, Amount, Balance, Remark, CreateTime) select SiteId, :Type, :TypeSign, Id, :OperatorId, :OperatorLoginName, :Amount, Integral, :Remark, now() from Member where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindValue(':Type', $amount > 0 ? EnumMemberIntegralTransactionType::上分 : EnumMemberIntegralTransactionType::下分, PDO::PARAM_INT);
  $sth->bindValue(':TypeSign', $amount > 0 ? 1 : -1, PDO::PARAM_INT);
  $sth->bindValue(':OperatorId', $authorization->Id, PDO::PARAM_INT);
  $sth->bindValue(':OperatorLoginName', $authorization->LoginName, PDO::PARAM_STR);
  $sth->bindValue(':Amount', abs($amount), PDO::PARAM_INT);
  $sth->bindValue(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  $pdomysql->commit();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  $pdomysql->rollBack();
  PageHelper::JsonResultException($e);
}
