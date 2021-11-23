import { BasicQueryFilter } from '../../model/baseModel';
import { EnumEnterpriseCashTransactionType } from '/@/enums/serviceEnum';

/**
 * @description: 现金流水管理 请求对象
 */
export interface EnterpriseCashHistoryManagerRequest extends BasicQueryFilter {
  /**
   * 站点Id
   */
  SiteId: number;

  /**
   * 操作人
   */
  OperatorLoginName: string;
  /**
   * 流水类型
   */
  Type: EnumEnterpriseCashTransactionType[];
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
 * @description: 现金流水管理 响应对象
 */
export interface EnterpriseCashHistoryManagerResponse {
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
  Type: EnumEnterpriseCashTransactionType;
  /**
   * 收支类型
   */
  TypeSign: string;
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
   * 备注
   */
  Remark: string;
  /**
   * 创建时间
   */
  CreateTime: string;
}
