var e=Object.defineProperty,t=Object.defineProperties,n=Object.getOwnPropertyDescriptors,l=Object.getOwnPropertySymbols,a=Object.prototype.hasOwnProperty,o=Object.prototype.propertyIsEnumerable,s=(t,n,l)=>n in t?e(t,n,{enumerable:!0,configurable:!0,writable:!0,value:l}):t[n]=l,i=(e,t)=>{for(var n in t||(t={}))a.call(t,n)&&s(e,n,t[n]);if(l)for(var n of l(t))o.call(t,n)&&s(e,n,t[n]);return e},r=(e,l)=>t(e,n(l));"undefined"!=typeof require&&require;import{u,a as E,aq as _,p as d,S as g,ab as c,aE as O,aa as S,h as T,ae as p,au as C,w as N,D as A,aR as D,aS as M,aT as f,M as R,l as y,aU as m,Z as I,Q as b,aV as H,aW as h,N as v,aX as L,aY as B,aZ as w,a_ as U,Y as P,m as F,a$ as x,b0 as G,b1 as W,b2 as k,_ as $}from"./index.e1fec598.js";import{m as X,j,N as V,n as K,q as Y,_ as Q,W as Z,O as q,V as z,a1 as J,y as ee,S as te,a0 as ne,z as le,J as ae,c4 as oe,x as se,Q as ie,bh as re,r as ue,u as Ee,t as _e,F as de,a5 as ge,L as ce,bg as Oe,aC as Se,w as Te,aj as pe,aB as Ce,aR as Ne,B as Ae,a3 as De,b4 as Me,b3 as fe}from"./vendor.8be1affb.js";import{c as Re,a as ye,b as me}from"./index.21336c00.js";/* empty css              */const{t:Ie}=u(),be={confirmLoading:{type:Boolean},showCancelBtn:{type:Boolean,default:!0},cancelButtonProps:Object,cancelText:{type:String,default:Ie("common.cancelText")},showOkBtn:{type:Boolean,default:!0},okButtonProps:Object,okText:{type:String,default:Ie("common.okText")},okType:{type:String,default:"primary"},showFooter:{type:Boolean},footerHeight:{type:[String,Number],default:60}},He=i({isDetail:{type:Boolean},title:{type:String,default:""},loadingText:{type:String},showDetailBack:{type:Boolean,default:!0},visible:{type:Boolean},loading:{type:Boolean},maskClosable:{type:Boolean,default:!0},getContainer:{type:[Object,String]},closeFunc:{type:[Function,Object],default:null},destroyOnClose:{type:Boolean}},be);var he=X({name:"BasicDrawerFooter",props:r(i({},be),{height:{type:String,default:"60px"}}),emits:["ok","close"],setup(e,{emit:t}){const{prefixCls:n}=E("basic-drawer-footer");return{handleOk:function(){t("ok")},prefixCls:n,handleClose:function(){t("close")},getStyle:j((()=>{const t=`${e.height}`;return{height:t,lineHeight:t}}))}}});he.render=function(e,t,n,l,a,o){const s=V("a-button");return e.showFooter||e.$slots.footer?(K(),Y("div",{key:0,class:le(e.prefixCls),style:ae(e.getStyle)},[e.$slots.footer?Z(e.$slots,"footer",{key:1}):(K(),Y(Q,{key:0},[Z(e.$slots,"insertFooter"),e.showCancelBtn?(K(),q(s,te({key:0},e.cancelButtonProps,{onClick:e.handleClose,class:"mr-2"}),{default:z((()=>[J(ee(e.cancelText),1)])),_:1},16,["onClick"])):ne("",!0),Z(e.$slots,"centerFooter"),e.showOkBtn?(K(),q(s,te({key:1,type:e.okType,onClick:e.handleOk},e.okButtonProps,{class:"mr-2",loading:e.confirmLoading}),{default:z((()=>[J(ee(e.okText),1)])),_:1},16,["type","onClick","loading"])):ne("",!0),Z(e.$slots,"appendFooter")],64))],6)):ne("",!0)};var ve=X({name:"BasicDrawerHeader",components:{BasicTitle:_,ArrowLeftOutlined:oe},props:{isDetail:d.bool,showDetailBack:d.bool,title:d.string},emits:["close"],setup(e,{emit:t}){const{prefixCls:n}=E("basic-drawer-header");return{prefixCls:n,handleClose:function(){t("close")}}}});const Le={key:1};ve.render=function(e,t,n,l,a,o){const s=V("BasicTitle"),i=V("ArrowLeftOutlined");return e.isDetail?(K(),Y("div",{key:1,class:le([e.prefixCls,`${e.prefixCls}--detail`])},[se("span",{class:le(`${e.prefixCls}__twrap`)},[e.showDetailBack?(K(),Y("span",{key:0,onClick:t[0]||(t[0]=(...t)=>e.handleClose&&e.handleClose(...t))},[ie(i,{class:le(`${e.prefixCls}__back`)},null,8,["class"])])):ne("",!0),e.title?(K(),Y("span",Le,ee(e.title),1)):ne("",!0)],2),se("span",{class:le(`${e.prefixCls}__toolbar`)},[Z(e.$slots,"titleToolbar")],2)],2)):(K(),q(s,{key:0,class:le(e.prefixCls)},{default:z((()=>[Z(e.$slots,"title"),J(" "+ee(e.$slots.title?"":e.title),1)])),_:3},8,["class"]))};var Be=X({components:{Drawer:re,ScrollContainer:g,DrawerFooter:he,DrawerHeader:ve},inheritAttrs:!1,props:He,emits:["visible-change","ok","close","register"],setup(e,{emit:t}){const n=ue(!1),l=c(),a=ue(null),{t:o}=u(),{prefixVar:s,prefixCls:_}=E("basic-drawer"),d={setDrawerProps:function(e){a.value=O(Ee(a)||{},e),Reflect.has(e,"visible")&&(n.value=!!e.visible)},emitVisible:void 0},g=ge();g&&t("register",d,g.uid);const p=j((()=>O(_e(e),Ee(a)))),C=j((()=>{const e=r(i(i({placement:"right"},Ee(l)),Ee(p)),{visible:Ee(n)});e.title=void 0;const{isDetail:t,width:a,wrapClassName:o,getContainer:u}=e;if(t){a||(e.width="100%");const t=`${_}__detail`;e.wrapClassName=o?`${o} ${t}`:t,u||(e.getContainer=`.${s}-layout-content`)}return e})),N=j((()=>i(i({},l),Ee(C)))),A=j((()=>{const{footerHeight:e,showFooter:t}=Ee(C);return t&&e?S(e)?`${e}px`:`${e.replace("px","")}px`:"0px"})),D=j((()=>({position:"relative",height:`calc(100% - ${Ee(A)})`}))),M=j((()=>{var e;return!!(null==(e=Ee(C))?void 0:e.loading)}));return de((()=>e.visible),((e,t)=>{e!==t&&(n.value=e)}),{deep:!0}),de((()=>n.value),(e=>{ce((()=>{var n;t("visible-change",e),g&&(null==(n=d.emitVisible)||n.call(d,e,g.uid))}))})),{onClose:function(e){return l=this,a=null,o=function*(){const{closeFunc:l}=Ee(C);if(t("close",e),l&&T(l)){const e=yield l();n.value=!e}else n.value=!1},new Promise(((t,n)=>{var s=t=>{try{r(o.next(t))}catch(e){n(e)}},i=t=>{try{r(o.throw(t))}catch(e){n(e)}},r=e=>e.done?t(e.value):Promise.resolve(e.value).then(s,i);r((o=o.apply(l,a)).next())}));var l,a,o},t:o,prefixCls:_,getMergeProps:p,getScrollContentStyle:D,getProps:C,getLoading:M,getBindValues:N,getFooterHeight:A,handleOk:function(){t("ok")}}}});Be.render=function(e,t,n,l,a,o){const s=V("DrawerHeader"),i=V("ScrollContainer"),r=V("DrawerFooter"),u=V("Drawer"),E=Oe("loading");return K(),q(u,te({class:e.prefixCls,onClose:e.onClose},e.getBindValues),Se({default:z((()=>[Te(ie(i,{style:ae(e.getScrollContentStyle),"loading-tip":e.loadingText||e.t("common.loadingText")},{default:z((()=>[Z(e.$slots,"default")])),_:3},8,["style","loading-tip"]),[[E,e.getLoading]]),ie(r,te(e.getProps,{onClose:e.onClose,onOk:e.handleOk,height:e.getFooterHeight}),Se({_:2},[pe(Object.keys(e.$slots),(t=>({name:t,fn:z((n=>[Z(e.$slots,t,Ce(Ne(n||{})))]))})))]),1040,["onClose","onOk","height"])])),_:2},[e.$slots.title?{name:"title",fn:z((()=>[Z(e.$slots,"title")]))}:{name:"title",fn:z((()=>[ie(s,{title:e.getMergeProps.title,isDetail:e.isDetail,showDetailBack:e.showDetailBack,onClose:e.onClose},{titleToolbar:z((()=>[Z(e.$slots,"titleToolbar")])),_:3},8,["title","isDetail","showDetailBack","onClose"])]))}]),1040,["class","onClose"])};const we=Ae({}),Ue=Ae({});const Pe=N(Be),Fe=Re((()=>A((()=>import("./TypePicker.93523dc2.js")),["assets/TypePicker.93523dc2.js","assets/TypePicker.3f1d0a54.css","assets/vendor.8be1affb.js","assets/vendor.1f50f3e6.css","assets/index.e1fec598.js","assets/index.fe3e64b3.css"]))),xe=Re((()=>A((()=>import("./ThemeColorPicker.f138acbf.js")),["assets/ThemeColorPicker.f138acbf.js","assets/ThemeColorPicker.65b8bb21.css","assets/index.65674215.css","assets/index.35b5cf30.css","assets/index.e1fec598.js","assets/index.fe3e64b3.css","assets/vendor.8be1affb.js","assets/vendor.1f50f3e6.css","assets/index.21336c00.js","assets/index.562e7644.css","assets/useContentViewHeight.1cc3b3a8.js","assets/useSortable.92d684a3.js"]))),Ge=Re((()=>A((()=>import("./SettingFooter.92e8fde5.js")),["assets/SettingFooter.92e8fde5.js","assets/SettingFooter.7e82f41f.css","assets/index.e1fec598.js","assets/index.fe3e64b3.css","assets/vendor.8be1affb.js","assets/vendor.1f50f3e6.css"]))),We=Re((()=>A((()=>import("./SwitchItem.0bf07aa4.js")),["assets/SwitchItem.0bf07aa4.js","assets/SwitchItem.6f2459b9.css","assets/index.317f90e2.css","assets/index.65674215.css","assets/index.35b5cf30.css","assets/vendor.8be1affb.js","assets/vendor.1f50f3e6.css","assets/index.e1fec598.js","assets/index.fe3e64b3.css","assets/index.21336c00.js","assets/index.562e7644.css","assets/useContentViewHeight.1cc3b3a8.js","assets/useSortable.92d684a3.js"]))),ke=Re((()=>A((()=>import("./SelectItem.ceb58e9f.js")),["assets/SelectItem.ceb58e9f.js","assets/SelectItem.31a03fe2.css","assets/index.65674215.css","assets/index.35b5cf30.css","assets/vendor.8be1affb.js","assets/vendor.1f50f3e6.css","assets/index.e1fec598.js","assets/index.fe3e64b3.css","assets/index.21336c00.js","assets/index.562e7644.css","assets/useContentViewHeight.1cc3b3a8.js","assets/useSortable.92d684a3.js"]))),$e=Re((()=>A((()=>import("./InputNumberItem.95d4cb49.js")),["assets/InputNumberItem.95d4cb49.js","assets/InputNumberItem.3a4e4f5c.css","assets/index.553174f4.css","assets/index.65674215.css","assets/index.35b5cf30.css","assets/vendor.8be1affb.js","assets/vendor.1f50f3e6.css","assets/index.e1fec598.js","assets/index.fe3e64b3.css","assets/index.21336c00.js","assets/index.562e7644.css","assets/useContentViewHeight.1cc3b3a8.js","assets/useSortable.92d684a3.js"]))),{t:Xe}=u();var je,Ve;(Ve=je||(je={}))[Ve.CHANGE_LAYOUT=0]="CHANGE_LAYOUT",Ve[Ve.CHANGE_THEME_COLOR=1]="CHANGE_THEME_COLOR",Ve[Ve.CHANGE_THEME=2]="CHANGE_THEME",Ve[Ve.MENU_HAS_DRAG=3]="MENU_HAS_DRAG",Ve[Ve.MENU_ACCORDION=4]="MENU_ACCORDION",Ve[Ve.MENU_TRIGGER=5]="MENU_TRIGGER",Ve[Ve.MENU_TOP_ALIGN=6]="MENU_TOP_ALIGN",Ve[Ve.MENU_COLLAPSED=7]="MENU_COLLAPSED",Ve[Ve.MENU_COLLAPSED_SHOW_TITLE=8]="MENU_COLLAPSED_SHOW_TITLE",Ve[Ve.MENU_WIDTH=9]="MENU_WIDTH",Ve[Ve.MENU_SHOW_SIDEBAR=10]="MENU_SHOW_SIDEBAR",Ve[Ve.MENU_THEME=11]="MENU_THEME",Ve[Ve.MENU_SPLIT=12]="MENU_SPLIT",Ve[Ve.MENU_FIXED=13]="MENU_FIXED",Ve[Ve.MENU_CLOSE_MIX_SIDEBAR_ON_CHANGE=14]="MENU_CLOSE_MIX_SIDEBAR_ON_CHANGE",Ve[Ve.MENU_TRIGGER_MIX_SIDEBAR=15]="MENU_TRIGGER_MIX_SIDEBAR",Ve[Ve.MENU_FIXED_MIX_SIDEBAR=16]="MENU_FIXED_MIX_SIDEBAR",Ve[Ve.HEADER_SHOW=17]="HEADER_SHOW",Ve[Ve.HEADER_THEME=18]="HEADER_THEME",Ve[Ve.HEADER_FIXED=19]="HEADER_FIXED",Ve[Ve.HEADER_SEARCH=20]="HEADER_SEARCH",Ve[Ve.TABS_SHOW_QUICK=21]="TABS_SHOW_QUICK",Ve[Ve.TABS_SHOW_REDO=22]="TABS_SHOW_REDO",Ve[Ve.TABS_SHOW=23]="TABS_SHOW",Ve[Ve.TABS_SHOW_FOLD=24]="TABS_SHOW_FOLD",Ve[Ve.LOCK_TIME=25]="LOCK_TIME",Ve[Ve.FULL_CONTENT=26]="FULL_CONTENT",Ve[Ve.CONTENT_MODE=27]="CONTENT_MODE",Ve[Ve.SHOW_BREADCRUMB=28]="SHOW_BREADCRUMB",Ve[Ve.SHOW_BREADCRUMB_ICON=29]="SHOW_BREADCRUMB_ICON",Ve[Ve.GRAY_MODE=30]="GRAY_MODE",Ve[Ve.COLOR_WEAK=31]="COLOR_WEAK",Ve[Ve.SHOW_LOGO=32]="SHOW_LOGO",Ve[Ve.SHOW_FOOTER=33]="SHOW_FOOTER",Ve[Ve.ROUTER_TRANSITION=34]="ROUTER_TRANSITION",Ve[Ve.OPEN_PROGRESS=35]="OPEN_PROGRESS",Ve[Ve.OPEN_PAGE_LOADING=36]="OPEN_PAGE_LOADING",Ve[Ve.OPEN_ROUTE_TRANSITION=37]="OPEN_ROUTE_TRANSITION";const Ke=[{value:D.FULL,label:Xe("layout.setting.contentModeFull")},{value:D.FIXED,label:Xe("layout.setting.contentModeFixed")}],Ye=[{value:M.CENTER,label:Xe("layout.setting.topMenuAlignRight")},{value:M.START,label:Xe("layout.setting.topMenuAlignLeft")},{value:M.END,label:Xe("layout.setting.topMenuAlignCenter")}],Qe=[f.ZOOM_FADE,f.FADE,f.ZOOM_OUT,f.FADE_SIDE,f.FADE_BOTTOM,f.FADE_SCALE].map((e=>({label:e,value:e}))),Ze=[{title:Xe("layout.setting.menuTypeSidebar"),mode:R.INLINE,type:y.SIDEBAR},{title:Xe("layout.setting.menuTypeMix"),mode:R.INLINE,type:y.MIX},{title:Xe("layout.setting.menuTypeTopMenu"),mode:R.HORIZONTAL,type:y.TOP_MENU},{title:Xe("layout.setting.menuTypeMixSidebar"),mode:R.INLINE,type:y.MIX_SIDEBAR}],qe=[{value:m.HOVER,label:Xe("layout.setting.triggerHover")},{value:m.CLICK,label:Xe("layout.setting.triggerClick")}];function ze(e,t){const n=b(),l=function(e,t){const n=b(),{getThemeColor:l,getDarkMode:a}=v();switch(e){case je.CHANGE_LAYOUT:const{mode:e,type:o,split:s}=t;return{menuSetting:i({mode:e,type:o,collapsed:!1,show:!0,hidden:!1},void 0===s?{split:s}:{})};case je.CHANGE_THEME_COLOR:return l.value===t?{}:(U(t),{themeColor:t});case je.CHANGE_THEME:return a.value===t||w(t),{};case je.MENU_HAS_DRAG:return{menuSetting:{canDrag:t}};case je.MENU_ACCORDION:return{menuSetting:{accordion:t}};case je.MENU_TRIGGER:return{menuSetting:{trigger:t}};case je.MENU_TOP_ALIGN:return{menuSetting:{topMenuAlign:t}};case je.MENU_COLLAPSED:return{menuSetting:{collapsed:t}};case je.MENU_WIDTH:return{menuSetting:{menuWidth:t}};case je.MENU_SHOW_SIDEBAR:return{menuSetting:{show:t}};case je.MENU_COLLAPSED_SHOW_TITLE:return{menuSetting:{collapsedShowTitle:t}};case je.MENU_THEME:return h(t),{menuSetting:{bgColor:t}};case je.MENU_SPLIT:return{menuSetting:{split:t}};case je.MENU_CLOSE_MIX_SIDEBAR_ON_CHANGE:return{menuSetting:{closeMixSidebarOnChange:t}};case je.MENU_FIXED:return{menuSetting:{fixed:t}};case je.MENU_TRIGGER_MIX_SIDEBAR:return{menuSetting:{mixSideTrigger:t}};case je.MENU_FIXED_MIX_SIDEBAR:return{menuSetting:{mixSideFixed:t}};case je.OPEN_PAGE_LOADING:return n.setPageLoading(!1),{transitionSetting:{openPageLoading:t}};case je.ROUTER_TRANSITION:return{transitionSetting:{basicTransition:t}};case je.OPEN_ROUTE_TRANSITION:return{transitionSetting:{enable:t}};case je.OPEN_PROGRESS:return{transitionSetting:{openNProgress:t}};case je.LOCK_TIME:return{lockTime:t};case je.FULL_CONTENT:return{fullContent:t};case je.CONTENT_MODE:return{contentMode:t};case je.SHOW_BREADCRUMB:return{showBreadCrumb:t};case je.SHOW_BREADCRUMB_ICON:return{showBreadCrumbIcon:t};case je.GRAY_MODE:return B(t),{grayMode:t};case je.SHOW_FOOTER:return{showFooter:t};case je.COLOR_WEAK:return L(t),{colorWeak:t};case je.SHOW_LOGO:return{showLogo:t};case je.TABS_SHOW_QUICK:return{multiTabsSetting:{showQuick:t}};case je.TABS_SHOW:return{multiTabsSetting:{show:t}};case je.TABS_SHOW_REDO:return{multiTabsSetting:{showRedo:t}};case je.TABS_SHOW_FOLD:return{multiTabsSetting:{showFold:t}};case je.HEADER_THEME:return H(t),{headerSetting:{bgColor:t}};case je.HEADER_SEARCH:return{headerSetting:{showSearch:t}};case je.HEADER_FIXED:return{headerSetting:{fixed:t}};case je.HEADER_SHOW:return{headerSetting:{show:t}};default:return{}}}(e,t);n.setProjectConfig(l),e===je.CHANGE_THEME&&(H(),h())}const{t:Je}=u();var et=X({name:"SettingDrawer",setup(e,{attrs:t}){const{getContentMode:n,getShowFooter:l,getShowBreadCrumb:a,getShowBreadCrumbIcon:o,getShowLogo:s,getFullContent:i,getColorWeak:r,getGrayMode:u,getLockTime:E,getShowDarkModeToggle:_,getThemeColor:d}=v(),{getOpenPageLoading:g,getBasicTransition:c,getEnableTransition:O,getOpenNProgress:S}=P(),{getIsHorizontal:T,getShowMenu:p,getMenuType:C,getTrigger:N,getCollapsedShowTitle:A,getMenuFixed:D,getCollapsed:M,getCanDrag:f,getTopMenuAlign:R,getAccordion:m,getMenuWidth:b,getMenuBgColor:H,getIsTopMenu:h,getSplit:L,getIsMixSidebar:B,getCloseMixSidebarOnChange:w,getMixSideTrigger:U,getMixSideFixed:$}=F(),{getShowHeader:X,getFixed:V,getHeaderBgColor:K,getShowSearch:Y}=ye(),{getShowMultipleTab:Z,getShowQuick:q,getShowRedo:z,getShowFold:J}=me(),ee=j((()=>Ee(p)&&!Ee(T)));function ne(){let e=Ee(N);const t=(l=Ee(L),[{value:I.NONE,label:Xe("layout.setting.menuTriggerNone")},{value:I.FOOTER,label:Xe("layout.setting.menuTriggerBottom")},...l?[]:[{value:I.HEADER,label:Xe("layout.setting.menuTriggerTop")}]]);var l;return t.some((t=>t.value===e))||(e=I.FOOTER),ie(Q,null,[ie(We,{title:Je("layout.setting.splitMenu"),event:je.MENU_SPLIT,def:Ee(L),disabled:!Ee(ee)||Ee(C)!==y.MIX},null),ie(We,{title:Je("layout.setting.mixSidebarFixed"),event:je.MENU_FIXED_MIX_SIDEBAR,def:Ee($),disabled:!Ee(B)},null),ie(We,{title:Je("layout.setting.closeMixSidebarOnChange"),event:je.MENU_CLOSE_MIX_SIDEBAR_ON_CHANGE,def:Ee(w),disabled:!Ee(B)},null),ie(We,{title:Je("layout.setting.menuCollapse"),event:je.MENU_COLLAPSED,def:Ee(M),disabled:!Ee(ee)},null),ie(We,{title:Je("layout.setting.menuDrag"),event:je.MENU_HAS_DRAG,def:Ee(f),disabled:!Ee(ee)},null),ie(We,{title:Je("layout.setting.menuSearch"),event:je.HEADER_SEARCH,def:Ee(Y),disabled:!Ee(X)},null),ie(We,{title:Je("layout.setting.menuAccordion"),event:je.MENU_ACCORDION,def:Ee(m),disabled:!Ee(ee)},null),ie(We,{title:Je("layout.setting.collapseMenuDisplayName"),event:je.MENU_COLLAPSED_SHOW_TITLE,def:Ee(A),disabled:!Ee(ee)||!Ee(M)||Ee(B)},null),ie(We,{title:Je("layout.setting.fixedHeader"),event:je.HEADER_FIXED,def:Ee(V),disabled:!Ee(X)},null),ie(We,{title:Je("layout.setting.fixedSideBar"),event:je.MENU_FIXED,def:Ee(D),disabled:!Ee(ee)||Ee(B)},null),ie(ke,{title:Je("layout.setting.mixSidebarTrigger"),event:je.MENU_TRIGGER_MIX_SIDEBAR,def:Ee(U),options:qe,disabled:!Ee(B)},null),ie(ke,{title:Je("layout.setting.topMenuLayout"),event:je.MENU_TOP_ALIGN,def:Ee(R),options:Ye,disabled:!Ee(X)||Ee(L)||!Ee(h)&&!Ee(L)||Ee(B)},null),ie(ke,{title:Je("layout.setting.menuCollapseButton"),event:je.MENU_TRIGGER,def:e,options:t,disabled:!Ee(ee)||Ee(B)},null),ie(ke,{title:Je("layout.setting.contentMode"),event:je.CONTENT_MODE,def:Ee(n),options:Ke},null),ie($e,{title:Je("layout.setting.autoScreenLock"),min:0,event:je.LOCK_TIME,defaultValue:Ee(E),formatter:e=>0===parseInt(e)?`0(${Je("layout.setting.notAutoScreenLock")})`:`${e}${Je("layout.setting.minute")}`},null),ie($e,{title:Je("layout.setting.expandedMenuWidth"),max:600,min:100,step:10,event:je.MENU_WIDTH,disabled:!Ee(ee),defaultValue:Ee(b),formatter:e=>`${parseInt(e)}px`},null)])}return()=>ie(Pe,te(t,{title:Je("layout.setting.drawerTitle"),width:330,wrapClassName:"setting-drawer"}),{default:()=>[Ee(_)&&ie(fe,null,{default:()=>Je("layout.setting.darkMode")}),Ee(_)&&ie(x,{class:"mx-auto"},null),ie(fe,null,{default:()=>Je("layout.setting.navMode")}),ie(Q,null,[ie(Fe,{menuTypeList:Ze,handler:e=>{ze(je.CHANGE_LAYOUT,{mode:e.mode,type:e.type,split:!Ee(T)&&void 0})},def:Ee(C)},null)]),ie(fe,null,{default:()=>Je("layout.setting.sysTheme")}),ie(xe,{colorList:G,def:Ee(d),event:je.CHANGE_THEME_COLOR},null),ie(fe,null,{default:()=>Je("layout.setting.headerTheme")}),ie(xe,{colorList:W,def:Ee(K),event:je.HEADER_THEME},null),ie(fe,null,{default:()=>Je("layout.setting.sidebarTheme")}),ie(xe,{colorList:k,def:Ee(H),event:je.MENU_THEME},null),ie(fe,null,{default:()=>Je("layout.setting.interfaceFunction")}),ne(),ie(fe,null,{default:()=>Je("layout.setting.interfaceDisplay")}),ie(Q,null,[ie(We,{title:Je("layout.setting.breadcrumb"),event:je.SHOW_BREADCRUMB,def:Ee(a),disabled:!Ee(X)},null),ie(We,{title:Je("layout.setting.breadcrumbIcon"),event:je.SHOW_BREADCRUMB_ICON,def:Ee(o),disabled:!Ee(X)},null),ie(We,{title:Je("layout.setting.tabs"),event:je.TABS_SHOW,def:Ee(Z)},null),ie(We,{title:Je("layout.setting.tabsRedoBtn"),event:je.TABS_SHOW_REDO,def:Ee(z),disabled:!Ee(Z)},null),ie(We,{title:Je("layout.setting.tabsQuickBtn"),event:je.TABS_SHOW_QUICK,def:Ee(q),disabled:!Ee(Z)},null),ie(We,{title:Je("layout.setting.tabsFoldBtn"),event:je.TABS_SHOW_FOLD,def:Ee(J),disabled:!Ee(Z)},null),ie(We,{title:Je("layout.setting.sidebar"),event:je.MENU_SHOW_SIDEBAR,def:Ee(p),disabled:Ee(T)},null),ie(We,{title:Je("layout.setting.header"),event:je.HEADER_SHOW,def:Ee(X)},null),ie(We,{title:"Logo",event:je.SHOW_LOGO,def:Ee(s),disabled:Ee(B)},null),ie(We,{title:Je("layout.setting.footer"),event:je.SHOW_FOOTER,def:Ee(l)},null),ie(We,{title:Je("layout.setting.fullContent"),event:je.FULL_CONTENT,def:Ee(i)},null),ie(We,{title:Je("layout.setting.grayMode"),event:je.GRAY_MODE,def:Ee(u)},null),ie(We,{title:Je("layout.setting.colorWeak"),event:je.COLOR_WEAK,def:Ee(r)},null)]),ie(fe,null,{default:()=>Je("layout.setting.animation")}),ie(Q,null,[ie(We,{title:Je("layout.setting.progress"),event:je.OPEN_PROGRESS,def:Ee(S)},null),ie(We,{title:Je("layout.setting.switchLoading"),event:je.OPEN_PAGE_LOADING,def:Ee(g)},null),ie(We,{title:Je("layout.setting.switchAnimation"),event:je.OPEN_ROUTE_TRANSITION,def:Ee(O)},null),ie(ke,{title:Je("layout.setting.animationType"),event:je.ROUTER_TRANSITION,def:Ee(c),options:Qe,disabled:!Ee(O)},null)]),ie(fe,null,null),ie(Ge,null,null)]})}}),tt=X({name:"SettingButton",components:{SettingDrawer:et,Icon:$},setup(){const[e,{openDrawer:t}]=function(){if(!ge())throw new Error("useDrawer() can only be used inside setup() or functional components!");const e=ue(null),t=ue(!1),n=ue(""),l=()=>{const t=Ee(e);return t||C("useDrawer instance is undefined!"),t};return[function(l,a){De((()=>{e.value=null,t.value=null,we[Ee(n)]=null})),Ee(t)&&p()&&l===Ee(e)||(n.value=a,e.value=l,t.value=!0,l.emitVisible=(e,t)=>{Ue[t]=e})},{setDrawerProps:e=>{var t;null==(t=l())||t.setDrawerProps(e)},getVisible:j((()=>Ue[~~Ee(n)])),openDrawer:(e=!0,t,a=!0)=>{var o;if(null==(o=l())||o.setDrawerProps({visible:e}),t)return a?(we[Ee(n)]=null,void(we[Ee(n)]=_e(t))):void(Me(_e(we[Ee(n)]),_e(t))||(we[Ee(n)]=_e(t)))},closeDrawer:()=>{var e;null==(e=l())||e.setDrawerProps({visible:!1})}}]}();return{register:e,openDrawer:t}}});tt.render=function(e,t,n,l,a,o){const s=V("Icon"),i=V("SettingDrawer");return K(),Y("div",{onClick:t[0]||(t[0]=t=>e.openDrawer(!0))},[ie(s,{icon:"ion:settings-outline"}),ie(i,{onRegister:e.register},null,8,["onRegister"])])};var nt=Object.freeze({__proto__:null,[Symbol.toStringTag]:"Module",default:tt});export{ze as b,nt as i};