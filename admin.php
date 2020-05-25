<?php

ob_start();
session_start();

//#region admin公共函数

/**
 * 根据文件名得到对应后缀(包含点号)
 */
function GetFileExtense($filename)
{
	$matches = array();
	if (preg_match('/(\.\w+)$/i', $filename, $matches)) {
		return $matches[1];
	} else {
		return $filename;
	}
}

//#endregion

include_once './general.php';

$model = GetGetParam('model', 'index');
$action = GetGetParam('action', 'index');
$parital = GetGetParam('parital', 'index');

define('Execute', true);
define('IsAdmin', true);
define('SOURCE_DIR', 'adminpage');
//StatusCode
if ($model != 'login' && empty(GetSession('UserName', ''))) {
	if (IsAjax()) {
		$ret = array('StatusCode' => 401);
		header("Content-Type: text/application;charset=utf-8");
		die(json_encode($ret));
	} else {
		$model = 'login';
		$action = 'login';
	}
}

$fileLocation = GetFileLocation(array($action, $model, $parital));
if (!file_exists($fileLocation)) {
	/**默认一定存在的模块方法 */
	$model = 'login';
	$action = 'login';
	$fileLocation = GetFileLocation(array($action, $model, $parital));
}

if (isDebug()) {
	file_put_contents("./log.txt", "\r\n" . json_encode(
		array(
			'POST' => $_POST,
			'GET' => $_GET,
			'File' => $_FILES,
			'model' => $model,
			'action' => $action,
			'parital' => $parital
		)
	), FILE_APPEND);
}

define('Model', $model);
define('Action', $action);

Render($action, $model, $parital);
