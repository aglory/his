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
$authorization->CheckCode(EnumPermission::站点管理);
$authorization->CheckType(EnumAccountType::配置员);

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

$columns = array('Id' => 0, 'Host' => '', 'Remark' => '', 'AccountId' => 0, 'AccountLoginName' => '');

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from ViewSite where Id = :Id and IsInner = 0;';
    $sth = $pdomysql->prepare($sql);
    $sth->execute(array('Id' => $id));
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      PageHelper::JsonResultError('参数错误');
      exit();
    }
  }
  if ($model['AccountId'] > 0) {
    $model['Account'] = array(array('Id' => $model['AccountId'], 'LoginName' => $model['AccountLoginName']));
  } else {
    $sql = 'select Id, LoginName from account where Type = ' . EnumAccountType::管理员 . ' and  SiteId = 0;';
    $sth = $pdomysql->prepare($sql);
    $sth->execute();
    $model['Account'] = $sth->fetchAll(PDO::FETCH_ASSOC);
  }
  PageHelper::JsonResultSuccess($model);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
