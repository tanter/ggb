webpackJsonp([9],{"1BvC":function(t,s,e){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var i=e("ZS1H"),a=e("OuSc"),r=e("lGGP"),n={components:{AoAssetReturn:i.a,AoAssetCurrency:a.a},data:function(){return{record_title:this.$t("asset.record_title"),record_td:this.$t("asset.record_td"),title:"",lines:[],money:"0.00000000",unit:"",rate:"",item:{},rateMoney:"",getMoney:"",address:"",number:"",password:"",wid:"",type:"",page:1,moreFlag:!1,list:[]}},mounted:function(){var t=this,s=JSON.parse(localStorage.getItem("jyxt_asset_table_path"));s||this.$router.back(-1),this.unit=s.unit,this.money=s.money,this.ctitle=this.$t("asset.zh_title")+s.unit+" "+s.money,this.wid=s.id,this.type=s.type,this.currency=s.currency,"USDT"==this.currency&&(this.item=s,this.lines=[this.item]),Object(r.r)({wid:this.wid}).then(function(s){s.item&&(t.item=s.item,t.lines=[t.item]),t.rate=s.rate}),this.getWalletLog()},methods:{ffff:function(t){var s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:8;return parseFloat(t).toFixed(s)},more:function(){this.moreFlag||(this.page++,this.getWalletLog())},getWalletLog:function(){var t=this;Object(r.s)({wid:this.wid,page:this.page,type:this.type,currency:this.currency}).then(function(s){s.length>0?t.list=t.list.concat(s):t.moreFlag=!0})}}},c={render:function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"ao-asset-record"},[e("ao-asset-return"),t._v(" "),e("ao-asset-currency",{attrs:{title:t.title,lines:t.lines,unit:t.unit}}),t._v(" "),e("div",{staticClass:"title"},[t._v(t._s(t.record_title))]),t._v(" "),e("div",{staticClass:"table"},[e("div",{staticClass:"theader"},[e("div",{staticClass:"th"},[e("div",{staticClass:"td left"},[t._v(t._s(t.record_td[0]))]),t._v(" "),e("div",{staticClass:"td center"},[t._v(t._s(t.record_td[1]))]),t._v(" "),e("div",{staticClass:"td right"},[t._v(t._s(t.record_td[2]))])])]),t._v(" "),e("div",{staticClass:"tbody"},t._l(t.list,function(s,i){return e("div",{key:i,staticClass:"tr border"},[e("div",{staticClass:"td left"},[t._v(t._s(t.ffff(s.money)))]),t._v(" "),e("div",{staticClass:"td center"},[t._v(t._s(s.message))]),t._v(" "),e("div",{staticClass:"td right"},[t._v(t._s(s.add_time))])])}),0),t._v(" "),e("div",{staticClass:"more",on:{click:t.more}},[t._v(t._s(t.moreFlag?t.$t("person.no_more"):t.$t("person.more")))])])],1)},staticRenderFns:[]};var d=e("C7Lr")(n,c,!1,function(t){e("7/t7")},"data-v-4989dbf6",null);s.default=d.exports},"7/t7":function(t,s){},OuSc:function(t,s,e){"use strict";var i={name:"AoAssetCurrency",props:{title:{type:String,default:""},unit:{type:String,default:""},lines:{type:Array,default:function(){return[]}}},data:function(){return{td:this.$t("asset.currency_td")}},methods:{ffff:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:4;return parseFloat(t).toFixed(s)}}},a={render:function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"ao-asset-currency"},[e("div",{staticClass:"table table-2"},[e("div",{staticClass:"theader"},[e("div",{staticClass:"th th-1"},[e("div",{staticClass:"td left"},[t._v(t._s(t.title))]),t._v(" "),e("div",{staticClass:"td center"}),t._v(" "),e("div",{staticClass:"td right"})]),t._v(" "),e("div",{staticClass:"th th-2"},[e("div",{staticClass:"td left"},[t._v(t._s(t.td[0]))]),t._v(" "),e("div",{staticClass:"td center"},[t._v(t._s(t.td[1]))]),t._v(" "),e("div",{staticClass:"td center"},[t._v(t._s(t.td[2]))]),t._v(" "),e("div",{staticClass:"td right"},[t._v(t._s(t.td[3])+"("+t._s(t.unit)+")")])])]),t._v(" "),e("div",{staticClass:"tbody"},t._l(t.lines,function(s,i){return e("div",{key:i,staticClass:"tr"},[e("div",{staticClass:"td left"},[t._v(t._s(s.currency))]),t._v(" "),e("div",{staticClass:"td center"},[t._v(t._s(t.ffff(s.positions)))]),t._v(" "),e("div",{staticClass:"td center"},[t._v(t._s(t.ffff(s.positions_lock)))]),t._v(" "),e("div",{staticClass:"td right"},[t._v(t._s(t.ffff(s.zh)))])])}),0)])])},staticRenderFns:[]};var r=e("C7Lr")(i,a,!1,function(t){e("hkQV")},"data-v-01a1ae60",null);s.a=r.exports},hkQV:function(t,s){}});
//# sourceMappingURL=9.c618f46363620ba7c010.js.map