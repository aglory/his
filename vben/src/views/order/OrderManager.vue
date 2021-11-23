<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable">
      <template #toolbar>
        <a-button type="primary" @click="handleEdit(null)">创建订单</a-button>
      </template>
      <template #action="{ record }">
        <TableAction :actions="handActionColumns(record)" />
      </template>
    </BasicTable>
    <OrderEditorModal
      @register="registerOrderEditorModal"
      @success="handleOrderEditorSunccessRefresh"
    />
    <OrderPayEditorModal @register="registerOrderPayEditorModal" @success="handleRefresh" />
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { useModal } from '/@/components/Modal';
  import { queryColumnsSchema, searchColumnsSchema } from './OrderManager.config';
  import { orderManagerApi } from '/@/api/order/order';
  import { onKeyStroke } from '@vueuse/core';

  import OrderEditorModal from './OrderEditorModal.vue';
  import OrderPayEditorModal from './OrderPayEditorModal.vue';

  import { EnumAccountType } from '/@/enums/serviceEnum';
  import { OrderManagerResponse } from '/@/api/order/model/orderModel';
  import { useUserStore } from '/@/store/modules/user';

  export default defineComponent({
    name: 'OrderManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
      OrderEditorModal,
      OrderPayEditorModal,
    },
    setup() {
      const [registerOrderEditorModal, { openModal: openOrderEditorModal }] = useModal();
      const [registerOrderPayEditorModal, { openModal: openOrderPayEditorModal }] = useModal();

      const userStore = useUserStore();

      const [registerTable, { reload, getRawDataSource }] = useTable({
        title: '订单管理',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: queryColumnsSchema.filter(
          (item) =>
            userStore.getUserInfo.Type === EnumAccountType.配置员 || item.dataIndex !== 'SiteId',
        ),
        api: orderManagerApi,
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
          width: 200,
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
              PreferenceAmount: rawDataSource.rawDataSource,
              BalanceAmount: rawDataSource.BalanceAmount,
              IntegralAmount: rawDataSource.IntegralAmount,
              OnlineAmount: rawDataSource.OnlineAmount,
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
            title: '账单',
            icon: 'ant-design:pay-circle-outlined',
            onClick: () => {
              handlePay(record);
            },
          },
        ];
        return btns;
      }

      /**
       * 弹出 添加或编辑 对话框
       */
      function handleEdit(record: Nullable<Recordable>) {
        openOrderEditorModal(true, record == null ? { Id: 0 } : record);
      }

      /**
       * 刷新数据
       */
      function handleRefresh() {
        reload();
      }
      /**
       * 添加订单回调
       */
      function handleOrderEditorSunccessRefresh(params) {
        openOrderPayEditorModal(true, params);
      }

      /**
       * 弹出 账单 对话框
       */
      function handlePay(record: OrderManagerResponse) {
        openOrderPayEditorModal(true, record);
      }

      return {
        registerTable,
        handActionColumns,
        registerOrderEditorModal,
        registerOrderPayEditorModal,
        handleEdit,
        handleRefresh,
        handleOrderEditorSunccessRefresh,
      };
    },
  });
</script>
