!function(t){function o(r){if(e[r])return e[r].exports;var n=e[r]={i:r,l:!1,exports:{}};return t[r].call(n.exports,n,n.exports,o),n.l=!0,n.exports}var e={};return o.m=t,o.c=e,o.i=function(t){return t},o.d=function(t,o,e){Object.defineProperty(t,o,{configurable:!1,enumerable:!0,get:e})},o.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return o.d(e,"a",e),e},o.o=function(t,o){return Object.prototype.hasOwnProperty.call(t,o)},o.p="",o(o.s=0)}([function(t,o){var e=$("#flot-line-chart").data("populations"),r=$("#flot-line-chart").data("weekly-ts"),n=$("#flot-line-chart").data("weekly-discord"),i={series:{points:{show:!0,radius:2,symbol:"circle"},splines:{show:!0,tension:.4,lineWidth:1,fill:.1}},grid:{tickColor:"#404652",borderWidth:1,color:"#000",borderColor:"#404652"},comment:{show:!0},tooltip:!1,tooltippage:{show:!0,content:"%x - %y members"},xaxis:{mode:"time",timeformat:"%m/%d/%y"},colors:["#1bbf89","#0F83C9","#f7af3e"]};$.plot($("#flot-line-chart"),[e,r,n],i),$(window).resize(function(){$.plot($("#flot-line-chart"),[e,r,n],i)})}]);