import { defHttp } from '/@/utils/http/axios';
import { LoginRequest, LoginResponse } from './model/loginModel';

import { ErrorMessageMode } from '/#/axios';
import { ChangePasswordRequest } from './model/changePasswordModel';

enum Api {
  ChangePassword = '?control=state&action=changePassword',
  Login = '?control=state&action=login',
  Logout = '?control=state&action=logout',
}

/**
 * 用户登录
 */
export function loginApi(params: LoginRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<LoginResponse>(
    {
      url: Api.Login,
      params,
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 用户退出
 */
export function logoutApi() {
  return defHttp.get({ url: Api.Logout });
}

/**
 * 修改密码
 */
export function changePasswordApi(params: ChangePasswordRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<LoginResponse>(
    {
      url: Api.ChangePassword,
      params,
    },
    {
      errorMessageMode: mode,
    },
  );
}
