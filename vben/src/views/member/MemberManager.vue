<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable">
      <template #toolbar>
        <a-button type="primary" @click="handleEdit(null)">创建会员</a-button>
      </template>
      <template #action="{ record }">
        <TableAction :actions="handActionColumns(record)" />
      </template>
    </BasicTable>
    <MemberEditorModal @register="registerMemberEditorModal" @success="handleRefresh" />
    <MemberBalanceEditorModal
      @register="registerMemberBalanceEditorModal"
      @success="handleRefresh"
    />
    <MemberIntegralEditorModal
      @register="registerMemberIntegralEditorModal"
      @success="handleRefresh"
    />
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { useModal } from '/@/components/Modal';
  import { queryColumnsSchema, searchColumnsSchema } from './MemberManager.config';
  import { memberChangeLockedStatusApi, memberManagerApi } from '/@/api/member/member';
  import { onKeyStroke } from '@vueuse/core';
  import { MemberManagerResponse } from '/@/api/member/model/memberModel';

  import MemberEditorModal from './MemberEditorModal.vue';
  import MemberBalanceEditorModal from './MemberBalanceEditorModal.vue';
  import MemberIntegralEditorModal from './MemberIntegralEditorModal.vue';

  import { EnumAccountType } from '/@/enums/serviceEnum';
  import { useUserStore } from '/@/store/modules/user';

  export default defineComponent({
    name: 'ProductManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
      MemberEditorModal,
      MemberBalanceEditorModal,
      MemberIntegralEditorModal,
    },
    setup() {
      const [registerMemberEditorModal, { openModal: openMemberEditorModal }] = useModal();
      const [registerMemberBalanceEditorModal, { openModal: openMemberBalanceEditorModal }] =
        useModal();
      const [registerMemberIntegralEditorModal, { openModal: openMemberIntegralEditorModal }] =
        useModal();

      const userStore = useUserStore();
      const [registerTable, { reload, getRawDataSource }] = useTable({
        title: '会员管理',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: queryColumnsSchema.filter(
          (item) =>
            userStore.getUserInfo.Type === EnumAccountType.配置员 || item.dataIndex !== 'SiteId',
        ),
        api: memberManagerApi,
        formConfig: {
          labelWidth: 80,
          schemas: searchColumnsSchema.filter(
            (item) =>
              userStore.getUserInfo.Type === EnumAccountType.配置员 || item.field !== 'SiteId',
          ),
        },
        useSearchForm: true,
        showTableSetting: true,
        bordered: true,
        actionColumn: {
          width: 240,
          title: '操作',
          dataIndex: 'action',
          slots: { customRender: 'action' },
          fixed: 'right',
        },
        showSummary: true,
        summaryFunc: () => {
          const rawDataSource = getRawDataSource();
          return [
            {
              Id: '合计',
              Balance: rawDataSource.Balance,
            },
          ];
        },
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
          {
            title: '充值',
            icon: 'ant-design:transaction-outlined',
            onClick: () => {
              handleMemberBalanceEdit(record);
            },
          },
          {
            title: '积分',
            icon: 'ant-design:copyright-circle-outlined',
            onClick: () => {
              handleMemberIntegralEdit(record);
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
      function handleEdit(record: Nullable<Recordable>) {
        openMemberEditorModal(true, record == null ? { Id: 0 } : record);
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
          await memberChangeLockedStatusApi({ Id: record.Id, IsLocked: !record.IsLocked });
          reload();
        } catch (ex: any) {
          console.error(ex);
        }
      }

      /**
       * 弹出 余额充值 对话框
       */
      function handleMemberBalanceEdit(record: MemberManagerResponse) {
        openMemberBalanceEditorModal(true, record);
      }

      /**
       * 弹出 修改积分 对话框
       */
      function handleMemberIntegralEdit(record: MemberManagerResponse) {
        openMemberIntegralEditorModal(true, record);
      }

      return {
        registerTable,
        handActionColumns,
        registerMemberEditorModal,
        registerMemberBalanceEditorModal,
        registerMemberIntegralEditorModal,
        handleEdit,
        handleRefresh,
      };
    },
  });
</script>
