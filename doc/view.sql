/**
	站点试图
*/
drop view if exists ViewSite;
create view ViewSite as 
	select s.*, ifnull(a.Id, 0) AccountId, ifnull(a.LoginName,'') AccountLoginName from Site s left join Account a on s.Id = a.SiteId and a.Type = 2;
	