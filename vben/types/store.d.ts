import { ErrorTypeEnum } from '/@/enums/exceptionEnum';
import { MenuModeEnum, MenuTypeEnum } from '/@/enums/menuEnum';
import { EnumAccountType } from '/@/enums/serviceEnum';

// Lock screen information
export interface LockInfo {
  // Password required
  pwd?: string | undefined;
  // Is it locked?
  isLock?: boolean;
}

// Error-log information
export interface ErrorLogInfo {
  // Type of error
  type: ErrorTypeEnum;
  // Error file
  file: string;
  // Error name
  name?: string;
  // Error message
  message: string;
  // Error stack
  stack?: string;
  // Error detail
  detail: string;
  // Error url
  url: string;
  // Error time
  time?: string;
}
export interface UserInfo {
  /**
   * 用户id
   */
  Id: number;
  /**
   * 用户层级
   */
  Depth: number;
  /**
   * 站点Id
   */
  SiteId: number;
  /**
   * 用户名
   */
  LoginName: string;
  /**
   * 真实名字
   */
  RealName: string;
  /**
   * 类型
   */
  Type: EnumAccountType;
  /**
   * 权限列表
   */
  Permission: EnumPermission[];
  /**
   * 登录时间
   */
  TimeSpan: number;
  /**
   * token
   */
  Token: string;
}

export interface BeforeMiniState {
  menuCollapsed?: boolean;
  menuSplit?: boolean;
  menuMode?: MenuModeEnum;
  menuType?: MenuTypeEnum;
}
