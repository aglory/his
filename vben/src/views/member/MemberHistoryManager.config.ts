import { h } from 'vue';
import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';
import {
  buildBasicColumnfilters,
  EnumMemberBalanceTransactionType,
  EnumMemberIntegralTransactionType,
  enumRender,
} from '/@/enums/serviceEnum';

export const searchBalanceColumnsSchema: FormSchema[] = [
  {
    label: '站点Id',
    field: 'SiteId',
    component: 'Input',
    colProps: { span: 4 },
    show: false,
  },
  {
    label: '会员姓名',
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
    label: '操作人',
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

export const queryBalanceColumnsSchema: BasicColumn[] = [
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
    title: '会员姓名',
    dataIndex: 'MemberName',
    align: 'left',
    width: 200,
    sorter: true,
  },
  {
    title: '会员电话',
    dataIndex: 'MemberTel',
    align: 'left',
    width: 200,
    sorter: true,
  },
  {
    title: '金额',
    dataIndex: 'Amount',
    align: 'right',
    width: 100,
    sorter: true,
    customRender: ({ record }) => {
      if (record.Type !== undefined) {
        if (record.TypeSign === 1) {
          return h('span', { className: 'page-color-green' }, record.Amount);
        } else if (record.TypeSign === -1) {
          return h('span', { className: 'page-color-red' }, record.Amount);
        } else {
          return h('span', {}, record.Amount);
        }
      } else {
        return h('span', {}, record.Amount);
      }
    },
  },
  {
    title: '余额',
    dataIndex: 'Balance',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '交易类型',
    dataIndex: 'Type',
    align: 'center',
    width: 160,
    customRender: ({ record }) => {
      if (record.Type !== undefined) {
        if (record.TypeSign === 1) {
          return h(
            'span',
            { className: 'page-color-green' },
            enumRender(EnumMemberBalanceTransactionType, record.Type, '-'),
          );
        } else if (record.TypeSign === -1) {
          return h(
            'span',
            { className: 'page-color-red' },
            enumRender(EnumMemberBalanceTransactionType, record.Type, '-'),
          );
        } else {
          return h('span', {}, enumRender(EnumMemberBalanceTransactionType, record.Type, '-'));
        }
      } else return '';
    },
    filters: buildBasicColumnfilters(EnumMemberBalanceTransactionType, 'text', 'value'),
    sorter: true,
  },
  {
    title: '收支类型',
    dataIndex: 'TypeSign',
    align: 'center',
    width: 120,
    customRender: ({ record }) => {
      if (record.TypeSign === 1) {
        return h('span', { className: 'page-color-green' }, '收入');
      } else if (record.TypeSign === -1) {
        return h('span', { className: 'page-color-red' }, '支出');
      }
    },
    filters: [
      { text: '收入', value: 1 },
      { text: '支出', value: -1 },
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
    title: '操作人',
    dataIndex: 'OperatorLoginName',
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

export const searchIntegralColumnsSchema: FormSchema[] = [
  {
    label: '站点Id',
    field: 'SiteId',
    component: 'Input',
    colProps: { span: 4 },
    show: false,
  },
  {
    label: '会员姓名',
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
    label: '操作人',
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

export const queryIntegralColumnsSchema: BasicColumn[] = [
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
    title: '会员姓名',
    dataIndex: 'MemberName',
    align: 'left',
    width: 200,
    sorter: true,
  },
  {
    title: '会员电话',
    dataIndex: 'MemberTel',
    align: 'left',
    width: 200,
    sorter: true,
  },
  {
    title: '变化积分',
    dataIndex: 'Amount',
    align: 'right',
    width: 100,
    sorter: true,
    customRender: ({ record }) => {
      if (record.Type !== undefined) {
        if (record.TypeSign === 1) {
          return h('span', { className: 'page-color-green' }, record.Amount);
        } else if (record.TypeSign === -1) {
          return h('span', { className: 'page-color-red' }, record.Amount);
        } else {
          return h('span', {}, record.Amount);
        }
      } else {
        return h('span', {}, record.Amount);
      }
    },
  },
  {
    title: '剩余积分',
    dataIndex: 'Balance',
    align: 'right',
    width: 100,
    sorter: true,
  },
  {
    title: '交易类型',
    dataIndex: 'Type',
    align: 'center',
    width: 160,
    customRender: ({ record }) => {
      if (record.Type !== undefined) {
        if (record.TypeSign === 1) {
          return h(
            'span',
            { className: 'page-color-green' },
            enumRender(EnumMemberIntegralTransactionType, record.Type, '-'),
          );
        } else if (record.TypeSign === -1) {
          return h(
            'span',
            { className: 'page-color-red' },
            enumRender(EnumMemberIntegralTransactionType, record.Type, '-'),
          );
        } else {
          return h('span', {}, enumRender(EnumMemberIntegralTransactionType, record.Type, '-'));
        }
      } else return '';
    },
    filters: buildBasicColumnfilters(EnumMemberIntegralTransactionType, 'text', 'value'),
    sorter: true,
  },
  {
    title: '收支类型',
    dataIndex: 'TypeSign',
    align: 'center',
    width: 120,
    customRender: ({ record }) => {
      if (record.TypeSign === 1) {
        return h('span', { className: 'page-color-green' }, '收入');
      } else if (record.TypeSign === -1) {
        return h('span', { className: 'page-color-red' }, '支出');
      }
    },
    filters: [
      { text: '收入', value: 1 },
      { text: '支出', value: -1 },
    ],
    sorter: true,
  },
  {
    title: '操作人',
    dataIndex: 'OperatorLoginName',
    align: 'left',
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
