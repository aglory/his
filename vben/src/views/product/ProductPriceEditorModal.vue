<template>
  <BasicModal v-bind="$attrs" @register="registerModal" title="修改价格" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { changePriceFormSchema } from './productManager.config';
  import { productPriceEditorApi, productPriceSaveApi } from '/@/api/product/product';
  import { ProductManagerResponse } from '/@/api/product/model/productModel';

  export default defineComponent({
    name: 'ProductPriceEditorModal',
    components: { BasicModal, BasicForm },
    emits: ['success'],
    setup(_, { emit }) {
      const model = reactive({ Id: 0 });

      const [registerForm, { setFieldsValue, resetFields, validate }] = useForm({
        labelWidth: 100,
        schemas: changePriceFormSchema,
        showActionButtonGroup: false,
        actionColOptions: {
          span: 25,
        },
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: ProductManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          setModalProps({ confirmLoading: true, maskClosable: false });
          try {
            const apiResult = await productPriceEditorApi({ Id: model.Id });
            setFieldsValue(apiResult);
          } catch (ex: any) {}
          setModalProps({ confirmLoading: false });
        },
      );

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await productPriceSaveApi(values);
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
