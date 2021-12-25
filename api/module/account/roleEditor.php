<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\PageHelper;
use Aglory\StringHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::角色管理);

$id = 0;

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
}

$columns = array('Id' => 0, 'Name' => '', 'Permission' => '');

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from Role where Id = :Id';
    if ($authorization->Type == EnumAccountType::配置员)
      $sql = $sql . ' and IsInner = 1';
    else
      $sql = $sql . ' and IsInner = 0 and SiteId = ' . $authorization->SiteId;
    $sql .= ';';
    $sth = $pdomysql->prepare($sql);
    $sth->execute(array('Id' => $id));
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      PageHelper::JsonResultError('参数错误');
    }
  }
  $model['Permission'] = array_map(function ($item) {
    return intval($item);
  }, StringHelper::ExplodeRemoveEmptyEntries(',', $model['Permission']));

  $tempPermission = [];
  foreach (EnumPermission::ToArray() as $key => $val) {
    if ($authorization->Type == EnumAccountType::配置员 || in_array($val, $authorization->Permission)) {
      $tempPermission[] = array('Id' => $val, 'Name' => $key);
    }
  }
  $model['TempPermission'] = $tempPermission;
  PageHelper::JsonResultSuccess($model);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
