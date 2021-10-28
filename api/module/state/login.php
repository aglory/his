<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/enum.php';
$enumAccountType = GetEnumAccountType();
$enumPermission = GetEnumPermission();

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
  JsonResultError('请输入用户名和密码');
}

include_once './lib/pdo.php';
include_once './lib/account.php';

if (empty($pdomysql))
  $pdomysql = GetPDO();

try {
  $sth = $pdomysql->prepare("select Id, IsLocked from Site where find_in_set(:Host, Host);");
  $sth->execute(array('Host' => $_SERVER["HTTP_HOST"]));
  $siteList = $sth->fetchAll(PDO::FETCH_ASSOC);
  if (count($siteList) != 1) {
    JsonResultError('系统网站错误',  $_SERVER["HTTP_HOST"]);
  } else {
    if ($siteList[0]['IsLocked']) {
      JsonResultError('系统已经锁定请联系管理员');
    } else {
      $siteId = $siteList[0]['Id'];
    }
  }
} catch (PDOException $e) {
  JsonResultException($e);
}

try {
  $sth = $pdomysql->prepare("select * from Account where LoginName = :LoginName and SiteId = :SiteId;");
  $sth->bindValue(':LoginName', $loginName, PDO::PARAM_STR);
  $sth->bindValue(':SiteId', $siteId, PDO::PARAM_INT);
  $sth->execute();
  $account = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  JsonResultException($e);
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

    // 权限赋值
    $permissions = array();
    if ($account['Type'] == $enumAccountType['配置员']) {
      $permissions = array_values($enumPermission);
    } else if (!empty($account['Role'])) {
      try {
        $sth = $pdomysql->prepare("select Permission from Role where Id in ({$account['Role']});");
        $sth->execute();
        $roleList = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        JsonResultException($e);
      }
      foreach ($roleList as $item) {
        if (!empty($item['Permission'])) {
          foreach (explode(',', $item['Permission']) as $permission) {
            $permissions[] = intval($permission);
          }
        }
      }
    }
    $data['Permission'] = $permissions;
    $data['Token'] = BuildToken($data);
    JsonResultSuccess($data);
  } else {
    JsonResultError('帐号已经被冻结了');
  }
} else {
  JsonResultError('帐号错误或者密码');
}
