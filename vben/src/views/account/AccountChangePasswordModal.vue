<template>
  <BasicModal v-bind="$attrs" @register="registerModal" title="修改密码" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { changePasswordFormSchema } from './Accountmanager.config';
  import { accountChangePasswordApi } from '/@/api/account/account';
  import { AccountManagerResponse } from '../../api/account/model/accountModel';

  export default defineComponent({
    name: 'AccountChangePasswordModal',
    components: { BasicModal, BasicForm },
    emits: ['success'],
    setup(_, { emit }) {
      const model = reactive({ Id: 0 });

      const [registerForm, { setFieldsValue, resetFields, validate }] = useForm({
        labelWidth: 100,
        schemas: changePasswordFormSchema,
        showActionButtonGroup: false,
        actionColOptions: {
          span: 25,
        },
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: AccountManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          setModalProps({ confirmLoading: false, maskClosable: false });
          setFieldsValue({
            Id: model.Id,
            Password: '',
            RePassword: '',
          });
        },
      );

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await accountChangePasswordApi(values);
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
