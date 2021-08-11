import { UserType } from '/@/enums/enumHelper';

/**
 * @description: Login interface parameters
 */
export interface LoginParams {
  LoginName: string;
  Password: string;
}

/**
 * @description: Login interface return value
 */
export interface LoginResultModel {
  // 用户id
  Id: string | number;
  // 用户登录账号
  LoginName: string;
  // 真实名字
  RealName: string;
  // 用户类型
  Type: UserType;
  // 权限码
  Permission: string[];
  Token: string;
}
