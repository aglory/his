var e=Object.defineProperty,r=Object.getOwnPropertySymbols,t=Object.prototype.hasOwnProperty,o=Object.prototype.propertyIsEnumerable,a=(r,t,o)=>t in r?e(r,t,{enumerable:!0,configurable:!0,writable:!0,value:o}):r[t]=o;"undefined"!=typeof require&&require;import{D as n}from"./index.e1fec598.js";import{L as i,u as l}from"./vendor.8be1affb.js";function u(e,u){return{initSortable:function(){i((()=>{return i=this,c=null,f=function*(){e&&(yield n((()=>import("./sortable.esm.b519ac50.js")),[])).default.create(l(e),((e,n)=>{for(var i in n||(n={}))t.call(n,i)&&a(e,i,n[i]);if(r)for(var i of r(n))o.call(n,i)&&a(e,i,n[i]);return e})({animation:500,delay:400,delayOnTouchOnly:!0},u))},new Promise(((e,r)=>{var t=e=>{try{a(f.next(e))}catch(t){r(t)}},o=e=>{try{a(f.throw(e))}catch(t){r(t)}},a=r=>r.done?e(r.value):Promise.resolve(r.value).then(t,o);a((f=f.apply(i,c)).next())}));var i,c,f}))}}}export{u};