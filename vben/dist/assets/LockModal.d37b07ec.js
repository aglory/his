"undefined"!=typeof require&&require;import{a as e,b as s,u as r}from"./index.e1fec598.js";import{B as a,u as t}from"./index.21fd786f.js";import{_ as o,u as i}from"./useForm.e9f08473.js";import{u as n}from"./index.21336c00.js";import{h as l}from"./header.d801b988.js";import{m as d,j as c,N as m,n as p,O as u,V as f,x,z as h,y as j,Q as v,a1 as g,S as y}from"./vendor.8be1affb.js";import"./useContentViewHeight.1cc3b3a8.js";import"./index.1c224cd3.js";/* empty css              *//* empty css              *//* empty css              *//* empty css              *//* empty css              *//* empty css              */import"./useSortable.92d684a3.js";var _=d({name:"LockModal",components:{BasicModal:a,BasicForm:o},setup(){const{t:a}=r(),{prefixCls:o}=e("header-lock-modal"),d=s(),m=n(),p=c((()=>{var e;return null==(e=d.getUserInfo)?void 0:e.realName})),[u,{closeModal:f}]=t(),[x,{validateFields:h,resetFields:j}]=i({showActionButtonGroup:!1,schemas:[{field:"password",label:a("layout.header.lockScreenPassword"),component:"InputPassword",required:!0}]});return{t:a,prefixCls:o,getRealName:p,register:u,registerForm:x,handleLock:function(){return e=this,s=null,r=function*(){const e=(yield h()).password;f(),m.setLockInfo({isLock:!0,pwd:e}),yield j()},new Promise(((a,t)=>{var o=e=>{try{n(r.next(e))}catch(s){t(s)}},i=e=>{try{n(r.throw(e))}catch(s){t(s)}},n=e=>e.done?a(e.value):Promise.resolve(e.value).then(o,i);n((r=r.apply(e,s)).next())}));var e,s,r},avatar:c((()=>{const{avatar:e}=d.getUserInfo;return e||l}))}}});const k=["src"];_.render=function(e,s,r,a,t,o){const i=m("BasicForm"),n=m("a-button"),l=m("BasicModal");return p(),u(l,y({footer:null,title:e.t("layout.header.lockScreen")},e.$attrs,{class:e.prefixCls,onRegister:e.register}),{default:f((()=>[x("div",{class:h(`${e.prefixCls}__entry`)},[x("div",{class:h(`${e.prefixCls}__header`)},[x("img",{src:e.avatar,class:h(`${e.prefixCls}__header-img`)},null,10,k),x("p",{class:h(`${e.prefixCls}__header-name`)},j(e.getRealName),3)],2),v(i,{onRegister:e.registerForm},null,8,["onRegister"]),x("div",{class:h(`${e.prefixCls}__footer`)},[v(n,{type:"primary",block:"",class:"mt-2",onClick:e.handleLock},{default:f((()=>[g(j(e.t("layout.header.lockScreenBtn")),1)])),_:1},8,["onClick"])],2)],2)])),_:1},16,["title","class","onRegister"])};export{_ as default};