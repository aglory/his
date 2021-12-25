<?php
ob_start();
define('Execute', true);

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
    include $router;
  }
}
