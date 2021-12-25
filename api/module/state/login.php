<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\DBInstance;
use Aglory\PageHelper;

$loginName = '';
$password = '';
$siteId = 0;

$content = file_get_contents('php://input');
if ($content && strlen($content) > 0) {
  $json_data = json_decode($content);
  if ($json_data != null && isset($json_data->LoginName))
    $loginName = $json_data->LoginName;

  if ($json_data != null && isset($json_data->Password))
    $password = $json_data->Password;
}

if (empty($loginName) || empty($password)) {
  PageHelper::JsonResultError('请输入用户名和密码');
}
if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

try {
  $sth = $pdomysql->prepare("select Id, IsLocked from Site where find_in_set(:Host, Host);");
  $sth->execute(array('Host' => $_SERVER["HTTP_HOST"]));
  $siteList = $sth->fetchAll(PDO::FETCH_ASSOC);
  if (count($siteList) != 1) {
    PageHelper::JsonResultError('系统网站错误',  $_SERVER["HTTP_HOST"]);
  } else {
    if ($siteList[0]['IsLocked']) {
      PageHelper::JsonResultError('系统已经锁定请联系管理员');
    } else {
      $siteId = $siteList[0]['Id'];
    }
  }
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}

try {
  $sth = $pdomysql->prepare("select * from Account where LoginName = :LoginName and SiteId = :SiteId;");
  $sth->bindValue(':LoginName', $loginName, PDO::PARAM_STR);
  $sth->bindValue(':SiteId', $siteId, PDO::PARAM_INT);
  $sth->execute();
  $account = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}

if ($account !== false && $account['Password'] == md5($password . $account['Salt'])) {
  if (!$account['IsLocked']) {
    $data = array(
      'Id' => $account['Id'],
      'SiteId' => $account['SiteId'],
      'LoginName' => $account['LoginName'],
      'RealName' => $account['RealName'],
      'Type' => $account['Type'],
    );

    // 层级赋值
    try {
      $sth = $pdomysql->prepare("select * from AccountParent where AccountId = {$account['Id']};");
      $sth->execute();
      $accountParent = $sth->fetch(PDO::FETCH_ASSOC);
      $data['Depth'] = $accountParent['Depth'];
    } catch (PDOException $e) {
      PageHelper::JsonResultException($e);
    }

    // 权限赋值
    $permissions = array();
    if ($account['Type'] == EnumAccountType::配置员) {
      // 配置员 没有层级关系
      $data['Permission'] = array_values(EnumPermission::ToArray());
    } else {
      $data['Permission'] = [];
      if (!empty($account['Role'])) {
        try {
          $sth = $pdomysql->prepare("select Permission from Role where Id in ({$account['Role']});");
          $sth->execute();
          $roleList = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          PageHelper::JsonResultException($e);
        }
        foreach ($roleList as $item) {
          if (!empty($item['Permission'])) {
            foreach (explode(',', $item['Permission']) as $permission) {
              $data['Permission'] = intval($permission);
            }
          }
        }
      }
    }
    $authorization = new Authorization($data);
    PageHelper::JsonResultSuccess($authorization);
  } else {
    PageHelper::JsonResultError('帐号已经被冻结了');
  }
} else {
  PageHelper::JsonResultError('帐号错误或者密码');
}
