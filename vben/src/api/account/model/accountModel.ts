import { BasicQueryFilter } from '../../model/baseModel';
import { EnumAccountType } from '/@/enums/serviceEnum';

/**
 * @description: 帐号管理 请求对象
 */
export interface AccountManagerRequest extends BasicQueryFilter {
  /**
   * 用户名
   */
  LoginName: string;
  /**
   * 真实名字
   */
  RealName: string;
  /**
   * 电话号码
   */
  Tel: string;
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
 * @description: 帐号管理 响应对象
 */
export interface AccountManagerResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 用户名
   */
  LoginName: string;
  /**
   * 真实名字
   */
  RealName: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 用户类型
   */
  Type: EnumAccountType;
  /**
   * 权限列表
   */
  IsLocked: boolean;
  /**
   * 创建时间
   */
  CreateTime: string;
}

/**
 *  @description: 修改密码 请求对象
 */
export interface AccountChangePasswordRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 密码
   */
  Password: string;
}

/**
 *  @description: 编辑帐号 响应对象
 */
export interface AccountEditorResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 用户名
   */
  LoginName: string;
  /**
   * 真实名字
   */
  RealName: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 密码
   */
  Password: string;
  /**
   * 用户类型
   */
  Type: number;
  /**
   * 用户角色
   */
  Role: number[];
  /**
   * 可选用户角色
   */
  TempRole: { Id: number; Name: string }[];
}

/**
 *  @description: 修改帐号 请求对象
 */
export interface AccountSaveRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 用户名
   */
  LoginName: string;
  /**
   * 真实名字
   */
  RealName: string;
  /**
   * 电话号码
   */
  Tel: string;
  /**
   * 密码
   */
  Password: string;
  /**
   * 用户类型
   */
  Type: number;
  /**
   * 用户角色
   */
  Role: number[];
}
