import { defHttp } from '/@/utils/http/axios';
import { LoginRequest, LoginResponse } from '../state/model/loginModel';

import { ErrorMessageMode } from '/#/axios';
import { MessageEditorResponse, MessageListResponse, MessageSaveRequest } from './model/messageModel';
import { ContentTypeEnum } from '/@/enums/httpEnum';
import { BasicQueryResult, ChangeLockedStatus } from '../model/baseModel';

enum Api {
  MessageManager = '?control=system&action=messageManager',
  MessageEditor = '?control=system&action=messageEditor',
  MessageSave = '?control=system&action=messageSave',
  MessageChangeLockedStatus = '?control=system&action=messageChangeLockedStatus',
  MessageList = '?control=system&action=messageList',
}

/**
 * 公告管理
 */
export function messageManagerApi(params: LoginRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<BasicQueryResult<LoginResponse>>(
    {
      url: Api.MessageManager,
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
 * 消息编辑
 */
export function messageEditorApi(params: { Id: number }, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<MessageEditorResponse>(
    {
      url: Api.MessageEditor,
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
 * 消息保存
 */
export function messageSaveApi(params: MessageSaveRequest, mode: ErrorMessageMode = 'modal') {
  return defHttp.post<void>(
    {
      url: Api.MessageSave,
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
 * 消息 (启用/锁定)
 */
export function messageChangeLockedStatusApi(
  params: ChangeLockedStatus,
  mode: ErrorMessageMode = 'modal',
) {
  return defHttp.post<void>(
    {
      url: Api.MessageChangeLockedStatus,
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
 * 消息列表
 */
export function messageListApi(mode: ErrorMessageMode = 'modal') {
  return defHttp.get<MessageListResponse[]>(
    {
      url: Api.MessageList,
    },
    {
      errorMessageMode: mode,
    },
  );
}
