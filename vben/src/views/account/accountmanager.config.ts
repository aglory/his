import { h } from 'vue';
import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';

export const searchColumnsSchema: FormSchema[] = [
  {
    label: '登录帐号',
    field: 'LoginName',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '真实姓名',
    field: 'RealName',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '手机',
    field: 'Tel',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '创建时间',
    field: 'CreateTime',
    component: 'RangePicker',
    colProps: { span: 6 },
  },
];

export const queryColumnsSchema: BasicColumn[] = [
  {
    title: '编号',
    dataIndex: 'Id',
    align: 'center',
    width: 80,
    sorter: true,
  },
  {
    title: '登录帐号',
    dataIndex: 'LoginName',
    align: 'left',
    width: 120,
    sorter: true,
  },
  {
    title: '真实姓名',
    dataIndex: 'RealName',
    align: 'left',
    width: 120,
    sorter: true,
  },
  {
    title: '手机',
    dataIndex: 'Tel',
    align: 'center',
    width: 120,
    sorter: true,
  },
  {
    title: '角色',
    dataIndex: 'Role',
    width: 200,
    align: 'left',
  },
  {
    title: '状态',
    dataIndex: 'IsLocked',
    align: 'center',
    width: 80,
    customRender: ({ record }) => {
      if (record.IsLocked) {
        return h('span', { className: 'page-lock' }, '锁定');
      } else {
        return h('span', { className: 'page-unlock' }, '启用');
      }
    },
    filters: [
      { text: '锁定', value: 1 },
      { text: '启用', value: 0 },
    ],
    sorter: true,
  },
  {
    title: '创建时间',
    dataIndex: 'CreateTime',
    width: 120,
    sorter: true,
  },
];

export const editorFormSchema: FormSchema[] = [
  {
    label: '编号',
    field: 'Id',
    defaultValue: 0,
    component: 'Input',
    show: false,
  },
  {
    label: '登录帐号',
    field: 'LoginName',
    defaultValue: '',
    component: 'Input',
    rules: [
      {
        required: true,
        message: '登录帐号必须为2至50个字符',
      },
      {
        max: 50,
        min: 2,
        message: '登录帐号必须为2至50个字符',
      },
    ],
  },
  {
    label: '密码',
    field: 'Password',
    defaultValue: '',
    component: 'StrengthMeter',
    required: true,
    show: false,
  },
  {
    label: '重复密码',
    field: 'RepeatPassword',
    defaultValue: '',
    component: 'StrengthMeter',
    dynamicRules: ({ values }) => {
      return [
        {
          required: true,
          validator: (_, value) => {
            if (!value) {
              return Promise.reject('密码不能为空');
            }
            if (value !== values.Password) {
              return Promise.reject('两次输入的密码不一致!');
            }
            return Promise.resolve();
          },
        },
      ];
    },
    show: false,
  },
  {
    label: '真实姓名',
    field: 'RealName',
    component: 'Input',
    required: true,
  },

  {
    label: '手机',
    field: 'Tel',
    component: 'Input',
    required: true,
    componentProps: {
      maxlength: 11,
    },
  },
  {
    label: '角色',
    field: 'Role',
    component: 'CheckboxGroup',
    componentProps: {
      options: [],
    },
  },
];

export const changePasswordFormSchema: FormSchema[] = [
  {
    label: '编号',
    field: 'Id',
    defaultValue: 0,
    component: 'Input',
    show: false,
  },
  {
    label: '密码',
    field: 'Password',
    defaultValue: '',
    component: 'StrengthMeter',
    required: true,
    show: true,
  },
  {
    label: '重复密码',
    field: 'RePassword',
    defaultValue: '',
    component: 'StrengthMeter',
    dynamicRules: ({ values }) => {
      return [
        {
          required: true,
          validator: (_, value) => {
            if (!value) {
              return Promise.reject('密码不能为空');
            }
            if (value !== values.Password) {
              return Promise.reject('两次输入的密码不一致!');
            }
            return Promise.resolve();
          },
        },
      ];
    },
    show: true,
  },
];
