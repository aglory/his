<?php
ob_start();

if (!defined('DIRECTORY_SEPATRATOR')) define('DIRECTORY_SEPATRATOR', '/');

//#region 枚举

const EnumContentStatus = array(1 => '启用', 2 => '停用');
const EnumContentTyp = array(1 => "综合新闻", 2 => "联盟新闻", 3 => "产业研究", 4 => "通知通告", 5 => "人才培养", 6 => "院内动态", 7 => "申报公告", 8 => "联盟公告");

//#endregion

function ActionLink()
{
	$params = func_get_args();
	if (!is_array($params))
		return;

	$action = '';
	$model = '';
	$opts = null;
	$echo = true;
	switch (count($params)) {
		case 4:
			$echo = $params[3];
		case 3:
			$opts = $params[2];
		case 2:
			$model = $params[1];
		case 1:
			$action = $params[0];
	}


	$result = array();
	$result[] = 'model=' . urlencode($model);
	$result[] = 'action=' . urlencode($action);
	if (!empty($opts)) {
		foreach ($opts as $k => $v) {
			$result[] = $k . '=' . urlencode($v);
		}
	}
	if ($echo)
		echo '?' . implode('&', $result);
	else
		return '?' . implode('&', $result);
}

function Render()
{
	$params = func_get_args();
	if (empty($params) || !is_array($params)) return;
	$fileLocation = GetFileLocation($params);
	if (!empty($fileLocation)) {
		include $fileLocation;
	}
}

function GetFileLocation($params)
{
	if (empty($params) || !is_array($params)) return '';

	if (!defined('SOURCE_DIR'))
		$source_dir = 'page';
	else
		$source_dir = SOURCE_DIR;

	switch (count($params)) {
		case 3:
			return './' . $source_dir . '/' . $params[1] . '/' . $params[0] . '/' . $params[2] . '.php';
		case 2:
			return './' . $source_dir . '/' . $params[1] . '/' . $params[0] . '/index.php';
		case 1:
			return './' . $source_dir . '/' . $params[0] . '.php';
	}

	return '';
}


function LoadClass()
{
	$params = func_get_args();
	if (empty($params)) return;
	include_once './class/' . implode(DIRECTORY_SEPATRATOR, $params) . '.class.php';
}

function GetGetParam($key, $default)
{
	if (array_key_exists($key, $_GET)) {
		return $_GET[$key];
	} else {
		return $default;
	}
}

function GetPostParam($key, $default)
{
	if (array_key_exists($key, $_POST)) {
		return $_POST[$key];
	} else {
		return $default;
	}
}

function GetFileParam($key)
{
	if (array_key_exists($key, $_FILES)) {
		return $_FILES[$key];
	} else {
		return null;
	}
}

function GetSession($key, $default)
{
	if (array_key_exists($key, $_SESSION)) {
		return $_SESSION[$key];
	} else {
		return $default;
	}
}

function IsAjax()
{
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

function isMobile()
{
	// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
	if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
		return true;
	}
	// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息

	if (isset($_SERVER['HTTP_VIA'])) {
		return true;
		// 找不到为flase,否则为true
		//return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
	}
	// 脑残法，判断手机发送的客户端标志,兼容性有待提高
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$clientkeywords = array(
			'nokia',
			'sony',
			'ericsson',
			'mot',
			'samsung',
			'htc',
			'sgh',
			'lg',
			'sharp',
			'sie-',
			'philips',
			'panasonic',
			'alcatel',
			'lenovo',
			'iphone',
			'ipod',
			'blackberry',
			'meizu',
			'android',
			'netfront',
			'symbian',
			'ucweb',
			'windowsce',
			'palm',
			'operamini',
			'operamobi',
			'openwave',
			'nexusone',
			'cldc',
			'midp',
			'wap',
			'mobile',
			'android'
		);
		// 从HTTP_USER_AGENT中查找手机浏览器的关键字
		if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
			return true;
		}
	}
	// 协议法，因为有可能不准确，放到最后判断
	if (isset($_SERVER['HTTP_ACCEPT'])) {
		// 如果只支持wml并且不支持html那一定是移动设备
		// 如果支持wml和html但是wml在html之前则是移动设备
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
			return true;
		}
	}
	return false;
}

function isDebug()
{
	return $_SERVER['REMOTE_HOST'] == "127.0.0.1";
}

//#region SqlBuilder

/**
 * @matchType number 匹配方式(1=> 精确匹配, 2 => 匹配开始, 3 => 匹配结束, 4 => 模糊匹配)
 * @return array(0 => sql字符串, 1 => sql值)
 */
function BuildSafeSqlMatchType($matchType, $columnName, $columnValue)
{
	switch ($matchType) {
		case 2:
			return array("$columnName like :$columnName", $columnValue . '%');
		case 3:
			return array("$columnName like :$columnName", '%' . $columnValue);
		case 4:
			return array("$columnName like :$columnName", '%' . $columnValue . '%');
		default:
			return array("$columnName = :$columnName",  $columnValue);
	}
}


function BuildSafeSqlOrderBy($pdo, $table, $pageOrderBy)
{
	$sth = $pdo->prepare("desc $table;");
	$sth->execute();
	$columns = $sth->fetchAll(PDO::FETCH_ASSOC);
	$pageOrderBys = explode(",", $pageOrderBy);
	$validColumns = array();
	foreach ($columns as $column) {
		foreach ($pageOrderBys as $item) {
			if ($column['Field'] . ' desc' == $item) {
				$validColumns[] = "`" . $column['Field'] . "`" . " desc";
				break;
			} else if ($column['Field'] . ' asc' == $item) {
				$validColumns[] = "`" . $column['Field'] . "`" . " asc";
				break;
			}
		}
	}

	return implode(",", $validColumns);
}

//#endregion
