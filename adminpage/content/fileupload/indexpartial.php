<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}

header('Content-type: application/json');

include './config.php';
$id = intval(GetPostParam('Id', 0));
$params = array('Id' => $id);

$dir = '.' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'content';
if (!file_exists($dir))
    mkdir($dir);
$dir = $dir . DIRECTORY_SEPARATOR . $id;
if (!file_exists($dir))
    mkdir($dir);
$dir = $dir . DIRECTORY_SEPARATOR;
$newImages = array();
for ($i = 0; $i < 10; $i++) {
    $sourceFile = '';
    $ext = '';
    $uploadFile = GetFileParam('file' . $i);
    $postFilename = GetPostParam('filename' . $i, '');
    if (!empty($uploadFile)) {
        $ext = GetFileExtense($uploadFile['name']);
        $sourceFile = $uploadFile['tmp_name'];
    } else if (!empty($postFilename)) {
        $ext = GetFileExtense($postFilename);
        $sourceFile =  '.' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $postFilename;
    }
    if (!empty($ext) && !empty($sourceFile)) {
        $filename = $i . $ext;
        $newImages[] = $filename;
        $descFile = $dir . $filename;
        if ($descFile != $sourceFile && file_exists($sourceFile)) {
            copy($sourceFile, $descFile);
        }
    } else {
        break;
    }
}

$params['Images'] = implode(',', $newImages);
$sth = $pdo->prepare('update `content` set Images = :Images where Id = :Id;');
$sth->execute($params);
$error = $sth->errorInfo();
if (empty($error[2])) {
    die(json_encode(array('Success' => true)));
} else {
    die(json_encode(array('Success' => false, 'Error' => $error[2])));
}
