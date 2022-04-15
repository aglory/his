<template>
  <BasicModal v-bind="$attrs" @register="registerModal" title="修改密码" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>
<script lang="ts">
  import { defineComponent } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal/index';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { changePasswordApi } from '/@/api/state/state';

  export default defineComponent({
    name: 'ChangePasswordModal',
    components: { BasicModal, BasicForm },

    setup() {
      const [registerModal, { closeModal, setModalProps }] = useModalInner();

      const [registerForm, { validate, resetFields }] = useForm({
        showActionButtonGroup: false,
        schemas: [
          {
            field: 'Password',
            label: '密码',
            component: 'StrengthMeter',
            required: true,
          },
          {
            field: 'RepeatPassword',
            label: '重复密码',
            component: 'StrengthMeter',
            required: true,
            dynamicRules: ({ values }) => {
              return [
                {
                  required: true,
                  validator: (_, value) => {
                    if (!value) {
                      return Promise.reject('密码不能为空');
                    }
                    if (value !== values.Password) {
                      return Promise.reject('两次输入的密码不一致!');
                    }
                    return Promise.resolve();
                  },
                },
              ];
            },
          },
        ],
      });

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await changePasswordApi(values);
          await resetFields();
          closeModal();
        } catch (ex: any) {
          console.info(ex);
        } finally {
          setModalProps({ confirmLoading: false });
        }
      }

      return {
        registerModal,
        registerForm,
        handleSubmit,
      };
    },
  });
</script>
