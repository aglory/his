<?php
ob_start();

include_once './general.php';

$model = GetGetParam('model', 'index');
$action = GetGetParam('action', 'index');

define('Execute', true);
$fileLocation = GetFileLocation(array($action, $model));
if (!file_exists($fileLocation)) {
	/**默认一定存在的模块方法 */
	$model = "index";
	$action = "index";
	$fileLocation = GetFileLocation(array($action, $model));
}

define('Model', $model);
define('Action', $action);

Render($action, $model);
