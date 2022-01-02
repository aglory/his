<?php
if (!defined('Execute')) {
  exit();
}

use Aglory\Authorization;
use Aglory\DBInstance;
use Aglory\EnumAccountType;
use Aglory\EnumPermission;
use Aglory\PageHelper;

$authorization = new Authorization();
$authorization->CheckCode(EnumPermission::流水管理);

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
$columnGeneral = ['Id', 'MemberId', 'Amount', 'Balance', 'Remark', 'CreateTime'];
$columnEqual  = ['SiteId'];
$columnLike  = ['OperatorLoginName', 'MemberName', 'MemberTel'];
$columnIn = ['Type', 'TypeSign',];

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
  }
}
if ($authorization->Type != EnumAccountType::配置员) {
  $sqlWhere[] = 'SiteId = ' . $authorization->SiteId;
}
if ($authorization->Type == EnumAccountType::操作员) {
  $sqlWhere[] = 'OperatorId = ' . $authorization->Id;
}

$columns = array_merge($columnGeneral, $columnEqual, $columnLike, $columnIn);
$sql = 'select SQL_CALC_FOUND_ROWS ' . implode(',', $columns) . ' from ViewMemberBalanceHistory';
if (count($sqlWhere)) {
  $sql = $sql . ' where ' . implode(' and ', $sqlWhere);
}
if (in_array($pageColumn, $columns)) {
  $sql = $sql . ' order by ' . $pageColumn . ($pageOrderBy == 'descend' ? ' desc' : ' asc');
}
$sql = $sql . " limit $pageStart, $pageSize;";

try {
  if (empty($pdomysql))
    $pdomysql = DBInstance::GetMain();
  $sth = $pdomysql->prepare($sql);
  $sth->execute($sqlParams);
  $items = $sth->fetchAll(PDO::FETCH_ASSOC);
  $sql = 'select count(1) as total,sum(Amount * TypeSign) Amount from ViewMemberBalanceHistory';
  if (count($sqlWhere)) {
    $sql = $sql . ' where ' . implode(' and ', $sqlWhere);
  }
  $sql = $sql . ';';
  $sth = $pdomysql->prepare($sql);
  $sth->execute($sqlParams);
  $statistics = $sth->fetch(PDO::FETCH_ASSOC);

  PageHelper::JsonResultSuccess(array('PageTotal' => $statistics['total'], 'Items' => $items, 'Amount' => $statistics['Amount']), $sql);
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
