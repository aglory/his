<?php

namespace Aglory;

/**
 * 系统配置
 * @package Aglory
 */
class ConfigInstance
{
  /**
   * api通讯安全码
   */
  const AuthorizationSecurityKey = '1e7b3492-f022-11eb-9116-e0d55ecbb109';

  /**
   * 主数据库
   */
  const PDODNS = 'mysql:host=localhost;dbname=His;port=3306;charset=utf8';
  const PDOUSER = 'root';
  const PDOPASSWORD = '123456';

  /**
   * 日志据库
   */
  const PDODNSLOG = 'mysql:host=localhost;dbname=HisLog;port=3306;charset=utf8';
  const PDOUSERLOG = 'root';
  const PDOPASSWORDLOG = '123456';
}
