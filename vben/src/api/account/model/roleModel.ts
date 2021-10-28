import { BasicQueryFilter } from '../../model/baseModel';

/**
 * @description: 角色管理 请求对象
 */
export interface RoleManagerRequest extends BasicQueryFilter {
  Name: string;
}

/**
 * @description: 角色管理 响应对象
 */
export interface RoleManagerResponse {
  /**
   * 角色id
   */
  Id: number;
  /**
   * 角色
   */
  Name: string;
  /**
   * 权限列表
   */
  Permission: string;
}

/**
 *  @description: 编辑角色 请求对象
 */
export interface RoleEditorResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 角色
   */
  Name: string;
  /**
   * 权限
   */
  Permission: number[];
  /**
   * 可选用户角色
   */
  TempPermission: { Id: number; Name: string }[];
}

/**
 *  @description: 编辑角色 响应对象
 */
export interface RoleSaveRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 角色
   */
  Name: string;
  /**
   * 权限
   */
  Permission: number[];
}
