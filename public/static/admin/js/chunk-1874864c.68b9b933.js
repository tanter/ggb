(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-1874864c"],{2432:function(t,e,n){},"67a5":function(t,e,n){"use strict";function i(t){t().then(function(t){var e=document.createElement("a");e.href=t.url,e.style.display="none",document.body.appendChild(e),e.click()})}n.d(e,"a",function(){return i})},7066:function(t,e,n){"use strict";var i=n("2432"),a=n.n(i);a.a},7190:function(t,e,n){"use strict";n.r(e);var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"app-container"},[n("el-row",{staticClass:"ao-el-row"},[n("el-input",{staticStyle:{width:"50%","min-width":"200px"},attrs:{placeholder:"请输入手机号码或邮箱"},model:{value:t.phone,callback:function(e){t.phone=e},expression:"phone"}},[n("el-button",{attrs:{slot:"append",icon:"el-icon-search"},on:{click:t.search},slot:"append"})],1)],1),t._v(" "),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],staticStyle:{"margin-top":"16px"},attrs:{data:t.list,"element-loading-text":"加载中",border:""}},[n("el-table-column",{attrs:{label:"操作",align:"center",fixed:"left",width:"260"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("el-button",{attrs:{size:"mini",type:"primary"},on:{click:function(n){return t.share(e.row.id)}}},[t._v("钱包管理")]),t._v(" "),n("el-button",{attrs:{size:"mini",type:"warning"},on:{click:function(n){return t.edit(e.$index)}}},[t._v("编辑")]),t._v(" "),n("el-button",{attrs:{size:"mini",type:"danger"},on:{click:function(n){return t.del(e.$index)}}},[t._v("删除")])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",prop:"id",label:"编号",width:"80"}}),t._v(">\n    "),n("el-table-column",{attrs:{align:"left",prop:"phone",label:"电话",width:"120"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"email",label:"邮箱",width:"200"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"p_id",label:"上级代理",width:"80"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"pname",label:"代理账号(昵称)",width:"200"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"bb_usdt",label:"币币余额(USDT)",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"bb_usdt_lock",label:"币币冻结(USDT)",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"hy_usdt",label:"合约余额(USDT)",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"hy_usdt_lock",label:"合约冻结(USDT)",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"add_time",label:"注册时间"}})],1),t._v(" "),n("el-pagination",{attrs:{"current-page":t.page,"page-sizes":[10,20,50,100],"page-size":t.limit,total:t.total,layout:t.layout},on:{"size-change":t.sizeChange,"current-change":t.currentChange}}),t._v(" "),n("el-dialog",{staticClass:"ao-el-dialog",attrs:{width:"50%",top:"1vh",title:t.dialogTitle,center:!1,visible:t.dialogVisible},on:{"update:visible":function(e){t.dialogVisible=e}}},[n("el-form",{ref:"form",attrs:{model:t.dialogData,"label-width":"100px"}},t._l(t.dialogForm,function(e,i){return n("el-form-item",{key:i,attrs:{label:e.label}},[n("el-input",{attrs:{disabled:e.disabled},model:{value:t.dialogData[e.field],callback:function(n){t.$set(t.dialogData,e.field,n)},expression:"dialogData[item.field]"}})],1)}),1),t._v(" "),n("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{attrs:{type:"primary"},on:{click:t.save}},[t._v("立即提交")]),t._v(" "),n("el-button",{on:{click:function(e){t.dialogVisible=!1}}},[t._v("返 回")])],1)],1)],1)},a=[],l=(n("ac6a"),n("c24f")),r=n("67a5"),o={data:function(){return{page:1,limit:10,layout:"total, sizes, prev, pager, next, jumper",total:0,list:[],phone:"",listLoading:!1,dialogTitle:"编辑用户",dialogVisible:!1,dialogData:{},dialogIndex:-1,dialogForm:[{field:"phone",label:"手机号码",disabled:!0},{field:"email",label:"邮箱",disabled:!0},{field:"id_card",label:"身份证号",disabled:!0},{field:"password",label:"密码",disabled:!1},{field:"transaction_account",label:"法币交易账号",disabled:!1},{field:"transaction_password",label:"法币交易密码",disabled:!1},{field:"bank_number",label:"银行卡卡号",disabled:!1},{field:"bank_name",label:"银行卡所在行",disabled:!1},{field:"alipay_account",label:"支付宝账号",disabled:!1},{field:"weixin_nickname",label:"微信昵称",disabled:!1},{field:"weixin_account",label:"微信账号",disabled:!1}]}},mounted:function(){this.getList()},methods:{switchChange:function(t){var e=this.list[t].is_lock_checked?1:0,n=this.list[t].id;Object(l["t"])({id:n,is_lock:e})},del:function(t){var e=this,n=this.list[t].id;Object(l["u"])({id:n,is_delete:1}).then(function(){e.list.splice(t,1)})},save:function(){var t=this,e={};this.dialogForm.forEach(function(n){!n.disabled&&t.dialogData[n.field]&&(e[n.field]=t.dialogData[n.field])}),e.id=this.list[this.dialogIndex].id,Object(l["v"])(e).then(function(n){for(var i in e)t.list[t.dialogIndex][i]="password"===i?"":e[i];t.dialogVisible=!1})},share:function(t){this.$router.push({path:"/walletManage",query:{user_id:t}})},excel:function(){Object(r["a"])(l["h"])},edit:function(t){var e={},n=this.list[t];this.dialogForm.forEach(function(t){e[t.field]=n[t.field]}),e.password="",this.dialogIndex=t,this.dialogData=e,this.dialogVisible=!0},sizeChange:function(t){this.page=1,this.limit=t,this.getList()},currentChange:function(t){this.page=t,this.getList()},search:function(){this.getList()},getList:function(){var t=this;this.listLoading=!0,Object(l["l"])({page:this.page,limit:this.limit,phone:this.phone}).then(function(e){e.list.forEach(function(t){t.is_lock_checked=!!t.is_lock}),t.total=e.total,t.list=e.list}).catch(function(){}).finally(function(){t.listLoading=!1})}}},s=o,d=(n("7066"),n("2877")),u=Object(d["a"])(s,i,a,!1,null,null,null);e["default"]=u.exports},c24f:function(t,e,n){"use strict";n.d(e,"l",function(){return a}),n.d(e,"t",function(){return l}),n.d(e,"u",function(){return r}),n.d(e,"v",function(){return o}),n.d(e,"r",function(){return s}),n.d(e,"w",function(){return d}),n.d(e,"x",function(){return u}),n.d(e,"k",function(){return c}),n.d(e,"s",function(){return f}),n.d(e,"h",function(){return h}),n.d(e,"p",function(){return b}),n.d(e,"j",function(){return p}),n.d(e,"c",function(){return g}),n.d(e,"a",function(){return m}),n.d(e,"e",function(){return _}),n.d(e,"n",function(){return v}),n.d(e,"q",function(){return w}),n.d(e,"g",function(){return j}),n.d(e,"d",function(){return O}),n.d(e,"b",function(){return U}),n.d(e,"o",function(){return k}),n.d(e,"f",function(){return y}),n.d(e,"m",function(){return x}),n.d(e,"i",function(){return L});var i=n("b775");function a(t){return Object(i["a"])({url:"User/list",method:"get",params:t})}function l(t){return Object(i["a"])({url:"User/isLock",method:"post",data:t})}function r(t){return Object(i["a"])({url:"User/userDelete",method:"post",data:t})}function o(t){return Object(i["a"])({url:"User/userEdit",method:"post",data:t})}function s(t){return Object(i["a"])({url:"User/getWalletList",method:"get",params:t})}function d(t){return Object(i["a"])({url:"User/walletDelete",method:"post",data:t})}function u(t){return Object(i["a"])({url:"User/walletEdit",method:"post",data:t})}function c(t){return Object(i["a"])({url:"User/getIdCradList",method:"get",params:t})}function f(t){return Object(i["a"])({url:"User/isAuth",method:"post",data:t})}function h(){return Object(i["a"])({url:"User/excel",method:"get"})}function b(t){return Object(i["a"])({url:"User/getUserOrderList",method:"get",params:t})}function p(t){return Object(i["a"])({url:"User/getCurrency",method:"get",params:t})}function g(t){return Object(i["a"])({url:"User/editCurrency",method:"post",data:t})}function m(t){return Object(i["a"])({url:"User/addSetting",method:"post",data:t})}function _(t){return Object(i["a"])({url:"User/editSetting",method:"post",data:t})}function v(){return Object(i["a"])({url:"User/getSetting",method:"get"})}function w(t){return Object(i["a"])({url:"User/getUserRechargeList",method:"get",params:t})}function j(t){return Object(i["a"])({url:"User/ensureRecharge",method:"post",data:t})}function O(t){return Object(i["a"])({url:"User/editRecharge",method:"post",data:t})}function U(t){return Object(i["a"])({url:"User/delRecharge",method:"post",data:t})}function k(t){return Object(i["a"])({url:"User/getTakeList",method:"get",params:t})}function y(t){return Object(i["a"])({url:"User/editTakeList",method:"post",data:t})}function x(t){return Object(i["a"])({url:"User/getNowList",method:"get",params:t})}function L(t){return Object(i["a"])({url:"User/getContractOrderDetail",method:"get",params:t})}}}]);