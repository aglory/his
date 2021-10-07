CREATE SCHEMA `His` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;

use His;

drop table if exists Site;
create table Site(
	Id int not null primary key auto_increment,
	Host varchar(600) not null unique 													comment '主机名',
	Remark varchar(50) not null 														comment '备注',
	IsLocked bit not null																comment '是否被锁定',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '站点' ;

drop table if exists Account;
create table Account(
	Id int not null primary key auto_increment,
	SiteId int not null																	comment '站点Id',
	LoginName varchar(50) not null 														comment '登录账号',
	RealName varchar(50) not null 														comment '真实姓名',
	Tel	varchar(20) not null															comment '电话号码',
	Password varchar(50) not null														comment '登录密码',
	Salt char(6) not null																comment '盐渍',
	Type int not null																	comment '用户类型',
    Role varchar(2000)																	comment '用户角色',
	IsLocked bit not null																comment '是否被锁定',
	CreateTime DATETIME not null 														comment '创建时间',
	unique key UniqueKey(SiteId, LoginName)
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '用户表' ;

drop table if exists Role;
create table Role(
	Id int not null primary key auto_increment,
	SiteId int not null																	comment '站点Id',
	Name varchar(50) not null 															comment '角色',
    Permission varchar(2000)															comment '角色对应权限',
    IsInner bit not null																comment '是否未内置角色'
)engine InnoDB default character set = utf8 collate = utf8_bin auto_increment=1			comment '角色表' ;

insert into Site(Host,					Remark, IsLocked, CreateTime) values
				('*',		'',	   false,      now());
insert into Account(Id, SiteId, LoginName, 		RealName, Tel, 						 Password, 	   	Salt, Type, Role, IsLocked, CreateTime) values 
					(1, 	 1,  'config', 		'配置员',  '', md5(concat('123123', '111111')), '111111', 	1,   '', 	 false,      now());

insert into Site(Host,					Remark, IsLocked, CreateTime) values
				('127.0.0.1,localhost,127.0.0.1:60011',		'',	   false,      now());
insert into Account(Id, SiteId, LoginName, 	    RealName, Tel, 						 Password, 	   	Salt, Type, Role, IsLocked, CreateTime) values 
					(2,   	 2,   'admin', 	'系统管理员',  '', md5(concat('123123', '111111')), '111111',    2,  '2', 	 false,      now());
					
insert into Role(Id, SiteId, 		 Name, 	  Permission, IsInner) values 
				 (2,	  1, '系统管理员', 			  '',       1);
