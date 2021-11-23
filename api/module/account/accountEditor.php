<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['帐号管理']);
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

$columns = array('Id' => 0, 'Type' => 0, 'LoginName' => '', 'RealName' => '', 'Tel' => '', 'Role' => '');

include_once './lib/pdo.php';
include_once './lib/stringHelper.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from Account where Id = :Id';
    if ($authorize['Type'] == $enumAccountType['配置员'])
      $sql = $sql . ' and Type = ' . $enumAccountType['管理员'];
    else
      $sql = $sql . ' and Type in(' . $enumAccountType['员工'] . ') and SiteId = ' . $authorize['SiteId'];
    $sql .= ';';
    $sth = $pdomysql->prepare($sql);
    $sth->execute(array('Id' => $id));
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      JsonResultError('参数错误');
    }
  }
  $model['Role'] = array_map(function ($item) {
    return intval($item);
  }, ExplodeRemoveEmptyEntries(',', $model['Role']));

  $sql = 'select Id, Name from Role where SiteId = ' . $authorize['SiteId'];
  if ($authorize['Type'] == $enumAccountType['配置员']) {
    $sql .= ' and IsInner = 1';
  } else {
    $sql .= ' and IsInner = 0';
  }
  $sth = $pdomysql->prepare($sql);
  $sth->execute();
  $model['TempRole'] = $sth->fetchAll(PDO::FETCH_ASSOC);
  JsonResultSuccess($model);
} catch (PDOException $e) {
  JsonResultException($e);
}
