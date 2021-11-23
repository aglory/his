<template>
  <BasicModal v-bind="$attrs" @register="registerModal" title="付款单" @ok="handleSubmit">
    <Form
      layout="horizontal"
      :labelCol="{ span: 4 }"
      :wrapperCol="{ span: 18 }"
      class="OrderPayEditorModal"
    >
      <FormItem label="总金额">
        <Input v-model:value="editData.Amount" disabled />
      </FormItem>
      <FormItem label="优惠金额">
        <InputNumber v-model:value="formData.PreferenceAmount" :disabled="disableOperator()" />
      </FormItem>
      <FormItem label="积分支付">
        <div class="InputGroup">
          <InputNumber v-model:value="formData.IntegralAmount" :disabled="disableOperator()" />
          <Input :disabled="true" addonBefore="抵扣" :value="formData.IntegralAmount * 0.01" />
          <a-button
            type="primary"
            :disabled="editData.MemberIntegral == 0 || disableOperator()"
            @click="handAllMemberIntegral"
            >全部</a-button
          >
        </div>
        <div v-if="editData.PayStatus == EnumPayStatus.未支付">
          积分:
          <span :class="[editData.MemberIntegral > 0 ? 'page-color-green' : '']">{{
            editData.MemberIntegral
          }}</span>
        </div>
      </FormItem>
      <FormItem label="余额支付">
        <div class="InputGroup">
          <InputNumber v-model:value="formData.BalanceAmount" :disabled="disableOperator()" />
          <a-button
            type="primary"
            :disabled="editData.MemberBalance == 0 || disableOperator()"
            @click="handAllMemberBalance"
            >全部</a-button
          >
        </div>
        <div v-if="editData.PayStatus == EnumPayStatus.未支付">
          余额:
          <span :class="[editData.MemberBalance > 0 ? 'page-color-green' : '']">{{
            editData.MemberBalance
          }}</span>
        </div>
      </FormItem>
      <FormItem label="在线支付">
        <div class="InputGroup">
          <InputNumber v-model:value="formData.OnlineAmount" :disabled="disableOperator()" />
          <a-button
            type="primary"
            :disabled="editData.PayStatus != EnumPayStatus.未支付"
            @click="handAllOnlineAmount"
            >全部</a-button
          >
        </div>
      </FormItem>
      <FormItem label="现金支付">
        <div class="InputGroup">
          <InputNumber v-model:value="formData.CashAmount" :disabled="disableOperator()" />
          <a-button
            type="primary"
            :disabled="editData.PayStatus != EnumPayStatus.未支付"
            @click="handAllCashAmount"
            >全部</a-button
          >
        </div>
      </FormItem>
    </Form>
  </BasicModal>
</template>

<script lang="ts">
  import { defineComponent, reactive } from 'vue';
  import { BasicModal, useModalInner } from '/@/components/Modal';
  import { orderPayEditorApi, orderPaySaveApi } from '/@/api/order/order';
  import { Form, FormItem, Input, InputNumber } from 'ant-design-vue';
  import { EnumPayStatus } from '/@/enums/serviceEnum';

  export default defineComponent({
    name: 'AccountEditorModal',
    components: { BasicModal, Form, FormItem, Input, InputNumber },
    emits: ['success'],
    setup(_, { emit }) {
      const formData = reactive({
        MemberId: 0,
        PreferenceAmount: 0,
        BalanceAmount: 0,
        IntegralAmount: 0,
        OnlineAmount: 0,
        CashAmount: 0,
        ProduceIntegral: 0,
      });

      const editData = reactive({
        Id: 0,
        Amount: 0,
        MemberBalance: 0,
        MemberIntegral: 0,
        PayStatus: 0,
      });

      const [registerModal, { setModalProps, closeModal }] = useModalInner(
        async (data: { Id: number }) => {
          editData.Id = data.Id;
          setModalProps({ confirmLoading: true, maskClosable: false });
          try {
            const apiResult = await orderPayEditorApi({ Id: data.Id });
            formData.MemberId = apiResult.MemberId;
            formData.PreferenceAmount = apiResult.PreferenceAmount;
            formData.BalanceAmount = apiResult.BalanceAmount;
            formData.IntegralAmount = apiResult.IntegralAmount;
            formData.OnlineAmount = apiResult.OnlineAmount;
            formData.CashAmount = apiResult.CashAmount;
            formData.ProduceIntegral = apiResult.ProduceIntegral;
            editData.Amount = apiResult.Amount;
            editData.PayStatus = apiResult.PayStatus;
            editData.MemberBalance = apiResult.MemberBalance;
            editData.MemberIntegral = apiResult.MemberIntegral;
          } catch (ex: any) {}
          setModalProps({ confirmLoading: false });
        },
      );

      async function handleSubmit() {
        if (disableOperator()) {
          closeModal();
          return;
        }
        try {
          setModalProps({ confirmLoading: true });
          var requestModel = {
            Id: editData.Id,
            PreferenceAmount: formData.PreferenceAmount,
            BalanceAmount: formData.BalanceAmount,
            IntegralAmount: formData.IntegralAmount,
            OnlineAmount: formData.OnlineAmount,
            CashAmount: formData.CashAmount,
          };
          await orderPaySaveApi(requestModel);
          closeModal();
          emit('success');
        } catch (ex: any) {
          console.info(ex);
        } finally {
          setModalProps({ confirmLoading: false });
        }
      }

      /** 是否可以修改 true:不能修改,false:可以修改 */
      function disableOperator() {
        return ![0, EnumPayStatus.未支付].some((item) => item === editData.PayStatus);
      }

      /**
       * 全部积分支付
       */
      function handAllMemberIntegral() {
        if (editData.MemberIntegral * 0.01 > editData.Amount - formData.PreferenceAmount) {
          formData.IntegralAmount = (editData.Amount - formData.PreferenceAmount) * 100;
        } else {
          formData.IntegralAmount = editData.MemberIntegral;
        }
      }

      /**
       * 全部余额支付
       */
      function handAllMemberBalance() {
        if (
          editData.MemberBalance >
          editData.Amount - formData.PreferenceAmount - formData.IntegralAmount * 0.01
        ) {
          formData.BalanceAmount =
            editData.Amount - formData.PreferenceAmount - formData.IntegralAmount * 0.01;
        } else {
          formData.BalanceAmount = editData.MemberBalance;
        }
      }

      /**
       * 全部余额支付
       */
      function handAllOnlineAmount() {
        const amount =
          editData.Amount -
          formData.PreferenceAmount -
          formData.IntegralAmount * 0.01 -
          formData.BalanceAmount;
        if (amount > 0) {
          formData.OnlineAmount = amount;
        } else {
          formData.OnlineAmount = 0;
        }
        formData.CashAmount = 0;
      }

      /**
       * 全部现金支付
       */
      function handAllCashAmount() {
        const amount =
          editData.Amount -
          formData.PreferenceAmount -
          formData.IntegralAmount * 0.01 -
          formData.BalanceAmount;
        if (amount > 0) {
          formData.CashAmount = amount;
        } else {
          formData.CashAmount = 0;
        }
        formData.OnlineAmount = 0;
      }

      return {
        registerModal,
        handleSubmit,
        disableOperator,
        formData,
        editData,
        EnumPayStatus,
        handAllMemberBalance,
        handAllMemberIntegral,
        handAllOnlineAmount,
        handAllCashAmount,
      };
    },
  });
</script>

<style lang="less">
  @import './OrderPayEditorModal.less';
</style>
