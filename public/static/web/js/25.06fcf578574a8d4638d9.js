webpackJsonp([25],{VbcS:function(t,e){},qpDc:function(t,e,o){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=o("TWFi"),a=o("gyMJ"),c=o("vMJZ"),r={components:{AoNav:s.a},data:function(){return{title:"",showAccount:!0,btn_get_code2:"",btn_get_code:"",code_unit:"",form:{account:"",password:"",password_again:"",code:""}}},mounted:function(){this.btn_get_code2=this.$t("forgetpwd.code_btn"),this.btn_get_code=this.btn_get_code2,this.code_unit=this.$t("forgetpwd.code_unit"),"changepwd"===this.$route.query.type?(this.showAccount=!1,this.title=this.$t("forgetpwd.title")[0]):this.title=this.$t("forgetpwd.title")[1]},methods:{error:function(t){this.$message({message:this.$t("forgetpwd."+t),type:"error"})},save:function(){var t=this;!this.showAccount||this.form.account?this.form.code?0!=this.r_code&&this.r_code==this.form.code?this.form.password&&this.form.password_again?this.form.password==this.form.password_again?Object(c.h)(this.form).then(function(e){t.$router.back(-1)}).catch(function(t){console.log(t)}):this.error("password_no_equality"):this.error("password_no_data"):this.error("code_no_equality"):this.error("code_no_data"):this.error("account_no_data")},getCode:function(){var t=this;if(!this.sendCodeFlag)if(!this.showAccount||this.form.account){this.sendCodeFlag=!0;var e={};this.showAccount?(e.account=this.form.account,e.type="forgetpwd"):e.type="bindmpwd",Object(a.b)(e).then(function(e){var o=e.code,s=void 0===o?0:o;t.r_code=s,t.btn_get_code=60+t.code_unit;var a=60,c=setInterval(function(){a--,t.btn_get_code=a+t.code_unit,0===a&&(clearInterval(c),t.btn_get_code=t.btn_get_code2,t.sendCodeFlag=!1)},1e3)}).catch(function(){t.sendCodeFlag=!1})}else this.$message({message:this.$t("forgetpwd.account_no_data"),type:"error"})}}},i={render:function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"forgetpwd"},[o("ao-nav",{attrs:{"ao-style":{background:"#1b2945"}}}),t._v(" "),o("div",{staticClass:"content"},[o("div",{staticClass:"content-bg"},[o("div",{staticClass:"content-box"},[o("div",{staticClass:"content-list"},[o("div",{staticClass:"title"},[t._v(t._s(t.title))]),t._v(" "),o("div",{staticClass:"account"},[o("el-form",{ref:"loginForm",attrs:{model:t.form}},[t.showAccount?o("el-form-item",{attrs:{prop:"checkPass"}},[o("el-row",{staticClass:"text"},[t._v(t._s(t.$t("forgetpwd.account")))]),t._v(" "),o("el-input",{staticClass:"el-input-row",attrs:{type:"text","auto-complete":"off",placeholder:""},model:{value:t.form.account,callback:function(e){t.$set(t.form,"account",e)},expression:"form.account"}})],1):t._e(),t._v(" "),o("el-form-item",{attrs:{prop:"checkPass"}},[o("el-row",{staticClass:"text"},[t._v(t._s(t.$t("forgetpwd.code_text")))]),t._v(" "),o("el-row",{staticClass:"el-input-border",staticStyle:{display:"flex"}},[o("el-input",{staticClass:"el-input-row",attrs:{type:"text","auto-complete":"off"},model:{value:t.form.code,callback:function(e){t.$set(t.form,"code",e)},expression:"form.code"}}),t._v(" "),o("div",{staticClass:"el-input-choose el-input-choose-code"},[o("div",{staticClass:"el-value",on:{click:t.getCode}},[t._v(t._s(t.btn_get_code))])])],1)],1),t._v(" "),o("el-form-item",{attrs:{prop:"checkPass"}},[o("el-row",{staticClass:"text"},[t._v(t._s(t.$t("forgetpwd.password_text")))]),t._v(" "),o("el-input",{staticClass:"el-input-row",attrs:{type:"password","auto-complete":"off"},model:{value:t.form.password,callback:function(e){t.$set(t.form,"password",e)},expression:"form.password"}})],1),t._v(" "),o("el-form-item",{attrs:{prop:"checkPass"}},[o("el-row",{staticClass:"text"},[t._v(t._s(t.$t("forgetpwd.password_again_text")))]),t._v(" "),o("el-input",{staticClass:"el-input-row",attrs:{type:"password","auto-complete":"off"},model:{value:t.form.password_again,callback:function(e){t.$set(t.form,"password_again",e)},expression:"form.password_again"}})],1),t._v(" "),o("el-form-item",[o("el-button",{attrs:{type:"primary"},on:{click:t.save}},[t._v(t._s(t.$t("forgetpwd.forgetpwd_btn")))])],1)],1)],1)])])])])],1)},staticRenderFns:[]};var n=o("C7Lr")(r,i,!1,function(t){o("VbcS")},null,null);e.default=n.exports}});
//# sourceMappingURL=25.06fcf578574a8d4638d9.js.map