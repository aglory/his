import { BasicColumn } from '/@/components/Table';
import { FormSchema } from '/@/components/Table';

export const searchColumnsSchema: FormSchema[] = [
  {
    label: '角色',
    field: 'Name',
    component: 'Input',
    colProps: { span: 4 },
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
    title: '角色',
    dataIndex: 'Name',
    align: 'left',
    width: 120,
    sorter: true,
  },
  {
    title: '权限',
    dataIndex: 'Permission',
    align: 'left',
  },
  {
    title: '类型',
    dataIndex: 'IsInner',
    align: 'center',
    width: 100,
    format: (val) => {
      return val ? '内置角色' : '自定义角色';
    },
    filters: [
      { text: '内置角色', value: 1 },
      { text: '自定义角色', value: 0 },
    ],
    sorter: true,
  }
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
    label: '角色',
    field: 'Name',
    defaultValue: '',
    component: 'Input',
    rules: [
      {
        required: true,
        message: '角色必须为2至50个字符',
      },
      {
        max: 50,
        min: 2,
        message: '角色必须为2至50个字符',
      },
    ],
  },
  {
    label: '权限',
    field: 'Permission',
    component: 'CheckboxGroup',
    componentProps: {
      options: [],
    },
  },
];
