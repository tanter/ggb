(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-09e9cb18"],{"3a3e":function(t,e,i){"use strict";i.r(e);var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"app-container"},[i("el-row",{staticClass:"ao-el-row"},[i("span",{staticStyle:{color:"#5a5353"}},[t._v("状态：")]),t._v(" "),i("el-select",{staticStyle:{width:"8%"},attrs:{placeholder:"请选择"},model:{value:t.status,callback:function(e){t.status=e},expression:"status"}},t._l(t.selectStatusList,function(t){return i("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})}),1),t._v(" "),i("el-input",{staticStyle:{width:"25%","min-width":"200px"},attrs:{placeholder:"请输入代理账号搜索"},model:{value:t.username,callback:function(e){t.username=e},expression:"username"}},[i("el-button",{attrs:{slot:"append",icon:"el-icon-search"},on:{click:t.search},slot:"append"})],1),t._v(" "),i("el-button",{staticStyle:{"margin-left":"1rem"},attrs:{type:"primary"},on:{click:function(e){return t.edit(-1)}}},[t._v("新增代理")])],1),t._v(" "),i("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],staticStyle:{"margin-top":"16px"},attrs:{data:t.list,"element-loading-text":"加载中",border:""}},[i("el-table-column",{attrs:{label:"操作",align:"center",fixed:"left",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[i("el-button",{attrs:{size:"mini",type:"primary"},on:{click:function(i){return t.edit(e.$index)}}},[t._v("编辑")]),t._v(" "),i("el-button",{attrs:{size:"mini",type:"danger"},on:{click:function(i){return t.del(e.$index)}}},[t._v("删除")])]}}])}),t._v(" "),i("el-table-column",{attrs:{align:"center",prop:"id",label:"编号",width:"80"}}),t._v(" "),i("el-table-column",{attrs:{align:"left",prop:"nickname",label:"昵称",width:"200"}}),t._v(" "),i("el-table-column",{attrs:{align:"left",prop:"phone",label:"联系方式",width:"120"}}),t._v(" "),i("el-table-column",{attrs:{align:"left",prop:"username",label:"账号",width:"120"}}),t._v(" "),i("el-table-column",{attrs:{align:"left",prop:"code",label:"推广码",width:"120"}}),t._v(" "),i("el-table-column",{attrs:{align:"left",prop:"count",label:"推广数",width:"100"}}),t._v(" "),i("el-table-column",{attrs:{label:"是否有效",align:"center",width:"100"},scopedSlots:t._u([{key:"default",fn:function(e){return[i("el-switch",{attrs:{"active-color":"#13ce66","inactive-color":"#aaaaaa"},on:{change:function(i){return t.switchChange(e.$index)}},model:{value:e.row.is_lock_checked,callback:function(i){t.$set(e.row,"is_lock_checked",i)},expression:"scope.row.is_lock_checked"}})]}}])}),t._v(" "),i("el-table-column",{attrs:{align:"left",prop:"add_time",label:"注册时间"}})],1),t._v(" "),i("el-pagination",{attrs:{"current-page":t.page,"page-sizes":[10,20,50,100],"page-size":t.limit,total:t.total,layout:t.layout},on:{"size-change":t.sizeChange,"current-change":t.currentChange}}),t._v(" "),i("el-dialog",{staticClass:"ao-el-dialog",attrs:{width:"50%",top:"1vh",title:t.dialogTitle,center:!1,visible:t.dialogVisible},on:{"update:visible":function(e){t.dialogVisible=e}}},[i("el-form",{ref:"form",attrs:{model:t.dialogData,"label-width":"100px"}},t._l(t.dialogForm,function(e,a){return i("el-form-item",{key:a,attrs:{label:e.label}},[i("el-input",{attrs:{disabled:e.disabled},model:{value:t.dialogData[e.field],callback:function(i){t.$set(t.dialogData,e.field,i)},expression:"dialogData[item.field]"}})],1)}),1),t._v(" "),i("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[i("el-button",{attrs:{type:"primary"},on:{click:t.save}},[t._v("立即提交")]),t._v(" "),i("el-button",{on:{click:function(e){t.dialogVisible=!1}}},[t._v("返 回")])],1)],1)],1)},l=[],n=(i("ac6a"),i("50fc")),o=i("67a5"),s={data:function(){return{selectStatusList:[{value:"0",label:"全部"},{value:"1",label:"正常"},{value:"2",label:"失效"}],status:"",page:1,limit:10,layout:"total, sizes, prev, pager, next, jumper",total:0,list:[],username:"",listLoading:!1,dialogTitle:"新增代理",dialogVisible:!1,dialogData:{},dialogIndex:-1,dialogForm:[{field:"nickname",label:"昵称"},{field:"phone",label:"联系方式"},{field:"username",label:"账号"},{field:"password",label:"密码"}]}},mounted:function(){this.getList()},methods:{switchChange:function(t){var e=this.list[t].is_lock_checked?1:2,i=this.list[t].id;this.editAccount({id:i,status:e})},del:function(t){var e=this,i=this.list[t].id;this.editAccount({id:i,is_delete:1},function(){e.list.splice(t,1)})},save:function(){var t=this,e={};this.dialogForm.forEach(function(i){e[i.field]=t.dialogData[i.field]}),this.dialogIndex>-1?(e.id=this.list[this.dialogIndex].id,this.editAccount(e,function(i){for(var a in e)t.list[t.dialogIndex][a]="password"===a?"":e[a];t.dialogVisible=!1})):(e.auth="agent",Object(n["a"])(e).then(function(e){t.list.unshift(e),t.dialogVisible=!1}))},editAccount:function(t,e){Object(n["b"])(t).then(function(t){e&&e(t)}).catch(function(){})},excel:function(){Object(o["a"])(n["excel"])},edit:function(t){if(this.dialogIndex=t,t>-1){var e={},i=this.list[t];this.dialogForm.forEach(function(t){e[t.field]=i[t.field]}),e.password="",this.dialogData=e}else this.dialogData={};this.dialogVisible=!0},sizeChange:function(t){this.page=1,this.limit=t,this.getList()},currentChange:function(t){this.page=t,this.getList()},search:function(){this.getList()},getList:function(){var t=this;this.listLoading=!0,Object(n["d"])({page:this.page,limit:this.limit,username:this.username,status:this.status}).then(function(e){e.list.forEach(function(t){t.is_lock_checked=1===t.status}),t.total=e.total,t.list=e.list}).catch(function(){}).finally(function(){t.listLoading=!1})}}},c=s,r=(i("af24"),i("2877")),u=Object(r["a"])(c,a,l,!1,null,null,null);e["default"]=u.exports},"4a39":function(t,e,i){},"50fc":function(t,e,i){"use strict";i.d(e,"d",function(){return l}),i.d(e,"a",function(){return n}),i.d(e,"b",function(){return o});var a=i("b775");function l(t){return Object(a["a"])({url:"Admin/getList",method:"get",params:t})}function n(t){return Object(a["a"])({url:"Admin/addAccount",method:"post",data:t})}function o(t){return Object(a["a"])({url:"Admin/editAccount",method:"post",data:t})}},"67a5":function(t,e,i){"use strict";function a(t){t().then(function(t){var e=document.createElement("a");e.href=t.url,e.style.display="none",document.body.appendChild(e),e.click()})}i.d(e,"a",function(){return a})},af24:function(t,e,i){"use strict";var a=i("4a39"),l=i.n(a);l.a}}]);