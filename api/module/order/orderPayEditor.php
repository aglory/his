<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['会员管理']);
$authorize = GetAuthorize();
$enumAccountType = GetEnumAccountType();

$id = 0;

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
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

// 验证
if (empty($id)) {
  JsonResultError('参数错误');
}

$columns = array(
  'Id' => 0,
  'MemberId' => 0,
  'Amount' => 0,
  'PreferenceAmount' => 0,
  'BalanceAmount' => 0,
  'IntegralAmount' => 0,
  'OnlineAmount' => 0,
  'CashAmount' => 0,
  'ProduceIntegral' => 0,
  'PayStatus' => 0
);

include_once './lib/pdo.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from `Order` where Id = :Id';
    $sqlParams = array('Id' => $id);
    if ($authorize['Type'] != $enumAccountType['配置员']) {
      $sql = $sql . ' and SiteId = ' . $authorize['SiteId'];
    }
    if ($authorize['Type'] == $enumAccountType['员工']) {
      $sql = $sql . ' and OperatorId = ' . $authorize['Id'];
    }
    $sql = $sql . ';';
    $sth = $pdomysql->prepare($sql);
    $sth->bindValue(':Id', $id, PDO::PARAM_INT);
    $sth->execute($sqlParams);
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      JsonResultError('参数错误');
    }
    $sql = 'select Balance, Integral from Member where Id = :Id;';
    $sth = $pdomysql->prepare($sql);
    $sth->bindValue(':Id', $model['MemberId'], PDO::PARAM_INT);
    $sth->execute();
    $member = $sth->fetch(PDO::FETCH_ASSOC);
    if ($member === false) {
      JsonResultError('参数错误');
    }
    $model['MemberBalance'] = $member['Balance'];
    $model['MemberIntegral'] = $member['Integral'];
  }
  JsonResultSuccess($model);
} catch (PDOException $e) {
  JsonResultException($e);
}
