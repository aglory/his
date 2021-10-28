<?php
if (!defined('Execute')) {
  exit();
}

/**
 * 用户枚举
 */
function GetEnumAccountType()
{
  return array(
    '配置员' => 1,
    '管理员' => 2,
    '系统用户' => 4
  );
}

/**
 * 权限枚举
 */
function GetEnumPermission()
{
  return array(
    '帐号管理' => 1,
    '角色管理' => 2,
    '站点管理' => 3,
    '公告管理' => 4,
    '会员管理' => 5,
    '产品管理' => 6,
    '订单管理' => 7,
    '流水管理' => 8,
  );
}

function GetEnumProductType()
{
  return array(
    '一般产品' => 1,
  );
}

/**
 * 用户交易枚举
 */
function GetEnumMemberTransactionType()
{
  return array(
    /**
     * TypeSign = 1
     */
    '用户充值' => 1,
    /**
     * TypeSign = -1
     */
    '用户消费' => 2,
  );
}
