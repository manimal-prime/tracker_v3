!function(t){function e(o){if(n[o])return n[o].exports;var r=n[o]={i:o,l:!1,exports:{}};return t[o].call(r.exports,r,r.exports,e),r.l=!0,r.exports}var n={};return e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,e,n){Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:n})},e.n=function(t){var n=t&&t.__esModule?function(){return t["default"]}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=0)}([function(t,e){var n=n||{};!function(t){n={setup:function(){this.initAutocomplete(),this.initSetup()},initSetup:function(){var e=t(".promotions-chart");if(e.length){new Chart(e,{type:"doughnut",data:{datasets:[{data:e.data("values"),borderWidth:0,backgroundColor:["#949ba2","#0f83c9","#1bbf89","#f7af3e","#56c0e0","#db524b"]}],labels:e.data("labels")},options:{legend:{position:"bottom",labels:{boxWidth:5,fontColor:"#949ba2"},label:{fullWidth:!0}}}})}},initAutocomplete:function(){t("#leader").bootcomplete({url:window.Laravel.appPath+"/search-member/",minLength:3,idField:!0,method:"POST",dataParams:{_token:t("meta[name=csrf-token]").attr("content")}})}}}(jQuery),n.setup()}]);