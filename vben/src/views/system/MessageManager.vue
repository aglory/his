<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable">
      <template #toolbar>
        <a-button type="primary" @click="handleEdit(null)">创建公告</a-button>
      </template>
      <template #action="{ record }">
        <TableAction :actions="handActionColumns(record)" />
      </template>
    </BasicTable>
    <MessageEditorModal @register="registerMessageEditorModal" @success="handleRefresh" />
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { useModal } from '/@/components/Modal';
  import MessageEditorModal from './MessageEditorModal.vue';
  import { queryColumnsSchema, searchColumnsSchema } from './messagemanager.config';
  import { messageChangeLockedStatusApi, messageManagerApi } from '/@/api/system/system';
  import { onKeyStroke } from '@vueuse/core';
  import { MessageManagerResponse } from '/@/api/system/model/messageModel';

  export default defineComponent({
    name: 'MessageManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
      MessageEditorModal,
    },
    setup() {
      const [registerMessageEditorModal, { openModal: openMessageEditorModal }] = useModal();
      const [registerTable, { reload }] = useTable({
        title: '公告管理',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: queryColumnsSchema,
        api: messageManagerApi,
        formConfig: {
          labelWidth: 80,
          schemas: searchColumnsSchema,
        },
        useSearchForm: true,
        showTableSetting: true,
        bordered: true,
        actionColumn: {
          width: 200,
          title: '操作',
          dataIndex: 'action',
          slots: { customRender: 'action' },
          fixed: 'right',
        },
        showSummary: false,
      });

      /**
       * 回车处理事件
       */
      onKeyStroke('Enter', (event: KeyboardEvent): void => {
        event.preventDefault();
        if (event.target?.toString() == '[object HTMLInputElement]') {
          handleRefresh();
        }
      });

      /**
       * 表格操作函数
       */
      function handActionColumns(record: any) {
        //操作按钮
        let btns: any[] = [
          {
            title: '编辑',
            icon: 'clarity:note-edit-line',
            onClick: () => {
              handleEdit(record);
            },
          },
        ];
        if (record.IsLocked) {
          btns.push({
            title: '启用',
            icon: 'ant-design:unlock-outlined',
            color: 'success',
            onClick: () => {
              handleLock(record);
            },
          });
        } else {
          btns.push({
            title: '锁定',
            icon: 'ant-design:lock-outlined',
            color: 'error',
            popConfirm: {
              title: '确定锁定',
              confirm: handleLock.bind(null, record),
            },
          });
        }

        return btns;
      }

      /**
       * 弹出 添加或编辑 对话框
       */
      function handleEdit(record: Nullable<MessageManagerResponse>) {
        openMessageEditorModal(true, record == null ? { Id: 0 } : record);
      }

      /**
       * 刷新数据
       */
      function handleRefresh() {
        reload();
      }

      /**
       * 锁定或启用
       */
      async function handleLock(record: Recordable) {
        try {
          await messageChangeLockedStatusApi({ Id: record.Id, IsLocked: !record.IsLocked });
          reload();
        } catch (ex: any) {
          console.error(ex);
        }
      }

      return {
        registerTable,
        handActionColumns,
        registerMessageEditorModal,
        handleEdit,
        handleRefresh,
      };
    },
  });
</script>
