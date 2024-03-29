import type { AppRouteRecordRaw, Menu } from '/@/router/types';

import { defineStore } from 'pinia';
import { store } from '/@/store';
import { useUserStore } from './user';
import { toRaw } from 'vue';
import { flatMultiLevelRoutes } from '/@/router/helper/routeHelper';
import { transformRouteToMenu } from '/@/router/helper/menuHelper';
import { asyncRoutes } from '/@/router/routes';
import { ERROR_LOG_ROUTE } from '/@/router/routes/basic';

import { filter } from '/@/utils/helper/treeHelper';

import { PageEnum } from '/@/enums/pageEnum';

interface PermissionState {
  // Permission code list
  permCodeList: string[] | number[];
  // Whether the route has been dynamically added
  isDynamicAddedRoute: boolean;
  // To trigger a menu update
  lastBuildMenuTime: number;
  // Backstage menu list
  backMenuList: Menu[];
  frontMenuList: Menu[];
}
export const usePermissionStore = defineStore({
  id: 'app-permission',
  state: (): PermissionState => ({
    permCodeList: [],
    // Whether the route has been dynamically added
    isDynamicAddedRoute: false,
    // To trigger a menu update
    lastBuildMenuTime: 0,
    // Backstage menu list
    backMenuList: [],
    // menu List
    frontMenuList: [],
  }),
  getters: {
    getPermCodeList(): string[] | number[] {
      return this.permCodeList;
    },
    getBackMenuList(): Menu[] {
      return this.backMenuList;
    },
    getFrontMenuList(): Menu[] {
      return this.frontMenuList;
    },
    getLastBuildMenuTime(): number {
      return this.lastBuildMenuTime;
    },
    getIsDynamicAddedRoute(): boolean {
      return this.isDynamicAddedRoute;
    },
  },
  actions: {
    setPermCodeList(codeList: string[]) {
      this.permCodeList = codeList;
    },

    setBackMenuList(list: Menu[]) {
      this.backMenuList = list;
      list?.length > 0 && this.setLastBuildMenuTime();
    },

    setFrontMenuList(list: Menu[]) {
      this.frontMenuList = list;
    },

    setLastBuildMenuTime() {
      this.lastBuildMenuTime = new Date().getTime();
    },

    setDynamicAddedRoute(added: boolean) {
      this.isDynamicAddedRoute = added;
    },
    resetState(): void {
      this.isDynamicAddedRoute = false;
      this.permCodeList = [];
      this.backMenuList = [];
      this.lastBuildMenuTime = 0;
    },
    async changePermissionCode() {
      const userStore = useUserStore();
      userStore.logout();
    },
    buildRoutesAction(): Promise<AppRouteRecordRaw[]> {
      return new Promise((resolve, reject) => {
        const userStore = useUserStore();
        let routes: AppRouteRecordRaw[] = [];
        const permissionCodes = toRaw(userStore.getPermissionCodes);
        const routeFilter = (route: AppRouteRecordRaw) => {
          const { meta } = route;
          const { permissions } = meta || {};
          if (!permissions) return true;

          return permissions.some((permission) =>
            permissionCodes.some((permissionCode) => permissionCode == permission),
          );
        };

        const routeRemoveIgnoreFilter = (route: AppRouteRecordRaw) => {
          const { meta } = route;
          const { ignoreRoute } = meta || {};
          return !ignoreRoute;
        };

        /**
         * @description 根据设置的首页path，修正routes中的affix标记（固定首页）
         * */
        const patchHomeAffix = (routes: AppRouteRecordRaw[]) => {
          if (!routes || routes.length === 0) return;
          let homePath: string = PageEnum.BASE_HOME;
          function patcher(routes: AppRouteRecordRaw[], parentPath = '') {
            if (parentPath) parentPath = parentPath + '/';
            routes.forEach((route: AppRouteRecordRaw) => {
              const { path, children, redirect } = route;
              const currentPath = path.startsWith('/') ? path : parentPath + path;
              if (currentPath === homePath) {
                if (redirect) {
                  homePath = route.redirect! as string;
                } else {
                  route.meta = Object.assign({}, route.meta, { affix: true });
                }
              }
              children && children.length > 0 && patcher(children, currentPath);
            });
          }
          try {
            patcher(routes);
          } catch (e) {
            reject(e);
            // 已处理完毕跳出循环
          }
          resolve(routes);
        };

        routes = filter(asyncRoutes, routeFilter);
        routes = routes.filter(routeFilter);
        const menuList = transformRouteToMenu(routes, true);
        routes = filter(routes, routeRemoveIgnoreFilter);
        routes = routes.filter(routeRemoveIgnoreFilter);
        menuList.sort((a, b) => {
          return (a.meta?.orderNo || 0) - (b.meta?.orderNo || 0);
        });

        this.setFrontMenuList(menuList);
        routes = flatMultiLevelRoutes(routes);

        routes.push(ERROR_LOG_ROUTE);
        patchHomeAffix(routes);
        return routes;
      });
    },
  },
});

// Need to be used outside the setup
export function usePermissionStoreWithOut() {
  return usePermissionStore(store);
}
