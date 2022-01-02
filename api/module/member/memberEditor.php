<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::会员管理);

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

$columns = array('Id' => 0, 'Name' => '', 'Tel' => '', 'IdcardNo' => '', 'Address' => '', 'Remark' => '');

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from Member where Id = :Id';
    $sqlParams = array('Id' => $id);
    if ($authorization->Type != EnumAccountType::配置员) {
      $sql = $sql . ' and SiteId = ' . $authorization->SiteId;
    }
    $sql = $sql . ';';
    $sth = $pdomysql->prepare($sql);
    $sth->execute($sqlParams);
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      PageHelper::JsonResultError('参数错误');
    }
  }
  PageHelper::JsonResultSuccess($model);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
