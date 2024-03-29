<template>
  <BasicModal v-bind="$attrs" @register="registerModal" :title="getTitle" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive, computed } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { editorFormSchema } from './Sitemanager.config';
  import { SiteManagerResponse } from '/@/api/account/model/siteModel';
  import { siteEditorApi, siteSaveApi } from '/@/api/account/account';

  export default defineComponent({
    name: 'RoleEditorModal',
    components: { BasicModal, BasicForm },
    emits: ['success'],
    setup(_, { emit }) {
      const model = reactive({ Id: 0 });

      const [registerForm, { setFieldsValue, updateSchema, resetFields, validate }] = useForm({
        labelWidth: 100,
        schemas: editorFormSchema,
        showActionButtonGroup: false,
        actionColOptions: {
          span: 25,
        },
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: SiteManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          setModalProps({ confirmLoading: true, maskClosable: false });
          let accountIds: any = [];
          try {
            let apiResult = await siteEditorApi({ Id: data.Id });
            accountIds = apiResult.Account.map((item) => {
              return { label: item.LoginName, value: item.Id };
            });
            setFieldsValue({
              ...apiResult,
            });
          } catch (ex: any) {}
          updateSchema([
            {
              field: 'AccountId',
              componentProps: {
                options: accountIds,
              },
            },
          ]);
          setModalProps({ confirmLoading: false });
        },
      );

      const getTitle = computed(() => {
        if (model.Id == 0) {
          return '创建站点';
        } else {
          return '编辑站点';
        }
      });

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await siteSaveApi(values);
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
