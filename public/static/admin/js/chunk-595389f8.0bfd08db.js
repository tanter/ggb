(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-595389f8"],{2118:function(t,e,a){},"2fda":function(t,e,a){"use strict";var l=a("2118"),n=a.n(l);n.a},"67a5":function(t,e,a){"use strict";function l(t){t().then(function(t){var e=document.createElement("a");e.href=t.url,e.style.display="none",document.body.appendChild(e),e.click()})}a.d(e,"a",function(){return l})},"87d7":function(t,e,a){"use strict";a.r(e);var l=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"app-container"},[a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],staticStyle:{"margin-top":"16px"},attrs:{data:t.list,"element-loading-text":"加载中",border:""}},[a("el-table-column",{attrs:{label:"操作",align:"center",fixed:"left",width:"100"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{size:"mini",type:"danger"},on:{click:function(a){return t.del(e.$index)}}},[t._v("删除")])]}}])}),t._v(" "),a("el-table-column",{attrs:{align:"center",prop:"user_id",label:"用户编号",width:"80"}}),t._v(" "),a("el-table-column",{attrs:{align:"left",prop:"currency",label:"币种",width:"80"}}),t._v(" "),a("el-table-column",{attrs:{align:"left",prop:"address",label:"地址",width:"400"}}),t._v(" "),a("el-table-column",{attrs:{label:"币币",align:"center"}},[a("el-table-column",{attrs:{align:"left",prop:"bb_usdt",label:"余额",width:"160"}}),t._v(" "),a("el-table-column",{attrs:{align:"left",prop:"bb_usdt_lock",label:"锁定",width:"160"}})],1),t._v(" "),a("el-table-column",{attrs:{label:"合约",align:"center"}},[a("el-table-column",{attrs:{align:"left",prop:"hy_usdt",label:"余额",width:"160"}}),t._v(" "),a("el-table-column",{attrs:{align:"left",prop:"hy_usdt_lock",label:"锁定",width:"160"}})],1),t._v(" "),a("el-table-column",{attrs:{align:"left",prop:"add_time",label:"创建时间"}})],1),t._v(" "),a("el-dialog",{staticClass:"ao-el-dialog",attrs:{width:"50%",top:"10vh",title:t.dialogTitle,center:!1,visible:t.dialogVisible},on:{"update:visible":function(e){t.dialogVisible=e}}},[a("el-form",{ref:"form",attrs:{model:t.dialogData,"label-width":"100px"}},t._l(t.dialogForm,function(e,l){return a("el-form-item",{key:l,attrs:{label:e.label}},["select"===e.type?a("el-select",{attrs:{placeholder:"请选择"},model:{value:t.dialogData[e.field],callback:function(a){t.$set(t.dialogData,e.field,a)},expression:"dialogData[item.field]"}},t._l(e.list,function(t,e){return a("el-option",{key:e,attrs:{label:t.label,value:t.value}})}),1):"radio"===e.type?a("el-radio-group",{model:{value:t.dialogData[e.field],callback:function(a){t.$set(t.dialogData,e.field,a)},expression:"dialogData[item.field]"}},t._l(e.list,function(e,l){return a("el-radio",{key:l,attrs:{label:e.label}},[t._v(t._s(e.value))])}),1):"textarea"===e.type?a("el-input",{attrs:{type:"textarea",row:3},model:{value:t.dialogData[e.field],callback:function(a){t.$set(t.dialogData,e.field,a)},expression:"dialogData[item.field]"}}):a("el-input",{attrs:{disabled:e.disabled},model:{value:t.dialogData[e.field],callback:function(a){t.$set(t.dialogData,e.field,a)},expression:"dialogData[item.field]"}})],1)}),1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{attrs:{type:"primary"},on:{click:t.save}},[t._v("立即提交")]),t._v(" "),a("el-button",{on:{click:function(e){t.dialogVisible=!1}}},[t._v("返 回")])],1)],1)],1)},n=[],i=a("c24f"),r=(a("67a5"),{data:function(){return{list:[],listLoading:!1,dialogTitle:"编辑用户",dialogVisible:!1,dialogData:{currency:"",field:"",type:"1",number:"",message:""},dialogIndex:-1,dialogForm:[{field:"currency",label:"钱包币种",disabled:!0},{field:"field",label:"调节账户",type:"select",list:[]},{field:"type",label:"调节方式",type:"radio"},{field:"number",label:"调节值"},{field:"message",label:"调节备注",type:"textarea"}]}},mounted:function(){this.dialogForm[1].list=[{value:"1||balance",label:"币币交易余额"},{value:"1||balance_lock",label:"币币交易锁定余额"},{value:"2||balance",label:"杠杆交易余额"},{value:"2||balance_lock",label:"杠杆交易锁定余额"}],this.dialogForm[2].list=[{label:"1",value:"增加"},{label:"0",value:"减少"}],this.user_id=this.$route.query.user_id,this.getWalletList()},methods:{del:function(t){var e=this,a=this.list[t].user_id,l=this.list[t].currency;Object(i["w"])({user_id:a,is_delete:1,currency:l}).then(function(){e.list.splice(t,1)})},save:function(){var t=this;this.dialogData.user_id=this.list[this.dialogIndex].user_id,Object(i["x"])(this.dialogData).then(function(e){t.dialogVisible=!1;var a="1"===t.dialogData.type?parseFloat(t.dialogData.number):0-parseFloat(t.dialogData.number);a+=parseFloat(t.list[t.dialogIndex][t.dialogData.field]),t.list[t.dialogIndex][t.dialogData.field]=parseFloat(a).toFixed(8)}).catch(function(){})},edit:function(t){this.dialogIndex=t,this.dialogData.currency=this.list[t].currency,this.dialogVisible=!0},getWalletList:function(){var t=this;this.listLoading=!0,Object(i["r"])({page:this.page,limit:this.limit,user_id:this.user_id}).then(function(e){t.list=e.list}).catch(function(){}).finally(function(){t.listLoading=!1})}}}),o=r,u=(a("2fda"),a("2877")),d=Object(u["a"])(o,l,n,!1,null,null,null);e["default"]=d.exports},c24f:function(t,e,a){"use strict";a.d(e,"l",function(){return n}),a.d(e,"t",function(){return i}),a.d(e,"u",function(){return r}),a.d(e,"v",function(){return o}),a.d(e,"r",function(){return u}),a.d(e,"w",function(){return d}),a.d(e,"x",function(){return s}),a.d(e,"k",function(){return c}),a.d(e,"s",function(){return f}),a.d(e,"h",function(){return b}),a.d(e,"p",function(){return g}),a.d(e,"j",function(){return p}),a.d(e,"c",function(){return m}),a.d(e,"a",function(){return h}),a.d(e,"e",function(){return v}),a.d(e,"n",function(){return _}),a.d(e,"q",function(){return y}),a.d(e,"g",function(){return O}),a.d(e,"d",function(){return j}),a.d(e,"b",function(){return U}),a.d(e,"o",function(){return D}),a.d(e,"f",function(){return k}),a.d(e,"m",function(){return w}),a.d(e,"i",function(){return x});var l=a("b775");function n(t){return Object(l["a"])({url:"User/list",method:"get",params:t})}function i(t){return Object(l["a"])({url:"User/isLock",method:"post",data:t})}function r(t){return Object(l["a"])({url:"User/userDelete",method:"post",data:t})}function o(t){return Object(l["a"])({url:"User/userEdit",method:"post",data:t})}function u(t){return Object(l["a"])({url:"User/getWalletList",method:"get",params:t})}function d(t){return Object(l["a"])({url:"User/walletDelete",method:"post",data:t})}function s(t){return Object(l["a"])({url:"User/walletEdit",method:"post",data:t})}function c(t){return Object(l["a"])({url:"User/getIdCradList",method:"get",params:t})}function f(t){return Object(l["a"])({url:"User/isAuth",method:"post",data:t})}function b(){return Object(l["a"])({url:"User/excel",method:"get"})}function g(t){return Object(l["a"])({url:"User/getUserOrderList",method:"get",params:t})}function p(t){return Object(l["a"])({url:"User/getCurrency",method:"get",params:t})}function m(t){return Object(l["a"])({url:"User/editCurrency",method:"post",data:t})}function h(t){return Object(l["a"])({url:"User/addSetting",method:"post",data:t})}function v(t){return Object(l["a"])({url:"User/editSetting",method:"post",data:t})}function _(){return Object(l["a"])({url:"User/getSetting",method:"get"})}function y(t){return Object(l["a"])({url:"User/getUserRechargeList",method:"get",params:t})}function O(t){return Object(l["a"])({url:"User/ensureRecharge",method:"post",data:t})}function j(t){return Object(l["a"])({url:"User/editRecharge",method:"post",data:t})}function U(t){return Object(l["a"])({url:"User/delRecharge",method:"post",data:t})}function D(t){return Object(l["a"])({url:"User/getTakeList",method:"get",params:t})}function k(t){return Object(l["a"])({url:"User/editTakeList",method:"post",data:t})}function w(t){return Object(l["a"])({url:"User/getNowList",method:"get",params:t})}function x(t){return Object(l["a"])({url:"User/getContractOrderDetail",method:"get",params:t})}}}]);