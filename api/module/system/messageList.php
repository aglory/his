<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
CheckAuthorized();
$authorize = GetAuthorize();

include_once './lib/pdo.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  $sql = 'select  Id, Title, Content from Message where IsLocked = false and SiteId = :SiteId order by Id desc;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':SiteId', $authorize['SiteId'], PDO::PARAM_INT);
  $sth->execute();
  $items = $sth->fetchAll(PDO::FETCH_ASSOC);
  JsonResultSuccess($items);
} catch (PDOException $e) {
  JsonResultException($e);
}
