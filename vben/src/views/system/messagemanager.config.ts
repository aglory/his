import { h } from 'vue';
import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';

export const searchColumnsSchema: FormSchema[] = [
  {
    label: '标题',
    field: 'Title',
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
    title: '标题',
    dataIndex: 'Title',
    align: 'left',
    width: 250,
    sorter: true,
  },
  {
    title: '类容',
    dataIndex: 'Content',
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
    label: '标题',
    field: 'Title',
    defaultValue: '',
    component: 'Input',
    rules: [
      {
        required: true,
        message: '标题必须为2至50个字符',
      },
      {
        max: 50,
        min: 2,
        message: '标题必须为2至50个字符',
      },
    ],
  },
  {
    label: '类容',
    field: 'Content',
    defaultValue: '',
    component: 'InputTextArea',
    componentProps: {
      rows: 6,
    },
    required: false,
    show: true,
  },
];
