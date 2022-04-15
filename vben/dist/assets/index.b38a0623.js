var e=Object.defineProperty,t=Object.getOwnPropertySymbols,a=Object.prototype.hasOwnProperty,l=Object.prototype.propertyIsEnumerable,i=(t,a,l)=>a in t?e(t,a,{enumerable:!0,configurable:!0,writable:!0,value:l}):t[a]=l,o=(e,o)=>{for(var n in o||(o={}))a.call(o,n)&&i(e,n,o[n]);if(t)for(var n of t(o))l.call(o,n)&&i(e,n,o[n]);return e};"undefined"!=typeof require&&require;import{aa as n,w as r,_ as s}from"./index.e1fec598.js";import{m as d,r as u,bV as p,j as c,u as f,aa as m,F as g,K as y,bW as h,n as b,q as v,y as x,J as w,_ as S,aj as O,O as V,V as j,Q as k,a1 as N,bl as T,x as _,z as B,bX as E,a0 as R,S as z}from"./vendor.8be1affb.js";/* empty css              */import{u as A}from"./useECharts.47b71843.js";/* empty css              *//* empty css              */var C=d({name:"CountTo",props:{startVal:{type:Number,default:0},endVal:{type:Number,default:2021},duration:{type:Number,default:1500},autoplay:{type:Boolean,default:!0},decimals:{type:Number,default:0,validator:e=>e>=0},prefix:{type:String,default:""},suffix:{type:String,default:""},separator:{type:String,default:","},decimal:{type:String,default:"."},color:{type:String},useEasing:{type:Boolean,default:!0},transition:{type:String,default:"linear"}},emits:["onStarted","onFinished"],setup(e,{emit:t}){const a=u(e.startVal),l=u(!1);let i=p(a);const r=c((()=>function(t){if(!t&&0!==t)return"";const{decimals:a,decimal:l,separator:i,suffix:o,prefix:r}=e;t=Number(t).toFixed(a);const s=(t+="").split(".");let d=s[0];const u=s.length>1?l+s[1]:"",p=/(\d+)(\d{3})/;if(i&&!n(i))for(;p.test(d);)d=d.replace(p,"$1"+i+"$2");return r+d+u+o}(f(i))));function s(){d(),a.value=e.endVal}function d(){i=p(a,o({disabled:l,duration:e.duration,onFinished:()=>t("onFinished"),onStarted:()=>t("onStarted")},e.useEasing?{transition:h[e.transition]}:{}))}return m((()=>{a.value=e.startVal})),g([()=>e.startVal,()=>e.endVal],(()=>{e.autoplay&&s()})),y((()=>{e.autoplay&&s()})),{value:r,start:s,reset:function(){a.value=e.startVal,d()}}}});C.render=function(e,t,a,l,i,o){return b(),v("span",{style:w({color:e.color})},x(e.value),5)};const F=r(C),L=[{title:"访问数",icon:"visit-count|svg",value:2e3,total:12e4,color:"green",action:"月"},{title:"成交额",icon:"total-sales|svg",value:2e4,total:5e5,color:"blue",action:"月"},{title:"下载数",icon:"download-count|svg",value:8e3,total:12e4,color:"orange",action:"周"},{title:"成交数",icon:"transaction|svg",value:5e3,total:5e4,color:"purple",action:"年"}],P={class:"md:flex"},$={class:"py-4 px-4 flex justify-between"},I={class:"p-2 px-4 flex justify-between"};var W=d({props:{loading:{type:Boolean}},setup:e=>(t,a)=>(b(),v("div",P,[(b(!0),v(S,null,O(f(L),((t,a)=>(b(),V(f(E),{key:t.title,size:"small",loading:e.loading,title:t.title,class:B(["md:w-1/4 w-full !md:mt-0 !mt-4",[a+1<4&&"!md:mr-4"]]),canExpan:!1},{extra:j((()=>[k(f(T),{color:t.color},{default:j((()=>[N(x(t.action),1)])),_:2},1032,["color"])])),default:j((()=>[_("div",$,[k(f(F),{prefix:"$",startVal:1,endVal:t.value,class:"text-2xl"},null,8,["endVal"]),k(f(s),{icon:t.icon,size:40},null,8,["icon"])]),_("div",I,[_("span",null,"总"+x(t.title),1),k(f(F),{prefix:"$",startVal:1,endVal:t.total},null,8,["endVal"])])])),_:2},1032,["loading","title","class"])))),128))]))});const q={width:{type:String,default:"100%"},height:{type:String,default:"280px"}};var M=d({props:o({},q),setup(e){const t=u(null),{setOptions:a}=A(t);return y((()=>{a({tooltip:{trigger:"axis",axisPointer:{lineStyle:{width:1,color:"#019680"}}},xAxis:{type:"category",boundaryGap:!1,data:["6:00","7:00","8:00","9:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00"],splitLine:{show:!0,lineStyle:{width:1,type:"solid",color:"rgba(226,226,226,0.5)"}},axisTick:{show:!1}},yAxis:[{type:"value",max:8e4,splitNumber:4,axisTick:{show:!1},splitArea:{show:!0,areaStyle:{color:["rgba(255,255,255,0.2)","rgba(226,226,226,0.2)"]}}}],grid:{left:"1%",right:"1%",top:"2  %",bottom:0,containLabel:!0},series:[{smooth:!0,data:[111,222,4e3,18e3,33333,55555,66666,33333,14e3,36e3,66666,44444,22222,11111,4e3,2e3,500,333,222,111],type:"line",areaStyle:{},itemStyle:{color:"#5ab1ef"}},{smooth:!0,data:[33,66,88,333,3333,5e3,18e3,3e3,1200,13e3,22e3,11e3,2221,1201,390,198,60,30,22,11],type:"line",areaStyle:{},itemStyle:{color:"#019680"}}]})})),(e,a)=>(b(),v("div",{ref:(e,a)=>{a.chartRef=e,t.value=e},style:w({height:e.height,width:e.width})},null,4))}}),D=d({props:o({},q),setup(e){const t=u(null),{setOptions:a}=A(t);return y((()=>{a({tooltip:{trigger:"axis",axisPointer:{lineStyle:{width:1,color:"#019680"}}},grid:{left:"1%",right:"1%",top:"2  %",bottom:0,containLabel:!0},xAxis:{type:"category",data:["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"]},yAxis:{type:"value",max:8e3,splitNumber:4},series:[{data:[3e3,2e3,3333,5e3,3200,4200,3200,2100,3e3,5100,6e3,3200,4800],type:"bar",barMaxWidth:80}]})})),(e,a)=>(b(),v("div",{ref:(e,a)=>{a.chartRef=e,t.value=e},style:w({height:e.height,width:e.width})},null,4))}});const X={key:0},G={key:1};var J=d({setup(e){const t=u("tab1"),a=[{key:"tab1",tab:"流量趋势"},{key:"tab2",tab:"访问量"}];function l(e){t.value=e}return(e,i)=>(b(),V(f(E),z({"tab-list":a},e.$attrs,{"active-tab-key":t.value,onTabChange:l}),{default:j((()=>["tab1"===t.value?(b(),v("p",X,[k(M)])):R("",!0),"tab2"===t.value?(b(),v("p",G,[k(D)])):R("",!0)])),_:1},16,["active-tab-key"]))}}),K=d({props:{loading:Boolean,width:{type:String,default:"100%"},height:{type:String,default:"300px"}},setup(e){const t=e,a=u(null),{setOptions:l}=A(a);return g((()=>t.loading),(()=>{t.loading||l({tooltip:{trigger:"item"},legend:{bottom:"1%",left:"center"},series:[{color:["#5ab1ef","#b6a2de","#67e0e3","#2ec7c9"],name:"访问来源",type:"pie",radius:["40%","70%"],avoidLabelOverlap:!1,itemStyle:{borderRadius:10,borderColor:"#fff",borderWidth:2},label:{show:!1,position:"center"},emphasis:{label:{show:!0,fontSize:"12",fontWeight:"bold"}},labelLine:{show:!1},data:[{value:1048,name:"搜索引擎"},{value:735,name:"直接访问"},{value:580,name:"邮件营销"},{value:484,name:"联盟广告"}],animationType:"scale",animationEasing:"exponentialInOut",animationDelay:function(){return 100*Math.random()}}]})}),{immediate:!0}),(t,l)=>(b(),V(f(E),{title:"访问来源",loading:e.loading},{default:j((()=>[_("div",{ref:(e,t)=>{t.chartRef=e,a.value=e},style:w({width:e.width,height:e.height})},null,4)])),_:1},8,["loading"]))}}),Q=d({props:{loading:Boolean,width:{type:String,default:"100%"},height:{type:String,default:"300px"}},setup(e){const t=e,a=u(null),{setOptions:l}=A(a);return g((()=>t.loading),(()=>{t.loading||l({legend:{bottom:0,data:["访问","购买"]},tooltip:{},radar:{radius:"60%",splitNumber:8,indicator:[{text:"电脑",max:100},{text:"充电器",max:100},{text:"耳机",max:100},{text:"手机",max:100},{text:"Ipad",max:100},{text:"耳机",max:100}]},series:[{type:"radar",symbolSize:0,areaStyle:{shadowBlur:0,shadowColor:"rgba(0,0,0,.2)",shadowOffsetX:0,shadowOffsetY:10,opacity:1},data:[{value:[90,50,86,40,50,20],name:"访问",itemStyle:{color:"#b6a2de"}},{value:[70,75,70,76,20,85],name:"购买",itemStyle:{color:"#5ab1ef"}}]}]})}),{immediate:!0}),(t,l)=>(b(),V(f(E),{title:"转化率",loading:e.loading},{default:j((()=>[_("div",{ref:(e,t)=>{t.chartRef=e,a.value=e},style:w({width:e.width,height:e.height})},null,4)])),_:1},8,["loading"]))}}),Y=d({props:{loading:Boolean,width:{type:String,default:"100%"},height:{type:String,default:"300px"}},setup(e){const t=e,a=u(null),{setOptions:l}=A(a);return g((()=>t.loading),(()=>{t.loading||l({tooltip:{trigger:"item"},series:[{name:"访问来源",type:"pie",radius:"80%",center:["50%","50%"],color:["#5ab1ef","#b6a2de","#67e0e3","#2ec7c9"],data:[{value:500,name:"电子产品"},{value:310,name:"服装"},{value:274,name:"化妆品"},{value:400,name:"家居"}].sort((function(e,t){return e.value-t.value})),roseType:"radius",animationType:"scale",animationEasing:"exponentialInOut",animationDelay:function(){return 400*Math.random()}}]})}),{immediate:!0}),(t,l)=>(b(),V(f(E),{title:"成交占比",loading:e.loading},{default:j((()=>[_("div",{ref:(e,t)=>{t.chartRef=e,a.value=e},style:w({width:e.width,height:e.height})},null,4)])),_:1},8,["loading"]))}});const H={class:"p-4"},U={class:"md:flex enter-y"};var Z=d({setup(e){const t=u(!0);return setTimeout((()=>{t.value=!1}),1500),(e,a)=>(b(),v("div",H,[k(W,{loading:t.value,class:"enter-y"},null,8,["loading"]),k(J,{class:"!my-4 enter-y",loading:t.value},null,8,["loading"]),_("div",U,[k(Q,{class:"md:w-1/3 w-full",loading:t.value},null,8,["loading"]),k(K,{class:"md:w-1/3 !md:mx-4 !md:my-0 !my-4 w-full",loading:t.value},null,8,["loading"]),k(Y,{class:"md:w-1/3 w-full",loading:t.value},null,8,["loading"])])]))}});export{Z as default};