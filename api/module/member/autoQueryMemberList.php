<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['订单管理']);
$enumAccountType = GetEnumAccountType();
CheckWidthOutAuthorizeType($enumAccountType['配置员']);
$authorize = GetAuthorize();

// 自定义查询条件
$columnGeneral = ['Id', 'Name', 'Tel', 'CreateTime'];
$columnEqual  = [];
$columnLike  = [];
$columnIn = [];

$sqlWhere = [];
$sqlParams = [];
foreach ($_POST as $key => $value) {
  if (in_array($key, $columnEqual)) {
    if (strlen($value)) {
      $sqlWhere[] = "`$key` = :$key";
      $sqlParams[$key] = $value;
    }
  } else if (in_array($key, $columnLike)) {
    $sqlWhere[] = "`$key` like :$key";
    $sqlParams[$key] = "%$value%";
  } else if (in_array($key, $columnIn) && is_array($value)) {
    $sqlWhere[] = "`$key` in(" . implode(',', array_map(function ($item) {
      return intval($item);
    }, $value)) . ")";
  } else if ($key == 'CreateTime' && count($value) == 2) {
    if (preg_match('/^(\w{4})-(\w{2})-(\w{2}) (\w{2}):(\w{2}):(\w{2})/', $value[0], $matches)) {
      $sqlWhere[] = 'CreateTime >= :CreateTimeStart';
      $sqlParams['CreateTimeStart'] = $matches[0];
    }
    if (preg_match('/^(\w{4})-(\w{2})-(\w{2}) (\w{2}):(\w{2}):(\w{2})/', $value[1], $matches)) {
      $sqlWhere[] = 'CreateTime < :CreateTimeEnd';
      $sqlParams['CreateTimeEnd'] = $matches[0];
    }
  } else if ($key == 'Keyword') {
    $sqlWhere[] = '(Name like :Name or Tel like :Tel)';
    $sqlParams['Name'] = "%$value%";
    $sqlParams['Tel'] = "%$value%";
  }
}
$sqlWhere[] = 'IsLocked = false';
$sqlWhere[] = 'SiteId = ' . $authorize['SiteId'];

$columns = array_merge($columnGeneral, $columnEqual, $columnLike, $columnIn);
$sql = 'select ' . implode(',', $columns) . ' from `Member`';
if (count($sqlWhere)) {
  $sql = $sql . ' where ' . implode(' and ', $sqlWhere);
}

// 分页统一参数
$sql = $sql . ' order by length(Name) asc limit 0, 20;';
include_once './lib/pdo.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  $sth = $pdomysql->prepare($sql);
  $sth->execute($sqlParams);
  $items = $sth->fetchAll(PDO::FETCH_ASSOC);

  JsonResultSuccess($items);
} catch (PDOException $e) {
  JsonResultException($e);
}
