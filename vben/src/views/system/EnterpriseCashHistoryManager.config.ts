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
    label: '操作人',
    field: 'OperatorLoginName',
    component: 'Input',
    colProps: { span: 4 },
    show: true,
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
    title: '金额',
    dataIndex: 'Amount',
    align: 'right',
    width: 100,
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
