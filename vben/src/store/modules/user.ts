import type { UserInfo } from '/#/store';
import type { ErrorMessageMode } from '/#/axios';
import { defineStore } from 'pinia';
import { store } from '/@/store';
import { EnumPermission } from '/@/enums/serviceEnum';
import { PageEnum } from '/@/enums/pageEnum';
import { TOKEN_KEY, USER_INFO_KEY } from '/@/enums/cacheEnum';
import { getAuthCache, setAuthCache } from '/@/utils/auth';
import { useMessage } from '/@/hooks/web/useMessage';
import { router } from '/@/router';
import { h } from 'vue';
import { LoginRequest, LoginResponse } from '/@/api/state/model/loginModel';
import { loginApi, logoutApi } from '/@/api/state/state';
import { usePermissionStore } from '/@/store/modules/permission';
import { RouteRecordRaw } from 'vue-router';
import { PAGE_NOT_FOUND_ROUTE } from '/@/router/routes/basic';

interface UserState {
  userInfo: Nullable<UserInfo>;
  token?: string;
  sessionTimeout?: boolean;
  lastUpdateTime: number;
}

export const useUserStore = defineStore({
  id: 'app-user',
  state: (): UserState => ({
    userInfo: null,
    // token
    token: undefined,
    // Whether the login expired
    sessionTimeout: false,
    // Last fetch time
    lastUpdateTime: 0,
  }),
  getters: {
    getUserInfo(): UserInfo {
      return this.userInfo || getAuthCache<UserInfo>(USER_INFO_KEY) || { Permission: [] };
    },
    getPermissionCodes(): EnumPermission[] {
      return this.getUserInfo.Permission;
    },
    getToken(): string {
      return this.token || getAuthCache<string>(TOKEN_KEY);
    },
    getSessionTimeout(): boolean {
      return !!this.sessionTimeout;
    },
    getLastUpdateTime(): number {
      return this.lastUpdateTime;
    },
  },
  actions: {
    setToken(info: string | undefined) {
      this.token = info ? info : ''; // for null or undefined value
      setAuthCache(TOKEN_KEY, info);
    },
    setUserInfo(info: UserInfo | null) {
      this.userInfo = info;
      this.lastUpdateTime = new Date().getTime();
      setAuthCache(USER_INFO_KEY, info);
    },
    setSessionTimeout(flag: boolean) {
      this.sessionTimeout = flag;
    },
    resetState() {
      this.userInfo = null;
      this.token = '';
      this.sessionTimeout = false;
      this.lastUpdateTime = 0;
    },
    /**
     * @description: login
     */
    async login(
      params: LoginRequest & {
        goHome?: boolean;
        mode?: ErrorMessageMode;
      },
    ): Promise<LoginResponse> {
      try {
        const { goHome = true, mode, ...loginParams } = params;
        const data = await loginApi(loginParams, mode);
        this.setUserInfo(data);
        const { Token } = data;
        this.setToken(Token);
        await this.afterLoginAction(goHome);
        return Promise.resolve(data);
      } catch (error) {
        return Promise.reject(error);
      }
    },
    async afterLoginAction(goHome?: boolean): Promise<void> {
      const permissionStore = usePermissionStore();
      if (!permissionStore.isDynamicAddedRoute) {
        const routes = await permissionStore.buildRoutesAction();
        routes.forEach((route) => {
          router.addRoute(route as unknown as RouteRecordRaw);
        });
        router.addRoute(PAGE_NOT_FOUND_ROUTE as unknown as RouteRecordRaw);
        permissionStore.setDynamicAddedRoute(true);
      }
      goHome && (await router.replace(PageEnum.BASE_HOME));
      return Promise.resolve();
    },
    /**
     * @description: logout
     */
    async logout(goLogin = false) {
      if (this.getToken) {
        try {
          await logoutApi();
        } catch {
          console.log('注销Token失败');
        }
      }
      this.setToken(undefined);
      this.setSessionTimeout(false);
      this.setUserInfo(null);
      goLogin && router.push(PageEnum.BASE_LOGIN);
    },

    /**
     * @description: Confirm before logging out
     */
    confirmLoginOut() {
      const { createConfirm } = useMessage();
      createConfirm({
        iconType: 'warning',
        title: () => h('span', '温馨提醒'),
        content: () => h('span', '是否确认退出系统?'),
        onOk: async () => {
          await this.logout(true);
        },
      });
    },
  },
});

// Need to be used outside the setup
export function useUserStoreWithOut() {
  return useUserStore(store);
}
