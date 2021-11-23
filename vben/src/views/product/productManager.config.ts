import { h } from 'vue';
import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';
import { buildBasicColumnfilters, EnumProductType } from '/@/enums/serviceEnum';

export const searchColumnsSchema: FormSchema[] = [
  {
    label: '站点Id',
    field: 'SiteId',
    component: 'Input',
    colProps: { span: 4 },
    show: false,
  },
  {
    label: '代号',
    field: 'Code',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '产品简称',
    field: 'ShortName',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '产品全称',
    field: 'FullName',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '创建时间',
    field: 'CreateTime',
    component: 'RangePicker',
    colProps: { span: 6 },
    componentProps: {
      'show-time': true,
    },
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
    ifShow: false,
  },
  {
    title: '代号',
    dataIndex: 'Code',
    align: 'left',
    width: 200,
    sorter: true,
  },
  {
    title: '产品简称',
    dataIndex: 'ShortName',
    align: 'left',
    width: 200,
    sorter: true,
  },
  {
    title: '产品全称',
    dataIndex: 'FullName',
    align: 'left',
    sorter: true,
  },
  {
    title: '市场价格',
    dataIndex: 'MarketPrice',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '销售价格',
    dataIndex: 'Price',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '结算价',
    dataIndex: 'SettlementPrice',
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
    title: '销售数量',
    dataIndex: 'SaleCopies',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '基础销量',
    dataIndex: 'BaseCopies',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '库存',
    dataIndex: 'NoSort',
    align: 'center',
    width: 120,
    customRender: ({ record }) => {
      if (record.NoSort) {
        return h('span', { className: 'page-green' }, '无库存');
      } else {
        return h('span', { className: 'page-red' }, '有库存');
      }
    },
    filters: [
      { text: '有库存', value: 0 },
      { text: '无库存', value: 1 },
    ],
    sorter: true,
  },
  {
    title: '库存数量',
    dataIndex: 'SortCopies',
    align: 'right',
    width: 100,
    customRender: ({ record }) => {
      if (record.NoSort) {
        return '-';
      } else {
        return record.SortCopies;
      }
    },
    sorter: true,
  },
  {
    title: '排列序号',
    dataIndex: 'OrderIndex',
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
    label: '类型',
    field: 'Type',
    component: 'Select',
    componentProps: {
      options: buildBasicColumnfilters(EnumProductType),
    },
  },
  {
    label: '代号',
    field: 'Code',
    component: 'Input',
  },
  {
    label: '产品简称',
    field: 'ShortName',
    defaultValue: '',
    component: 'Input',
    rules: [
      {
        required: true,
        message: '产品简称必须为2至50个字符',
      },
      {
        max: 50,
        min: 2,
        message: '产品简称必须为2至50个字符',
      },
    ],
  },
  {
    label: '产品全称',
    field: 'FullName',
    defaultValue: '',
    component: 'Input',
    rules: [
      {
        required: true,
        message: '产品全称必须为2至2000个字符',
      },
      {
        max: 50,
        min: 2,
        message: '产品全称必须为2至2000个字符',
      },
    ],
  },
  {
    label: '描述',
    field: 'Description',
    defaultValue: '',
    component: 'InputTextArea',
    componentProps: {
      rows: 3,
    },
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

export const changePriceFormSchema: FormSchema[] = [
  {
    label: '编号',
    field: 'Id',
    defaultValue: 0,
    component: 'Input',
    show: false,
  },
  {
    label: '市场价格',
    field: 'MarketPrice',
    defaultValue: 0,
    component: 'Input',
  },
  {
    label: '销售价格',
    field: 'Price',
    defaultValue: 0,
    component: 'Input',
  },
  {
    label: '结算价',
    field: 'SettlementPrice',
    defaultValue: 0,
    component: 'Input',
  },
  {
    label: '积分',
    field: 'Integral',
    defaultValue: 0,
    component: 'Input',
  },
];

export const changeCopiesFormSchema: FormSchema[] = [
  {
    label: '编号',
    field: 'Id',
    defaultValue: 0,
    component: 'Input',
    show: false,
  },
  {
    label: '销售数量',
    field: 'SaleCopies',
    defaultValue: 0,
    component: 'Input',
    componentProps: {
      disabled: true,
    },
  },
  {
    label: '基础销量',
    field: 'BaseCopies',
    defaultValue: 0,
    component: 'Input',
  },
  {
    label: '有无库存',
    field: 'NoSort',
    defaultValue: false,
    component: 'Switch',
  },
  {
    label: '库存数量',
    field: 'SortCopies',
    defaultValue: 0,
    component: 'Input',
    show: ({ model }) => {
      return model.NoSort;
    },
  },
];

export const changeOrderIndexSchema: FormSchema[] = [
  {
    label: '编号',
    field: 'Id',
    defaultValue: 0,
    component: 'Input',
    show: false,
  },
  {
    label: '排列序号',
    field: 'OrderIndex',
    defaultValue: 0,
    component: 'Input',
  },
];
