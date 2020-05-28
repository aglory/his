
insert into `User` (`Name`, `Password`, `Status`, `CreateDate`)values('admin',md5('123456'),1,now());

insert into `Content`(Type, Images, `Index`, Status, CreateDate, Title, Content )values
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '不负韶华，联盟为全生态要素产业孵化工程锦上添花', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '定岗就业、定向创业培训扶持计划政策解读会“五一”开讲', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '百亿专项资金扶持 “全生态要素产业孵化工程', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '抓好业务，突出重点，我院业务工作会议在京召开', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '习近平主持召开中央全面深化改革委员会第十三次会议', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '设立工程专项资金，启动“全生态要素产业赋能孵化工程”立项研', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '广东省委省政府印发《关于促进中医药传承创新发展的若干措施》', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '传播正能量 日久出奇功', ''),
					(    1,     '1.jpg,2.jpg,3.jpg,4.jpg,5.jpg,6.jpg,7.jpg,8.jpg,9.jpg,10.jpg',       0,      1,	  now(), '3553工程计划人才战略示范工程启动仪式在京举行', '')


update `Content` set Content = '“坚持中西医并重，传承发展中医药事业。”这是党的十九大报告的明确要求。习近平总书记指出，中医药学是中国古代科学的瑰宝，也是打开中华文明宝库的钥匙。

　　中国工程院院士、中国中医科学院院长黄璐琦委员说，坚持中西医并重，才能保障中医、西医享有同等的发展权利，护航中医药事业健康发展。在H7N9禽流感疫情防控中，中医药参与，降低了病死率，为中西医并重方针做了生动注解，赢得国际社会高度评价。

　　目前，中西医在实践中并没有被摆到平等地位。黄璐琦委员认为，问题出在政策不配套上。现行医师管理、药品管理制度“以西律中”，中医西化、中药西管，不适应中医药特点和发展需要。

　　坚持中西医并重，任重道远。黄璐琦委员建议，加强中医药事业发展顶层设计，构建独立完善的中医药治理体系；推进中医临床条件和能力建设，提升中医药服务能力和水平；建立符合中医药特点的临床疗效评价机制及科研绩效机制。

　　北京中医药大学校长徐安龙委员表示，坚持中西医并重，实质是补齐中医发展的短板。长期以来，我国对中医投入不足，历史欠账很多，造成西医“腿长”、中医“腿短”，严重影响中医医疗服务能力提升。

　　中医传承发展，人才是根本。如今，西医院校招生人数是中医院校的近5倍。徐安龙委员建议，在医学院校的设置布局和招生规模上，尽量确保中医药和西医药人才培养基本平衡协调。为师承中医、自学成才的医生，提供一个合法行医的渠道，夯实人才根基。

　　徐安龙委员认为，中医药植根于中国传统文化。坚持中西医并重，首要的是传承好民族优秀传统文化。让中医药养生保健知识融入公众日常生活，使得传统中医药与现代中国相得益彰、岐黄之术历久弥新，为健康中国助力，为人类健康造福。

　　在扬子江药业集团董事长徐镜人代表看来，中西医各有特色，中医能治疗不少西医治不好的病。坚持中西医并重，取长补短，优势互补，才能发挥治病的最大效果。

　　徐镜人代表建议，鼓励设立中西医特色医院，强化中西医的协同作用，真正做到中西医并重，不断满足人民群众对健康生活的需求。' where Id <> 0;





update content set Images = 'aa257487ee9d735f186b9e0d23f92be.jpg' where Id = 83; 
update content set Images = 'zb3t.jpg' where Id = 85; 
update content set Images = 'ojsd.jpg' where Id = 88; 
update content set Images = '12121.jpg' where Id = 104; 
update content set Images = '0.jpg' where Id in(135, 145, 147); 
update content set Images = 'kvr7.jpg' where Id in(120, 122); 
update content set Imagescontent = 'u5u3.jpg' where Id = 131; 
update content set Images = 'xeww.jpg' where Id = 124; 
update content set Images = '333-2.jpg' where Id = 171; 