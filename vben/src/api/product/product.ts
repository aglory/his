import { defHttp } from '/@/utils/http/axios';

import { ErrorMessageMode } from '/#/axios';
import { ContentTypeEnum } from '/@/enums/httpEnum';
import { BasicQueryResult, ChangeLockedStatus, ChangeOrderIndex } from '../model/baseModel';
import {
  AutoQueryProductListRequest,
  AutoQueryProductListResponse,
  ProductCopiesEditorResponse,
  ProductCopiesSaveRequest,
  ProductEditorResponse,
  ProductManagerRequest,
  ProductManagerResponse,
  ProductPriceEditorResponse,
  ProductPriceSaveRequest,
  ProductSaveRequest,
} from './model/productModel';

enum Api {
  AutoQueryProductList = '?control=product&action=autoQueryProductList',
  ProductManager = '?control=product&action=productManager',
  ProductChangeLockedStatus = '?control=product&action=productChangeLockedStatus',
  ProductChangeOrderIndex = '?control=product&action=productChangeOrderIndex',
  ProductEditor = '?control=product&action=productEditor',
  ProductSave = '?control=product&action=productSave',
  ProductCopiesEditor = '?control=product&action=productCopiesEditor',
  ProductCopiesSave = '?control=product&action=productCopiesSave',
  ProductPriceEditor = '?control=product&action=productPriceEditor',
  ProductPriceSave = '?control=product&action=productPriceSave',
}

/**
 * 自动提示产品
 */
export function autoQueryProductListApi(
  params: AutoQueryProductListRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<AutoQueryProductListResponse[]>(
    {
      url: Api.AutoQueryProductList,
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
 * 产品管理
 */
export function productManagerApi(params: ProductManagerRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<BasicQueryResult<ProductManagerResponse>>(
    {
      url: Api.ProductManager,
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
 * 产品 (启用/锁定)
 */
export function productChangeLockedStatusApi(
  params: ChangeLockedStatus,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.ProductChangeLockedStatus,
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
 * 产品 排序
 */
export function productChangeOrderIndexApi(
  params: ChangeOrderIndex,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.ProductChangeOrderIndex,
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
 * 产品编辑
 */
export function productEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<ProductEditorResponse>(
    {
      url: Api.ProductEditor,
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
 * 产品保存
 */
export function productSaveApi(params: ProductSaveRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<number>(
    {
      url: Api.ProductSave,
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
 * 产品数量编辑
 */
export function productCopiesEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<ProductCopiesEditorResponse>(
    {
      url: Api.ProductCopiesEditor,
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
 * 产品数量保存
 */
export function productCopiesSaveApi(
  params: ProductCopiesSaveRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.ProductCopiesSave,
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
 * 产品价格编辑
 */
export function productPriceEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<ProductPriceEditorResponse>(
    {
      url: Api.ProductPriceEditor,
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
 * 产品价格保存
 */
export function productPriceSaveApi(
  params: ProductPriceSaveRequest,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.ProductPriceSave,
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
