<?php
if (!defined('Execute')) {
  exit();
}
include_once './lib/account.php';
include_once './lib/enum.php';
$enumPermission = GetEnumPermission();
CheckAuthorized($enumPermission['产品管理']);
$authorize = GetAuthorize();
$enumAccountType = GetEnumAccountType();

// 分页统一参数
$pageIndex = 1;
$pageSize = 50;
$pageColumn = 'Id';
$pageOrderBy = 'descend';

if (array_key_exists('PageIndex', $_POST)) {
  $pageIndex = intval($_POST['PageIndex']);
}
if (array_key_exists('PageSize', $_POST)) {
  $pageSize = intval($_POST['PageSize']);
}
if (array_key_exists('PageColumn', $_POST)) {
  $pageColumn = $_POST['PageColumn'];
}
if (array_key_exists('PageOrderBy', $_POST)) {
  $pageOrderBy = $_POST['PageOrderBy'];
}
$pageStart = $pageIndex > 0 ? ($pageIndex - 1) * $pageSize : 0;

// 自定义查询条件
$columnGeneral = ['Id', 'MarketPrice', 'Price', 'SettlementPrice', 'SaleCopies', 'BaseCopies', 'SortCopies', 'OrderIndex', 'CreateTime'];
$columnEqual  = ['SiteId'];
$columnLike  = ['ShortName', 'FullName'];
$columnIn = ['Type','IsLocked'];

$sqlWhere = [];
$sqlParams = [];
foreach ($_POST as $key => $value) {
  if (in_array($key, $columnEqual)) {
    $sqlWhere[] = "`$key` = :$key";
    $sqlParams[$key] = "%$value%";
  } else if (in_array($key, $columnLike)) {
    $sqlWhere[] = "`$key` like :$key";
    $sqlParams[$key] = "%$value%";
  } else if (in_array($key, $columnIn) && is_array($value)) {
    $sqlWhere[] = "`$key` in(" . implode(',', array_map(function ($item) {
      return intval($item);
    }, $value)) . ")";
  } else if ($key == 'CreateTime' && count($value) == 2) {
    if (preg_match('/^(\w{4})-(\w{2})-(\w{2})/', $value[0], $matches)) {
      $sqlWhere[] = 'CreateTime >= :CreateTimeStart';
      $sqlParams['CreateTimeStart'] = $matches[0];
    }
    if (preg_match('/^(\w{4})-(\w{2})-(\w{2})/', $value[1], $matches)) {
      $sqlWhere[] = 'CreateTime <= adddate(:CreateTimeEnd, interval 1 day)';
      $sqlParams['CreateTimeEnd'] = $matches[0];
    }
  }
}
if ($authorize['Type'] == $enumAccountType['配置员']) {
  $sqlWhere[] = 'Type = ' . $enumAccountType['管理员'];
} else {
  $sqlWhere[] = 'Type = ' . $enumAccountType['系统用户'];
  $sqlWhere[] = 'SiteId = ' . $authorize['SiteId'];
}
$sqlWhere[] = 'Id <> ' . $authorize['Id'];

$columns = array_merge($columnGeneral, $columnEqual, $columnLike, $columnIn);
$sql = 'select SQL_CALC_FOUND_ROWS ' . implode(',', $columns) . ' from Product';
if (count($sqlWhere)) {
  $sql = $sql . ' where ' . implode(' and ', $sqlWhere);
}
if (in_array($pageColumn, $columns)) {
  $sql = $sql . ' order by ' . $pageColumn . ($pageOrderBy == 'descend' ? ' desc' : ' asc');
}
$sql = $sql . " limit $pageStart, $pageSize;";
include_once './lib/pdo.php';

try {
  if (empty($pdomysql))
    $pdomysql = GetPDO();
  $sth = $pdomysql->prepare($sql);
  $sth->execute($sqlParams);
  $items = $sth->fetchAll(PDO::FETCH_ASSOC);
  $sth = $pdomysql->prepare('select FOUND_ROWS() as total;');
  $sth->execute();
  $statistics = $sth->fetch(PDO::FETCH_ASSOC);
  JsonResultSuccess(array('PageTotal' => $statistics['total'], 'Items' => $items));
} catch (PDOException $e) {
  JsonResultException($e);
}
