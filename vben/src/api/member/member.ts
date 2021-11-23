import { defHttp } from '/@/utils/http/axios';

import { ErrorMessageMode } from '/#/axios';
import { ContentTypeEnum } from '/@/enums/httpEnum';
import { BasicAutoCompleteRequest, BasicQueryResult, ChangeLockedStatus } from '../model/baseModel';

import {
  AutoQueryMemberListResponse,
  MemberChangeBalanceRequest,
  MemberChangeIntegralRequest,
  MemberEditorResponse,
  MemberManagerRequest,
  MemberManagerResponse,
  MemberSaveRequest,
  MemberSaveResponse,
} from './model/memberModel';
import {
  MemberBalanceHistoryManagerRequest,
  MemberBalanceHistoryManagerResponse,
  MemberIntegralHistoryManagerRequest,
  MemberIntegralHistoryManagerResponse,
} from './model/memberHistoryModel';

enum Api {
  AutoQueryMemberList = '?control=member&action=autoQueryMemberList',

  MemberManager = '?control=member&action=memberManager',
  MemberChangeLockedStatus = '?control=member&action=memberChangeLockedStatus',
  MemberEditor = '?control=member&action=memberEditor',
  MemberSave = '?control=member&action=memberSave',
  MemberChangeBalance = '?control=member&action=memberChangeBalance',
  MemberChangeIntegral = '?control=member&action=memberChangeIntegral',

  MemberBalanceHistoryManager = '?control=member&action=memberBalanceHistoryManager',
  MemberIntegralHistoryManager = '?control=member&action=memberIntegralHistoryManager',
}

/**
 * 自动提示会员
 */
export function autoQueryMemberListApi(
  params: BasicAutoCompleteRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<AutoQueryMemberListResponse[]>(
    {
      url: Api.AutoQueryMemberList,
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
 * 会员管理
 */
export function memberManagerApi(params: MemberManagerRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<BasicQueryResult<MemberManagerResponse>>(
    {
      url: Api.MemberManager,
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
 * 会员 (启用/锁定)
 */
export function memberChangeLockedStatusApi(
  params: ChangeLockedStatus,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.MemberChangeLockedStatus,
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
 * 会员编辑
 */
export function memberEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<MemberEditorResponse>(
    {
      url: Api.MemberEditor,
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
 * 会员保存
 */
export function memberSaveApi(params: MemberSaveRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<MemberSaveResponse>(
    {
      url: Api.MemberSave,
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
 * 会员充值编辑
 */
export function memberChangeBalanceApi(
  params: MemberChangeBalanceRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.MemberChangeBalance,
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
 * 余额流水管理
 */
export function memberBalanceHistoryManagerApi(
  params: MemberBalanceHistoryManagerRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<BasicQueryResult<MemberBalanceHistoryManagerResponse>>(
    {
      url: Api.MemberBalanceHistoryManager,
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
 * 会员积分编辑
 */
export function memberChangeIntegralApi(
  params: MemberChangeIntegralRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.MemberChangeIntegral,
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
 * 积分流水管理
 */
export function memberIntegralHistoryManagerApi(
  params: MemberIntegralHistoryManagerRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<BasicQueryResult<MemberIntegralHistoryManagerResponse>>(
    {
      url: Api.MemberIntegralHistoryManager,
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
