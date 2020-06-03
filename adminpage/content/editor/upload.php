<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}

$type = GetGetParam('Type', 0);

$dir = '.' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'content';
if (!file_exists($dir))
	mkdir($dir);
$dir = $dir . DIRECTORY_SEPARATOR . 'type' . $type;
if (!file_exists($dir))
	mkdir($dir);
$dir = $dir . DIRECTORY_SEPARATOR;
$url = '';
$exts = array('.git', '.png', '.bmp', '.jpg');
$errors = '';
if (count($_FILES) == 1) {
	$uploadFile;
	foreach ($_FILES as $file) {
		$uploadFile = $file;
		break;
	}
	$ext = GetFileExtense($uploadFile['name']);
	$sourceFile = $uploadFile['tmp_name'];
	if (in_array($ext, $exts)) {
		$mt = explode(' ', microtime());
		$filename = $mt[1] . $mt[0] . $ext;
		$descFile = $dir . $filename;
		copy($sourceFile, $descFile);
		$url = str_replace(DIRECTORY_SEPARATOR, '/', ltrim($descFile, '.'));
	} else {
		$errors = $ext . '类型的文件不能上传';
	}
}
if (empty($errors)) {
	die(json_encode(array(
		'error' => 0,
		'url' => $url
	)));
} else {
	die(json_encode(array(
		'error' => 1,
		'message' => $errors
	)));
}
