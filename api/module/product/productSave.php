<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['产品管理']);
$enumAccountType = GetEnumAccountType();
CheckWidthOutAuthorizeType($enumAccountType['配置员']);
$authorize = GetAuthorize();
$enumProductType = GetEnumProductType();

$id = 0;
$type = 0;
$shortName = '';
$fullName = '';
$description = '';
$remark = '';

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
    $type = $json_data->Type;

  if (isset($json_data->ShortName))
    $shortName = $json_data->ShortName;

  if (isset($json_data->FullName))
    $fullName = $json_data->FullName;

  if (isset($json_data->Description))
    $description = $json_data->Description;

  if (isset($json_data->Remark))
    $remark = $json_data->Remark;
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

// 验证
if (empty($shortName) || strlen($shortName) < 2 || strlen($shortName) > 50) {
  JsonResultError('产品简称必须为1至50个字符');
}
if (empty($fullName) || strlen($fullName) < 2 || strlen($fullName) > 2000) {
  JsonResultError('产品全称必须为1至2000个字符');
}
if (empty($id)) {
  // 添加
  if (!in_array($type, $enumProductType)) {
    JsonResultError('请选择正确的产品类型');
  }
} else {
  // 修改
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare("insert Product(SiteId, Type, ShortName, FullName, Description, Remark, MarketPrice, Price, SettlementPrice, SaleCopies, BaseCopies, SortCopies, OrderIndex, IsLocked, CreateTime)values(:SiteId, :Type, :ShortName, :FullName, :Description, :Remark, 0, 0, 0, 0, 0, 0, 0, true, now());");
    $sth->bindValue(':Type', $type, PDO::PARAM_INT);
  } else {
    $sql = 'update Product set ShortName = :ShortName, FullName = :FullName, Description = :Description, Remark = :Remark where Id = :Id and SiteId = :SiteId;';
    $sth->bindParam(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindValue(':ShortName', $shortName, PDO::PARAM_STR);
  $sth->bindParam(':FullName', $fullName, PDO::PARAM_STR);
  $sth->bindParam(':Description', $description, PDO::PARAM_STR);
  $sth->bindParam(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  if (empty($id)) {
    $id = $pdomysql->lastInsertId();
  }
  JsonResultSuccess($id);
} catch (PDOException $e) {
  JsonResultException($e);
}
