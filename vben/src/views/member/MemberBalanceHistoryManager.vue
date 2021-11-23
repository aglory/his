<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable" @member="">
      <template #toolbar> </template>
    </BasicTable>
    <MemberEditorModal @register="registerMemberEditorModal" @success="handleRefresh" />
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent, h } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { useModal } from '/@/components/Modal';
  import {
    queryBalanceColumnsSchema,
    searchBalanceColumnsSchema,
  } from './MemberHistoryManager.config';
  import { memberBalanceHistoryManagerApi } from '/@/api/member/member';
  import { onKeyStroke } from '@vueuse/core';

  import MemberEditorModal from './MemberEditorModal.vue';
  import MemberBalanceEditorModal from './MemberBalanceEditorModal.vue';

  import { EnumAccountType } from '/@/enums/serviceEnum';
  import { useUserStore } from '/@/store/modules/user';
  import { MemberBalanceHistoryManagerResponse } from '/@/api/member/model/memberHistoryModel';

  export default defineComponent({
    name: 'MemberBalanceHistoryManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
      MemberEditorModal,
      MemberBalanceEditorModal,
    },
    setup() {
      const [registerMemberEditorModal, { openModal: openMemberEditorModal }] = useModal();

      const userStore = useUserStore();
      const adapterSearchBalanceColumnsSchema = searchBalanceColumnsSchema.filter(
        (item) => userStore.getUserInfo.Type == EnumAccountType.配置员 || item.field !== 'SiteId',
      );
      const adapterQueryBalanceColumnsSchema = queryBalanceColumnsSchema.filter(
        (item) =>
          userStore.getUserInfo.Type == EnumAccountType.配置员 || item.dataIndex !== 'SiteId',
      );
      adapterQueryBalanceColumnsSchema
        .filter((item) =>
          ['MemberName', 'MemberTel'].some((dataIndex) => item.dataIndex === dataIndex),
        )
        .forEach(
          (item) =>
            (item.customRender = ({ record }) => {
              if (record[item.dataIndex ?? ''] !== undefined) {
                return h(
                  'a',
                  {
                    onClick: () => {
                      handleMemberEdit(record);
                    },
                  },
                  record[item.dataIndex ?? ''],
                );
              } else {
                return '';
              }
            }),
        );
      const [registerTable, { reload, getRawDataSource }] = useTable({
        title: '资金流水',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: adapterQueryBalanceColumnsSchema,
        api: memberBalanceHistoryManagerApi,
        formConfig: {
          labelWidth: 80,
          schemas: adapterSearchBalanceColumnsSchema,
        },
        useSearchForm: true,
        showTableSetting: true,
        bordered: true,
        actionColumn: {
          width: 0,
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
              Amount: rawDataSource.Amount,
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
       * 刷新数据
       */
      function handleRefresh() {
        reload();
      }

      /**
       * 弹出 会员编辑 对话框
       */
      function handleMemberEdit(record: MemberBalanceHistoryManagerResponse) {
        openMemberEditorModal(true, { Id: record.MemberId });
      }

      return {
        registerTable,
        registerMemberEditorModal,
        handleRefresh,
      };
    },
  });
</script>
