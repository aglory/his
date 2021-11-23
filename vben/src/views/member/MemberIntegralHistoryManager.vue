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
    queryIntegralColumnsSchema,
    searchIntegralColumnsSchema,
  } from './MemberHistoryManager.config';
  import { memberIntegralHistoryManagerApi } from '/@/api/member/member';
  import { onKeyStroke } from '@vueuse/core';

  import MemberEditorModal from './MemberEditorModal.vue';
  import MemberBalanceEditorModal from './MemberBalanceEditorModal.vue';

  import { EnumAccountType } from '/@/enums/serviceEnum';
  import { useUserStore } from '/@/store/modules/user';

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
      const adapterSearchBalanceColumnsSchema = searchIntegralColumnsSchema.filter(
        (item) => userStore.getUserInfo.Type == EnumAccountType.配置员 || item.field !== 'SiteId',
      );
      const adapterQueryBalanceColumnsSchema = queryIntegralColumnsSchema.filter(
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
                      openMemberEditorModal(record);
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
        title: '余额流水',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: adapterQueryBalanceColumnsSchema,
        api: memberIntegralHistoryManagerApi,
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

      return {
        registerTable,
        registerMemberEditorModal,
        handleRefresh,
      };
    },
  });
</script>
