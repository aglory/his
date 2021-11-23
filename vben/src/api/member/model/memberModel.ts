import { BasicQueryFilter } from '../../model/baseModel';

export interface AutoQueryMemberListResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 姓名
   */
  Name: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 创建时间
   */
  CreateTime: string;
}

/**
 * @description: 会员管理 请求对象
 */
export interface MemberManagerRequest extends BasicQueryFilter {
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 姓名
   */
  Name: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 身份证
   */
  IdcardNo: string;
  /**
   * 是否被锁定
   */
  IsLocked: number[];
  /**
   * 创建时间
   */
  CreateTime: string[];
}

/**
 * @description: 会员管理 响应对象
 */
export interface MemberManagerResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 姓名
   */
  Name: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 身份证
   */
  IdcardNo: string;
  /**
   * 余额
   */
  Balance: number;
  /**
   * 积分
   */
  Integral: number;
  /**
   * 是否被锁定
   */
  IsLocked: boolean;
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
 *  @description: 编辑会员 响应对象
 */
export interface MemberEditorResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 姓名
   */
  Name: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 身份证
   */
  IdcardNo: string;
  /**
   * 备注
   */
  Remark: string;
}

/**
 *  @description: 修改会员 请求对象
 */
export interface MemberSaveRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 姓名
   */
  Name: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 身份证
   */
  IdcardNo: string;
  /**
   * 备注
   */
  Remark: string;
}

/**
 *  @description: 修改会员 响应对象
 */
export interface MemberSaveResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 姓名
   */
  Name: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 身份证
   */
  IdcardNo: string;
  /**
   * 备注
   */
  Remark: string;
}

/**
 *  @description: 修改充值 请求对象
 */
export interface MemberChangeBalanceRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 金额
   */
  Amount: number;
}

/**
 *  @description: 修改充值 请求对象
 */
export interface MemberChangeIntegralRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 积分
   */
  Amount: number;
}
