<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['会员管理']);
$enumAccountType = GetEnumAccountType();
CheckWidthOutAuthorizeType($enumAccountType['配置员']);
$authorize = GetAuthorize();

$id = 0;

$name = '';
$tel = '';
$idcardNo = '';
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

  if (isset($json_data->Name))
    $name = $json_data->Name;

  if (isset($json_data->Tel))
    $tel = $json_data->Tel;

  if (isset($json_data->IdcardNo))
    $idcardNo = $json_data->IdcardNo;

  if (isset($json_data->Remark))
    $remark = $json_data->Remark;
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

// 验证
if (empty($name) || strlen($name) < 2 || strlen($name) > 50) {
  JsonResultError('姓名必须为2至50个字符');
}
if (empty($tel) || strlen($tel) < 2 || strlen($tel) > 20) {
  JsonResultError('请输入正确的电话号码');
}
if (empty($id)) {
  // 添加
} else {
  // 修改
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare('insert Member(SiteId, Name, Tel, IdcardNo, Remark, Balance, Integral, IsLocked, CreateTime)values(:SiteId, :Name, :Tel, :IdcardNo, :Remark, 0, 0, false, now());');
  } else {
    $sth =  $pdomysql->prepare('update Member set Name = :Name, Tel = :Tel, IdcardNo = :IdcardNo, Remark = :Remark where Id = :Id and SiteId = :SiteId;');
    $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->bindParam(':Name', $name, PDO::PARAM_STR);
  $sth->bindValue(':Tel', $tel, PDO::PARAM_STR);
  $sth->bindParam(':IdcardNo', $idcardNo, PDO::PARAM_STR);
  $sth->bindParam(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  if (empty($id)) {
    $id = $pdomysql->lastInsertId();
  }
  JsonResultSuccess(array('Id' => $id, 'Name' => $name, 'Tel' => $tel, 'IdcardNo' => $idcardNo, 'Remark' => $remark));
} catch (PDOException $e) {
  JsonResultException($e);
}
