export enum EnumPermission {
  '帐号管理' = 1,
  '角色管理' = 2,
  '站点管理' = 3,
  '公告管理' = 4,
  '会员管理' = 5,
  '产品管理' = 6,
  '订单管理' = 7,
  '流水管理' = 8,
}

export enum EnumAccountType {
  '配置员' = 1,
  '管理员' = 2,
  '普通用户' = 4,
}

export enum EnumProductType {
  '一般产品' = 1,
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
