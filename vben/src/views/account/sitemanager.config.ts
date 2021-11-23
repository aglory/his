import { h } from 'vue';
import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';

export const searchColumnsSchema: FormSchema[] = [
  {
    label: '域名',
    field: 'Host',
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
    title: '域名',
    dataIndex: 'Host',
    align: 'left',
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
    dataIndex: 'Id',
    align: 'left',
    width: 120,
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
    label: '域名',
    field: 'Host',
    defaultValue: '',
    component: 'Input',
  },
  {
    label: '备注',
    field: 'Remark',
    component: 'InputTextArea',
    componentProps: {
      rows: 6,
    },
  },
  {
    label: '绑定帐号',
    field: 'AccountId',
    component: 'Select',
    componentProps: {
      options: [],
    },
  },
];
