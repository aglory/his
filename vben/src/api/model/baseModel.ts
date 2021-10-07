export interface BasicPageParams {
  page: number;
  pageSize: number;
}

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
