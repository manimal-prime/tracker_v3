!function(e){function t(a){if(n[a])return n[a].exports;var o=n[a]={i:a,l:!1,exports:{}};return e[a].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var n={};return t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,t,n){Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:n})},t.n=function(e){var n=e&&e.__esModule?function(){return e["default"]}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=0)}([function(e,t){var n=n||{};!function(e){n={Setup:function(){n.GeneralInit(),n.SearchMembers(),n.SearchCollection(),n.InitRepeater(),n.InitTabActivate(),n.ResetLocality()},SearchMembers:function(){this.TriggerFilter(document.getElementById("member-search"),this.GetSearchResults,1e3),e("#searchclear").click(function(){e("section.search-results").addClass("closed").removeClass("open"),e("#member-search").val(""),e("#searchclear").css("display","none")})},InitRepeater:function(){e(".repeater").repeater({isFirstItemUndeletable:!0})},InitTabActivate:function(){e(".nav-tabs").stickyTabs(),e('a[data-toggle="tab"]').on("shown.bs.tab",function(t){e.sparkline_display_visible()})},TriggerFilter:function(t,n,a){var o=null;e("#member-search").length&&(t.onkeypress=function(){e(".results-loader").removeClass("hidden"),o&&window.clearTimeout(o),o=window.setTimeout(function(){o=null,n()},a)},t=null)},GetSearchResults:function(){if(e("#member-search").val()){var t=e("input#member-search").val(),n=window.Laravel.appPath;e.ajax({url:n+"/search/members/"+t,type:"GET",success:function(t){window.scrollTo(0,0),e(".results-loader").addClass("hidden"),e("#searchclear").css("display","block"),e("section.search-results").html(t),e("section.search-results").addClass("open").removeClass("closed")}})}},FormatNumber:function(e){return e.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")},SearchCollection:function(){e("#search-collection").keyup(function(){var t=e(this).val(),n=new RegExp("^"+t,"i"),a=".collection .collection-item";e(a).each(function(){var t=n.test(e(this).text());e(this).toggle(t)})})},ResetLocality:function(){e("[data-reset-locality]").click(function(){e("[data-locality-entry]").each(function(){var t=e(this).find("[data-new-string]"),n=e(this).find("[data-old-string]");t.val()!==n.val()&&(t.effect("highlight",1e3),t.val(n.val()))})})},smoothScroll:function(){e(".smooth-scroll").click(function(t){t.preventDefault();var n=e(this).attr("href"),a=e(n).offset().top-90;e("html, body").stop().animate({scrollTop:a},750)})},windowOpener:function(e,t,n){"object"!=typeof popupWin||popupWin.closed?popupWin=window.open(e,t,n):popupWin.location.href=e,popupWin.focus()},GeneralInit:function(){e(".approve-request").click(function(t){var a="width=900,height=600,scrollbars=yes";n.windowOpener(e(this).data("path"),"Tracker | Approve Member",a)}),e(".remove-member").click(function(t){var a=e(this).data("member-id"),o="https://www.clanaod.net/forums/modcp/aodmember.php?do=remaod&u="+a,r="Tracker | Remove Member",i="width=900,height=600,scrollbars=yes";n.windowOpener(o,r,i)}),e(".left-nav-toggle a").click(function(){e("body").hasClass("nav-toggle")?e.get(window.Laravel.appPath+"/primary-nav/decollapse"):e.get(window.Laravel.appPath+"/primary-nav/collapse")}),e(window).height()+100<e(document).height()&&e("#top-link-block").removeClass("hidden").affix({offset:{top:100}}),this.smoothScroll();var t=new Clipboard(".copy-to-clipboard");t.on("success",function(e){toastr.success("Copied!"),e.clearSelection()}),e("table.basic-datatable").DataTable({paging:!1,bFilter:!1,stateSave:!0,bInfo:!1,order:[],columnDefs:[{targets:"no-sort",orderable:!1}]}),e("table.adv-datatable").DataTable({order:[],columnDefs:[{targets:"no-sort",orderable:!1}]});var a,o=function(){e("[census-data]").sparkline(e("[census-data]").data("counts"),{type:"line",lineColor:"#fff",lineWidth:3,fillColor:"#404652",height:50,width:"100%"}),e(".census-pie").each(function(){e(this).sparkline(e(this).data("counts"),{type:"pie",sliceColors:e(this).data("colors")})}),e("[census-data]").bind("sparklineClick",function(e){var t=e.sparklines[0];t.getCurrentRegionFields()})};e(window).resize(function(){clearTimeout(a),a=setTimeout(o,100)}),o(),e(".left-nav-toggle a").on("click",function(t){t.preventDefault(),e("body").toggleClass("nav-toggle"),clearTimeout(a),a=setTimeout(o,100)}),e(".nav-second").on("show.bs.collapse",function(){e(".nav-second.in").collapse("hide")}),e(".panel-toggle").on("click",function(t){t.preventDefault();var n=e(t.target).closest("div.panel"),a=e(t.target).closest("i.toggle-icon"),o=e(t.target).find("i.toggle-icon"),r=n.find("div.panel-body"),i=n.find("div.panel-footer");r.slideToggle(300),i.slideToggle(200),a.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),o.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),n.toggleClass("").toggleClass("panel-collapse"),setTimeout(function(){n.resize(),n.find("[id^=map-]").resize()},50)}),e(".panel-close").on("click",function(t){t.preventDefault();var n=e(t.target).closest("div.panel");n.remove()}),e(".search-member").bootcomplete({url:window.Laravel.appPath+"/search-member/",minLength:3,idField:!0,method:"POST",dataParams:{_token:e("meta[name=csrf-token]").attr("content")}})}}}(jQuery),n.Setup()}]);