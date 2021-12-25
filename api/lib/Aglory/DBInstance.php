<?php

namespace Aglory;

/**
 * 数据库事例
 * @package Aglory
 */
class DBInstance
{
  private static $main = false;
  private static $log = false;

  public static function GetMain()
  {
    if (self::$main === false) {
      self::$main = new \PDO(
        ConfigInstance::PDODNS,
        ConfigInstance::PDOUSER,
        ConfigInstance::PDOPASSWORD,
        array(\PDO::MYSQL_ATTR_FOUND_ROWS => true, \PDO::ATTR_STRINGIFY_FETCHES => false, \PDO::ATTR_EMULATE_PREPARES => false)
      );
    }
    return self::$main;
  }

  public static function GetLog()
  {
    if (self::$log === false)
      self::$log = new \PDO(
        ConfigInstance::PDODNSLOG,
        ConfigInstance::PDOUSERLOG,
        ConfigInstance::PDOPASSWORDLOG,
        array(\PDO::MYSQL_ATTR_FOUND_ROWS => true, \PDO::ATTR_STRINGIFY_FETCHES => false, \PDO::ATTR_EMULATE_PREPARES => false)
      );
    return self::$log;
  }
}
