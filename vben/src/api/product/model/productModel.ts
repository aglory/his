import { BasicQueryFilter } from '../../model/baseModel';
import { EnumProductType } from '/@/enums/serviceEnum';

/**
 * @description: 产品管理 请求对象
 */
export interface ProductManagerRequest extends BasicQueryFilter {
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 产品简称
   */
  ShortName: string;
  /**
   * 产品全称
   */
  FullName: string;
  /**
   * 产品类型
   */
  Type: number[];
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
 * @description: 产品管理 响应对象
 */
export interface ProductManagerResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 产品类型
   */
  Type: EnumProductType;
  /**
   * 产品简称
   */
  ShortName: string;
  /**
   * 产品全称
   */
  FullName: string;
  /**
   * 市场价格
   */
  MarketPrice: number;
  /**
   * 价格
   */
  Price: number;
  /**
   * 结算价
   */
  SettlementPrice: number;
  /**
   * 销售数量
   */
  SaleCopies: number;
  /**
   * 基础销量
   */
  BaseCopies: number;
  /**
   * 库存数量
   */
  SortCopies: number;
  /**
   * 排列序号
   */
  OrderIndex: number;
  /**
   * 是否被锁定
   */
  IsLocked: boolean;
  /**
   * 描述
   */
  Description: string;
  /**
   * 备注
   */
  Remark: string;
  /**
   * 创建时间
   */
  CreateTime: string;
}

/**
 *  @description: 编辑产品 响应对象
 */
export interface ProductEditorResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 产品类型
   */
  Type: EnumProductType;
  /**
   * 产品简称
   */
  ShortName: string;
  /**
   * 产品全称
   */
  FullName: string;
  /**
   * 描述
   */
  Description: string;
  /**
   * 备注
   */
  Remark: string;
}

/**
 *  @description: 修改产品 请求对象
 */
export interface ProductSaveRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 产品类型
   */
  Type: EnumProductType;
  /**
   * 产品简称
   */
  ShortName: string;
  /**
   * 产品全称
   */
  FullName: string;
  /**
   * 描述
   */
  Description: string;
  /**
   * 备注
   */
  Remark: string;
}

/**
 *  @description: 编辑产品数量 响应对象
 */
export interface ProductCopiesEditorResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 销售数量
   */
  SaleCopies: number;
  /**
   * 基础销量
   */
  BaseCopies: number;
  /**
   * 库存数量
   */
  SortCopies: number;
}

/**
 *  @description: 修改产品 请求对象
 */
export interface ProductCopiesSaveRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 基础销量
   */
  BaseCopies: number;
  /**
   * 库存数量
   */
  SortCopies: number;
}

/**
 *  @description: 编辑产品数量 响应对象
 */
export interface ProductPriceEditorResponse {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 市场价格
   */
  MarketPrice: number;
  /**
   * 销售价格
   */
  Price: number;
  /**
   * 结算价
   */
  SettlementPrice: number;
}

/**
 *  @description: 修改产品 请求对象
 */
export interface ProductPriceSaveRequest {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 市场价格
   */
  MarketPrice: number;
  /**
   * 销售价格
   */
  Price: number;
  /**
   * 结算价
   */
  SettlementPrice: number;
}
