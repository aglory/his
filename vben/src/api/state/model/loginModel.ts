import { EnumPermission, EnumAccountType } from '/@/enums/serviceEnum';

/**
 * @description: 登录 请求对象
 */
export interface LoginRequest {
  LoginName: string;
  Password: string;
}

/**
 * @description: 登录 返回对象
 */
export interface LoginResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 用户层级
   */
  Depth: number;
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 用户名
   */
  LoginName: string;
  /**
   * 真实名字
   */
  RealName: string;
  /**
   * 用户类型
   */
  Type: EnumAccountType;
  /**
   * 权限列表
   */
  Permission: EnumPermission[];
  /**
   * 登录时间
   */
  TimeSpan: number;
  /**
   * token
   */
  Token: string;
}
