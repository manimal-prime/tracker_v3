!function e(t,n,a){function o(r,l){if(!n[r]){if(!t[r]){var s="function"==typeof require&&require;if(!l&&s)return s(r,!0);if(i)return i(r,!0);var c=new Error("Cannot find module '"+r+"'");throw c.code="MODULE_NOT_FOUND",c}var u=n[r]={exports:{}};t[r][0].call(u.exports,function(e){var n=t[r][1][e];return o(n?n:e)},u,u.exports,e,t,n,a)}return n[r].exports}for(var i="function"==typeof require&&require,r=0;r<a.length;r++)o(a[r]);return o}({1:[function(e,t,n){"use strict";var a=a||{};!function(e){a={Setup:function(){a.GeneralInit(),a.SearchMembers(),a.SearchCollection(),a.InitRepeater(),a.InitTabActivate(),a.ResetLocality()},SearchMembers:function(){this.TriggerFilter(document.getElementById("member-search"),this.GetSearchResults,1e3),e("#searchclear").click(function(){e("section.search-results").addClass("closed").removeClass("open"),e("#member-search").val(""),e("#searchclear").css("display","none")})},InitRepeater:function(){e(".repeater").repeater({isFirstItemUndeletable:!0})},InitTabActivate:function(){e(".nav-tabs").stickyTabs(),e('a[data-toggle="tab"]').on("shown.bs.tab",function(t){e.sparkline_display_visible()})},TriggerFilter:function(t,n,a){var o=null;e("#member-search").length&&(t.onkeypress=function(){o&&window.clearTimeout(o),o=window.setTimeout(function(){o=null,n()},a)},t=null)},GetSearchResults:function(){if(e("#member-search").val()){var t=e("input#member-search").val(),n=window.Laravel.appPath;e.ajax({url:n+"/search/members/"+t,type:"GET",success:function(t){e("#searchclear").css("display","block"),e("section.search-results").html(t),e("section.search-results").addClass("open").removeClass("closed")}})}},FormatNumber:function(e){return e.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")},SearchCollection:function(){e("#search-collection").keyup(function(){var t=e(this).val(),n=new RegExp("^"+t,"i"),a=".collection .collection-item";e(a).each(function(){var t=n.test(e(this).text());e(this).toggle(t)})})},ResetLocality:function(){e("[data-reset-locality]").click(function(){e("[data-locality-entry]").each(function(){var t=e(this).find("[data-new-string]"),n=e(this).find("[data-old-string]");t.val()!==n.val()&&(t.effect("highlight",1e3),t.val(n.val()))})})},GeneralInit:function(){var t=new Clipboard(".copy-to-clipboard");t.on("success",function(e){toastr.success("Copied!"),e.clearSelection()}),e("table.basic-datatable").DataTable({paging:!1,bFilter:!1,bInfo:!1,order:[],columnDefs:[{targets:"no-sort",orderable:!1}]}),e("table.adv-datatable").DataTable({order:[],columnDefs:[{targets:"no-sort",orderable:!1}]});var n=function(){e("[census-data]").sparkline(e("[census-data]").data("counts"),{type:"line",lineColor:"#fff",lineWidth:3,fillColor:"#404652",height:50,width:"100%"}),e(".census-pie").each(function(){e(this).sparkline(e(this).data("counts"),{type:"pie",sliceColors:["#404652","#f7af3e"]})}),e("[census-data]").bind("sparklineClick",function(e){var t=e.sparklines[0];t.getCurrentRegionFields()})},a=void 0;e(window).resize(function(){clearTimeout(a),a=setTimeout(n,100)}),n(),e(".left-nav-toggle a").on("click",function(t){t.preventDefault(),e("body").toggleClass("nav-toggle"),clearTimeout(a),a=setTimeout(n,100)}),e(".nav-second").on("show.bs.collapse",function(){e(".nav-second.in").collapse("hide")}),e(".panel-toggle").on("click",function(t){t.preventDefault();var n=e(t.target).closest("div.panel"),a=e(t.target).closest("i.toggle-icon"),o=e(t.target).find("i.toggle-icon"),i=n.find("div.panel-body"),r=n.find("div.panel-footer");i.slideToggle(300),r.slideToggle(200),a.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),o.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),n.toggleClass("").toggleClass("panel-collapse"),setTimeout(function(){n.resize(),n.find("[id^=map-]").resize()},50)}),e(".panel-close").on("click",function(t){t.preventDefault();var n=e(t.target).closest("div.panel");n.remove()})}}}(jQuery),a.Setup()},{}]},{},[1]);