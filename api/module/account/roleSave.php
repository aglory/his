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
$authorization->CheckCode(EnumPermission::角色管理);

$id = 0;
$name = '';
$permission = [];

$content = file_get_contents('php://input');
if (empty($content)) {
  PageHelper::JsonResultError('参数错误');
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    PageHelper::JsonResultError('参数错误');
  }

  if (isset($json_data->Id))
    $id = $json_data->Id;

  if (isset($json_data->Name))
    $name = $json_data->Name;

  if (isset($json_data->Permission))
    $permission = $json_data->Permission;
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
if (empty($id)) {
  // 添加
  if (empty($name)) {
    PageHelper::JsonResultError('名称不能为空');
  }
} else {
  // 修改
}

// 过滤掉越权的权限
$allPermission = $authorization->Type == EnumAccountType::配置员 ? EnumPermission::ToArray() : $authorization->Permission;
$tempPermission = [];
foreach ($permission as $item) {
  if (in_array($item, $allPermission)) {
    $tempPermission[] = $item;
  }
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare("insert Role(SiteId, Name, Permission, IsInner)values(:SiteId, :Name, :Permission, :IsInner);");
  } else {
    $sth = $pdomysql->prepare("update Role set Name = :Name, Permission = :Permission where Id = :Id and SiteId = :SiteId and IsInner = :IsInner;");
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindParam(':Name', $name, PDO::PARAM_STR);
  $sth->bindValue(':Permission', implode(',', $tempPermission), PDO::PARAM_STR);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  if ($authorization->Type == EnumAccountType::配置员) {
    $sth->bindValue(':IsInner', 1, PDO::PARAM_INT);
  } else {
    $sth->bindValue(':IsInner', 0, PDO::PARAM_INT);
  }
  $sth->execute();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
