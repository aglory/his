<?php
ob_start();
session_start();

//#region admin公共函数

const EnumMatchType = array(1 => '精确匹配', 2 => '匹配开始', 3 => '匹配结束', 4 => '模糊匹配');

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

/**
 * curl远程请求
 */
function GetCurl($url, $method, $data)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	if ($method == 'GET') {
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
	$headerArray = array('user-agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36;');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
}

/**
 * 权限验证
 */
function ValidatePermission($permission)
{
	return in_array($permission,	explode(',', $_SESSION['UserNamePermissions']));
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
