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
$authorization->CheckCode(EnumPermission::会员管理);
$authorization->CheckType(EnumAccountType::管理员, EnumAccountType::操作员);

$id = 0;

$name = '';
$tel = '';
$idcardNo = '';
$address = '';
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

  if (isset($json_data->Name))
    $name = $json_data->Name;

  if (isset($json_data->Tel))
    $tel = $json_data->Tel;

  if (isset($json_data->IdcardNo))
    $idcardNo = $json_data->IdcardNo;

  if (isset($json_data->Address))
    $address = $json_data->Address;

  if (isset($json_data->Remark))
    $remark = $json_data->Remark;
}

include_once './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

// 验证
if (empty($name) || strlen($name) < 2 || strlen($name) > 50) {
  PageHelper::JsonResultError('姓名必须为2至50个字符');
}
if (empty($tel) || strlen($tel) < 2 || strlen($tel) > 20) {
  PageHelper::JsonResultError('请输入正确的电话号码');
}
if (empty($id)) {
  // 添加
} else {
  // 修改
}

try {
  if (empty($id)) {
    $sth = $pdomysql->prepare('insert Member(SiteId, Name, Tel, IdcardNo, Address, Remark, Balance, Integral, IsLocked, CreateTime)values(:SiteId, :Name, :Tel, :IdcardNo, :Address, :Remark, 0, 0, false, now());');
  } else {
    $sth =  $pdomysql->prepare('update Member set Name = :Name, Tel = :Tel, IdcardNo = :IdcardNo, Address = :Address, Remark = :Remark where Id = :Id and SiteId = :SiteId;');
    $sth->bindValue(':Id', $id, PDO::PARAM_INT);
  }
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->bindParam(':Name', $name, PDO::PARAM_STR);
  $sth->bindValue(':Tel', $tel, PDO::PARAM_STR);
  $sth->bindParam(':IdcardNo', $idcardNo, PDO::PARAM_STR);
  $sth->bindParam(':Address', $address, PDO::PARAM_STR);
  $sth->bindParam(':Remark', $remark, PDO::PARAM_STR);
  $sth->execute();
  if (empty($id)) {
    $id = $pdomysql->lastInsertId();
  }
  PageHelper::JsonResultSuccess(array('Id' => $id, 'Name' => $name, 'Tel' => $tel, 'IdcardNo' => $idcardNo, 'Address' => $address, 'Remark' => $remark));
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
