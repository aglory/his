<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode();

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();
  $sql = 'select  Id, Title, Content from Message where IsLocked = false and SiteId = :SiteId order by Id desc;';
  $sth = $pdomysql->prepare($sql);
  $sth->bindValue(':SiteId', $authorization->SiteId, PDO::PARAM_INT);
  $sth->execute();
  $items = $sth->fetchAll(PDO::FETCH_ASSOC);
  PageHelper::JsonResultSuccess($items);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
