CREATE SCHEMA `His` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;

use His;

drop table if exists Account;
create table Account(
	Id int not null primary key auto_increment,
	LoginName varchar(50) not null 														comment '登录账号',
	RealName varchar(50) not null 														comment '真实姓名',
	Password varchar(50) not null														comment '登录密码',
	Type int not null																	comment '用户类型',
    Role varchar(2000)																	comment '用户角色',
	IsLocked bit not null																comment '是否被锁定',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '用户表' ;

drop table if exists Role;
create table Role(
	Id int not null primary key auto_increment,
	Name varchar(50) not null 															comment '角色',
    Permission varchar(2000)															comment '角色对应权限',
    IsInner bit not null																comment '是否未内置角色'
)engine InnoDB default character set = utf8 collate = utf8_bin auto_increment=10000		comment '角色表' ;

insert into Account(LoginName, RealName, Password, Type, Role, IsLocked, CreateTime) values ('admin', '系统管理员', md5('123123'), 1, '1', false, now());
insert into Role(Id, Name, Permission, IsInner) values (1, '系统管理员', '10001,10002,100003', 1);
