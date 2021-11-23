<template>
  <BasicModal v-bind="$attrs" @register="registerModal" title="编辑订单" @ok="handleSubmit">
    <Form
      layout="horizontal"
      :labelCol="{ span: 4 }"
      :wrapperCol="{ span: 18 }"
      class="OrderEditorModal"
    >
      <FormItem label="会员">
        <AutoComplete
          :value="editData.MemberLabel"
          @search="handleMemberSearch"
          @select="handleMemberSelect"
          :disabled="disableOperator()"
        >
          <template #options>
            <SelectOption
              v-for="item in editData.AutoCompleteMemberDataSource"
              :key="item.key"
              :value="item.value"
            ></SelectOption>
          </template>
          <template #notFoundContent>
            <Empty />
          </template>
        </AutoComplete>
      </FormItem>
      <FormItem label="产品">
        <div class="ProductItem" v-for="(item, index) in formData.Items">
          <div class="ProductName">
            <AutoComplete
              :value="item.ProductShortName"
              @search="handleProductSearch"
              @select="handleProductSelect"
              :disabled="disableOperator()"
            >
              <template #options>
                <SelectOption
                  v-for="item in editData.AutoCompleteProductDataSource"
                  :key="item.key"
                  :value="item.value"
                ></SelectOption>
              </template>
              <template #notFoundContent>
                <Empty />
              </template>
            </AutoComplete>
          </div>
          <div class="ProductCopies">
            <Input v-model:value="item.Copies" :disabled="disableOperator()" />
          </div>
          <div class="ProductOperator">
            <a-button
              type="danger"
              @click="handleProductDelete(index)"
              :disabled="disableOperator()"
              >删除</a-button
            >
          </div>
        </div>
        <div class="ProductItem" v-if="!disableOperator()">
          <div>
            <a-button type="primary" @click="handleProductAdd">添加产品</a-button>
          </div>
        </div>
      </FormItem>
      <FormItem label="备注">
        <Textarea
          v-model:value="formData.Remark"
          :rows="4"
          :disabled="disableOperator()"
        ></Textarea>
      </FormItem>
    </Form>
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm } from '/@/components/Form/index';
  import { orderEditorApi, orderSaveApi } from '/@/api/order/order';
  import { Form, FormItem, Input, AutoComplete, SelectOption, Empty } from 'ant-design-vue';
  import { BasicAutoCompleteDataSourceItemKeyValue } from '/@/api/model/baseModel';
  import { autoQueryMemberListApi } from '/@/api/member/member';
  import { OrderItemEditorResponse, OrderManagerResponse } from '/@/api/order/model/orderModel';
  import { autoQueryProductListApi } from '/@/api/product/product';
  import { useMessage } from '/@/hooks/web/useMessage';
  import { EnumPayStatus } from '/@/enums/serviceEnum';

  const autoCompleteDelayTime = 800;

  export default defineComponent({
    name: 'OrderEditorModal',
    components: {
      BasicModal,
      BasicForm,
      Form,
      FormItem,
      Input,
      AutoComplete,
      SelectOption,
      Empty,
      Textarea: Input.TextArea,
    },
    emits: ['success'],
    setup(_, { emit }) {
      const formData = reactive({
        Id: 0,
        No: '',
        MemberId: 0,
        Remark: '',
        Items: new Array<OrderItemEditorResponse>(),
      });

      const editData = reactive({
        PayStatus: 0,
        MemberLabel: '',
        MemberName: '',
        MemberTel: '',
        AutoCompleteMemberDataSource: new Array<BasicAutoCompleteDataSourceItemKeyValue>(),
        AutoCompleteMemberAjaxHandle: 0,
        AutoCompleteProductDataSource: new Array<BasicAutoCompleteDataSourceItemKeyValue>(),
        AutoCompleteProductAjaxHandle: 0,
      });

      const { createMessage } = useMessage();

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: Nullable<OrderManagerResponse>) => {
          if (data == null) {
            formData.Id = 0;
          } else {
            formData.Id = data.Id;
          }
          formData.MemberId = 0;
          formData.Remark = '';
          editData.PayStatus = 0;
          editData.MemberName = '';
          editData.MemberTel = '';
          formData.Items = [];
          editData.MemberLabel = '';
          setModalProps({ confirmLoading: true, maskClosable: false, width: 800, height: 600 });
          try {
            if (formData.Id > 0) {
              const apiResult = await orderEditorApi({ Id: formData.Id });
              formData.MemberId = apiResult.MemberId;
              formData.Remark = apiResult.Remark;
              formData.Items = apiResult.Items;
              editData.PayStatus = apiResult.PayStatus;
              editData.MemberName = apiResult.MemberName;
              editData.MemberTel = apiResult.MemberTel;
              editData.MemberLabel = `${apiResult.MemberName}(${apiResult.MemberTel})`;
            }
          } catch (ex: any) {}
          setModalProps({ confirmLoading: false });
        },
      );

      async function handleSubmit() {
        if (disableOperator()) {
          closeModal();
          return;
        }
        try {
          if (formData.MemberId == 0) {
            createMessage.error('未选择会员');
            return;
          }
          if (!formData.Items || !formData.Items.length) {
            createMessage.error('产品不能未空');
            return;
          }
          for (let i = 0; i < formData.Items.length; i++) {
            let iItem = formData.Items[i];
            if (iItem.ProductId == 0) {
              createMessage.error('未选择产品');
              return;
            }
            if (iItem.Copies <= 0) {
              createMessage.error('产品必须大于0');
              return;
            }
            for (let j = i + 1; j < formData.Items.length; j++) {
              let jItem = formData.Items[j];
              if (iItem.ProductId == jItem.ProductId) {
                createMessage.error(`产品${iItem.ProductShortName}重复`);
                return;
              }
            }
          }

          setModalProps({ confirmLoading: true });
          var requestModel = {
            Id: formData.Id,
            MemberId: formData.MemberId,
            Remark: formData.Remark,
            Products: formData.Items.map((item) => {
              return { Id: item.ProductId, Copies: item.Copies };
            }),
          };
          var id = await orderSaveApi(requestModel);
          closeModal();
          debugger;
          emit('success', { Id: id });
        } catch (ex: any) {
          console.info(ex);
        } finally {
          setModalProps({ confirmLoading: false });
        }
      }

      /** 是否可以修改 true:不能修改,false:可以修改 */
      function disableOperator() {
        return ![0, EnumPayStatus.未支付].some((item) => item === editData.PayStatus);
      }

      /**
       * 自动填充会员(弹出框)
       */
      function handleMemberSearch(value: string) {
        clearTimeout(editData.AutoCompleteMemberAjaxHandle);
        setTimeout(() => {
          autoQueryMemberListApi({ Keyword: value }).then((ret) => {
            editData.AutoCompleteMemberDataSource = ret.map((item) => {
              return { key: item.Id, value: `${item.Name}(${item.Tel})` };
            });
          });
        }, autoCompleteDelayTime);
      }

      /**
       * 自动填充会员(回调)
       */
      function handleMemberSelect(_: number, option: BasicAutoCompleteDataSourceItemKeyValue) {
        formData.MemberId = option.key;
        editData.MemberLabel = option.value;
      }

      /**
       * 添加产品
       */
      function handleProductAdd() {
        if (formData.Items.some((item) => item.ProductId == 0)) {
          return;
        } else {
          formData.Items.push({ ProductId: 0, ProductShortName: '', Copies: 0 });
        }
      }

      /**
       * 删除产品
       */
      function handleProductDelete(index) {
        formData.Items.splice(index, 1);
      }

      /**
       * 自动填充产品(弹出框)
       */
      function handleProductSearch(value: string) {
        clearTimeout(editData.AutoCompleteMemberAjaxHandle);
        setTimeout(async () => {
          try {
            const ret = await autoQueryProductListApi({ Keyword: value, Type: [] });
            editData.AutoCompleteProductDataSource = ret.map((item) => {
              return { key: item.Id, value: item.ShortName };
            });
          } catch (_: any) {}
        }, autoCompleteDelayTime);
      }

      /**
       * 自动填充产品(回调)
       */
      function handleProductSelect(_: number, option: BasicAutoCompleteDataSourceItemKeyValue) {
        var productId = option.key;
        if (!formData.Items.some((item) => item.ProductId == option.key)) {
          productId = 0;
        }
        formData.Items.filter((item) => item.ProductId == productId).forEach((item) => {
          item.ProductId = option.key;
          item.ProductShortName = option.value;
          item.Copies = 1;
        });
      }

      return {
        registerModal,
        handleSubmit,
        disableOperator,
        formData,
        editData,
        handleMemberSearch,
        handleMemberSelect,
        handleProductAdd,
        handleProductDelete,
        handleProductSearch,
        handleProductSelect,
      };
    },
  });
</script>
<style lang="less">
  @import './OrderEditorModal.less';
</style>
