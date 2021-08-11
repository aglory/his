<?php
if (!defined('Execute')) {
  exit();
}

function GetSecurityKey()
{
  return '1e7b3492-f022-11eb-9116-e0d55ecbb109';
}

function GetOperator()
{
  if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
    $operator = json_decode(str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']));
    if (
      isset($operator->Token) &&
      isset($operator->Id) &&
      isset($operator->LoginName) &&
      isset($operator->RealName) &&
      isset($operator->Type) &&
      isset($operator->Permission) &&
      $operator->SecurityKey == md5(
        $operator->Id .
          $operator->LoginName .
          $operator->RealName .
          $operator->Type .
          implode(',', $operator->Permission) .
          GetSecurityKey()
      )
    ) {
      return array(
        'Id' => $operator->Id,
        'LoginName' => $operator->LoginName,
        'RealName' => $operator->RealName,
        'Type' => $operator->Type,
        'Permission' => $operator->Permission
      );
    }
  }
  return array(
    'Id' => 0,
    'LoginName' => '',
    'RealName' => '',
    'Type' => 0,
    'Permission' => array()
  );
}

/**
 * 检查用户是否授权
 */
function CheckAuthorized($codes)
{
  $operator = GetOperator();


  if ($operator['Id'] > 0) {
    if (empty($codes)) {                                        // 没有权限码
      return $operator;
    } else if (is_array($codes)) {                              // 数组权限码
      $all = true;
      foreach ($codes as $code) {
        if (!in_array($code, $operator['Permission'])) {
          $all = false;
          break;
        }
      }
      if ($all)
        return $operator;
    } else {                                                    // 单一权限码
      if (in_array($codes, $operator['Permission'])) {
        return $operator;
      }
    }
  }

  header('HTTP/1.1 401 Unauthorized');
  header('status: 401 Unauthorized');
  return false;
}
