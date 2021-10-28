import { BasicQueryFilter } from '../../model/baseModel';

/**
 * @description: 公告管理 请求对象
 */
export interface MessageManagerRequest extends BasicQueryFilter {
  /**
   * 标题
   */
  Title: string;
  /**
   * 是否被锁定
   */
  IsLocked: boolean[];
  /**
   * 创建时间
   */
  CreateTime: string[];
}

/**
 * @description: 公告管理 返回对象
 */
export interface MessageManagerResponse {
  Id: number;
  /**
   * 标题
   */
  Title: string;
  /**
   * 类容
   */
  Content: string;
  /**
   * 是否被锁定
   */
  IsLocked: boolean;
  /**
   * 创建时间
   */
  CreateTime: string;
}

/**
 * @description: 编辑公告 返回对象
 */
export interface MessageEditorResponse {
  Id: number;
  /**
   * 标题
   */
  Title: string;
  /**
   * 类容
   */
  Content: string;
}

/**
 * @description: 编辑公告 返回对象
 */
export interface MessageSaveRequest {
  Id: number;
  /**
   * 标题
   */
  Title: string;
  /**
   * 类容
   */
  Content: string;
}

/**
 * @description: 公告列表 返回对象
 */
export interface MessageListResponse {
  Id: number;
  /**
   * 标题
   */
  Title: string;
  /**
   * 类容
   */
  Content: string;
}
