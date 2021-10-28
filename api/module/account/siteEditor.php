<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['站点管理']);
$enumAccountType = GetEnumAccountType();
CheckAuthorizeType($enumAccountType['配置员']);
$authorize = GetAuthorize();

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

$columns = array('Id' => 0, 'Host' => '', 'Remark' => '', 'AccountId' => 0, 'AccountLoginName' => '');

include_once './lib/pdo.php';
include_once './lib/stringHelper.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from ViewSite where Id = :Id and IsInner = 0;';
    $sth = $pdomysql->prepare($sql);
    $sth->execute(array('Id' => $id));
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      JsonResultError('参数错误');
      exit();
    }
  }
  if ($model['AccountId'] > 0) {
    $model['Account'] = array(array('Id' => $model['AccountId'], 'LoginName' => $model['AccountLoginName']));
  } else {
    $sql = 'select Id, LoginName from account where Type = ' . $enumAccountType['管理员'] . ' and  SiteId = 0;';
    $sth = $pdomysql->prepare($sql);
    $sth->execute();
    $model['Account'] = $sth->fetchAll(PDO::FETCH_ASSOC);
  }
  JsonResultSuccess($model);
} catch (PDOException $e) {
  JsonResultException($e);
}
