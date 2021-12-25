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
$host = '';
$remark = '';
$accountId = 0;

$content = file_get_contents('php://input');
if (empty($content)) {
  PageHelper::JsonResultError('参数错误');
  exit();
} else {
  $json_data = json_decode($content);
  if (empty($json_data)) {
    PageHelper::JsonResultError('参数错误');
  }

  if (isset($json_data->Id))
    $id = $json_data->Id;

  if (isset($json_data->Host))
    $host = $json_data->Host;

  if (isset($json_data->Remark))
    $remark = $json_data->Remark;

  if (isset($json_data->AccountId))
    $accountId = intval($json_data->AccountId);
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
if (empty($id)) {
  // 添加
} else {
  // 修改
}
try {
  if (!empty($host)) {
    // 检测域名$host是否被其它记录使用
    $sqlWhere = [];
    $sqlParams = [];
    foreach (explode(',', $host) as $item) {
      $sqlWhere[] = "(find_in_set(? , Host) and Id <> $id)";
      $sqlParams[] = $item;
    }
    $sql = 'select Id from Site where ' . implode(' and ', $sqlWhere);
    $sth = $pdomysql->prepare($sql);
    $sth->execute($sqlParams);
    $item = $sth->fetch(PDO::FETCH_ASSOC);
    if ($item !== false) {
      PageHelper::JsonResultError($host . '已经被使用');
    }
  }
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}

try {
  $pdomysql->beginTransaction();
  if (empty($id)) {
    $sth = $pdomysql->prepare("insert Site(Host, IsInner, IsLocked, Remark, CreateTime)values(:Host, 0, 0, :Remark, now());");
  } else {
    $sth = $pdomysql->prepare("update Site set Host = :Host, Remark = :Remark where Id = :Id and IsInner = 0;");
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindParam(':Host', $host, PDO::PARAM_STR);
  $sth->bindValue('Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  if (empty($id)) {
    $id = $pdomysql->lastInsertId();
  }
  if ($accountId > 0) {
    $sth = $pdomysql->prepare("update Account set SiteId = :SiteId where Id = :Id and SiteId = 0 and Type = :Type;");
    $sth->bindValue(':SiteId', $id, PDO::PARAM_INT);
    $sth->bindValue(':Id', $accountId, PDO::PARAM_INT);
    $sth->bindValue(':Type', EnumAccountType::管理员, PDO::PARAM_INT);
    $sth->execute();
  }
  $pdomysql->commit();
  PageHelper::JsonResultSuccess($id);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
