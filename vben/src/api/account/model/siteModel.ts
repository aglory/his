import { BasicQueryFilter } from '../../model/baseModel';

/**
 * @description: 站点管理 请求对象
 */
export interface SiteManagerRequest extends BasicQueryFilter {
  /**
   * 域名(,)分割
   */
  Host: string;
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
 * @description: 站点管理 响应对象
 */
export interface SiteManagerResponse {
  /**
   * 站点id
   */
  Id: number;
  /**
   * 域名(,)分割
   */
  Host: string;
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
 * @description: 站点编辑 响应对象
 */
export interface SiteEditorResponse {
  /**
   * 站点id
   */
  Id: number;
  /**
   * 域名(,)分割
   */
  Host: string;
  /**
   * 备注
   */
  Remark: string;
  /**
   * 绑定帐号Id
   */
  AccountId: number;
  /**
   * 可绑定的帐号
   */
  Account: { Id: number; LoginName: string }[];
}

/**
 * @description: 保存站点 请求对象
 */
export interface SiteSaveRequest {
  /**
   * 站点id
   */
  Id: number;
  /**
   * 域名(,)分割
   */
  Host: string;
  /**
   * 备注
   */
  Remark: string;
  /**
   * 绑定帐号Id
   */
  AccountId: number;
}
