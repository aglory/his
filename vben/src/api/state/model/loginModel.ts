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
   * 头像
   */
  Type: EnumAccountType;
  /**
   * 权限列表
   */
  Permission: EnumPermission[];
  /**
   * token
   */
  Token: string;
}
