import{m as e,az as n,j as s,a5 as t,N as a,n as o,O as r,V as i,x as c,Q as l,y as m}from"./vendor.8be1affb.js";import{_ as u,p}from"./index.e1fec598.js";var d=e({name:"DropdownMenuItem",components:{MenuItem:n.Item,Icon:u},props:{key:p.string,text:p.string,icon:p.string},setup(e){const n=t();return{itemKey:s((()=>{var s,t;return e.key||(null==(t=null==(s=null==n?void 0:n.vnode)?void 0:s.props)?void 0:t.key)}))}}});const f={class:"flex items-center"};d.render=function(e,n,s,t,u,p){const d=a("Icon"),v=a("MenuItem");return o(),r(v,{key:e.itemKey},{default:i((()=>[c("span",f,[l(d,{icon:e.icon,class:"mr-1"},null,8,["icon"]),c("span",null,m(e.text),1)])])),_:1})};export{d as default};