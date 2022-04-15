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

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::产品管理);
$authorization->CheckType(EnumAccountType::管理员, EnumAccountType::操作员);

$id = 0;
$type = 0;
$code = '';
$shortName = '';
$fullName = '';
$description = '';
$remark = '';

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

  if (isset($json_data->Type))
    $type = $json_data->Type;

  if (isset($json_data->Code))
    $code = $json_data->Code;

  if (isset($json_data->ShortName))
    $shortName = $json_data->ShortName;

  if (isset($json_data->FullName))
    $fullName = $json_data->FullName;

  if (isset($json_data->Description))
    $description = $json_data->Description;

  if (isset($json_data->Remark))
    $remark = $json_data->Remark;
}

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
if (empty($shortName) || strlen($shortName) < 2 || strlen($shortName) > 50) {
  PageHelper::JsonResultError('产品简称必须为1至50个字符');
}
if (empty($fullName) || strlen($fullName) < 2 || strlen($fullName) > 2000) {
  PageHelper::JsonResultError('产品全称必须为1至2000个字符');
}
if (empty($id)) {
  // 添加
  if (!in_array($type, EnumProductType::ToArray())) {
    PageHelper::JsonResultError('请选择正确的产品类型');
  }
} else {
  // 修改
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare("insert Product(SiteId, Type, Code, ShortName, FullName, MarketPrice, Price, SettlementPrice, Integral, SaleCopies, BaseCopies, Unit, OrderIndex, IsLocked, Description, NoSort, SortCopies, Remark, CreateTime)values(:SiteId, :Type, :Code, :ShortName, :FullName, 0, 0, 0, 0, 0, 0, '', 0, true, '', true, 0, '', now());");
    $sth->bindValue(':Type', $type, PDO::PARAM_INT);
  } else {
    $sth = $pdomysql->prepare('update Product set Code = :Code, ShortName = :ShortName, FullName = :FullName, Description = :Description, Remark = :Remark where Id = :Id and SiteId = :SiteId;');
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':Code', $code, PDO::PARAM_STR);
  $sth->bindValue(':ShortName', $shortName, PDO::PARAM_STR);
  $sth->bindParam(':FullName', $fullName, PDO::PARAM_STR);
  $sth->bindParam(':Description', $description, PDO::PARAM_STR);
  $sth->bindParam(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  if (empty($id)) {
    $id = $pdomysql->lastInsertId();
  }
  PageHelper::JsonResultSuccess($id);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
