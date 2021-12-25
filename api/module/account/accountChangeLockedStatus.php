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
$authorization->CheckCode(EnumPermission::帐号管理);

$id = 0;
$isLocked = false;

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

  if (isset($json_data->IsLocked))
    $isLocked = $json_data->IsLocked;
}

if (empty($id) || !in_array($isLocked, array(false, true), true)) {
  PageHelper::JsonResultError('参数错误');
}
if ($authorization->Id == $id) {
  PageHelper::JsonResultError('不能修改自己');
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
try {
  // AccountParent 等级验证
  $sth = $pdomysql->prepare('select * from AccountParent where AccountId = :Id;');
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->execute();
  $accountParent = $sth->fetch(PDO::FETCH_ASSOC);
  if ($accountParent === false) {
    PageHelper::JsonResultError('数据错误');
  }
  switch ($authorization->Type) {
    case EnumAccountType::配置员:
      // 配置员,只能修改管理员
      if ($accountParent['AccountId'] !== $accountParent['Id1'] && $accountParent['Depth'] != 1) {
        PageHelper::JsonResultError('越权错误');
      }
      break;
    case EnumAccountType::管理员:
      // 管理员,不能越权
      if ($accountParent['Id' . $authorization->Depth] != $authorization->Id) {
        PageHelper::JsonResultError('越权错误');
      }
      break;
    default:
      PageHelper::JsonResultError('错误用户类型');
      break;
  }
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}

try {
  $sql = 'update Account set IsLocked = :IsLocked where Id = :Id';
  switch ($authorization->Type) {
    case  EnumAccountType::配置员:
      $sql .= ' and Type = ' . EnumAccountType::管理员;
      break;
    case EnumAccountType::管理员:
      $sql .= ' and SiteId = ' . $authorization->SiteId;
      $sql .= ' and Type = ' . EnumAccountType::操作员;
      $sql .= '';
      break;
    default:
      PageHelper::JsonResultError('错误用户类型');
      break;
  }

  $sql .= ';';
  $sth = $pdomysql->prepare($sql);
  $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  $sth->bindParam(':IsLocked',  $isLocked, PDO::PARAM_BOOL);
  $sth->execute();
  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
