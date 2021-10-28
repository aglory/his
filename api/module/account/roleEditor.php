<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['角色管理']);
$authorize = GetAuthorize();
$enumAccountType = GetEnumAccountType();

$id = 0;

$content = file_get_contents('php://input');
if (empty($content)) {
  JsonResultError( '参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    JsonResultError('参数错误');
  }

  if (isset($json_data->Id))
    $id = intval($json_data->Id);
}

$columns = array('Id' => 0, 'Name' => '', 'Permission' => '');

include_once './lib/pdo.php';
include_once './lib/stringHelper.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from Role where Id = :Id';
    if ($authorize['Type'] == $enumAccountType['配置员'])
      $sql = $sql . ' and IsInner = 1';
    else
      $sql = $sql . ' and IsInner = 0 and SiteId = ' . $authorize['SiteId'];
    $sql .= ';';
    $sth = $pdomysql->prepare($sql);
    $sth->execute(array('Id' => $id));
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      JsonResultError( '参数错误');
    }
  }
  $model['Permission'] = array_map(function ($item) {
    return intval($item);
  }, ExplodeRemoveEmptyEntries(',', $model['Permission']));

  $tempPermission = [];
  foreach ($enumPermission as $key => $val) {
    if ($authorize['Type'] == $enumAccountType['配置员'] || in_array($val, $authorize['Permission'])) {
      $tempPermission[] = array('Id' => $val, 'Name' => $key);
    }
  }
  $model['TempPermission'] = $tempPermission;
  JsonResultSuccess($model);
} catch (PDOException $e) {
  JsonResultException($e);
}

