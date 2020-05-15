drop table if exists `User`;
create table `User`
(
  `Id` int primary key not null auto_increment,
  `Name` varchar(100) not null comment '帐号',
  `Password` varchar(64) not null comment '密码',
  `Status` int not null comment '状态(1:正常,2:删除)',
  `CreateDate` DateTime NULL
);

drop table if exists `Role`;
create table `Role` (
  `Id` int not null auto_increment,
  `Name` varchar(100) not null comment '名称',
  `Permissions` varchar(1000) not null comment '权限列表',
  `CreateDate` DateTime NULL,
  primary key (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
comment = '角色信息';

drop table if exists `UserRole`;
create table `UserRole` (
  `UserId` int not null,
  `RoleId` int not null,
  primary key (`UserId`, `RoleId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
comment = '用户角色关联关系';


drop table if exists `Content`;
create table `Content` (
  `Id` int not null auto_increment,
  `Type` int not null comment '类别(1：新闻)',
  `Title` nvarchar(200) not null comment '标题',
  `Images` nvarchar(200) not null comment '图片',
  `Index` int not null comment '顺序',
  `Content` text comment '内容',
  `Status` int not null comment '状态(1:正常,2:删除)',
  `CreateDate` DateTime NULL,
  primary key (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
comment = '内容';

