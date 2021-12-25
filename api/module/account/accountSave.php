<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\EnumProductType;
use Aglory\PageHelper;
use Aglory\StringHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::帐号管理);

$id = 0;
$parentId = 0;
$loginName = '';
$realName = '';
$tel = '';
$password = '';
$role = [];

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

  if (isset($json_data->ParentId))
    $parentId = $json_data->ParentId;

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

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
if (empty($realName) || strlen($realName) < 2 || strlen($realName) > 50) {
  PageHelper::JsonResultError('真实姓名必须为1至50个字符');
}
if (empty($tel) || strlen($tel) < 2 || strlen($tel) > 20) {
  PageHelper::JsonResultError('请输入正确的电话号码');
}

$accountParent = null;

if (empty($id)) {
  // 添加
  if (empty($loginName) || strlen($loginName) < 2 || strlen($loginName) > 50) {
    PageHelper::JsonResultError('登录账号必须为2至50个字符');
  }
  if (empty($password)) {
    PageHelper::JsonResultError('密码不能为空');
  }

  switch ($authorization->Type) {
    case EnumAccountType::配置员:
      break;
    case EnumAccountType::管理员:
      if (empty($parentId)) {
        $parentId = $authorization->Id;
      }
      try {
        $sth->$pdomysql->prepare('select * from AccountParent where AccountId = :AccountId;');
        $sth->bindParam(':AccountId', $parentId, PDO::PARAM_INT);
        $sth->execute();
        $accountParent = $sth->fetch(PDO::FETCH_ASSOC);
        if ($accountParent === false || ($accountParent['Depth'] < $authorization->Depth || $accountParent['Id' . $authorization->Depth] != $authorization->Id)) {
          PageHelper::JsonResultError('越权错误');
        }
        if ($accountParent['Depth'] >= 9) {
          PageHelper::JsonResultError('用户层级不能超过9层');
        }
      } catch (PDOException $e) {
        PageHelper::JsonResultException($e);
      }
      break;
    default:
      PageHelper::JsonResultError('错误用户类型');
      break;
  }

  try {
    $sql = 'select * from Account where LoginName = :LoginName and Type = :Type and SiteId = :SiteId';
    $sth = $pdomysql->prepare($sql);
    switch ($authorization->Type) {
      case EnumAccountType::配置员:
        $sth->bindValue(':Type', EnumAccountType::管理员, PDO::PARAM_INT);
        $sth->bindValue(':SiteId', 0, PDO::PARAM_INT);
        break;
      case EnumAccountType::管理员:
        $sth->bindValue(':Type', EnumAccountType::操作员, PDO::PARAM_INT);
        $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
        break;
      default:
        PageHelper::JsonResultError('错误用户类型');
        break;
    }
    $sth->bindValue(':LoginName', $loginName, PDO::PARAM_STR);
    $sth->execute();
    $account = $sth->fetch(PDO::FETCH_ASSOC);
    if ($account !== false) {
      PageHelper::JsonResultError('帐号已经存在');
    }
  } catch (PDOException $e) {
    PageHelper::JsonResultException($e);
  }
} else {
  // 修改
}

// 角色越权判断
try {
  if (!empty($role)) {
    $sql = 'select Id from Role where SiteId = ' . $authorization->SiteId;
    if ($authorization->Type == EnumAccountType::配置员) {
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
        PageHelper::JsonResultError('错误的角色');
      }
    }
  }
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}

