import{aG as e,aH as r}from"./index.e1fec598.js";var a,o;function n(o,n="modal"){return e.post({url:a.AutoQueryMemberList,params:o,headers:{"Content-Type":r.FORM_URLENCODED}},{errorMessageMode:n})}function t(o,n="modal"){return e.post({url:a.MemberManager,params:o,headers:{"Content-Type":r.FORM_URLENCODED}},{errorMessageMode:n})}function m(o,n="modal"){return e.post({url:a.MemberChangeLockedStatus,params:o,headers:{"Content-Type":r.JSON}},{errorMessageMode:n})}function s(o,n="modal"){return e.post({url:a.MemberEditor,params:o,headers:{"Content-Type":r.JSON}},{errorMessageMode:n})}function M(o,n="modal"){return e.post({url:a.MemberSave,params:o,headers:{"Content-Type":r.JSON}},{errorMessageMode:n})}function l(o,n="modal"){return e.post({url:a.MemberChangeBalance,params:o,headers:{"Content-Type":r.JSON}},{errorMessageMode:n})}function c(o,n="modal"){return e.post({url:a.MemberBalanceHistoryManager,params:o,headers:{"Content-Type":r.FORM_URLENCODED}},{errorMessageMode:n})}function b(o,n="modal"){return e.post({url:a.MemberChangeIntegral,params:o,headers:{"Content-Type":r.JSON}},{errorMessageMode:n})}function u(o,n="modal"){return e.post({url:a.MemberIntegralHistoryManager,params:o,headers:{"Content-Type":r.FORM_URLENCODED}},{errorMessageMode:n})}(o=a||(a={})).AutoQueryMemberList="?control=member&action=autoQueryMemberList",o.MemberManager="?control=member&action=memberManager",o.MemberChangeLockedStatus="?control=member&action=memberChangeLockedStatus",o.MemberEditor="?control=member&action=memberEditor",o.MemberSave="?control=member&action=memberSave",o.MemberChangeBalance="?control=member&action=memberChangeBalance",o.MemberChangeIntegral="?control=member&action=memberChangeIntegral",o.MemberBalanceHistoryManager="?control=member&action=memberBalanceHistoryManager",o.MemberIntegralHistoryManager="?control=member&action=memberIntegralHistoryManager";export{t as a,m as b,s as c,M as d,l as e,c as f,u as g,n as h,b as m};