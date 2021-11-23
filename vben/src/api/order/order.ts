import { defHttp } from '/@/utils/http/axios';

import { ErrorMessageMode } from '/#/axios';
import { ContentTypeEnum } from '/@/enums/httpEnum';
import { BasicQueryResult } from '../model/baseModel';

import {
  OrderEditorResponse,
  OrderManagerRequest,
  OrderManagerResponse,
  OrderPayEditorResponse,
  OrderSaveRequest,
} from './model/orderModel';

enum Api {
  OrderManagerApi = '?control=order&action=orderManager',
  OrderEditor = '?control=order&action=orderEditor',
  OrderSave = '?control=order&action=orderSave',
  OrderPayEditor = '?control=order&action=orderPayEditor',
  OrderPaySave = '?control=order&action=orderPaySave',
}

/**
 * 订单管理
 */
export function orderManagerApi(params: OrderManagerRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<BasicQueryResult<OrderManagerResponse>>(
    {
      url: Api.OrderManagerApi,
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
 * 订单编辑
 */
export function orderEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<OrderEditorResponse>(
    {
      url: Api.OrderEditor,
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
export function orderSaveApi(params: OrderSaveRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<number>(
    {
      url: Api.OrderSave,
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
 * 订单账单编辑
 */
export function orderPayEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<OrderPayEditorResponse>(
    {
      url: Api.OrderPayEditor,
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
 * 订单账单编辑
 */
export function orderPaySaveApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<OrderPayEditorResponse>(
    {
      url: Api.OrderPaySave,
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
