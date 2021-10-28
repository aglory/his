import type { AppRouteModule } from '/@/router/types';
import { LAYOUT } from '/@/router/constant';
import { EnumPermission } from '/@/enums/serviceEnum';

const product: AppRouteModule = {
  path: '/product',
  name: 'product',
  component: LAYOUT,
  redirect: '/product/ProductManager',
  meta: {
    icon: 'ant-design:shop-outlined',
    title: '产品管理',
    orderNo: 2,
    permissions: [EnumPermission.产品管理],
  },
  children: [
    {
      path: 'ProductManager',
      name: 'ProductManager',
      component: () => {
        return import('/@/views/product/ProductManager.vue');
      },
      meta: {
        title: '产品管理',
        permissions: [EnumPermission.产品管理],
      },
    },
  ],
};

export default product;
