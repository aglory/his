CREATE SCHEMA ` HisLog ` DEFAULT CHARACTER
SET
    utf8 COLLATE utf8_bin;

use HisLog;

drop table if exists Api;

create table Api(
    Id bigint not null primary key auto_increment,
    BusinessName varchar(200) not null comment '业务名称',
    Url varchar(255) not null comment '请求地址',
    Request text comment '请求参数',
    Response text comment '响应参数',
    CreateTime DATETIME not null comment '创建时间'
) engine InnoDB default character
set
    = utf8 collate = utf8_bin auto_increment = 1 comment '接口日志表';

drop table if exists Operator;

create table Operator(
    Id bigint not null primary key auto_increment,
    BusinessName varchar(200) not null comment '业务名称',
    AccountId bigint not null comment '用户Id',
    AccountLoginName varchar(255) not null comment '用户登录账号',
    Content text comment '操作类容',
    CreateTime DATETIME not null comment '创建时间'
) engine InnoDB default character
set
    = utf8 collate = utf8_bin auto_increment = 1 comment '操作日志表';
