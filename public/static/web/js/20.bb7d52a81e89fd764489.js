webpackJsonp([20],{PGSv:function(t,s,e){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var a=e("lGGP"),i={name:"AOAssetReturn",data:function(){return{list:[],page:1,moreFalg:!1,jyzt_td:this.$t("person.jyzt_td")}},mounted:function(){this.getDealLog()},methods:{more:function(){this.moreFalg||(this.page++,this.getDealLog())},getDealLog:function(){var t=this;Object(a.p)({page:this.page}).then(function(s){s.length>0?t.list=t.list.concat(s):t.moreFalg=!0})}}},n={render:function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"ao-person-jyrz"},[e("div",{staticClass:"table"},[e("div",{staticClass:"theader"},[e("div",{staticClass:"th"},t._l(t.jyzt_td,function(s,a){return e("div",{key:a,staticClass:"td"},[t._v(t._s(s))])}),0)]),t._v(" "),e("div",{staticClass:"tbody"},[t._l(t.list,function(s,a){return e("div",{key:a,staticClass:"tr"},[e("div",{staticClass:"td"},[t._v(t._s(s.add_time))]),t._v(" "),e("div",{staticClass:"td"},[t._v(t._s(s.message))]),t._v(" "),e("div",{staticClass:"td"},[t._v(t._s(s.money))])])}),t._v(" "),e("div",{staticClass:"more",on:{click:t.more}},[t._v(t._s(t.moreFalg?t.$t("person.more"):t.$t("person.no_more")))])],2)])])},staticRenderFns:[]};var o=e("C7Lr")(i,n,!1,function(t){e("U9Ox")},"data-v-507e147b",null);s.default=o.exports},U9Ox:function(t,s){}});
//# sourceMappingURL=20.bb7d52a81e89fd764489.js.map