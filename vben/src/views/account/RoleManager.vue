<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable">
      <template #toolbar>
        <a-button type="primary" @click="handleEdit(null)">创建角色</a-button>
      </template>
      <template #action="{ record }">
        <TableAction :actions="handActionColumns(record)" />
      </template>
    </BasicTable>
    <RoleEditorModal @register="registerRoleEditorModal" @success="handleRefresh" />
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { useModal } from '/@/components/Modal';
  import RoleEditorModal from './RoleEditorModal.vue';
  import { queryColumnsSchema, searchColumnsSchema } from './rolemanager.config';
  import { roleManagerApi } from '/@/api/account/account';
  import { onKeyStroke } from '@vueuse/core';

  export default defineComponent({
    name: 'RoleManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
      RoleEditorModal,
    },
    setup() {
      const [registerRoleEditorModal, { openModal: openRoleEditorModal }] = useModal();
      const [registerTable, { reload }] = useTable({
        title: '角色管理',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: queryColumnsSchema,
        api: roleManagerApi,
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
        return btns;
      }

      /**
       * 弹出 添加或编辑 对话框
       */
      function handleEdit(record: Nullable<Recordable>) {
        openRoleEditorModal(true, record == null ? { Id: 0 } : record);
      }

      /**
       * 刷新数据
       */
      function handleRefresh() {
        reload();
      }

      return {
        registerTable,
        handActionColumns,
        registerRoleEditorModal,
        handleEdit,
        handleRefresh,
      };
    },
  });
</script>
