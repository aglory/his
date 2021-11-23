<template>
  <BasicModal v-bind="$attrs" @register="registerModal" :title="getTitle" @ok="handleSubmit">
    <BasicForm @register="registerForm" />
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive, computed } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { BasicForm, useForm } from '/@/components/Form/index';
  import { editorFormSchema } from './Messagemanager.config';
  import { MessageManagerResponse } from '/@/api/system/model/messageModel';
  import { messageEditorApi, messageSaveApi } from '/@/api/system/system';

  export default defineComponent({
    name: 'AccountEditorModal',
    components: { BasicModal, BasicForm },
    emits: ['success'],
    setup(_, { emit }) {
      const model = reactive({ Id: 0 });

      const [registerForm, { setFieldsValue, resetFields, validate }] = useForm({
        labelWidth: 100,
        schemas: editorFormSchema,
        showActionButtonGroup: false,
        actionColOptions: {
          span: 25,
        },
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: MessageManagerResponse) => {
          model.Id = data.Id;
          resetFields();
          setModalProps({ confirmLoading: true, maskClosable: false });
          const apiResult = await messageEditorApi({ Id: data.Id });
          setFieldsValue({
            ...apiResult,
          });
          setModalProps({ confirmLoading: false });
        },
      );

      const getTitle = computed(() => {
        if (model.Id == 0) {
          return '创建公告';
        } else {
          return '编辑公告';
        }
      });

      async function handleSubmit() {
        try {
          const values = await validate();
          setModalProps({ confirmLoading: true });
          await messageSaveApi(values);
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
