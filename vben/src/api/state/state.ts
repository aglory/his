import { defHttp } from '/@/utils/http/axios';
import { LoginRequest, LoginResponse } from './model/loginModel';

import { ErrorMessageMode } from '/#/axios';

enum Api {
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
