<template>
  <BasicModal v-bind="$attrs" @register="registerModal" title="修改排列" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { changeOrderIndexSchema } from './productManager.config';
  import { productChangeOrderIndexApi } from '/@/api/product/product';
  import { ProductManagerResponse } from '/@/api/product/model/productModel';

  export default defineComponent({
    name: 'ProductOrderIndexEditorModal',
    components: { BasicModal, BasicForm },
    emits: ['success'],
    setup(_, { emit }) {
      const model = reactive({ Id: 0, OrderIndex: 0 });

      const [registerForm, { setFieldsValue, resetFields, validate }] = useForm({
        labelWidth: 100,
        schemas: changeOrderIndexSchema,
        showActionButtonGroup: false,
        actionColOptions: {
          span: 25,
        },
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: ProductManagerResponse) => {
          model.Id = data.Id;
          model.OrderIndex = data.OrderIndex;
          resetFields();
          setModalProps({ confirmLoading: false, maskClosable: false });
          setFieldsValue(model);
        },
      );

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await productChangeOrderIndexApi(values);
          closeModal();
          emit('success');
        } catch (ex: any) {
          console.info(ex);
        } finally {
          setModalProps({ confirmLoading: false });
        }
      }

      return { registerModal, registerForm, handleSubmit };
    },
  });
</script>
