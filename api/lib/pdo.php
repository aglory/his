<?php
if (!defined('Execute')) {
  exit();
}

/**
 * PDO 主数据库
 */
function GetPDO()
{
  return new PDO(
    PDO_DNS,
    PDO_USER,
    PDO_PASSWORD,
    array(PDO::MYSQL_ATTR_FOUND_ROWS => true, PDO::ATTR_STRINGIFY_FETCHES => false, PDO::ATTR_EMULATE_PREPARES => false)
  );
}

/**
 *  PDO 日志据库
 */
function GetPDOLOG()
{
  return new PDO(
    PDO_DNS_LOG,
    PDO_USER_LOG,
    PDO_PASSWORD_LOG,
    array(PDO::MYSQL_ATTR_FOUND_ROWS => true, PDO::ATTR_STRINGIFY_FETCHES => false, PDO::ATTR_EMULATE_PREPARES => false)
  );
}
