import { BasicQueryFilter } from '../../model/baseModel';
import {
  EnumMemberBalanceTransactionType,
  EnumMemberIntegralTransactionType,
} from '/@/enums/serviceEnum';

/**
 * @description: 余额流水管理 请求对象
 */
export interface MemberBalanceHistoryManagerRequest extends BasicQueryFilter {
  /**
   * 站点Id
   */
  SiteId: number;

  /**
   * 操作人
   */
  OperatorLoginName: string;
  /**
   * 会员姓名
   */
  MemberName: string;
  /**
   * 会员   */
  MemberTel: string;
  /**
   * 流水类型
   */
  Type: EnumMemberBalanceTransactionType[];
  /**
   * 收支类型
   */
  TypeSign: number[];
  /**
   * 创建时间
   */
  CreateTime: string[];
}

/**
 * @description: 余额流水管理 响应对象
 */
export interface MemberBalanceHistoryManagerResponse {
  /**
   *  流水id
   */
  Id: number;
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 流水类型
   */
  Type: EnumMemberBalanceTransactionType;
  /**
   * 收支类型
   */
  TypeSign: string;
  /**
   * 会员编号
   */
  MemberId: number;
  /**
   * 操作编号
   */
  OperatorId: number;
  /**
   * 操作人
   */
  OperatorLoginName: boolean;
  /**
   * 变化金额
   */
  Amount: number;
  /**
   * 变化后余额
   */
  Balance: number;
  /**
   * 会员姓名
   */
  MemberName: string;
  /**
   * 会员   */
  MemberTel;
  /**
   * 备注
   */
  Remark: string;
  /**
   * 创建时间
   */
  CreateTime: string;
}

/**
 * @description: 积分流水管理 请求对象
 */
export interface MemberIntegralHistoryManagerRequest extends BasicQueryFilter {
  /**
   * 站点Id
   */
  SiteId: number;

  /**
   * 操作人
   */
  OperatorLoginName: string;
  /**
   * 会员姓名
   */
  MemberName: string;
  /**
   * 会员   */
  MemberTel: string;
  /**
   * 流水类型
   */
  Type: EnumMemberIntegralTransactionType[];
  /**
   * 收支类型
   */
  TypeSign: number[];
  /**
   * 创建时间
   */
  CreateTime: string[];
}

/**
 * @description: 积分流水管理 响应对象
 */
export interface MemberIntegralHistoryManagerResponse {
  /**
   *  流水id
   */
  Id: number;
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 流水类型
   */
  Type: EnumMemberIntegralTransactionType;
  /**
   * 收支类型
   */
  TypeSign: string;
  /**
   * 会员编号
   */
  MemberId: number;
  /**
   * 操作编号
   */
  OperatorId: number;
  /**
   * 操作人
   */
  OperatorLoginName: boolean;
  /**
   * 变化金额
   */
  Amount: number;
  /**
   * 变化后余额
   */
  Balance: number;
  /**
   * 会员姓名
   */
  MemberName: string;
  /**
   * 会员   */
  MemberTel;
  /**
   * 备注
   */
  Remark: string;
  /**
   * 创建时间
   */
  CreateTime: string;
}
