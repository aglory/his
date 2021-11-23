/**
 * 权限码
 */
export enum EnumPermission {
  '帐号管理' = 1,
  '角色管理' = 2,
  '站点管理' = 3,
  '公告管理' = 4,
  '会员管理' = 5,
  '产品管理' = 6,
  '订单管理' = 7,
  '流水管理' = 8,
  '现金管理' = 9,
}

/**
 * 用户类型
 */
export enum EnumAccountType {
  '配置员' = 1,
  '管理员' = 2,
  '领导' = 4,
  '员工' = 8,
}

/**
 * 产品类型
 */
export enum EnumProductType {
  '一般产品' = 1,
}

/**
 * 用户余额交易枚举
 */
export enum EnumMemberBalanceTransactionType {
  '用户充值' = 1,
  '用户消费' = 2,
}

/**
 * 用户积分交易枚举
 */
export enum EnumMemberIntegralTransactionType {
  '上分' = 1,
  '下分' = 2,
  '购物积分' = 3,
  '积分支付' = 4,
}

/**
 * 企业现金交易枚举
 */
export enum EnumEnterpriseCashTransactionType {
  '充值' = 1,
  '消费' = 2,
}

/**
 * 支付状态
 */
export enum EnumPayStatus {
  '未支付' = 1,
  '付款中' = 2,
  '已支付' = 3,
  '已退款' = 4,
}

/**
 * 渲染枚举
 */
export function enumRender(e: any, v: any, d = '') {
  for (const k in e) {
    if (e[k] == v) return k;
  }
  if (d === undefined) d = '';
  return d;
}

/**
 * 渲染组合枚举
 */
export function enumRenders(e: any, v: any, d = '') {
  const ret = new Array<string>();
  for (const k in e) {
    if (/^\d+$/.test(k)) {
      if ((parseInt(k) & v) > 0) ret.push(e[k]);
    }
  }
  if (ret.length) return ret.join(',');
  if (d === undefined) d = '';
  return d;
}

/**
 * 生成表单枚举过滤数组
 */
export function buildBasicColumnfilters(e: any, label = 'label', value = 'value') {
  const dict = new Array<any>();
  for (const i in e) {
    if (/^\d+$/.test(i)) {
      const o: any = {};
      o[label] = e[i];
      o[value] = parseInt(i);
      dict.push(o);
    }
  }
  return dict;
}

/**
 *  枚转化表单初始化话数据
 */
export function explodeEnumnValues(e: any, value: number) {
  const values = new Array<number>();
  for (const i in e) {
    if (/^\d+$/.test(i)) {
      const v = parseInt(i);
      if ((v & value) > 0) values.push(v);
    }
  }

  return values;
}

/**
 * 将表单数据转化未枚举值
 */
export function implodeEnumnValues(values: Array<number>) {
  let value = 0;
  values.forEach((v) => {
    value = value | v;
  });
  return value;
}
