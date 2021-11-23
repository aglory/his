export interface BasicPageParams {
  page: number;
  pageSize: number;
}

/**
 * 分页查询返回统一参数
 */
export interface BasicFetchResult<T extends any> {
  items: T[];
  total: number;
}

/**
 * 分页统一参数
 */
export interface BasicQueryFilter {
  /**
   * 其实页码
   */
  PageIndex: number;
  /**
   * 页面大小
   */
  PageSize: number;
  /**
   * 排序字段
   */
  PageColumn: string;
  /**
   * 排序方式
   */
  PageOrderBy: string;
}

/**
 * 服务列表端基础响应模型
 */
export interface BasicQueryResult<T extends any> {
  Items: T[];
  PageTotal: number;
}

/**
 * 修改锁定状态
 */
export interface ChangeLockedStatus {
  Id: number;
  IsLocked: boolean;
}

/**
 * 修改排序
 */
export interface ChangeOrderIndex {
  Id: number;
  OrderIndex: number;
}

/**
 * Ant Design of Vue中 AutoCompleteDataSourceItem 接口实现
 */
export interface BasicAutoCompleteDataSourceItemKeyLabel {
  key: number;
  label: string;
}

/**
 * Ant Design of Vue中 AutoCompleteDataSourceItem 接口实现
 */
export interface BasicAutoCompleteDataSourceItemKeyValue {
  key: number;
  value: string;
}

/**
 * Ant Design of Vue中 基础请求信息
 */
export interface BasicAutoCompleteRequest {
  Keyword: string;
}
