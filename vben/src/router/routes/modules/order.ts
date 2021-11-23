import type { AppRouteModule } from '/@/router/types';
import { LAYOUT } from '/@/router/constant';
import { EnumPermission } from '/@/enums/serviceEnum';

const order: AppRouteModule = {
  path: '/order',
  name: 'order',
  component: LAYOUT,
  redirect: '/order/orderManager',
  meta: {
    icon: 'ant-design:unordered-list-outlined',
    title: '订单管理',
    orderNo: 4,
    permissions: [EnumPermission.订单管理],
  },
  children: [
    {
      path: 'orderManager',
      name: 'orderManager',
      component: () => {
        return import('/@/views/order/orderManager.vue');
      },
      meta: {
        title: '订单管理',
        permissions: [EnumPermission.订单管理],
      },
    },
  ],
};

export default order;
