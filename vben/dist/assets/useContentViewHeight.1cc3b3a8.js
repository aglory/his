"undefined"!=typeof require&&require;import{v as e}from"./index.e1fec598.js";import{bk as t,a3 as n,G as i,r,j as o,u as a}from"./vendor.8be1affb.js";function s(e,r=150,o){let a=()=>{e()};const s=i(a,r);a=s;const u=()=>{o&&o.immediate&&a(),window.addEventListener("resize",a)},c=()=>{window.removeEventListener("resize",a)};return t((()=>{u()})),n((()=>{c()})),[u,c]}const u=Symbol();const c=r(0),f=r(0);function d(){return{headerHeightRef:c,footerHeightRef:f,setHeaderHeight:function(e){c.value=e},setFooterHeight:function(e){f.value=e}}}function h(){const t=r(window.innerHeight),n=r(window.innerHeight),i=o((()=>a(t)-a(c)-a(f)||0));s((()=>{t.value=window.innerHeight}),100,{immediate:!0}),e({contentHeight:i,setPageHeight:function(e){return t=this,i=null,r=function*(){n.value=e},new Promise(((e,n)=>{var o=e=>{try{s(r.next(e))}catch(t){n(t)}},a=e=>{try{s(r.throw(e))}catch(t){n(t)}},s=t=>t.done?e(t.value):Promise.resolve(t.value).then(o,a);s((r=r.apply(t,i)).next())}));var t,i,r},pageHeight:n},u,{native:!0})}export{d as a,h as b,s as u};