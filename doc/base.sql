CREATE SCHEMA `His` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;

use His;

drop table if exists Site;
create table Site(
	Id bigint not null primary key auto_increment,
	Host varchar(2000) not null 														comment '域名(,)分割',
    IsInner bit not null																comment '是否为内置站点',
	IsLocked bit not null																comment '是否被锁定',
	Remark varchar(50) not null 														comment '备注',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '站点表' ;

drop table if exists Account;
create table Account(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	LoginName varchar(50) not null 														comment '登录账号',
	RealName varchar(50) not null 														comment '真实姓名',
	Tel	varchar(20) not null															comment '电话号码',
	Password varchar(50) not null														comment '登录密码',
	Salt char(6) not null																comment '盐渍',
	Type int not null																	comment '用户类型',
    Role varchar(2000)																	comment '用户角色(,)分割',
	IsLocked bit not null																comment '是否被锁定',
	CreateTime DATETIME not null 														comment '创建时间',
	unique key UniqueKey(SiteId, LoginName)
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '用户表' ;

drop table if exists Role;
create table Role(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	Name varchar(50) not null 															comment '角色',
    Permission varchar(2000)															comment '角色对应权限(,)分割',
    IsInner bit not null																comment '是否为内置角色'
)engine InnoDB default character set = utf8 collate = utf8_bin auto_increment=1			comment '角色表' ;

drop table if exists Message;
create table Message(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	Title varchar(200) not null 														comment '标题',
    Content text not null																comment '类容',
	IsLocked bit not null																comment '是否被锁定',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin auto_increment=1			comment '消息表' ;

drop table if exists Member;
create table Member(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	Name varchar(50) not null 															comment '姓名',
	Tel	varchar(20) not null															comment '电话号码',
	IdcardNo varchar(20) not null														comment '省份证',
	Balance decimal(18, 2) not null														comment '余额',
	IsLocked bit not null																comment '是否被锁定',
    Remark text	not null																comment '备注',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '会员表' ;

drop table if exists Product;
create table Product(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	Type int not null 																	comment '产品类型',
	ShortName varchar(50) not null 														comment '产品名称(简称)',
	FullName text not null																comment '产品名称(全称)',
    MarketPrice decimal(18, 2) not null													comment '市场价格',
	Price decimal(18, 2) not null														comment '价格',
	SettlementPrice decimal(18, 2) not null												comment '结算价',
	SaleCopies int not null																comment '销售数量',
	BaseCopies int not null																comment '基础销量',
	SortCopies int not null																comment '库存数量',
	OrderIndex int not null																comment '排列序号',
	IsLocked bit not null																comment '是否被锁定',
    Description text not null															comment '描述',
    Remark text	not null																comment '备注',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '产品表';

drop table if exists `Order`;
create table `Order`(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	Amount decimal(18, 2) not null														comment '总金额',
	PreferenceAmount decimal(18, 2) not null											comment '优惠金额',
	BalanceAmount decimal(18, 2) not null												comment '余额支付',
	IntegralAmount decimal(18, 2) not null												comment '积分支付',
	OnlineAmount decimal(18, 2) not null												comment '在线支付',
    Remark text	not null																comment '备注',
	PayStatus int not null																comment '支付状态',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '订单表' ;

drop table if exists OrderItem;
create table OrderItem(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	OrderId bigint not null																comment '订单Id',
	ProductId bigint not null															comment '产品Id',
	ProductShortName varchar(50) not null 												comment '产品名称(简称)',
	Copies int not null 																comment '购买数量',	
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '订单项表' ;

drop table if exists MemberBalanceHistory;
create table MemberBalanceHistory(
	Id bigint not null primary key auto_increment,
	SiteId bigint not null																comment '站点Id',
	Type int 																			comment '流水类型',
	TypeSign int 																		comment '变动余额的符号,1:余额增加,-1:余额减少',
	MemberId bigint 																	comment '会员Id',
    OperatorId bigint																	comment '操作者Id',
	OperatorLoginName varchar(50) not null 												comment '操作者登录账号',
	Amount decimal(18, 2) not null														comment '变动金额',
	Balance decimal(18, 2) not null														comment '变动后余额',
    Remark text	not null																comment '备注',
	CreateTime DATETIME not null 														comment '创建时间'
)engine InnoDB default character set = utf8 collate = utf8_bin							comment '流水表' ;

