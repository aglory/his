<template>
  <div :class="prefixCls">
    <Popover title="" trigger="click" :overlayClassName="`${prefixCls}__overlay`">
      <Badge :count="count" dot>
        <BellOutlined />
      </Badge>
      <template #content>
        <div
          class="messageitem"
          v-for="(item, index) in model"
          :key="index"
          @click="handItemClick(item)"
        >
          {{ item.Title }}
        </div>
      </template>
    </Popover>
  </div>
</template>
<script lang="ts">
  import { computed, defineComponent, reactive } from 'vue';
  import { Popover, Tabs, Badge } from 'ant-design-vue';
  import { BellOutlined } from '@ant-design/icons-vue';
  import NoticeList from './NoticeList.vue';
  import { useDesign } from '/@/hooks/web/useDesign';
  import { useMessage } from '/@/hooks/web/useMessage';
  import { messageListApi } from '/@/api/system/system';
  import { MessageListResponse } from '/@/api/system/model/messageModel';

  export default defineComponent({
    components: { Popover, BellOutlined, Tabs, TabPane: Tabs.TabPane, Badge, NoticeList },
    setup() {
      const { prefixCls } = useDesign('header-notify');
      const { createInfoModal } = useMessage();
      const model = reactive<MessageListResponse[]>([]);

      const count = computed(() => {
        return model.length;
      });

      messageListApi().then((ret) => {
        model.splice(0, model.length);
        ret.forEach((o) => {
          model.push(o);
        });
      });

      function handItemClick(item: MessageListResponse) {
        createInfoModal({ title: item.Title, content: item.Content });
      }

      return {
        prefixCls,
        count,
        model,
        handItemClick,
      };
    },
  });
</script>
<style lang="less">
  @prefix-cls: ~'@{namespace}-header-notify';

  .@{prefix-cls} {
    padding-top: 2px;

    &__overlay {
      max-width: 360px;
      min-width: 200px;

      .ant-popover-inner-content {
        .messageitem {
          cursor: pointer;
          border-bottom: 1px dashed black;

          &:last-child {
            border-bottom-style: none;
          }
        }
      }
    }
  }
</style>
