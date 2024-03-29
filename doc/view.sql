/**
 站点视图
 */
drop view if exists ViewSite;
create view ViewSite as
select s.*,
    ifnull(a.Id, 0) AccountId,
    ifnull(a.LoginName, '') AccountLoginName
from Site s
    left join Account a on s.Id = a.SiteId
    and a.Type = 2;
/**
 用户表等级视图
 */
drop view if exists ViewAccountParent;
create view ViewAccountParent as
select a.*,
    ap.*
from Account a
    inner join AccountParent ap on a.Id = ap.AccountId;
/**
 产品1视图
 */
drop view if exists ViewProduct1;
create view ViewProduct1 as
select p.*,
    p1.*
from Product p
    left join Product1 p1 on p.Id = p1.ProductId;
/**
 产品2视图
 */
drop view if exists ViewProduct2;
create view ViewProduct2 as
select p.*,
    p2.*
from Product p
    inner join Product2 p2 on p.Id = p2.ProductId;
/**
 会员余额流水视图
 */
drop view if exists ViewMemberBalanceHistory;
create view ViewMemberBalanceHistory as
select mbh.*,
    ifnull(m.Name, 0) MemberName,
    ifnull(m.Tel, '') MemberTel
from MemberBalanceHistory mbh
    inner join Member m on mbh.MemberId = m.Id;
/**
 会员积分流水视图
 */
drop view if exists ViewMemberIntegralHistory;
create view ViewMemberIntegralHistory as
select mih.*,
    ifnull(m.Name, 0) MemberName,
    ifnull(m.Tel, '') MemberTel
from MemberIntegralHistory mih
    inner join Member m on mih.MemberId = m.Id;
/**
 订单视图
 */
drop view if exists ViewOrder;
create view ViewOrder as
select o.*,
    ifnull(m.Name, '') MemberName,
    ifnull(m.Tel, '') MemberTel
from `Order` o
    inner join Member m on o.MemberId = m.Id;