<?php
ob_start();
define('Execute', true);
if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    die('OPTIONS:Success');
  } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    die('GET:Success');
  }
}

function GetRouter()
{
  $params = func_get_args();
  if (empty($params)) return;
  $params = array_reverse($params);
  return './model/' . implode(DIRECTORY_SEPARATOR, $params) . '.php';
}

$model = "";
$action = "";
if (array_key_exists('model', $_GET)) {
  $model = $_GET['model'];
}
if (array_key_exists('action', $_GET)) {
  $action = $_GET['action'];
}

include 'config.php';

if ($model && $action) {
  $router =  GetRouter($action, $model);
  if (file_exists($router)) {
    include $router;
  }
}
