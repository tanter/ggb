webpackJsonp([10],{ADzs:function(t,e){},BuAB:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=n("4YfN"),r=n.n(i),o=n("dQyo"),a=n.n(o),s=n("2bvH"),c=n("qw/7"),l=n.n(c),u=n("eq+R"),f=n.n(u),d=n("qR5f"),h=n.n(d),p=n("vMJZ"),y={name:"AOAssetReturn",data:function(){return{iconaq:l.a,iconchecked:f.a,width:0,msg_txt:this.$t("person.zhsz_txt"),msg:"",msg2:"",detailList:this.$t("person.zhsz_detailList")}},computed:r()({},Object(s.c)(["invitation_code","phone","transaction_password"])),mounted:function(){var t=this;this.detailList[0].value=this.phone,this.phone||(this.detailList[0].icon=h.a,this.detailList[0].btn=this.detailList[0].btn2,this.detailList[0].path=this.detailList[0].path2),this.transaction_password&&(this.detailList[2].icon=f.a),Object(p.c)().then(function(e){t.width=e.level,e.spt?(t.msg=t.msg_txt[0].replace("#",e.spt),t.msg2=t.msg_txt[1].replace("#",e.spt)):(e.spt=e.level>60?t.$t("person.zhsz_m"):e.level>40?t.$t("person.zhsz_n"):t.$t("person.zhsz_p"),t.msg=t.msg_txt[0].replace("#",e.spt),t.msg2=t.msg_txt[1].replace("#",e.spt))})},methods:{copy:function(){var t=this,e=new a.a(".copy");e.on("success",function(n){t.$message({message:"复制成功",type:"success"}),e.destroy()}),e.on("error",function(n){t.$message({message:"该浏览器不支持自动复制",type:"error"}),e.destroy()})},path:function(t,e){t&&this.$router.push({path:t}),e&&this[e]()}}},m={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"ao-person-zhsz"},[n("div",{staticClass:"header"},[n("img",{attrs:{src:t.iconaq}}),t._v(" "),n("div",{staticClass:"info"},[n("div",{staticClass:"msg"},[t._v(t._s(t.msg))]),t._v(" "),n("div",{staticClass:"progress"},[n("div",{staticClass:"progress-load",style:{width:t.width+"%"}})]),t._v(" "),n("div",{staticClass:"msg msg-2"},[t._v(t._s(t.msg2))])])]),t._v(" "),n("div",{staticClass:"detail"},t._l(t.detailList,function(e,i){return n("div",{key:i,staticClass:"detail-item"},[n("img",{attrs:{src:e.icon}}),t._v(" "),n("span",{staticClass:"title"},[t._v(t._s(e.title))]),t._v(" "),n("span",{staticClass:"value"},[t._v(t._s(e.value))]),t._v(" "),e.btn?n("span",{staticClass:"btn",class:[e.class],attrs:{"data-clipboard-text":e.value},on:{click:function(n){return t.path(e.path,e.event)}}},[t._v(t._s(e.btn))]):t._e()])}),0)])},staticRenderFns:[]};var v=n("C7Lr")(y,m,!1,function(t){n("ADzs")},"data-v-32a4fa4a",null);e.default=v.exports},dQyo:function(t,e,n){
/*!
 * clipboard.js v2.0.4
 * https://zenorocha.github.io/clipboard.js
 * 
 * Licensed MIT © Zeno Rocha
 */
var i;i=function(){return function(t){var e={};function n(i){if(e[i])return e[i].exports;var r=e[i]={i:i,l:!1,exports:{}};return t[i].call(r.exports,r,r.exports,n),r.l=!0,r.exports}return n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)n.d(i,r,function(e){return t[e]}.bind(null,r));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=0)}([function(t,e,n){"use strict";var i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},r=function(){function t(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(e,n,i){return n&&t(e.prototype,n),i&&t(e,i),e}}(),o=c(n(1)),a=c(n(3)),s=c(n(4));function c(t){return t&&t.__esModule?t:{default:t}}var l=function(t){function e(t,n){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e);var i=function(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}(this,(e.__proto__||Object.getPrototypeOf(e)).call(this));return i.resolveOptions(n),i.listenClick(t),i}return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}(e,a.default),r(e,[{key:"resolveOptions",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this.action="function"==typeof t.action?t.action:this.defaultAction,this.target="function"==typeof t.target?t.target:this.defaultTarget,this.text="function"==typeof t.text?t.text:this.defaultText,this.container="object"===i(t.container)?t.container:document.body}},{key:"listenClick",value:function(t){var e=this;this.listener=(0,s.default)(t,"click",function(t){return e.onClick(t)})}},{key:"onClick",value:function(t){var e=t.delegateTarget||t.currentTarget;this.clipboardAction&&(this.clipboardAction=null),this.clipboardAction=new o.default({action:this.action(e),target:this.target(e),text:this.text(e),container:this.container,trigger:e,emitter:this})}},{key:"defaultAction",value:function(t){return u("action",t)}},{key:"defaultTarget",value:function(t){var e=u("target",t);if(e)return document.querySelector(e)}},{key:"defaultText",value:function(t){return u("text",t)}},{key:"destroy",value:function(){this.listener.destroy(),this.clipboardAction&&(this.clipboardAction.destroy(),this.clipboardAction=null)}}],[{key:"isSupported",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:["copy","cut"],e="string"==typeof t?[t]:t,n=!!document.queryCommandSupported;return e.forEach(function(t){n=n&&!!document.queryCommandSupported(t)}),n}}]),e}();function u(t,e){var n="data-clipboard-"+t;if(e.hasAttribute(n))return e.getAttribute(n)}t.exports=l},function(t,e,n){"use strict";var i,r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o=function(){function t(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(e,n,i){return n&&t(e.prototype,n),i&&t(e,i),e}}(),a=n(2),s=(i=a)&&i.__esModule?i:{default:i};var c=function(){function t(e){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.resolveOptions(e),this.initSelection()}return o(t,[{key:"resolveOptions",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this.action=t.action,this.container=t.container,this.emitter=t.emitter,this.target=t.target,this.text=t.text,this.trigger=t.trigger,this.selectedText=""}},{key:"initSelection",value:function(){this.text?this.selectFake():this.target&&this.selectTarget()}},{key:"selectFake",value:function(){var t=this,e="rtl"==document.documentElement.getAttribute("dir");this.removeFake(),this.fakeHandlerCallback=function(){return t.removeFake()},this.fakeHandler=this.container.addEventListener("click",this.fakeHandlerCallback)||!0,this.fakeElem=document.createElement("textarea"),this.fakeElem.style.fontSize="12pt",this.fakeElem.style.border="0",this.fakeElem.style.padding="0",this.fakeElem.style.margin="0",this.fakeElem.style.position="absolute",this.fakeElem.style[e?"right":"left"]="-9999px";var n=window.pageYOffset||document.documentElement.scrollTop;this.fakeElem.style.top=n+"px",this.fakeElem.setAttribute("readonly",""),this.fakeElem.value=this.text,this.container.appendChild(this.fakeElem),this.selectedText=(0,s.default)(this.fakeElem),this.copyText()}},{key:"removeFake",value:function(){this.fakeHandler&&(this.container.removeEventListener("click",this.fakeHandlerCallback),this.fakeHandler=null,this.fakeHandlerCallback=null),this.fakeElem&&(this.container.removeChild(this.fakeElem),this.fakeElem=null)}},{key:"selectTarget",value:function(){this.selectedText=(0,s.default)(this.target),this.copyText()}},{key:"copyText",value:function(){var t=void 0;try{t=document.execCommand(this.action)}catch(e){t=!1}this.handleResult(t)}},{key:"handleResult",value:function(t){this.emitter.emit(t?"success":"error",{action:this.action,text:this.selectedText,trigger:this.trigger,clearSelection:this.clearSelection.bind(this)})}},{key:"clearSelection",value:function(){this.trigger&&this.trigger.focus(),window.getSelection().removeAllRanges()}},{key:"destroy",value:function(){this.removeFake()}},{key:"action",set:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"copy";if(this._action=t,"copy"!==this._action&&"cut"!==this._action)throw new Error('Invalid "action" value, use either "copy" or "cut"')},get:function(){return this._action}},{key:"target",set:function(t){if(void 0!==t){if(!t||"object"!==(void 0===t?"undefined":r(t))||1!==t.nodeType)throw new Error('Invalid "target" value, use a valid Element');if("copy"===this.action&&t.hasAttribute("disabled"))throw new Error('Invalid "target" attribute. Please use "readonly" instead of "disabled" attribute');if("cut"===this.action&&(t.hasAttribute("readonly")||t.hasAttribute("disabled")))throw new Error('Invalid "target" attribute. You can\'t cut text from elements with "readonly" or "disabled" attributes');this._target=t}},get:function(){return this._target}}]),t}();t.exports=c},function(t,e){t.exports=function(t){var e;if("SELECT"===t.nodeName)t.focus(),e=t.value;else if("INPUT"===t.nodeName||"TEXTAREA"===t.nodeName){var n=t.hasAttribute("readonly");n||t.setAttribute("readonly",""),t.select(),t.setSelectionRange(0,t.value.length),n||t.removeAttribute("readonly"),e=t.value}else{t.hasAttribute("contenteditable")&&t.focus();var i=window.getSelection(),r=document.createRange();r.selectNodeContents(t),i.removeAllRanges(),i.addRange(r),e=i.toString()}return e}},function(t,e){function n(){}n.prototype={on:function(t,e,n){var i=this.e||(this.e={});return(i[t]||(i[t]=[])).push({fn:e,ctx:n}),this},once:function(t,e,n){var i=this;function r(){i.off(t,r),e.apply(n,arguments)}return r._=e,this.on(t,r,n)},emit:function(t){for(var e=[].slice.call(arguments,1),n=((this.e||(this.e={}))[t]||[]).slice(),i=0,r=n.length;i<r;i++)n[i].fn.apply(n[i].ctx,e);return this},off:function(t,e){var n=this.e||(this.e={}),i=n[t],r=[];if(i&&e)for(var o=0,a=i.length;o<a;o++)i[o].fn!==e&&i[o].fn._!==e&&r.push(i[o]);return r.length?n[t]=r:delete n[t],this}},t.exports=n},function(t,e,n){var i=n(5),r=n(6);t.exports=function(t,e,n){if(!t&&!e&&!n)throw new Error("Missing required arguments");if(!i.string(e))throw new TypeError("Second argument must be a String");if(!i.fn(n))throw new TypeError("Third argument must be a Function");if(i.node(t))return function(t,e,n){return t.addEventListener(e,n),{destroy:function(){t.removeEventListener(e,n)}}}(t,e,n);if(i.nodeList(t))return function(t,e,n){return Array.prototype.forEach.call(t,function(t){t.addEventListener(e,n)}),{destroy:function(){Array.prototype.forEach.call(t,function(t){t.removeEventListener(e,n)})}}}(t,e,n);if(i.string(t))return function(t,e,n){return r(document.body,t,e,n)}(t,e,n);throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList")}},function(t,e){e.node=function(t){return void 0!==t&&t instanceof HTMLElement&&1===t.nodeType},e.nodeList=function(t){var n=Object.prototype.toString.call(t);return void 0!==t&&("[object NodeList]"===n||"[object HTMLCollection]"===n)&&"length"in t&&(0===t.length||e.node(t[0]))},e.string=function(t){return"string"==typeof t||t instanceof String},e.fn=function(t){return"[object Function]"===Object.prototype.toString.call(t)}},function(t,e,n){var i=n(7);function r(t,e,n,r,o){var a=function(t,e,n,r){return function(n){n.delegateTarget=i(n.target,e),n.delegateTarget&&r.call(t,n)}}.apply(this,arguments);return t.addEventListener(n,a,o),{destroy:function(){t.removeEventListener(n,a,o)}}}t.exports=function(t,e,n,i,o){return"function"==typeof t.addEventListener?r.apply(null,arguments):"function"==typeof n?r.bind(null,document).apply(null,arguments):("string"==typeof t&&(t=document.querySelectorAll(t)),Array.prototype.map.call(t,function(t){return r(t,e,n,i,o)}))}},function(t,e){var n=9;if("undefined"!=typeof Element&&!Element.prototype.matches){var i=Element.prototype;i.matches=i.matchesSelector||i.mozMatchesSelector||i.msMatchesSelector||i.oMatchesSelector||i.webkitMatchesSelector}t.exports=function(t,e){for(;t&&t.nodeType!==n;){if("function"==typeof t.matches&&t.matches(e))return t;t=t.parentNode}}}])},t.exports=i()},"qw/7":function(t,e){t.exports="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABUCAMAAAArteDzAAABJlBMVEUAAABJWXEwP1IxQFI/TmU+TmQ5SF09TGI9TGIvPlE9TWMxQFMxQVRGVm01RFk1RVhJWnJJWXJDU2pKWnI7Sl9LXHVCUmg8TGEwP1I9TWJJWXFLW3RDU2o5SV1MXHUtPE5LW3RBUWdMXHVMXHX///82RVpKW3MwP1ItPE4/T2VIWHBCUWhFVWw7Sl88TGJHV29GV240Q1dlcYLk5un4+fqgqLJ8h5bw8vNDUWT7/PyIkZ+8wch0fozCx83q7O6nrrjd4ORteYqyucKZoa3Q1NlVYnVIVmhcaXw0Q1dAUGY8TGI/T2U0Q1c0Q1YzQ1YvPVA0Q1Y9TGI0Q1Y+TmRLW3QvPlBKW3NAT2Y/T2VLW3QuPVBAT2Y/T2RLW3RAUGYvPlBKW3NKW3PDzsOVAAAAOXRSTlMAzKm3GiIyEAPPKmpcanujtdijXcigUeOSCJF3tPbr4qj19/z///////////////////////////5HrZd9AAADn0lEQVRYw6zQXWviQBgF4DOQmCCk5KOxVEXaZchFIqyYD1DZrqYtZS+XBnYv/P+/o03TUpl5zUwSH+8O7zlkhJI5mYXM+1G9W3gsnE1MDGME4aKSLMLAQE+Ww6qzmGOhu3FYKYRjdDNyKw3uCPqMu0rTnQE99izqYGZDg8miTpgJpSDqLFA9fRr1MLXR4taNenFvcZbFop6YdXbTi3vzrHPfGQ9Af6vtxoO4NmTTeKApJEE8WACB+fMCTOEP9S4x6tk45axUDml6UB45OGEoz4uM82yrPDPwzVfcRr/5h7JSHPrfm6Nlu2LPP6WF4nSEL/O2s1XxxE88Fau26zk+jVuO1nnKBWm+bimM0fCXhOp5XTzuHjjp4ddjsX6uqJ6PD9ZSlmdcQ5YTVQs1J5FtuJaMqDqosSRZCr+EayKqDO+MRKY/SjDq1w8bpd8/v/ToHMD9pUfvAfMPhWsiyyYmeqObcrstN3qjE1z9o0ibhzo9SKtk+Qr+fwoX7Jp4J+Zk2cf1kcIFeRPnYk6Wr3HzSuGCsolLMSfLNzhqje6beK8zejziL4mLXur0RYrJ8qvuaF6nuTxKeiud7noTBaIwAL/hGyFwY1p70fSGWTZLzg2wkirabrSmMdnZ+00T//+/2KU2aWXOwKjPBGMm57weHDANrbrdyjh0z8kU5X5fZoo9C7fEyRRPRE+Zgjj3xqFboq1h6C2mhqENUWMYOkVKnFo9KaKK+SVOioQ4ldl/WhEnwQ2RUBatsp76G9EPZf4t23wDlzgbZlCin8orQRwXuBeMUnlMNbuMewCWEKSuda990ZUveptr4lotALHg9O+0XhTFou7fveDEAJzuC/UusauzUfVOdOj0Qzj4byo4m2zURnCm6ESCQ8/ZiGcSnAgdX7BemmxQ8yJYPt6lglU+ZgMeW8FKceS98n7VA4fUapo8fLA1BeU601iXmhYb6I2qKFYZa1W8jg0KpL915g1zRHNteYpPjtTarZQxd1LLwReR1Js3p2NKvQhfBaHUK5afmctC6oUBTkykzLVLtuuPQ2+7Xm3ZBD2x1JV219vyfcy3Y5FGDMUsH9RWVZsPmkEV2HkutetIDiw7AMMP8yuEPsCnXpvJp16Xybuz84vYdxgQzA4XmAUYFp+fGWPUJDwvMpzAQJD8OUMSwIxr/TVkuTDn2SaRtofzeOnolB7O50fhd60w8nEhJ7JyNTC3IgfXcePECh8OXdrhIbSS2MWYf0vhUEYK+1Z+AAAAAElFTkSuQmCC"}});
//# sourceMappingURL=10.73a3a1d83b1ecebe5bf6.js.map