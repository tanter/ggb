(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-72deebb0"],{be1c:function(t,e,n){"use strict";var a=n("cdaa"),i=n.n(a);i.a},c046:function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"app-container"},[n("el-row",{staticClass:"ao-el-row"},[n("el-input",{staticStyle:{width:"50%","min-width":"200px"},attrs:{placeholder:"请输入用户昵称、手机号、邮箱查询"},model:{value:t.phone,callback:function(e){t.phone=e},expression:"phone"}},[n("el-button",{attrs:{slot:"append",icon:"el-icon-search"},on:{click:t.search},slot:"append"})],1)],1),t._v(" "),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],staticStyle:{"margin-top":"16px"},attrs:{data:t.list,"element-loading-text":"加载中",border:"","summary-method":t.getSummaries,"show-summary":""}},[n("el-table-column",{attrs:{align:"center",prop:"user_id",label:"用户编号",width:"80"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"name",label:"用户名",width:"200"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"p_id",label:"所属代理",width:"80"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"phone",label:"手机号",width:"200"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"email",label:"邮箱",width:"200"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"currency",label:"币种",width:"100"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"floating_pl",label:"浮动盈亏",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"手续费"}},[n("el-table-column",{attrs:{align:"center",prop:"close_fee",label:"平仓",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"center",prop:"position_fee",label:"持仓",width:"160"}})],1),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"profit_loss",label:"平仓盈亏"}})],1),t._v(" "),n("el-pagination",{attrs:{"current-page":t.page,"page-sizes":[10,20,50,100],"page-size":t.limit,total:t.total,layout:t.layout},on:{"size-change":t.sizeChange,"current-change":t.currentChange}}),t._v(" "),n("el-dialog",{staticClass:"ao-el-dialog",attrs:{width:"50%",top:"1vh",title:t.dialogTitle,center:!1,visible:t.dialogVisible},on:{"update:visible":function(e){t.dialogVisible=e}}},[n("el-form",{ref:"form",attrs:{model:t.dialogData,"label-width":"100px"}},t._l(t.dialogForm,function(e,a){return n("el-form-item",{key:a,attrs:{label:e.label}},["img"===e.type?n("img",{staticStyle:{"max-width":"200px"},attrs:{src:t.dialogData[e.field]}}):n("el-input",{attrs:{disabled:!0},model:{value:t.dialogData[e.field],callback:function(n){t.$set(t.dialogData,e.field,n)},expression:"dialogData[item.field]"}})],1)}),1),t._v(" "),n("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(e){t.dialogVisible=!1}}},[t._v("返 回")])],1)],1)],1)},i=[],r=(n("ac6a"),n("c24f")),l={data:function(){return{page:1,limit:10,layout:"total, sizes, prev, pager, next, jumper",total:0,list:[],phone:"",listLoading:!1,dialogTitle:"认证详情",dialogVisible:!1,dialogData:{},dialogIndex:-1,dialogForm:[{field:"phone",label:"用户手机号码或邮箱"},{field:"name",label:"真实姓名"},{field:"num",label:"身份证号"},{field:"id_card_face_url",label:"身份证正面",type:"img"},{field:"id_card_back_url",label:"身份证反面",type:"img"}]}},mounted:function(){this.getList()},methods:{getSummaries:function(t){t.columns;var e=t.data,n=[];return n[0]="汇总",n[6]=0,n[7]=0,n[8]=0,n[9]=0,e.forEach(function(t){n[6]+=t.floating_pl,n[7]+=t.close_fee,n[8]+=t.position_fee,n[9]+=t.profit_loss}),n},save:function(){var t=this,e={};this.dialogForm.forEach(function(n){!n.disabled&&t.dialogData[n.field]&&(e[n.field]=t.dialogData[n.field])}),e.id=this.list[this.dialogIndex].id,userEdit(e).then(function(n){for(var a in e)t.list[t.dialogIndex][a]="password"===a?"":e[a]})},edit:function(t){this.dialogData=this.list[t],this.dialogVisible=!0},sizeChange:function(t){this.page=1,this.limit=t,this.getList()},currentChange:function(t){this.page=t,this.getList()},search:function(){this.getList()},getList:function(){var t=this;this.listLoading=!0,Object(r["m"])({page:this.page,limit:this.limit,phone:this.phone}).then(function(e){e.list.forEach(function(t){t.is_lock_checked=!!t.is_auth}),t.total=e.total,t.list=e.list}).catch(function(){}).finally(function(){t.listLoading=!1})}}},o=l,u=(n("be1c"),n("2877")),s=Object(u["a"])(o,a,i,!1,null,null,null);e["default"]=s.exports},c24f:function(t,e,n){"use strict";n.d(e,"l",function(){return i}),n.d(e,"t",function(){return r}),n.d(e,"u",function(){return l}),n.d(e,"v",function(){return o}),n.d(e,"r",function(){return u}),n.d(e,"w",function(){return s}),n.d(e,"x",function(){return c}),n.d(e,"k",function(){return d}),n.d(e,"s",function(){return f}),n.d(e,"h",function(){return g}),n.d(e,"p",function(){return p}),n.d(e,"j",function(){return h}),n.d(e,"c",function(){return m}),n.d(e,"a",function(){return b}),n.d(e,"e",function(){return _}),n.d(e,"n",function(){return v}),n.d(e,"q",function(){return w}),n.d(e,"g",function(){return j}),n.d(e,"d",function(){return O}),n.d(e,"b",function(){return U}),n.d(e,"o",function(){return L}),n.d(e,"f",function(){return x}),n.d(e,"m",function(){return y}),n.d(e,"i",function(){return k});var a=n("b775");function i(t){return Object(a["a"])({url:"User/list",method:"get",params:t})}function r(t){return Object(a["a"])({url:"User/isLock",method:"post",data:t})}function l(t){return Object(a["a"])({url:"User/userDelete",method:"post",data:t})}function o(t){return Object(a["a"])({url:"User/userEdit",method:"post",data:t})}function u(t){return Object(a["a"])({url:"User/getWalletList",method:"get",params:t})}function s(t){return Object(a["a"])({url:"User/walletDelete",method:"post",data:t})}function c(t){return Object(a["a"])({url:"User/walletEdit",method:"post",data:t})}function d(t){return Object(a["a"])({url:"User/getIdCradList",method:"get",params:t})}function f(t){return Object(a["a"])({url:"User/isAuth",method:"post",data:t})}function g(){return Object(a["a"])({url:"User/excel",method:"get"})}function p(t){return Object(a["a"])({url:"User/getUserOrderList",method:"get",params:t})}function h(t){return Object(a["a"])({url:"User/getCurrency",method:"get",params:t})}function m(t){return Object(a["a"])({url:"User/editCurrency",method:"post",data:t})}function b(t){return Object(a["a"])({url:"User/addSetting",method:"post",data:t})}function _(t){return Object(a["a"])({url:"User/editSetting",method:"post",data:t})}function v(){return Object(a["a"])({url:"User/getSetting",method:"get"})}function w(t){return Object(a["a"])({url:"User/getUserRechargeList",method:"get",params:t})}function j(t){return Object(a["a"])({url:"User/ensureRecharge",method:"post",data:t})}function O(t){return Object(a["a"])({url:"User/editRecharge",method:"post",data:t})}function U(t){return Object(a["a"])({url:"User/delRecharge",method:"post",data:t})}function L(t){return Object(a["a"])({url:"User/getTakeList",method:"get",params:t})}function x(t){return Object(a["a"])({url:"User/editTakeList",method:"post",data:t})}function y(t){return Object(a["a"])({url:"User/getNowList",method:"get",params:t})}function k(t){return Object(a["a"])({url:"User/getContractOrderDetail",method:"get",params:t})}},cdaa:function(t,e,n){}}]);