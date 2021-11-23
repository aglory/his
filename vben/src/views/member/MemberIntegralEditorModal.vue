<template>
  <BasicModal v-bind="$attrs" @register="registerModal" title="上下分" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { changeIntegralFormSchema } from './MemberManager.config';
  import { MemberManagerResponse } from '/@/api/member/model/memberModel';
  import { memberChangeIntegralApi } from '/@/api/member/member';

  export default defineComponent({
    name: 'MemberIntegralEditorModal',
    components: { BasicModal, BasicForm },
    emits: ['success'],
    setup(_, { emit }) {
      const model = reactive({ Id: 0 });

      const [registerForm, { setFieldsValue, resetFields, validate }] = useForm({
        labelWidth: 100,
        schemas: changeIntegralFormSchema,
        showActionButtonGroup: false,
        actionColOptions: {
          span: 25,
        },
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: MemberManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          setModalProps({ confirmLoading: true, maskClosable: false });

          setFieldsValue({
            Id: data.Id,
            Integral: data.Integral,
            Amount: 0,
          });

          setModalProps({ confirmLoading: false });
        },
      );

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await memberChangeIntegralApi(values);
          closeModal();
          emit('success');
        } catch (ex: any) {
          console.info(ex);
        } finally {
          setModalProps({ confirmLoading: false });
        }
      }

      return {
        registerModal: <any>registerModal,
        registerForm: <any>registerForm,
        handleSubmit,
      };
    },
  });
</script>
