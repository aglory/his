import { BasicQueryFilter } from '../../model/baseModel';
import { EnumPayStatus } from '/@/enums/serviceEnum';

/**
 * @description: 订单管理 请求对象
 */
export interface OrderManagerRequest extends BasicQueryFilter {
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 流水号
   */
  No: string;
  /**
   * 操作人帐号
   */
  OperatorLoginName: string;
  /**
   * 会员帐号
   */
  MemberName: string;
  /**
   * 会员   */
  MemberTel: string;
  /**
   * 创建时间
   */
  CreateTime: string[];
}

/**
 * @description: 订单管理 响应对象
 */
export interface OrderManagerResponse {
  /**
   * 订单id
   */
  Id: number;
  /**
   * 会员Id
   */
  MemberId: number;
  /**
   * 会员姓名
   */
  MemberName: string;
  /**
   * 会员   */
  MemberTel: string;
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 总金额
   */
  Amount: number;
  /**
   * 优惠金额
   */
  PreferenceAmount: number;
  /**
   * 余额支付
   */
  BalanceAmount: number;
  /**
   * 积分支付
   */
  IntegralAmount: number;
  /**
   * 在线支付
   */
  OnlineAmount: number;
  /**
   * 现金支付
   */
  CashAmount: number;
  /**
   * 产生积分
   */
  ProduceIntegral: number;
  /**
   * 变动后余额
   */
  Balance: number;
  /**
   * 备注
   */
  Remark: string;
  /**
   * 支付状态
   */
  PayStatus: EnumPayStatus;
  /**
   * 创建时间
   */
  CreateTime: string;
}
/**
 *  @description: 订单编辑 响应对象
 */
export interface OrderEditorResponse {
  /**
   * 订单id
   */
  Id: number;
  /**
   * 订单号
   */
  No: string;

  /**
   * 操作人登录账号
   */
  OperatorLoginName: string;
  /**
   * 会员Id
   */
  MemberId: number;
  /**
   * 会员姓名
   */
  MemberName: string;
  /**
   * 会员   */
  MemberTel: string;
  /**
   * 备注
   */
  Remark: string;
  /**
   * 支付状态
   */
  PayStatus: EnumPayStatus;
  /**
   * 创建时间
   */
  CreateTime: string;

  /**
   * 订单项 列表
   */
  Items: Array<OrderItemEditorResponse>;
}

/**
 *  @description: 编辑订单项 响应对象
 */
export interface OrderItemEditorResponse {
  /**
   * 产品Id
   */
  ProductId: number;
  /**
   * 产品名称(简称)
   */
  ProductShortName: string;
  /**
   * 购买数量
   */
  Copies: number;
}

/**
 *  @description: 保存订单 请求对象
 */
export interface OrderSaveRequest {
  /**
   * 订单id
   */
  Id: number;
  /**
   * 会员Id
   */
  MemberId: number;
  /**
   * 产品
   */
  Products: Array<{ Id: number; Copies: number }>;
  /**
   * 备注
   */
  Remark: string;
}

/**
 *  @description: 编辑账单 响应对象
 */
export interface OrderPayEditorResponse {
  /**
   * 订单id
   */
  Id: number;
  /**
   * 会员Id
   */
  MemberId: number;
  /**
   * 总金额
   */
  Amount: number;
  /**
   * 优惠金额
   */
  PreferenceAmount: number;

  /**
   * 余额支付
   */
  BalanceAmount: number;
  /**
   * 积分支付
   */
  IntegralAmount: number;
  /**
   * 在线支付
   */
  OnlineAmount: number;
  /**
   * 现金支付
   */
  CashAmount: number;
  /**
   * 产生积分
   */
  ProduceIntegral: number;
  /**
   * 支付状态
   */
  PayStatus: EnumPayStatus;

  /**
   * 当前用户余额
   */
  MemberBalance: number;
  /**
   * 当前用户积分
   */
  MemberIntegral: number;
}
