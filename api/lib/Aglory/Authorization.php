<?php

namespace Aglory;

/**
 * 用户登录票据
 * @package Aglory
 */
class Authorization
{
  /**
   * 需要验证的属性
   */
  public $Id = 0;
  public $Depth = 0;
  public $SiteId = 0;
  public $LoginName = '';
  public $Type = 0;
  public $Permission = array();
  public $TimeSpan = 0;
  public $Token = '';

  /** 
   * 不需要验证的属性
   */
  public $RealName = '';

  /**
   * true:已登录授权,false:未登录授权
   */
  public $Authorized = false;

  public function __construct(...$params)
  {
    $this->TimeSpan = time();
    switch (count($params)) {
        // 数据库取出的数组
      case 1:
        $paramsData = $params[0];
        if (array_key_exists('Id', $paramsData))
          $this->Id = $paramsData['Id'];
        if (array_key_exists('Depth', $paramsData))
          $this->Depth = $paramsData['Depth'];
        if (array_key_exists('SiteId', $paramsData))
          $this->SiteId = $paramsData['SiteId'];
        if (array_key_exists('LoginName', $paramsData))
          $this->LoginName = $paramsData['LoginName'];
        if (array_key_exists('Type', $paramsData))
          $this->Type = $paramsData['Type'];
        if (array_key_exists('Permission', $paramsData) && is_array($paramsData['Permission']))
          $this->Permission = $paramsData['Permission'];
        if (array_key_exists('TimeSpan', $paramsData))
          $this->TimeSpan = $paramsData['TimeSpan'];

        $this->Token = $this->BuildTeken();
        $this->Token = json_encode($this);

        if (array_key_exists('RealName', $paramsData))
          $this->RealName = $paramsData['RealName'];
        break;
      default:
        // 浏览器传入的Token;
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
          $jsonData = json_decode(str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']));
          if (isset($jsonData->Id))
            $this->Id = $jsonData->Id;
          if (isset($jsonData->Depth))
            $this->Depth = $jsonData->Depth;
          if (isset($jsonData->SiteId))
            $this->SiteId = $jsonData->SiteId;
          if (isset($jsonData->LoginName))
            $this->LoginName = $jsonData->LoginName;
          if (isset($jsonData->Type))
            $this->Type = $jsonData->Type;
          if (isset($jsonData->Permission) && is_array($jsonData->Permission))
            $this->Permission = $jsonData->Permission;
          if (isset($jsonData->TimeSpan))
            $this->TimeSpan = $jsonData->TimeSpan;
          if (isset($jsonData->Token))
            $this->Token = $jsonData->Token;

          $this->Authorized = $this->Token === $this->BuildTeken();
        }
        break;
    }
  }


  /**
   * 建立通讯Token明文
   */
  private function BuildTeken()
  {
    $params = [$this->Id, $this->Depth, $this->SiteId, $this->LoginName, $this->Type, implode(',', $this->Permission), $this->TimeSpan, ConfigInstance::AuthorizationSecurityKey];
    return md5(implode('', $params));
  }


  /**
   * 检查用户是否授权
   */
  public function CheckCode(...$codes)
  {
    if ($this->Authorized) {
      if (empty($codes)) {                                        // 没有权限码
        return;
      } else {
        $success = true;
        foreach ($codes as $code) {
          if (!in_array($code, $this->Permission)) {
            $success = false;
            break;
          }
        }
        if ($success)
          return;                                                 // 用户有权限码
      }
    }

    header('HTTP/1.1 401 Unauthorized');
    header('status: 401 Unauthorized');
    exit();
  }

  /**
   * 检查用户类型是否为确定类型
   */
  public function CheckType(...$types)
  {
    if ($this->Authorized) {
      if (empty($types)) {
        return;
      } else if (in_array($this->Type, $types)) {
        return;
      }
    }

    header('HTTP/1.1 401 Unauthorized');
    header('status: 401 Unauthorized');
    exit();
  }
}
