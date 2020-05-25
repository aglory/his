<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}

header('Content-type: application/json');

include './config.php';
$id = intval(GetPostParam('Id', 0));
$type = intval(GetPostParam('Type', 0));
if (!$id && !in_array($type, array(1, 2))) {
    die(json_encode(array('Success' => false, 'Message' => '参数错误')));
}

$index = intval(GetPostParam('Index', 0));
$title = GetPostParam('Title', '');
$content = GetPostParam('Content', '');
$createdate = GetPostParam('CreateDate', '');
if (empty($createdate))
    $createdate = date_format(date_create(), "Y-m-d H:i:s");

if ($id) {
    $sth = $pdo->prepare('update `content` set Title = :Title, `Index` = :Index, Content = :Content, CreateDate = :CreateDate where Id = :Id;');
    $params = array(
        'Id' => $id,
        'Title' => $title,
        'Index' => $index,
        'Content' => $content,
        'CreateDate' => $createdate
    );
} else {
    $sth = $pdo->prepare('insert into `content` (Type, Title, Images, `Index`, Content, Status, ViewCount, CreateDate)values(:Type, :Title, :Images, :Index, :Content, :Status, :ViewCount, :CreateDate);');
    $params = array(
        'Type' => $type,
        'Title' => $title,
        'Images' => '',
        'Index' => $index,
        'Content' => $content,
        'Status' => 1,
        'ViewCount' => 0,
        'CreateDate' => $createdate
    );
}
$sth->execute($params);
$error = $sth->errorInfo();
if (empty($error[2])) {
    die(json_encode(array('Success' => true)));
} else {
    die(json_encode(array('Success' => false, 'Error' => $error[2])));
}
