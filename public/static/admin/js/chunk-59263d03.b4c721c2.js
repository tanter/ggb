(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-59263d03"],{1923:function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"app-container"},[n("el-row",{staticClass:"ao-el-row"},[n("el-input",{staticStyle:{width:"50%","min-width":"200px"},attrs:{placeholder:"请输入代理商电话或账号"},model:{value:t.phone,callback:function(e){t.phone=e},expression:"phone"}},[n("el-button",{attrs:{slot:"append",icon:"el-icon-search"},on:{click:t.search},slot:"append"})],1)],1),t._v(" "),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],staticStyle:{"margin-top":"16px"},attrs:{data:t.list,"element-loading-text":"加载中",border:""}},[n("el-table-column",{attrs:{align:"center",prop:"id",label:"编号",width:"80"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"nickname",label:"代理商名称",width:"200"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"username",label:"代理商账号",width:"200"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"phone",label:"代理商电话",width:"120"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"usdt",label:"余额",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"usdt_lock",label:"锁定金额",width:"160"}}),t._v(" "),n("el-table-column",{attrs:{align:"left",prop:"add_time",label:"时间"}})],1),t._v(" "),n("el-pagination",{attrs:{"current-page":t.page,"page-sizes":[10,20,50,100],"page-size":t.limit,total:t.total,layout:t.layout},on:{"size-change":t.sizeChange,"current-change":t.currentChange}})],1)},i=[],l=(n("ac6a"),n("bbbc")),o={data:function(){return{page:1,limit:10,layout:"total, sizes, prev, pager, next, jumper",total:0,list:[],phone:"",listLoading:!1}},mounted:function(){this.getList()},methods:{save:function(){var t=this,e={};this.dialogForm.forEach(function(n){!n.disabled&&t.dialogData[n.field]&&(e[n.field]=t.dialogData[n.field])}),e.id=this.list[this.dialogIndex].id,userEdit(e).then(function(n){for(var a in e)t.list[t.dialogIndex][a]="password"===a?"":e[a]})},edit:function(t){this.dialogData=this.list[t],this.dialogVisible=!0},sizeChange:function(t){this.page=1,this.limit=t,this.getList()},currentChange:function(t){this.page=t,this.getList()},search:function(){this.getList()},getList:function(){var t=this;this.listLoading=!0,Object(l["f"])({page:this.page,limit:this.limit,phone:this.phone}).then(function(e){e.list.forEach(function(t){t.is_lock_checked=!!t.is_auth}),t.total=e.total,t.list=e.list}).catch(function(){}).finally(function(){t.listLoading=!1})}}},r=o,s=(n("9ab6"),n("2877")),u=Object(s["a"])(r,a,i,!1,null,null,null);e["default"]=u.exports},"4fe4":function(t,e,n){},"9ab6":function(t,e,n){"use strict";var a=n("4fe4"),i=n.n(a);i.a},bbbc:function(t,e,n){"use strict";n.d(e,"i",function(){return i}),n.d(e,"f",function(){return l}),n.d(e,"h",function(){return o}),n.d(e,"e",function(){return r}),n.d(e,"d",function(){return s}),n.d(e,"k",function(){return u}),n.d(e,"a",function(){return c}),n.d(e,"b",function(){return d}),n.d(e,"j",function(){return g}),n.d(e,"c",function(){return h}),n.d(e,"g",function(){return p});var a=n("b775");function i(t){return Object(a["a"])({url:"agent/getDealLines",method:"get",params:t})}function l(t){return Object(a["a"])({url:"agent/getAssetList",method:"get",params:t})}function o(t){return Object(a["a"])({url:"web/getCurrency",method:"get",params:t})}function r(t){return Object(a["a"])({url:"agent/getAgentTakeList",method:"get",params:t})}function s(t){return Object(a["a"])({url:"agent/delAgentTake",method:"post",data:t})}function u(t){return Object(a["a"])({url:"agent/isAuth",method:"post",data:t})}function c(t){return Object(a["a"])({url:"agent/addAgentTake",method:"post",data:t})}function d(t){return Object(a["a"])({url:"agent/calcelAgentTake",method:"post",data:t})}function g(){return Object(a["a"])({url:"agent/home",method:"get"})}function h(){return Object(a["a"])({url:"agent/clearCache",method:"post"})}function p(t){return Object(a["a"])({url:"agent/getAssetReport",method:"get",params:t})}}}]);