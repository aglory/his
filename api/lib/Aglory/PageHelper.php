<?php

namespace Aglory;


/**
 * 页面帮助处理类
 * @package Aglory
 */
class PageHelper
{

  /**
   * 输出处理结果,并且退出程序
   */
  static function JsonResultSuccess(...$params)
  {
    header('Content-Type:application/json;');
    switch (count($params)) {
      case 2:
        echo json_encode(array('Result' => true, 'Data' => $params[0], 'Debuger' => $params[1]));
        break;
      case 1:
        echo json_encode(array('Result' => true, 'Data' => $params[0]));
        break;
      default:
        echo json_encode(array('Result' => true));
        break;
    }
    exit();
  }

  /**
   * 输出错误信息,并且退出程序
   */
  static  function JsonResultError(...$params)
  {
    header('Content-Type:application/json;');
    switch (count($params)) {
      case 2:
        echo json_encode(array('Result' => false, 'Message' => $params[0], 'Debuger' => $params[1]));
        break;
      case 1:
        echo json_encode(array('Result' => false, 'Message' => $params[0]));
        break;
      default:
        echo json_encode(array('Result' => false));
        break;
    }
    exit();
  }

  /**
   * 输出异常,并且退出程序 
   */
  static  function JsonResultException(...$params)
  {
    switch (count($params)) {
      case 2:
        self::JsonResultError($params[0]->getMessage(), $params[1]);
        break;
      case 1:
        self::JsonResultError($params[0]->getMessage());
        break;
      default:
        self::JsonResultError();
        break;
    }
  }
}
