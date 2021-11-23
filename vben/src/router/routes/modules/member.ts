import type { AppRouteModule } from '/@/router/types';
import { LAYOUT } from '/@/router/constant';
import { EnumPermission } from '/@/enums/serviceEnum';

const member: AppRouteModule = {
  path: '/member',
  name: 'member',
  component: LAYOUT,
  redirect: '/member/MemberManager',
  meta: {
    icon: 'ant-design:user-outlined',
    title: '会员管理',
    orderNo: 1,
    permissions: [EnumPermission.会员管理],
  },
  children: [
    {
      path: 'MemberManager',
      name: 'MemberManager',
      component: () => {
        return import('/@/views/member/MemberManager.vue');
      },
      meta: {
        title: '会员管理',
        permissions: [EnumPermission.会员管理],
      },
    },
    {
      path: 'MemberBalanceHistoryManager',
      name: 'MemberBalanceHistoryManager',
      component: () => {
        return import('/@/views/member/MemberBalanceHistoryManager.vue');
      },
      meta: {
        title: '会员流水',
        permissions: [EnumPermission.流水管理],
      },
    },
    {
      path: 'MemberIntegralHistoryManager',
      name: 'MemberIntegralHistoryManager',
      component: () => {
        return import('/@/views/member/MemberIntegralHistoryManager.vue');
      },
      meta: {
        title: '积分流水',
        permissions: [EnumPermission.流水管理],
      },
    },
  ],
};

export default member;
