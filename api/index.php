<?php
ob_start();
define('Execute', true);

use Aglory\PageHelper;

if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    die('OPTIONS:Success');
  }
}

function GetRouter()
{
  $params = func_get_args();
  if (empty($params)) return;
  $params = array_reverse($params);
  return './module/' . implode(DIRECTORY_SEPARATOR, $params) . '.php';
}

$control = "";
$action = "";
if (array_key_exists('control', $_GET)) {
  $control = $_GET['control'];
}
if (array_key_exists('action', $_GET)) {
  $action = $_GET['action'];
}
if ($control && $action) {
  $router =  GetRouter($action, $control);
  if (file_exists($router)) {
    /**
     * 设置时区
     */
    ini_set('date.timezone', 'Asia/Shanghai');
    include __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';
    /**
     * 记录错误日志
     */
    set_error_handler(function ($level, $message, $file, $line, $context) {
      $time = time();
      file_put_contents('./' . date('Y-m-d', $time) . '.log',  json_encode(array('time' => date('Y-m-d H:i:s', $time), 'level' => $level, 'message' => $message, 'file' => $file, 'line' => $line, 'context' => $context)) . ',', FILE_APPEND);
      PageHelper::JsonResultError('系统错误');
    });
    include $router;
  }
}
