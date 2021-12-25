import { defHttp } from '/@/utils/http/axios';

import { ErrorMessageMode } from '/#/axios';
import { ContentTypeEnum } from '/@/enums/httpEnum';
import { BasicQueryResult, ChangeLockedStatus } from '../model/baseModel';
import {
  AccountEditorResponse,
  AccountManagerRequest,
  AccountManagerResponse,
  AccountSaveRequest,
} from './model/accountModel';
import {
  RoleEditorResponse,
  RoleManagerRequest,
  RoleManagerResponse,
  RoleSaveRequest,
} from './model/roleModel';
import {
  SiteEditorResponse,
  SiteManagerRequest,
  SiteManagerResponse,
  SiteSaveRequest,
} from './model/siteModel';

enum Api {
  AccountManager = '?control=account&action=accountManager',
  AccountChangeLockedStatus = '?control=account&action=accountChangeLockedStatus',
  AccountChangePassword = '?control=account&action=accountChangePassword',
  AccountEditor = '?control=account&action=accountEditor',
  AccountSave = '?control=account&action=accountSave',

  RoleManager = '?control=account&action=roleManager',
  RoleEditor = '?control=account&action=roleEditor',
  RoleSave = '?control=account&action=roleSave',

  SiteManager = '?control=account&action=siteManager',
  SiteChangeLockedStatus = '?control=account&action=siteChangeLockedStatus',
  SiteEditor = '?control=account&action=siteEditor',
  SiteSave = '?control=account&action=siteSave',
}

/**
 * 账号管理
 */
export function accountManagerApi(params: AccountManagerRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<BasicQueryResult<AccountManagerResponse>>(
    {
      url: Api.AccountManager,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.FORM_URLENCODED,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 账号 (启用/锁定)
 */
export function accountChangeLockedStatusApi(
  params: ChangeLockedStatus,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.AccountChangeLockedStatus,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 修改账号密码
 */
export function accountChangePasswordApi(
  params: ChangeLockedStatus,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.AccountChangePassword,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 账号编辑
 */
export function accountEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<AccountEditorResponse>(
    {
      url: Api.AccountEditor,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 账号保存
 */
export function accountSaveApi(params: AccountSaveRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<void>(
    {
      url: Api.AccountSave,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 角色管理
 */
export function roleManagerApi(params: RoleManagerRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<BasicQueryResult<RoleManagerResponse>>(
    {
      url: Api.RoleManager,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.FORM_URLENCODED,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 角色编辑
 */
export function roleEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<RoleEditorResponse>(
    {
      url: Api.RoleEditor,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 角色保存
 */
export function roleSaveApi(params: RoleSaveRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<void>(
    {
      url: Api.RoleSave,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 站点管理
 */
export function siteManagerApi(params: SiteManagerRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<BasicQueryResult<SiteManagerResponse>>(
    {
      url: Api.SiteManager,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.FORM_URLENCODED,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 站点 (启用/锁定)
 */
export function siteChangeLockedStatusApi(
  params: ChangeLockedStatus,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.SiteChangeLockedStatus,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 站点编辑
 */
export function siteEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<SiteEditorResponse>(
    {
      url: Api.SiteEditor,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}

/**
 * 角色保存
 */
export function siteSaveApi(params: SiteSaveRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<void>(
    {
      url: Api.SiteSave,
      params,
      headers: {
        'Content-Type': ContentTypeEnum.JSON,
      },
    },
    {
      errorMessageMode: mode,
    },
  );
}
