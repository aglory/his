<template>
  <BasicModal v-bind="$attrs" @register="registerModal" :title="getTitle" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive, computed } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { editorFormSchema } from './MemberManager.config';
  import { MemberManagerResponse } from '../../api/member/model/memberModel';
  import { memberEditorApi, memberSaveApi } from '/@/api/member/member';

  export default defineComponent({
    name: 'AccountEditorModal',
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
        async (data: MemberManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          setModalProps({ confirmLoading: true, maskClosable: false });
          try {
            const apiResult = await memberEditorApi({ Id: data.Id });
            setFieldsValue({
              ...apiResult,
            });
          } catch (ex: any) {}
          updateSchema([
            {
              field: 'Type',
              componentProps: {
                disabled: model.Id > 0,
              },
            },
          ]);
          setModalProps({ confirmLoading: false });
        },
      );

      const getTitle = computed(() => {
        if (model.Id == 0) {
          return '创建会员';
        } else {
          return '编辑会员';
        }
      });

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await memberSaveApi(values);
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
