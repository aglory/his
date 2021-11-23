import { h } from 'vue-demi';
import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';
import {
  buildBasicColumnfilters,
  EnumPayStatus,
  EnumProductType,
  enumRender,
} from '/@/enums/serviceEnum';

export const searchColumnsSchema: FormSchema[] = [
  {
    label: '站点Id',
    field: 'SiteId',
    component: 'Input',
    colProps: { span: 4 },
    show: false,
  },
  {
    label: '流水号',
    field: 'No',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '会员名称',
    field: 'MemberName',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '会员电话',
    field: 'MemberTel',
    component: 'Input',
    colProps: { span: 4 },
  },
  {
    label: '操作人帐号',
    field: 'OperatorLoginName',
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
    title: '总金额',
    dataIndex: 'Amount',
    align: 'left',
    width: 100,
    sorter: true,
  },
  {
    title: '优惠金额',
    dataIndex: 'PreferenceAmount',
    align: 'left',
    width: 100,
    sorter: true,
  },
  {
    title: '余额支付',
    dataIndex: 'BalanceAmount',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '积分支付',
    dataIndex: 'IntegralAmount',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '在线支付',
    dataIndex: 'OnlineAmount',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '现金支付',
    dataIndex: 'CashAmount',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '产生积分',
    dataIndex: 'ProduceIntegral',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '变动后余额',
    dataIndex: 'Balance',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '支付状态',
    dataIndex: 'PayStatus',
    align: 'center',
    width: 160,
    customRender: ({ record }) => {
      switch (record.PayStatus) {
        case EnumPayStatus.未支付:
          return h('span', {}, EnumPayStatus[EnumPayStatus.未支付]);
        case EnumPayStatus.已支付:
          return h('span', { class: 'page-color-green' }, EnumPayStatus[EnumPayStatus.已支付]);
        case EnumPayStatus.已退款:
          return h('span', { class: 'page-color-red' }, EnumPayStatus[EnumPayStatus.已退款]);
      }
      return enumRender(EnumPayStatus, record.PayStatus);
    },
    filters: buildBasicColumnfilters(EnumPayStatus, 'text', 'value'),
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
    label: '类型',
    field: 'Type',
    component: 'AutoComplete',
    componentProps: {
      options: buildBasicColumnfilters(EnumProductType),
    },
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
