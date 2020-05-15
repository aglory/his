<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}

header('Content-type: application/json');

include './config.php';
$sql = 'SELECT * FROM `content` where name = :Name;';
$params  = array();
$sth = $pdo->prepare($sql);
$sth->execute($params);
$users = $sth->fetchAll(PDO::FETCH_ASSOC);
