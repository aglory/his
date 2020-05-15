<?php

ob_start();
session_start();

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


define('Model', $model);
define('Action', $action);

Render($action, $model);
