<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable" @member="">
      <template #toolbar> </template>
    </BasicTable>
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { queryColumnsSchema, searchColumnsSchema } from './EnterpriseCashHistoryManager.config';
  import { enterpriseCashHistoryManagerApi } from '/@/api/system/system';
  import { onKeyStroke } from '@vueuse/core';

  import { EnumAccountType } from '/@/enums/serviceEnum';
  import { useUserStore } from '/@/store/modules/user';

  export default defineComponent({
    name: 'MemberBalanceHistoryManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
    },
    setup() {
      const userStore = useUserStore();
      const adapterSearchBalanceColumnsSchema = searchColumnsSchema.filter(
        (item) => userStore.getUserInfo.Type == EnumAccountType.配置员 || item.field !== 'SiteId',
      );
      const adapterQueryBalanceColumnsSchema = queryColumnsSchema.filter(
        (item) =>
          userStore.getUserInfo.Type == EnumAccountType.配置员 || item.dataIndex !== 'SiteId',
      );
      const [registerTable, { reload, getRawDataSource }] = useTable({
        title: '资金流水',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: adapterQueryBalanceColumnsSchema,
        api: enterpriseCashHistoryManagerApi,
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
      };
    },
  });
</script>
