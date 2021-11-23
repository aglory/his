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
    '员工' => 4
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
    '现金管理' => 9,
  );
}

function GetEnumProductType()
{
  return array(
    '一般产品' => 1,
  );
}

/**
 * 用户余额交易枚举
 */
function GetEnumMemberBalanceTransactionType()
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

/**
 * 用户积分交易枚举
 */
function GetEnumMemberIntegralTransactionType()
{
  return array(
    /**
     * TypeSign = 1
     */
    '上分' => 1,
    /**
     * TypeSign = -1
     */
    '下分' => 2,
    /**
     * TypeSign = 1
     */
    '购物积分' => 3,
    /**
     * TypeSign = -1
     */
    '积分支付' => 4,
  );
}

/**
 * 用户余额交易枚举
 */
function GetEnumMemberCashTransactionType()
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

/**
 * 企业现金交易枚举
 */
function GetEnumEnterpriseCashTransactionType()
{
  return array(
    /**
     * TypeSign = 1
     */
    '充值' => 1,
    /**
     * TypeSign = 1
     */
    '消费' => 2,
  );
}

/**
 * 支付状态
 */
function GetEnumPayStatus()
{
  return array(
    '未支付' => 1,
    '付款中' => 2,
    '已支付' => 3,
    '已退款' => 4,
  );
}

/**
 * 渲染枚举值对应的Key
 */
function RenderEnum($enum, $val, $default = '-')
{
  foreach ($enum as $k => $v) {
    if ($v === $val) {
      return $k;
    }
  }
  return $default;
}
