import { h } from 'vue';
import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';

export const searchColumnsSchema: FormSchema[] = [
  {
    label: '站点Id',
    field: 'SiteId',
    component: 'Input',
    colProps: { span: 4 },
    show: true,
  },
  {
    label: '姓名',
    field: 'Name',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '电话号码',
    field: 'Tel',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '身份证',
    field: 'IdcardNo',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '地址',
    field: 'Address',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '创建时间',
    field: 'CreateTime',
    component: 'RangePicker',
    componentProps: {
      'show-time': true,
    },
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
    title: '站点Id',
    dataIndex: 'SiteId',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '姓名',
    dataIndex: 'Name',
    align: 'left',
    width: 120,
    sorter: true,
  },
  {
    title: '电话号码',
    dataIndex: 'Tel',
    align: 'left',
    width: 120,
    sorter: true,
  },
  {
    title: '地址',
    dataIndex: 'Address',
    align: 'left',
    width: 200,
    sorter: true,
  },
  {
    title: '身份证',
    dataIndex: 'Address',
    align: 'left',
    width: 160,
    sorter: true,
  },
  {
    title: '余额',
    dataIndex: 'Balance',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '积分',
    dataIndex: 'Integral',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '状态',
    dataIndex: 'IsLocked',
    align: 'center',
    width: 100,
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
    title: '备注',
    dataIndex: 'Remark',
    align: 'left',
    sorter: true,
  },
  {
    title: '创建时间',
    dataIndex: 'CreateTime',
    width: 160,
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
    label: '姓名',
    field: 'Name',
    defaultValue: '',
    component: 'Input',
    rules: [
      {
        required: true,
        message: '姓名必须为2至50个字符',
      },
      {
        max: 50,
        min: 2,
        message: '姓名必须为2至50个字符',
      },
    ],
  },
  {
    label: '电话号码',
    field: 'Tel',
    defaultValue: '',
    component: 'Input',
    required: true,
    componentProps: {
      maxlength: 11,
    },
  },
  {
    label: '身份证',
    field: 'IdcardNo',
    defaultValue: '',
    component: 'Input',
  },
  {
    label: '地址',
    field: 'Address',
    defaultValue: '',
    component: 'Input',
  },
  {
    label: '备注',
    field: 'Remark',
    defaultValue: '',
    component: 'InputTextArea',
    componentProps: {
      rows: 3,
    },
  },
];

export const changeBalanceFormSchema: FormSchema[] = [
  {
    label: '编号',
    field: 'Id',
    defaultValue: 0,
    component: 'Input',
    show: false,
  },
  {
    label: '余额',
    field: 'Balance',
    defaultValue: 0,
    component: 'Input',
    componentProps: {
      disabled: true,
    },
  },
  {
    label: '充值金额',
    field: 'Amount',
    defaultValue: 0,
    component: 'Input',
    dynamicRules: () => {
      return [
        {
          required: true,
          validator: (_, value) => {
            var amount = parseFloat(value);
            if (isNaN(amount) || amount < 0) {
              return Promise.reject('充值金额必须大于0');
            }
            return Promise.resolve();
          },
        },
      ];
    },
  },
  {
    label: '备注',
    field: 'Remark',
    defaultValue: 0,
    component: 'InputTextArea',
    componentProps: {
      rows: 3,
    },
  },
];

export const changeIntegralFormSchema: FormSchema[] = [
  {
    label: '编号',
    field: 'Id',
    defaultValue: 0,
    component: 'Input',
    show: false,
  },
  {
    label: '剩余积分',
    field: 'Integral',
    defaultValue: 0,
    component: 'Input',
    componentProps: {
      disabled: true,
    },
  },
  {
    label: '修改积分',
    field: 'Amount',
    defaultValue: 0,
    component: 'Input',
    required: true,
  },
  {
    label: '备注',
    field: 'Remark',
    defaultValue: 0,
    component: 'InputTextArea',
    componentProps: {
      rows: 3,
    },
  },
];
