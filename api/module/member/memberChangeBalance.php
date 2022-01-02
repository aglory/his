<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumMemberBalanceTransactionType;
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
if ($amount <= 0) {
  PageHelper::JsonResultError('充值金额必须大于0');
}

/**
 * 1：更改用户余额
 * 2：添加用户流水
 */
try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();
  $pdomysql->beginTransaction();
  $sql = "update Member set Balance = Balance + :Amount where Id = :Id and SiteId = :SiteId;";
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindValue(':Amount', $amount, PDO::PARAM_INT);
  $sth->execute();
  if (!$sth->rowCount()) {
    PageHelper::JsonResultError('参数错误');
  }
  $sql = 'insert into MemberBalanceHistory(SiteId, Type, TypeSign, MemberId, OperatorId, OperatorLoginName, Amount, Balance, Remark, CreateTime) select SiteId, :Type, 1, Id, :OperatorId, :OperatorLoginName, :Amount, Balance, :Remark, now() from Member where Id = :Id and SiteId = :SiteId;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindValue(':Type', EnumMemberBalanceTransactionType::用户充值, PDO::PARAM_INT);
  $sth->bindValue(':OperatorId', $authorization->Id, PDO::PARAM_INT);
  $sth->bindValue(':OperatorLoginName', $authorization->LoginName, PDO::PARAM_STR);
  $sth->bindValue(':Amount', $amount, PDO::PARAM_INT);
  $sth->bindValue(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  $pdomysql->commit();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  $pdomysql->rollBack();
  PageHelper::JsonResultException($e);
}
