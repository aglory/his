import type { AppRouteModule } from '/@/router/types';
import { LAYOUT } from '/@/router/constant';
import { EnumPermission } from '/@/enums/serviceEnum';

const account: AppRouteModule = {
  path: '/account',
  name: 'account',
  component: LAYOUT,
  redirect: '/account/AccountManager',
  meta: {
    icon: 'bx:bxs-user-account',
    title: '帐号管理',
    orderNo: 100000,
    permissions: [EnumPermission.帐号管理, EnumPermission.角色管理, EnumPermission.站点管理],
  },
  children: [
    {
      path: 'AccountManager',
      name: 'AccountManager',
      component: () => {
        return import('/@/views/account/AccountManager.vue');
      },
      meta: {
        title: '帐号管理',
        permissions: [EnumPermission.帐号管理],
      },
    },
    {
      path: 'RoleManager',
      name: 'RoleManager',
      component: () => {
        return import('/@/views/account/RoleManager.vue');
      },
      meta: {
        title: '角色管理',
        permissions: [EnumPermission.角色管理],
      },
    },
    {
      path: 'SiteManager',
      name: 'SiteManager',
      component: () => {
        return import('/@/views/account/SiteManager.vue');
      },
      meta: {
        title: '站点管理',
        permissions: [EnumPermission.站点管理],
      },
    },
  ],
};

export default account;
