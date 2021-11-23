import type { AppRouteModule } from '/@/router/types';
import { LAYOUT } from '/@/router/constant';
import { EnumPermission } from '/@/enums/serviceEnum';

const account: AppRouteModule = {
  path: '/system',
  name: 'system',
  component: LAYOUT,
  redirect: '/system/MessageManager',
  meta: {
    icon: 'ion:settings-outline',
    title: '系统管理',
    orderNo: 1000,
    permissions: [EnumPermission.公告管理],
  },
  children: [
    {
      path: 'MessageManager',
      name: 'MessageManager',
      component: () => {
        return import('/@/views/system/MessageManager.vue');
      },
      meta: {
        title: '公告管理',
        permissions: [EnumPermission.公告管理],
      },
    },
    {
      path: 'EnterpriseCashHistoryManager',
      name: 'EnterpriseCashHistoryManager',
      component: () => {
        return import('/@/views/system/EnterpriseCashHistoryManager.vue');
      },
      meta: {
        title: '现金流水',
        permissions: [EnumPermission.现金管理],
      },
    },
  ],
};

export default account;
