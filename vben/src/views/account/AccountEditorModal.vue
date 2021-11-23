<template>
  <BasicModal v-bind="$attrs" @register="registerModal" :title="getTitle" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive, computed } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { editorFormSchema } from './Accountmanager.config';
  import { AccountManagerResponse } from '../../api/account/model/accountModel';
  import { accountEditorApi, accountSaveApi } from '/@/api/account/account';

  import { useUserStore } from '/@/store/modules/user';
  import { EnumAccountType } from '/@/enums/serviceEnum';

  export default defineComponent({
    name: 'AccountEditorModal',
    components: { BasicModal, BasicForm },
    emits: ['success'],
    setup(_, { emit }) {
      const model = reactive({ Id: 0 });
      const userStore = useUserStore();

      const [registerForm, { setFieldsValue, updateSchema, resetFields, validate }] = useForm({
        labelWidth: 100,
        schemas: editorFormSchema,
        showActionButtonGroup: false,
        actionColOptions: {
          span: 25,
        },
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: AccountManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          setModalProps({ confirmLoading: true, maskClosable: false });
          let roles: any = [];
          try {
            const apiResult = await accountEditorApi({ Id: data.Id });
            if (model.Id == 0) {
              if (userStore.getUserInfo.Type == EnumAccountType.配置员) {
                apiResult.Type = EnumAccountType.管理员;
              } else {
                apiResult.Type = EnumAccountType.领导;
              }
            }
            roles = apiResult.TempRole.map((item) => {
              return { label: item.Name, value: item.Id };
            });
            setFieldsValue({
              ...apiResult,
            });
          } catch (ex: any) {}
          if (model.Id == 0) {
            updateSchema([
              {
                field: 'Password',
                show: true,
              },
              {
                field: 'RepeatPassword',
                show: true,
              },
            ]);
          } else {
            updateSchema([
              {
                field: 'Password',
                show: false,
                required: false,
              },
              {
                field: 'RepeatPassword',
                show: false,
                dynamicRules: () => {
                  return [];
                },
              },
            ]);
          }
          if (userStore.getUserInfo.Type == EnumAccountType.配置员) {
            updateSchema([
              {
                field: 'Type',
                defaultValue: EnumAccountType.管理员,
                componentProps: {
                  options: [
                    {
                      label: EnumAccountType[EnumAccountType.管理员],
                      value: EnumAccountType.管理员,
                    },
                  ],
                  disabled: model.Id != 0,
                },
              },
            ]);
          } else {
            updateSchema([
              {
                field: 'Type',
                defaultValue: EnumAccountType.员工,
                componentProps: {
                  options: [
                    {
                      label: EnumAccountType[EnumAccountType.领导],
                      value: EnumAccountType.领导,
                    },
                    {
                      label: EnumAccountType[EnumAccountType.员工],
                      value: EnumAccountType.员工,
                    },
                  ],
                  disabled: model.Id != 0,
                },
              },
            ]);
          }
          updateSchema([
            {
              field: 'Role',
              componentProps: {
                options: roles,
              },
            },
          ]);
          setModalProps({ confirmLoading: false });
        },
      );

      const getTitle = computed(() => {
        if (model.Id == 0) {
          return '创建帐号';
        } else {
          return '编辑帐号';
        }
      });

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await accountSaveApi(values);
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
        getTitle,
        handleSubmit,
      };
    },
  });
</script>
