"undefined"!=typeof require&&require;var e=(e,t,o)=>new Promise(((n,r)=>{var i=e=>{try{s(o.next(e))}catch(t){r(t)}},a=e=>{try{s(o.throw(e))}catch(t){r(t)}},s=e=>e.done?n(e.value):Promise.resolve(e.value).then(i,a);s((o=o.apply(e,t)).next())}));import{_ as t,u as o}from"./useTable.7d8a6e5e.js";import{_ as n,u as r,a as i}from"./useForm.e9f08473.js";import{P as a}from"./index.24ce52d8.js";import{B as s,u as l,a as d}from"./index.21fd786f.js";import{c,_ as u,a as m,q as f,s as g}from"./MemberBalanceEditorModal.9491d964.js";import{m as p,a as b,b as h}from"./member.b5761d5d.js";import{m as M,B as I,N as j,n as x,O as R,V as y,Q as E,S,av as B,a1 as C}from"./vendor.8be1affb.js";import{b as k,ag as v}from"./index.e1fec598.js";import"./index.1c224cd3.js";/* empty css              *//* empty css              *//* empty css              */import"./useContentViewHeight.1cc3b3a8.js";/* empty css              */import"./useSortable.92d684a3.js";/* empty css              *//* empty css              *//* empty css              *//* empty css              */var T=M({name:"MemberIntegralEditorModal",components:{BasicModal:s,BasicForm:n},emits:["success"],setup(t,{emit:o}){const n=I({Id:0}),[i,{setFieldsValue:a,resetFields:s,validate:d}]=r({labelWidth:100,schemas:c,showActionButtonGroup:!1,actionColOptions:{span:25}}),[u,{setModalProps:m,closeModal:f}]=l((t=>e(this,null,(function*(){n.Id=t.Id,s(),m({confirmLoading:!0,maskClosable:!1}),a({Id:t.Id,Integral:t.Integral,Amount:0}),m({confirmLoading:!1})}))));return{registerModal:u,registerForm:i,handleSubmit:function(){return e(this,null,(function*(){try{const e=yield d();m({confirmLoading:!0}),yield p(e),f(),o("success")}catch(e){}finally{m({confirmLoading:!1})}}))}}}});T.render=function(e,t,o,n,r,i){const a=j("BasicForm"),s=j("BasicModal");return x(),R(s,S(e.$attrs,{onRegister:e.registerModal,title:"上下分",onOk:e.handleSubmit}),{default:y((()=>[E(a,{onRegister:e.registerForm},null,8,["onRegister"])])),_:1},16,["onRegister","onOk"])};var F=M({name:"ProductManager",components:{PageWrapper:a,BasicTable:t,TableAction:i,MemberEditorModal:u,MemberBalanceEditorModal:m,MemberIntegralEditorModal:T},setup(){const[t,{openModal:n}]=d(),[r,{openModal:i}]=d(),[a,{openModal:s}]=d(),l=k(),[c,{reload:u,getRawDataSource:m}]=o({title:"会员管理",canColDrag:!0,showIndexColumn:!1,striped:!0,canResize:!0,columns:f.filter((e=>l.getUserInfo.Type===v.配置员||"SiteId"!==e.dataIndex)),api:b,formConfig:{labelWidth:80,schemas:g.filter((e=>l.getUserInfo.Type===v.配置员||"SiteId"!==e.field))},useSearchForm:!0,showTableSetting:!0,bordered:!0,actionColumn:{width:240,title:"操作",dataIndex:"action",slots:{customRender:"action"},fixed:"right"},showSummary:!0,summaryFunc:()=>[{Id:"合计",Balance:m().Balance}]});function p(e){n(!0,null==e?{Id:0}:e)}function M(){u()}function I(t){return e(this,null,(function*(){try{yield h({Id:t.Id,IsLocked:!t.IsLocked}),u()}catch(e){}}))}return B("Enter",(e=>{var t;e.preventDefault(),"[object HTMLInputElement]"==(null==(t=e.target)?void 0:t.toString())&&M()})),{registerTable:c,handActionColumns:function(e){let t=[{title:"编辑",icon:"clarity:note-edit-line",onClick:()=>{p(e)}},{title:"充值",icon:"ant-design:transaction-outlined",onClick:()=>{!function(e){i(!0,e)}(e)}},{title:"积分",icon:"ant-design:copyright-circle-outlined",onClick:()=>{!function(e){s(!0,e)}(e)}}];return e.IsLocked?t.push({title:"启用",icon:"ant-design:unlock-outlined",color:"success",onClick:()=>{I(e)}}):t.push({title:"锁定",icon:"ant-design:lock-outlined",color:"error",popConfirm:{title:"确定锁定",confirm:I.bind(null,e)}}),t},registerMemberEditorModal:t,registerMemberBalanceEditorModal:r,registerMemberIntegralEditorModal:a,handleEdit:p,handleRefresh:M}}});const w=C("创建会员");F.render=function(e,t,o,n,r,i){const a=j("a-button"),s=j("TableAction"),l=j("BasicTable"),d=j("MemberEditorModal"),c=j("MemberBalanceEditorModal"),u=j("MemberIntegralEditorModal"),m=j("PageWrapper");return x(),R(m,{dense:"",contentFullHeight:"",fixedHeight:""},{default:y((()=>[E(l,{onRegister:e.registerTable},{toolbar:y((()=>[E(a,{type:"primary",onClick:t[0]||(t[0]=t=>e.handleEdit(null))},{default:y((()=>[w])),_:1})])),action:y((({record:t})=>[E(s,{actions:e.handActionColumns(t)},null,8,["actions"])])),_:1},8,["onRegister"]),E(d,{onRegister:e.registerMemberEditorModal,onSuccess:e.handleRefresh},null,8,["onRegister","onSuccess"]),E(c,{onRegister:e.registerMemberBalanceEditorModal,onSuccess:e.handleRefresh},null,8,["onRegister","onSuccess"]),E(u,{onRegister:e.registerMemberIntegralEditorModal,onSuccess:e.handleRefresh},null,8,["onRegister","onSuccess"])])),_:1})};export{F as default};