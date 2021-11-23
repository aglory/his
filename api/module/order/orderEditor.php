<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['订单管理']);
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
    $id = intval($json_data->Id);
}

$columns = array('Id' => 0, 'No' => '', 'MemberId' => 0, 'MemberName' => '', 'MemberTel' => '', 'PayStatus' => 0, 'Remark' => '', 'CreateTime' => '');

include_once './lib/pdo.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  if (empty($id)) {
    $model = $columns;
    $model['Items'] = [];
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from ViewOrder where Id = :Id';
    $sqlParams = array('Id' => $id);
    if ($authorize['Type'] != $enumAccountType['配置员']) {
      $sql = $sql . ' and SiteId = ' . $authorize['SiteId'];
    }
    if ($authorize['Type'] == $enumAccountType['员工']) {
      $sql = $sql . ' and OperatorId = ' . $authorize['Id'];
    }
    $sql = $sql . ';';
    $sth = $pdomysql->prepare($sql);
    $sth->execute($sqlParams);
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      JsonResultError('参数错误');
    }

    $sql = 'select ProductId, ProductShortName, Copies from OrderItem where OrderId = :OrderId;';
    $sth = $pdomysql->prepare($sql);
    $sth->bindValue(':OrderId', $model['Id'], PDO::PARAM_INT);
    $sth->execute();
    $model['Items'] = $sth->fetchAll(PDO::FETCH_ASSOC);
  }
  JsonResultSuccess($model);
} catch (PDOException $e) {
  JsonResultException($e);
}
