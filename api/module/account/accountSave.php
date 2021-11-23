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
$type = 0;
$loginName = '';
$realName = '';
$tel = '';
$password = '';
$role = [];

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

  if (isset($json_data->Type))
    $type = intval($json_data->Type);

  if (isset($json_data->LoginName))
    $loginName = $json_data->LoginName;

  if (isset($json_data->RealName))
    $realName = $json_data->RealName;

  if (isset($json_data->Tel))
    $tel = $json_data->Tel;

  if (isset($json_data->Password))
    $password = $json_data->Password;

  if (isset($json_data->Role))
    $role = $json_data->Role;
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

// 验证
if (empty($realName) || strlen($realName) < 2 || strlen($realName) > 50) {
  JsonResultError('真实姓名必须为1至50个字符');
}
if (empty($tel) || strlen($tel) < 2 || strlen($tel) > 20) {
  JsonResultError('请输入正确的电话号码');
}
if (empty($id)) {
  // 添加
  if (empty($loginName) || strlen($loginName) < 2 || strlen($loginName) > 50) {
    JsonResultError('登录账号必须为2至50个字符');
  }
  if (empty($password)) {
    JsonResultError('密码不能为空');
  }

  try {
    if ($authorize['Type'] == $enumAccountType['配置员']) {
      $type = $enumAccountType['管理员'];
      // 配置员 判断未分配出去的站点重名
      $sql = 'select * from Account where LoginName = :LoginName and Type = ' . $enumAccountType['管理员'] . ' and SiteId = :SiteId';
      $sth = $pdomysql->prepare($sql);
      $sth->bindValue(':SiteId', 0, PDO::PARAM_INT);
    } else {
      if (!in_array($type, [$enumAccountType['员工']], true)) {
        JsonResultError('错误的用户类型');
      }
      $sql = 'select * from Account where LoginName = :LoginName and Type in(' .  $enumAccountType['员工'] . ') and SiteId = :SiteId';
      $sth = $pdomysql->prepare($sql);
      $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    }
    $sth->bindValue(':LoginName', $loginName, PDO::PARAM_STR);
    $sth->execute();
    $account = $sth->fetch(PDO::FETCH_ASSOC);
    if ($account !== false) {
      JsonResultError('帐号已经存在');
    }
  } catch (PDOException $e) {
    JsonResultException($e);
  }
} else {
  // 修改
}

// 角色越权判断
try {
  if (!empty($role)) {
    $sql = 'select Id from Role where SiteId = ' . $authorize['SiteId'];
    if ($authorize['Type'] == $enumAccountType['配置员']) {
      $sql .= ' and IsInner = 1';
    } else {
      $sql .= ' and IsInner = 0';
    }
    $sql .= ';';
    $sth = $pdomysql->prepare($sql);
    $sth->execute();
    $roleIds = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($roleIds as  $roleId) {
      if (!in_array($roleId, $roleIds)) {
        JsonResultError('错误的角色');
      }
    }
  }
} catch (PDOException $e) {
  JsonResultException($e);
}

try {
  if (empty($id)) {
    include_once './lib/stringHelper.php';
    $salt = GenerateRandomString(6);
    $sth = $pdomysql->prepare("insert Account(SiteId, LoginName, RealName, Tel, Password, Salt, Type, Role, IsLocked, CreateTime)values(:SiteId, :LoginName, :RealName, :Tel, :Password, :Salt, :Type, :Role, false, now());");
    $sth->bindParam(':LoginName', $loginName, PDO::PARAM_STR);
    $sth->bindValue(':Password', md5($password . $salt), PDO::PARAM_STR);
    $sth->bindParam(':Salt', $salt, PDO::PARAM_STR);
    $sth->bindParam(':Type', $type, PDO::PARAM_INT);

    if ($authorize['Type'] == $enumAccountType['配置员']) {
      $sth->bindValue(':SiteId', 0, PDO::PARAM_INT);
    } else {
      $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    }
  } else {
    $sql = 'update Account set RealName = :RealName, Tel = :Tel, Role = :Role where Id = :Id';
    if ($authorize['Type'] != $enumAccountType['配置员']) {
      $sql .= ' and SiteId = :SiteId';
    }
    $sql .= ';';
    $sth = $pdomysql->prepare($sql);
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
    if ($authorize['Type'] != $enumAccountType['配置员']) {
      $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
    }
  }
  $sth->bindParam(':RealName', $realName, PDO::PARAM_STR);
  $sth->bindParam(':Tel', $tel, PDO::PARAM_STR);
  $sth->bindValue(':Role', implode(',', $role), PDO::PARAM_STR);
  $sth->execute();
  JsonResultSuccess();
} catch (PDOException $e) {
  JsonResultException($e);
}
