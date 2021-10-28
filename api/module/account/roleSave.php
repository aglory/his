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
$name = '';
$permission = [];

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

  if (isset($json_data->Name))
    $name = $json_data->Name;

  if (isset($json_data->Permission))
    $permission = $json_data->Permission;
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

// 验证
if (empty($id)) {
  // 添加
  if (empty($name)) {
    JsonResultError('名称不能为空');
  }
} else {
  // 修改
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare("insert Role(SiteId, Name, Permission, IsInner)values(:SiteId, :Name, :Permission, :IsInner);");
  } else {
    $sth = $pdomysql->prepare("update Role set Name = :Name, Permission = :Permission where Id = :Id and SiteId = :SiteId and IsInner = :IsInner;");
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindParam(':Name', $name, PDO::PARAM_STR);
  $sth->bindValue(':Permission', implode(',', $permission), PDO::PARAM_STR);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  if ($authorize['Type'] == $enumAccountType['配置员']) {
    $sth->bindValue(':IsInner', 1, PDO::PARAM_INT);
  } else {
    $sth->bindValue(':IsInner', 0, PDO::PARAM_INT);
  }
  $sth->execute();
  JsonResultSuccess();
} catch (PDOException $e) {
  JsonResultException($e);
}
