<?php
if (!defined('Execute')) {
  exit();
}

/**
 * api通讯安全码
 */
function GetSecurityKey()
{
  return Authorize_Security_Key;
}

/**
 * 建立通讯Token明文
 */
function BuildSecurityValue($authorize)
{
  return md5(
    $authorize['Id'] .
      $authorize['LoginName'] .
      $authorize['RealName'] .
      $authorize['Type'] .
      implode(',', $authorize['Permission']) .
      GetSecurityKey()
  );
}

/**
 * 建立客户端Token
 */
function BuildToken($authorize)
{
  return json_encode(array(
    'Id' => $authorize['Id'],
    'SiteId' => $authorize['SiteId'],
    'LoginName' => $authorize['LoginName'],
    'RealName' => $authorize['RealName'],
    'Type' => $authorize['Type'],
    'Permission' => $authorize['Permission'],
    'Token' => BuildSecurityValue($authorize)
  ));
}

/**
 * 登录信息
 */
function GetAuthorize()
{
  if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
    $authorize = json_decode(str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']));
    if (
      isset($authorize->Id) &&
      isset($authorize->SiteId) &&
      isset($authorize->LoginName) &&
      isset($authorize->RealName) &&
      isset($authorize->Type) &&
      isset($authorize->Permission) &&
      isset($authorize->Token)
    ) {
      $ret = array(
        'Id' => $authorize->Id,
        'SiteId' => $authorize->SiteId,
        'LoginName' => $authorize->LoginName,
        'RealName' => $authorize->RealName,
        'Type' => $authorize->Type,
        'Permission' => $authorize->Permission,
      );
      if ($authorize->Token == BuildSecurityValue($ret)) {
        return $ret;
      }
    }
  }

  return array(
    'Id' => 0,
    'SiteId' => 0,
    'LoginName' => '',
    'RealName' => '',
    'Type' => 0,
    'Permission' => array()
  );
}

/**
 * 检查用户是否授权
 */
function CheckAuthorized($codes)
{
  $authorize = GetAuthorize();

  if ($authorize['Id'] > 0) {
    if (empty($codes)) {                                        // 没有权限码
      return true;
    } else if (is_array($codes)) {
      foreach ($codes as $code) {
        if (!in_array($code, $authorize['Permission'])) {
          return false;
        }
      }
      return true;
    } else {                                                    // 单一权限码
      if (in_array($codes, $authorize['Permission'])) {
        return true;
      }
    }
  }

  header('HTTP/1.1 401 Unauthorized');
  header('status: 401 Unauthorized');
  return false;
}
