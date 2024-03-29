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
$authorization->CheckCode(EnumPermission::角色管理);

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
$columnGeneral = ['Id', 'Permission'];
$columnEqual  = ['SiteId'];
$columnLike  = ['Name'];
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
  }
}
$sqlWhere[] = 'SiteId = ' . $authorization->SiteId;
if ($authorization->Type == EnumAccountType::配置员) {
  $sqlWhere[] = 'IsInner = 1';
} else {
  $sqlWhere[] = 'IsInner = 0';
}

$columns = array_merge($columnGeneral, $columnEqual, $columnLike, $columnIn);
$sql = 'select SQL_CALC_FOUND_ROWS ' . implode(',', $columns) . ' from Role';
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
  $sth = $pdomysql->prepare('select FOUND_ROWS() as total;');
  $sth->execute();
  $statistics = $sth->fetch(PDO::FETCH_ASSOC);

  $permissionIds = [];
  foreach ($items as $item) {
    if (!empty($item['Permission'])) {
      $permissionIds = explode(',', $item['Permission']);
      foreach ($permissionIds as $itemPermissionId) {
        if (!in_array($itemPermissionId, $permissionIds)) {
          $permissionIds[] = $itemPermissionId;
        }
      }
    }
  }
  if (!empty($permissionIds)) {
    foreach ($items as &$item) {
      if (!empty($item['Permission'])) {
        $itemPermissionIds = explode(',', $item['Permission']);
        $permissionNames = [];
        foreach ($itemPermissionIds as $itemPermissionId) {
          foreach (EnumPermission::ToArray() as $key => $value) {
            if ($value == $itemPermissionId) {
              $permissionNames[] = $key;
            }
          }
        }
        $item['Permission'] = implode(',', $permissionNames);
      }
    }
  }
  PageHelper::JsonResultSuccess(array('PageTotal' => $statistics['total'], 'Items' => $items));
} catch (PDOException $e) {
  PageHelper::JsonResultException($e);
}
