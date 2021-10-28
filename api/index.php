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

/**
 * 输出处理结果,并且退出程序
 */
function JsonResultSuccess(...$params)
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
function JsonResultError(...$params)
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
function JsonResultException(...$params)
{
  switch (count($params)) {
    case 2:
      JsonResultError($params[0]->getMessage(), $params[1]);
      break;
    case 1:
      JsonResultError($params[0]->getMessage());
      break;
    default:
      JsonResultError();
      break;
  }
}

$control = "";
$action = "";
if (array_key_exists('control', $_GET)) {
  $control = $_GET['control'];
}
if (array_key_exists('action', $_GET)) {
  $action = $_GET['action'];
}

include 'config.php';

if ($control && $action) {
  $router =  GetRouter($action, $control);
  if (file_exists($router)) {
    include $router;
  }
}
