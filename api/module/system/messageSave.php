<?php
if (!defined('Execute')) {
  exit();
}
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumPermission;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::公告管理);

$id = 0;
$title = 0;
$content = '';

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

  if (isset($json_data->Title))
    $title = $json_data->Title;

  if (isset($json_data->Content))
    $content = $json_data->Content;
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
if (empty($id)) {
  // 添加
} else {
  // 修改
}
if (empty($title) || strlen($title) < 2 || strlen($title) > 200) {
  PageHelper::JsonResultError('标题必须为2至200个字符');
}
if (!empty($content) && strlen($title) > 4000) {
  PageHelper::JsonResultError('类容不能操过4000个字符');
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare("insert Message(SiteId, Title, Content, IsLocked, CreateTime)values(:SiteId, :Title, :Content, false, now());");
  } else {
    $sth = $pdomysql->prepare("update Message set Title = :Title, Content = :Content where Id = :Id and SiteId = :SiteId;");
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindValue(':Title', $title, PDO::PARAM_STR);
  $sth->bindValue(':Content', $content, PDO::PARAM_STR);
  $sth->execute();

  PageHelper::JsonResultSuccess();
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
