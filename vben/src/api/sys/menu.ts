import { RouteItem } from './model/menuModel';

import { useUserStore } from '/@/store/modules/user';
import { usePermissionStore } from '/@/store/modules/permission';

export function getMenuList() {
  const userStore = useUserStore();
  const usePermission = usePermissionStore();
  return new Promise<RouteItem[]>((resolve) => {
    const routeItems = new Array<RouteItem>();
    //const permCodes = usePermission.getPermCodeList;
    routeItems.push({
      path: '/dashboard',
      component: 'LAYOUT',
      meta: {
        title: 'routes.dashboard.dashboard',
        hideChildrenInMenu: true,
        icon: 'bx:bx-home',
      },
      name: 'Dashboard',
      redirect: '/dashboard/analysis',
      children: [
        {
          path: 'analysis',
          name: 'Analysis',
          component: '/dashboard/analysis/index',
          meta: {
            hideMenu: true,
            hideBreadcrumb: true,
            title: 'routes.dashboard.analysis',
            currentActiveMenu: '/dashboard',
            icon: 'bx:bx-home',
          },
        },
      ],
    });
    resolve(routeItems);
  });
}
