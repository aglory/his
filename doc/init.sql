
insert into Site(Host			  ,IsInner, IsLocked, Remark, CreateTime) values
				('127.0.0.1:60011',	  true,	   false,     '',      now());
insert into Account(Id, SiteId, LoginName, 		RealName, Tel, 						 Password, 	   	Salt, Type, Role, IsLocked, CreateTime) values 
					(1, 	 1,  'config', 		'配置员',  '', md5(concat('123123', '111111')), '111111', 	1,   '', 	 false,      now());

