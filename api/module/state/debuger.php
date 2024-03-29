<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;

$authorization = new Authorization();
$authorization->CheckCode();
include_once './lib/pdo.php';

if (empty($pdomysql))
  $pdomysql = DBInstance::GetMain();

$sth = $pdomysql->prepare("select id, name from debugger;");
$sth -> execute();
$items = $sth->fetchAll(PDO::FETCH_ASSOC);

$sthUpdate = $pdomysql->prepare("update debugger set id = :newId where id = :oldId;");
foreach ($items as $item) {
	$ids = explode('_', $item['id']);
	$id = $ids[count($ids)-1];
	echo json_encode($ids), $id,'<br />';
	$sthUpdate  -> execute(array('oldId' => $item['id'],'newId' => $id));
}

