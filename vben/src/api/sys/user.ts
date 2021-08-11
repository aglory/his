import { defHttp } from '/@/utils/http/axios';
import { LoginParams, LoginResultModel } from './model/userModel';

import { ErrorMessageMode } from '/#/axios';

enum Api {
  Login = '?model=state&action=login',
  Logout = '?model=state&action=logout',
  GetUserInfo = '/getUserInfo',
  GetPermCode = '/getPermCode',
}

/**
 * @description: user login api
 */
export function loginApi(params: LoginParams, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<LoginResultModel>(
    {
      url: Api.Login,
      params,
    },
    {
      errorMessageMode: mode,
    }
  );
}

export function doLogout() {
  return defHttp.get({ url: Api.Logout });
}
