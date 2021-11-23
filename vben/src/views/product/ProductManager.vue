<template>
  <PageWrapper dense contentFullHeight fixedHeight>
    <BasicTable @register="registerTable">
      <template #toolbar>
        <a-button type="primary" @click="handleEdit(null)">创建产品</a-button>
      </template>
      <template #action="{ record }">
        <TableAction :actions="handActionColumns(record)" />
      </template>
    </BasicTable>
    <ProductEditorModal @register="registerProductEditorModal" @success="handleRefresh" />
    <ProductCopiesEditorModal
      @register="registerProductCopiesEditorModal"
      @success="handleRefresh"
    />
    <ProductPriceEditorModal @register="registerProductPriceEditorModal" @success="handleRefresh" />
    <ProductOrderIndexEditorModal
      @register="registerProductOrderIndexEditorModal"
      @success="handleRefresh"
    />
  </PageWrapper>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicTable, useTable, TableAction } from '/@/components/Table';
  import { PageWrapper } from '/@/components/Page';
  import { useModal } from '/@/components/Modal';
  import { queryColumnsSchema, searchColumnsSchema } from './ProductManager.config';
  import { productChangeLockedStatusApi, productManagerApi } from '/@/api/product/product';
  import { onKeyStroke } from '@vueuse/core';
  import { ProductManagerResponse } from '/@/api/product/model/productModel';

  import ProductEditorModal from './ProductEditorModal.vue';
  import ProductPriceEditorModal from './ProductPriceEditorModal.vue';
  import ProductCopiesEditorModal from './ProductCopiesEditorModal.vue';
  import ProductOrderIndexEditorModal from './ProductOrderIndexEditorModal.vue';

  import { EnumAccountType } from '/@/enums/serviceEnum';
  import { useUserStore } from '/@/store/modules/user';

  export default defineComponent({
    name: 'ProductManager',
    components: {
      PageWrapper,
      BasicTable,
      TableAction,
      ProductEditorModal,
      ProductPriceEditorModal,
      ProductCopiesEditorModal,
      ProductOrderIndexEditorModal,
    },
    setup() {
      const [registerProductEditorModal, { openModal: openProductEditorModal }] = useModal();
      const [registerProductCopiesEditorModal, { openModal: openProductCopiesEditorModal }] =
        useModal();
      const [registerProductPriceEditorModal, { openModal: openProductPriceEditorModal }] =
        useModal();
      const [
        registerProductOrderIndexEditorModal,
        { openModal: openProductOrderIndexEditorModal },
      ] = useModal();

      const userStore = useUserStore();
      const [registerTable, { reload }] = useTable({
        title: '产品管理',
        canColDrag: true,
        showIndexColumn: false,
        striped: true,
        canResize: true,
        columns: queryColumnsSchema.filter(
          (item) =>
            userStore.getUserInfo.Type === EnumAccountType.配置员 || item.dataIndex !== 'SiteId',
        ),
        api: productManagerApi,
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
          width: 320,
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
          {
            title: '改价',
            icon: 'ant-design:account-book-outlined',
            onClick: () => {
              handlePriceEdit(record);
            },
          },
          {
            title: '库存',
            icon: 'ant-design:retweet-outlined',
            onClick: () => {
              handleCopiesEdit(record);
            },
          },
          {
            title: '排序',
            icon: 'ant-design:ordered-list-outlined',
            onClick: () => {
              handleOrderIndexEdit(record);
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
        openProductEditorModal(true, record == null ? { Id: 0 } : record);
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
          await productChangeLockedStatusApi({ Id: record.Id, IsLocked: !record.IsLocked });
          reload();
        } catch (ex: any) {
          console.error(ex);
        }
      }

      /**
       * 弹出 修改价格 对话框
       */
      function handlePriceEdit(record: ProductManagerResponse) {
        openProductPriceEditorModal(true, record);
      }

      /**
       * 弹出 修改库存 对话框
       */
      function handleCopiesEdit(record: ProductManagerResponse) {
        openProductCopiesEditorModal(true, record);
      }

      /**
       * 弹出 修改序号 对话框
       */
      function handleOrderIndexEdit(record: ProductManagerResponse) {
        openProductOrderIndexEditorModal(true, record);
      }

      return {
        registerTable,
        handActionColumns,
        registerProductEditorModal,
        registerProductPriceEditorModal,
        registerProductCopiesEditorModal,
        registerProductOrderIndexEditorModal,
        handleEdit,
        handleRefresh,
      };
    },
  });
</script>
