"undefined"!=typeof require&&require;import{Q as e,bl as t,m as r,n as a,O as o,V as s,u as n,S as i,r as l,F as d,L as u,ar as c,N as m,q as f,_ as p,aj as g,w as y,v as x,a1 as b,y as j}from"./vendor.8be1affb.js";import{B as h,a as v}from"./index.21fd786f.js";import{u as w,D as L}from"./index.49cacef0.js";import{aN as R,u as C,aG as E,aO as I}from"./index.e1fec598.js";/* empty css              */import{u as k,_}from"./useTable.7d8a6e5e.js";import{a as A}from"./useForm.e9f08473.js";import"./useContentViewHeight.1cc3b3a8.js";import"./index.1c224cd3.js";import"./index.24ce52d8.js";/* empty css              *//* empty css              *//* empty css              *//* empty css              *//* empty css              */import"./useSortable.92d684a3.js";/* empty css              *//* empty css              */const{t:D}=C();function O(){return[{dataIndex:"type",title:D("sys.errorLog.tableColumnType"),width:80,customRender:({text:r})=>{const a=r===R.VUE?"green":r===R.RESOURCE?"cyan":r===R.PROMISE?"blue":R.AJAX?"red":"purple";return e(t,{color:a},{default:()=>r})}},{dataIndex:"url",title:"URL",width:200},{dataIndex:"time",title:D("sys.errorLog.tableColumnDate"),width:160},{dataIndex:"file",title:D("sys.errorLog.tableColumnFile"),width:200},{dataIndex:"name",title:"Name",width:200},{dataIndex:"message",title:D("sys.errorLog.tableColumnMsg"),width:300},{dataIndex:"stack",title:D("sys.errorLog.tableColumnStackMsg")}]}var S,T=r({props:{info:{type:Object,default:null}},setup(t){const{t:r}=C(),[l]=w({column:2,schema:O().map((e=>({field:e.dataIndex,label:e.title})))});return(d,u)=>(a(),o(n(h),i({width:800,title:n(r)("sys.errorLog.tableActionDesc")},d.$attrs),{default:s((()=>[e(n(L),{data:t.info,onRegister:n(l)},null,8,["data","onRegister"])])),_:1},16,["title"]))}});(S||(S={})).Error="/error";const M={class:"p-4"},V=["src"];var q=r({setup(t){const r=l(),o=l([]),{t:i}=C(),h=I(),[w,{setTableData:L}]=k({title:i("sys.errorLog.tableTitle"),columns:O(),actionColumn:{width:80,title:"Action",dataIndex:"action",slots:{customRender:"action"}}}),[R,{openModal:D}]=v();function q(e){r.value=e,D(!0)}function F(){throw new Error("fire vue error!")}function N(){o.value.push(`${(new Date).getTime()}.png`)}function P(){return e=this,t=null,r=function*(){yield E.get({url:S.Error})},new Promise(((a,o)=>{var s=e=>{try{i(r.next(e))}catch(t){o(t)}},n=e=>{try{i(r.throw(e))}catch(t){o(t)}},i=e=>e.done?a(e.value):Promise.resolve(e.value).then(s,n);i((r=r.apply(e,t)).next())}));var e,t,r}return d((()=>h.getErrorLogInfoList),(e=>{u((()=>{L(c(e))}))}),{immediate:!0}),(t,l)=>{const d=m("a-button");return a(),f("div",M,[(a(!0),f(p,null,g(o.value,(e=>y((a(),f("img",{key:e,src:e},null,8,V)),[[x,!1]]))),128)),e(T,{info:r.value,onRegister:n(R)},null,8,["info","onRegister"]),e(n(_),{onRegister:n(w),class:"error-handle-table"},{toolbar:s((()=>[e(d,{onClick:F,type:"primary"},{default:s((()=>[b(j(n(i)("sys.errorLog.fireVueError")),1)])),_:1}),e(d,{onClick:N,type:"primary"},{default:s((()=>[b(j(n(i)("sys.errorLog.fireResourceError")),1)])),_:1}),e(d,{onClick:P,type:"primary"},{default:s((()=>[b(j(n(i)("sys.errorLog.fireAjaxError")),1)])),_:1})])),action:s((({record:t})=>[e(n(A),{actions:[{label:n(i)("sys.errorLog.tableActionDesc"),onClick:q.bind(null,t)}]},null,8,["actions"])])),_:1},8,["onRegister"])])}}});export{q as default};