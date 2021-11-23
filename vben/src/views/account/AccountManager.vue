<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable">
      <template #toolbar>
        <a-button type="primary" @click="handleEdit(null)">创建帐号</a-button>
      </template>
      <template #action="{ record }">
        <TableAction :actions="handActionColumns(record)" />
      </template>
    </BasicTable>
    <AccountEditorModal @register="registerAccountEditorModal" @success="handleRefresh" />
    <AccountChangePasswordModal @register="registerAccountChangePasswordModal" @success="handleRefresh" />
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { useModal } from '/@/components/Modal';
  import AccountEditorModal from './AccountEditorModal.vue';
  import AccountChangePasswordModal from './AccountChangePasswordModal.vue';
  import { queryColumnsSchema, searchColumnsSchema } from './Accountmanager.config';
  import { accountChangeLockedStatusApi, accountManagerApi } from '/@/api/account/account';
  import { onKeyStroke } from '@vueuse/core';

  export default defineComponent({
    name: 'AccountManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
      AccountEditorModal,
      AccountChangePasswordModal,
    },
    setup() {
      const [registerAccountEditorModal, { openModal: openAccountEditorModal }] = useModal();
      const [registerAccountChangePasswordModal, { openModal: openAccountChangePasswordModal }] = useModal();
      const [registerTable, { reload }] = useTable({
        title: '帐号管理',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: queryColumnsSchema,
        api: accountManagerApi,
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
        btns.push({
          title: '修改密码',
          icon: 'grommet-icons:user-admin',
          color: 'info',
          onClick: () => {
            handleChangePassword(record);
          },
        });

        return btns;
      }

      /**
       * 弹出 添加或编辑 对话框
       */
      function handleEdit(record: Nullable<Recordable>) {
        openAccountEditorModal(true, record == null ? { Id: 0 } : record);
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
          await accountChangeLockedStatusApi({ Id: record.Id, IsLocked: !record.IsLocked });
          reload();
        } catch (ex: any) {
          console.error(ex);
        }
      }

      /**
       * 弹出 修改密码 对话框
       */
      function handleChangePassword(record: Recordable) {
        openAccountChangePasswordModal(true, record == null ? { Id: 0 } : record);
      }

      return {
        registerTable,
        handActionColumns,
        registerAccountEditorModal,
        registerAccountChangePasswordModal,
        handleEdit,
        handleRefresh,
      };
    },
  });
</script>
