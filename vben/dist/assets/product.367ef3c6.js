import{aG as r,aH as o}from"./index.e1fec598.js";var e,t;function a(t,a="modal"){return r.post({url:e.AutoQueryProductList,params:t,headers:{"Content-Type":o.FORM_URLENCODED}},{errorMessageMode:a})}function d(t,a="modal"){return r.post({url:e.ProductManager,params:t,headers:{"Content-Type":o.FORM_URLENCODED}},{errorMessageMode:a})}function n(t,a="modal"){return r.post({url:e.ProductChangeLockedStatus,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}function c(t,a="modal"){return r.post({url:e.ProductChangeOrderIndex,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}function u(t,a="modal"){return r.post({url:e.ProductEditor,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}function s(t,a="modal"){return r.post({url:e.ProductSave,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}function p(t,a="modal"){return r.post({url:e.ProductCopiesEditor,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}function i(t,a="modal"){return r.post({url:e.ProductCopiesSave,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}function l(t,a="modal"){return r.post({url:e.ProductPriceEditor,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}function P(t,a="modal"){return r.post({url:e.ProductPriceSave,params:t,headers:{"Content-Type":o.JSON}},{errorMessageMode:a})}(t=e||(e={})).AutoQueryProductList="?control=product&action=autoQueryProductList",t.ProductManager="?control=product&action=productManager",t.ProductChangeLockedStatus="?control=product&action=productChangeLockedStatus",t.ProductChangeOrderIndex="?control=product&action=productChangeOrderIndex",t.ProductEditor="?control=product&action=productEditor",t.ProductSave="?control=product&action=productSave",t.ProductCopiesEditor="?control=product&action=productCopiesEditor",t.ProductCopiesSave="?control=product&action=productCopiesSave",t.ProductPriceEditor="?control=product&action=productPriceEditor",t.ProductPriceSave="?control=product&action=productPriceSave";export{a,s as b,l as c,P as d,p as e,i as f,c as g,d as h,n as i,u as p};