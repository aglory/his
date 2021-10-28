<?php
if (!defined('Execute')) {
  exit();
}

/**
 * api通讯安全码
 */
define('Authorize_Security_Key', '1e7b3492-f022-11eb-9116-e0d55ecbb109');

/**
 * 主数据库
 */
define('PDO_DNS', 'mysql:host=localhost;dbname=His;port=3306;charset=utf8');
define('PDO_USER', 'root');
define('PDO_PASSWORD', '123456');

/**
 * 日志据库
 */
define('PDO_DNS_LOG', 'mysql:host=localhost;dbname=HisLog;port=3306;charset=utf8');
define('PDO_USER_LOG', 'root');
define('PDO_PASSWORD_LOG', '123456');

/**
 * 设置时区
 */
ini_set('date.timezone', 'Asia/Shanghai');
