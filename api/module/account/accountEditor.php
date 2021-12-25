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
$authorization->CheckCode(EnumPermission::帐号管理);

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

$columns = array('Id' => 0, 'Type' => 0, 'LoginName' => '', 'RealName' => '', 'Tel' => '', 'Role' => '');

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
try {
  if (!empty($id)) {
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
  }
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}

try {
  if (empty($id)) {
    $model = $columns;
  } else {
    $sql = 'select ' . implode(',', array_keys($columns)) . ' from Account where Id = :Id';
    if ($authorization->Type == EnumAccountType::配置员)
      $sql = $sql . ' and Type = ' . EnumAccountType::管理员;
    else
      $sql = $sql . ' and Type = ' . EnumAccountType::操作员 . ' and SiteId = ' . $authorization->SiteId;
    $sql .= ';';
    $sth = $pdomysql->prepare($sql);
    $sth->execute(array('Id' => $id));
    $model = $sth->fetch(PDO::FETCH_ASSOC);
    if ($model === false) {
      PageHelper::JsonResultError('参数错误');
    }
  }
  $model['Role'] = array_map(function ($item) {
    return intval($item);
  }, StringHelper::ExplodeRemoveEmptyEntries(',', $model['Role']));

  $sql = 'select Id, Name from Role where SiteId = ' . $authorization->SiteId;
  if ($authorization->Type == EnumAccountType::配置员) {
    $sql .= ' and IsInner = 1';
  } else {
    $sql .= ' and IsInner = 0';
  }
  $sth = $pdomysql->prepare($sql);
  $sth->execute();
  $model['TempRole'] = $sth->fetchAll(PDO::FETCH_ASSOC);
  PageHelper::JsonResultSuccess($model);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