try {
  $pdomysql->beginTransaction();
  if (empty($id)) {
    $salt = StringHelper::GenerateRandomString(6);
    $sth = $pdomysql->prepare("insert Account(SiteId, LoginName, RealName, Tel, Password, Salt, Type, Role, IsLocked, CreateTime)values(:SiteId, :LoginName, :RealName, :Tel, :Password, :Salt, :Type, :Role, false, now());");
    $sth->bindParam(':LoginName', $loginName, PDO::PARAM_STR);
    $sth->bindValue(':Password', md5($password . $salt), PDO::PARAM_STR);
    $sth->bindParam(':Salt', $salt, PDO::PARAM_STR);

    switch ($authorization->Type) {
      case EnumAccountType::配置员:
        $sth->bindValue(':SiteId', 0, PDO::PARAM_INT);
        $sth->bindValue(':Type', EnumAccountType::管理员, PDO::PARAM_INT);
        break;
      case EnumAccountType::管理员:
        $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
        $sth->bindValue(':Type', EnumAccountType::操作员, PDO::PARAM_INT);
        break;
      default:
        PageHelper::JsonResultError('错误用户类型');
        break;
    }
  } else {
    $sql = 'update Account set RealName = :RealName, Tel = :Tel, Role = :Role where Id = :Id';

    switch ($authorization->Type) {
      case EnumAccountType::配置员:
        break;
      case EnumAccountType::管理员:
        $sql .= ' and SiteId = ' . $authorization->SiteId;
        break;
      default:
        PageHelper::JsonResultError('错误用户类型');
        break;
    }
    $sql .= ';';
    $sth = $pdomysql->prepare($sql);
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindParam(':RealName', $realName, PDO::PARAM_STR);
  $sth->bindParam(':Tel', $tel, PDO::PARAM_STR);
  $sth->bindValue(':Role', implode(',', $role), PDO::PARAM_STR);
  $sth->execute();
  if (empty($id)) {
    $id = $pdomysql->lastInsertId();
    $depth = 1;
    switch ($authorization->Type) {
      case EnumAccountType::配置员:
        $accountParentColumn = array('AccountId' => $id, 'Depth' => 1, 'Id1' => $id, 'LoginName1' => $loginName, 'RealName1' => $realName);
        break;
      case EnumAccountType::管理员:
        $depth = $accountParentColumn['Depth'] + 1;
        $accountParentColumn = $accountParent;
        $accountParentColumn['AccountId'] = $id;
        $accountParentColumn['Depth'] = $depth;
        $accountParentColumn['Id' . $accountParentColumn['Depth']] = $id;
        $accountParentColumn['LoginName' . $accountParentColumn['Depth']] = $loginName;
        $accountParentColumn['RealName' . $accountParentColumn['Depth']] = $realName;
        break;
      default:
        PageHelper::JsonResultError('错误用户类型');
        break;
    }
    $sql = 'insert into AccountParent(AccountId, Depth';
    for ($i = 1; $i <= 9; $i++) {
      if (!isset($accountParentColumn['Id' . $i]) || empty($accountParentColumn['Id' . $i])) {
        break;
      }
      $sql .= ', Id' . $i;
      $sql .= ', LoginName' . $i;
      $sql .= ', RealName' . $i;
    }
    $sql .= ')values(:AccountId, :Depth';
    for ($i = 1; $i <= 9; $i++) {
      if (!isset($accountParentColumn['Id' . $i]) || empty($accountParentColumn['Id' . $i])) {
        break;
      }
      $sql .= ', :Id' . $i;
      $sql .= ', :LoginName' . $i;
      $sql .= ', :RealName' . $i;
    }
    $sql .= ');';

    $sth = $pdomysql->prepare($sql);
    $sth->bindValue(':AccountId', $id, PDO::PARAM_INT);
    $sth->bindValue(':Depth', $depth, PDO::PARAM_INT);
    for ($i = 1; $i <= 9; $i++) {
      if (!isset($accountParentColumn['Id' . $i]) || empty($accountParentColumn['Id' . $i])) {
        break;
      }
      $sth->bindValue(':Id' . $i, $accountParentColumn['Id' . $i], PDO::PARAM_INT);
      $sth->bindValue(':LoginName' . $i, $accountParentColumn['LoginName' . $i], PDO::PARAM_STR);
      $sth->bindValue(':RealName' . $i, $accountParentColumn['RealName' . $i], PDO::PARAM_STR);
    }
    $sth->execute();
  } else {
    $sth = $pdomysql->prepare('select Depth from AccountParent where AccountId = :AccountId;');
    $sth->bindValue(':AccountId', $id, PDO::PARAM_INT);
    $sth->execute();
    $accountParent = $sth->fetch(PDO::FETCH_ASSOC);
    if ($accountParent === false) {
      PageHelper::JsonResultError('数据错误');
    }
    $depth = $accountParent['Depth'];
    switch ($authorization->Type) {
      case EnumAccountType::配置员:
        $sth = $pdomysql->prepare("update AccountParent set RealName1 = :RealName1 where Id1 = :Id1;");
        $sth->bindValue(':RealName1', $realName, PDO::PARAM_STR);
        $sth->bindValue(':Id1', $id, PDO::PARAM_INT);
        $sth->execute();
        break;
      case EnumAccountType::管理员:
        $parentDepth = $depth - 1;
        $sth = $pdomysql->prepare("update AccountParent set RealName{$parentDepth} = :RealName{$parentDepth} where Id{$parentDepth} = :Id{$parentDepth};");
        $sth->bindValue(':RealName' . $parentDepth, $realName, PDO::PARAM_STR);
        $sth->bindValue(':Id' . $parentDepth, $parentId, PDO::PARAM_INT);
        $sth->execute();
        break;
      default:
        PageHelper::JsonResultError('错误用户类型');
        break;
    }
  }
  $pdomysql->commit();
  PageHelper::JsonResultSuccess(array('Id' => $id, 'Depth' => $depth));
} catch (PDOException $e) {
  $pdomysql->rollBack();
  PageHelper::JsonResultException($e);
}
