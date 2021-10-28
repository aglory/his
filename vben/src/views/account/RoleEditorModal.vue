<template>
  <BasicModal v-bind="$attrs" @register="registerModal" :title="getTitle" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive, computed } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { editorFormSchema } from './rolemanager.config';
  import { RoleManagerResponse } from '/@/api/account/model/roleModel';
  import { roleEditorApi, roleSaveApi } from '/@/api/account/account';

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
        async (data: RoleManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          let permissions: any = [];
          try {
            setModalProps({ confirmLoading: true, maskClosable: false });
            const apiResult = await roleEditorApi({ Id: data.Id });
            permissions = apiResult.TempPermission.map((item) => {
              return { label: item.Name, value: item.Id };
            });
            setFieldsValue({
              ...apiResult,
            });
          } catch (ex: any) {}
          updateSchema([
            {
              field: 'Permission',
              componentProps: {
                options: permissions,
              },
            },
          ]);
          setModalProps({ confirmLoading: false });
        },
      );

      const getTitle = computed(() => {
        if (model.Id == 0) {
          return '创建管理';
        } else {
          return '编辑管理';
        }
      });

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await roleSaveApi(values);
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
