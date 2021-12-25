<?php

namespace Aglory;

/**
 * 权限枚举
 */
class EnumPermission
{
  const 帐号管理 = 1;
  const 角色管理 = 2;
  const 站点管理 = 3;
  const 公告管理 = 4;
  const 会员管理 = 5;
  const 产品管理 = 6;
  const 订单管理 = 7;
  const 流水管理 = 8;
  const 现金管理 = 9;

  static function ToArray()
  {
    return array(
      '帐号管理' => self::帐号管理,
      '角色管理' => self::角色管理,
      '站点管理' => self::站点管理,
      '公告管理' => self::公告管理,
      '会员管理' => self::会员管理,
      '产品管理' => self::产品管理,
      '订单管理' => self::订单管理,
      '流水管理' => self::流水管理,
      '现金管理' => self::现金管理,
    );
  }
}

/**
 * 用户枚举
 */
class EnumAccountType
{
  const 配置员 = 1;
  const 管理员 = 2;
  const 操作员 = 4;
}

/**
 * 产品枚举
 */
class EnumProductType
{
  const 一般产品 = 1;
}

/**
 * 用户余额交易枚举
 */
class EnumMemberBalanceTransactionType
{
  /**
   * TypeSign = 1
   */
  const 用户充值 = 1;
  /**
   * TypeSign = -1
   */
  const 用户消费 = 2;
}

/**
 * 用户积分交易枚举
 */
class EnumMemberIntegralTransactionType
{
  /**
   * TypeSign = 1
   */
  const  上分 = 1;
  /**
   * TypeSign = -1
   */
  const 下分 = 2;
  /**
   * TypeSign = 1
   */
  const 购物积分 = 3;
  /**
   * TypeSign = -1
   */
  const 积分支付 = 4;
}

/**
 * 用户余额交易枚举
 */
class EnumMemberCashTransactionType
{
  /**
   * TypeSign = 1
   */
  const 用户充值 = 1;
  /**
   * TypeSign = -1
   */
  const 用户消费 = 2;
}

/**
 * 企业现金交易枚举
 */
class EnumEnterpriseCashTransactionType
{
  /**
   * TypeSign = 1
   */
  const 充值 = 1;
  /**
   * TypeSign = 1
   */
  const 消费 = 2;
}

/**
 * 支付状态
 */
class EnumPayStatus
{
  const 未支付 = 1;
  const 付款中 = 2;
  const 已支付 = 3;
  const 已退款 = 4;
}
