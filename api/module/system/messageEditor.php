<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['公告管理']);
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

$columns = array('Id' => 0, 'Title' => '', 'Content' => '');

include_once './lib/pdo.php';
include_once './lib/stringHelper.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from Message where Id = :Id and SiteId = :SiteId;';
    $sth = $pdomysql->prepare($sql);
    $sth->bindValue(':Id', $id, PDO::PARAM_INT);
    $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    $sth->execute();
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      JsonResultError('参数错误');
    }
  }
  JsonResultSuccess($model);
} catch (PDOException $e) {
  JsonResultException($e);
  exit();
}
