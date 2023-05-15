(()=>{function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e(t)}var t,a=a||{};t=jQuery,(a={Setup:function(){a.GeneralInit(),a.SearchMembers(),a.SearchCollection(),a.InitRepeater(),a.InitTabActivate(),a.ResetLocality()},SearchMembers:function(){this.TriggerFilter(document.getElementById("member-search"),this.GetSearchResults,500),t("#search_type").change((function(){a.GetSearchResults(),"handle"===this.value?t("#member-search").attr("placeholder","Search for an ingame name..."):t("#member-search").attr("placeholder","Search for a player...")})),t("#searchclear").click((function(){t("section.search-results").addClass("closed").removeClass("open"),t("#member-search").val(""),t("#searchclear").css("display","none")}))},InitRepeater:function(){t(".repeater").repeater({isFirstItemUndeletable:!0})},InitTabActivate:function(){t(".nav-tabs").stickyTabs(),t('a[data-toggle="tab"]').on("shown.bs.tab",(function(e){t.sparkline_display_visible()}))},TriggerFilter:function(e,a,o){var n=null;t("#member-search").length&&(e.onkeypress=function(){t(".results-loader").removeClass("hidden"),n&&window.clearTimeout(n),n=window.setTimeout((function(){n=null,a()}),o)},e=null)},GetSearchResults:function(){if(t("#member-search").val()){var e=t("input#member-search").val(),a=t("select#search_type").val(),o=window.Laravel.appPath;t.ajax({url:"".concat(o,"/search/").concat(a,"/").concat(e),type:"GET",success:function(e){window.scrollTo(0,0),t(".results-loader").addClass("hidden"),t("#searchclear").css("display","block"),t("section.search-results").html(e),t("section.search-results").addClass("open").removeClass("closed")}})}},FormatNumber:function(e){return e.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")},SearchCollection:function(){t("#search-collection").keyup((function(){var e=t(this).val(),a=new RegExp("^"+e,"i");t(".collection .collection-item").each((function(){var e=a.test(t(this).text());t(this).toggle(e)}))}))},ResetLocality:function(){t("[data-reset-locality]").click((function(){t("[data-locality-entry]").each((function(){var e=t(this).find("[data-new-string]"),a=t(this).find("[data-old-string]");e.val()!==a.val()&&(e.effect("highlight",1e3),e.val(a.val()))}))}))},smoothScroll:function(){t(".smooth-scroll").click((function(e){e.preventDefault();var a=t(this).attr("href"),o=t(a).offset().top-90;t("html, body").stop().animate({scrollTop:o},750),window.location.hash=t.attr(this,"href").substr(1)}))},windowOpener:function(t,a,o){"object"!=("undefined"==typeof popupWin?"undefined":e(popupWin))||popupWin.closed?popupWin=window.open(t,a,o):popupWin.location.href=t,popupWin.focus()},GeneralInit:function(){t(".approve-request").click((function(e){a.windowOpener(t(this).data("path"),"Tracker | Approve Member","width=900,height=600,scrollbars=yes")})),t(".remove-member").click((function(e){var o="https://www.clanaod.net/forums/modcp/aodmember.php?do=remaod&u="+t(this).data("member-id");a.windowOpener(o,"Tracker | Remove Member","width=900,height=600,scrollbars=yes")})),t(".left-nav-toggle a").click((function(){t("body").hasClass("nav-toggle")?t.get(window.Laravel.appPath+"/primary-nav/decollapse"):t.get(window.Laravel.appPath+"/primary-nav/collapse")})),t(window).height()+100<t(document).height()&&t("#top-link-block").removeClass("hidden").affix({offset:{top:100}}),this.smoothScroll(),new Clipboard(".copy-to-clipboard").on("success",(function(e){toastr.success("Copied!"),e.clearSelection()}));var e=t("table.basic-datatable").DataTable({paging:!1,bFilter:!1,stateSave:!0,bInfo:!1,order:[],columnDefs:[{targets:"no-sort",orderable:!1}],select:{style:"os",selector:"td:first-child"}});t("table.adv-datatable").DataTable({order:[],columnDefs:[{targets:"no-sort",orderable:!1}]}),t(".for-pm-selection").length&&e.on("select",(function(a,o,n,l){var s=e.rows(t(".selected")).data().toArray().map((function(e){return e[4]}));s.length>=2&&(t("#selected-data").show(),t("#selected-data .status-text").text("With selected ("+s.length+")"),t("#pm-member-data").val(s))}));var o,n=function(){t("[census-data]").sparkline(t("[census-data]").data("counts"),{type:"line",lineColor:"#fff",lineWidth:3,fillColor:"#404652",height:50,width:"100%"}),t(".census-pie").each((function(){t(this).sparkline(t(this).data("counts"),{type:"pie",sliceColors:t(this).data("colors")})})),t("[census-data]").bind("sparklineClick",(function(e){var t=e.sparklines[0].getCurrentRegionFields();console.log("Clicked on x="+t.x+" y="+t.y)}))};t(window).resize((function(){clearTimeout(o),o=setTimeout(n,100)})),n(),t(".left-nav-toggle a").on("click",(function(e){e.preventDefault(),t("body").toggleClass("nav-toggle"),clearTimeout(o),o=setTimeout(n,100)})),t(".nav-second").on("show.bs.collapse",(function(){t(".nav-second.in").collapse("hide")})),t(".panel-toggle").on("click",(function(e){e.preventDefault();var a=t(e.target).closest("div.panel"),o=t(e.target).closest("i.toggle-icon"),n=t(e.target).find("i.toggle-icon"),l=a.find("div.panel-body"),s=a.find("div.panel-footer");l.slideToggle(300),s.slideToggle(200),o.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),n.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),a.toggleClass("").toggleClass("panel-collapse"),setTimeout((function(){a.resize(),a.find("[id^=map-]").resize()}),50)})),t(".panel-close").on("click",(function(e){e.preventDefault(),t(e.target).closest("div.panel").remove()})),t(".search-member").bootcomplete({url:window.Laravel.appPath+"/search-member/",minLength:3,idField:!0,method:"POST",dataParams:{_token:t("meta[name=csrf-token]").attr("content")}})}}).Setup()})();