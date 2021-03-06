jQuery.noConflict();var OFFSET_PX=0,MIN_WIDTH=12,MIN_HEIGHT=8,START_FRACTION=.4,MIDDLE_FRACTION=.8,focusSnail={enabled:!0,trigger:trigger};function trigger(t,e){svg?onEnd():initialize();var a=dimensionsOf(t),n=dimensionsOf(e),o=0,i=0,s=0,r=0,l=animationDuration(dist(a.left,a.top,n.left,n.top));var d=!0;animate(function(t){var e;d&&(e=scrollOffset(),svg.style.left=e.left+"px",svg.style.top=e.top+"px",svg.setAttribute("width",win.innerWidth),svg.setAttribute("height",win.innerHeight),svg.classList.add("focus-snail_visible"),o=n.left-e.left,i=a.left-e.left,s=n.top-e.top,r=a.top-e.top,setGradientAngle(gradient,i,r,a.width,a.height,o,s,n.width,n.height),enclose(getPointsList({top:r,right:i+a.width,bottom:r+a.height,left:i},{top:s,right:o+n.width,bottom:s+n.height,left:o}),polygon));var l=t>START_FRACTION?easeOutQuad((t-START_FRACTION)/(1-START_FRACTION)):0,c=t<MIDDLE_FRACTION?easeOutQuad(t/MIDDLE_FRACTION):1;start.setAttribute("offset",100*l+"%"),middle.setAttribute("offset",100*c+"%"),t>=1&&onEnd(),d=!1},l)}function animationDuration(t){return 50*Math.pow(constrain(t,32,1024),1/3)}function easeOutQuad(t){return 2*t-t*t}var win=window,doc=document,docElement=doc.documentElement,body=doc.body,prevFocused=null,animationId=0,keyDownTime=0;function setGradientAngle(t,e,a,n,o,i,s,r,l){var d=rectCentroid(e,a,n,o),c=rectCentroid(i,s,r,l),u=angleToLine(Math.atan2(d.y-c.y,d.x-c.x));t.setAttribute("x1",u.x1),t.setAttribute("y1",u.y1),t.setAttribute("x2",u.x2),t.setAttribute("y2",u.y2)}function rectCentroid(t,e,a,n){return{x:t+a/2,y:e+n/2}}function angleToLine(t){var e=Math.floor(t/Math.PI*2)+2,a=Math.PI/4+Math.PI/2*e,n=Math.sqrt(2),o=Math.cos(Math.abs(a-t))*n,i=o*Math.cos(t),s=o*Math.sin(t);return{x1:i<0?1:0,y1:s<0?1:0,x2:i>=0?i:i+1,y2:s>=0?s:s+1}}docElement.addEventListener("keydown",function(t){if(focusSnail.enabled){var e=t.which;(9===e||e>36&&e<41)&&(keyDownTime=Date.now())}},!1),docElement.addEventListener("blur",function(t){focusSnail.enabled&&(onEnd(),prevFocused=isJustPressed()?t.target:null)},!0),docElement.addEventListener("focus",function(t){prevFocused&&isJustPressed()&&trigger(prevFocused,t.target)},!0);var svg=null,polygon=null,start=null,middle=null,end=null,gradient=null;function htmlFragment(){var t=doc.createElement("div");return t.innerHTML='<svg id="focus-snail_svg" width="1000" height="800">\t\t<linearGradient id="focus-snail_gradient">\t\t\t<stop id="focus-snail_start" offset="0%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0"/>\t\t\t<stop id="focus-snail_middle" offset="80%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0.8"/>\t\t\t<stop id="focus-snail_end" offset="100%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0"/>\t\t</linearGradient>\t\t<polygon id="focus-snail_polygon" fill="url(#focus-snail_gradient)"/>\t</svg>',t}function initialize(){var t=htmlFragment();svg=getId(t,"svg"),polygon=getId(t,"polygon"),start=getId(t,"start"),middle=getId(t,"middle"),end=getId(t,"end"),gradient=getId(t,"gradient"),body.appendChild(svg)}function getId(t,e){return t.querySelector("#focus-snail_"+e)}function onEnd(){animationId&&(cancelAnimationFrame(animationId),animationId=0,svg.classList.remove("focus-snail_visible"))}function isJustPressed(){return Date.now()-keyDownTime<42}function animate(t,e){var a=Date.now();!function n(){animationId=requestAnimationFrame(function(){var o=Date.now()-a;t(o/e),o<e&&n()})}()}function getPointsList(t,e){var a=0;t.top<e.top&&(a=1),t.right>e.right&&(a+=2),t.bottom>e.bottom&&(a+=4),t.left<e.left&&(a+=8);for(var n=rectPoints(t).concat(rectPoints(e)),o=[],i=[[],[0,1],[1,2],[0,1,2],[2,3],[0,1],[1,2,3],[0,1,2,3],[3,0],[3,0,1],[3,0],[3,0,1,2],[2,3,0],[2,3,0,1],[1,2,3,0],[0,1,2,3,0]][a],s=0;s<i.length;s++)o.push(n[i[s]]);for(;s--;)o.push(n[i[s]+4]);return o}function enclose(t,e){e.points.clear();for(var a=0;a<t.length;a++){addPoint(e,t[a])}}function addPoint(t,e){var a=t.ownerSVGElement.createSVGPoint();a.x=e.x,a.y=e.y,t.points.appendItem(a)}function rectPoints(t){return[{x:t.left,y:t.top},{x:t.right,y:t.top},{x:t.right,y:t.bottom},{x:t.left,y:t.bottom}]}function dimensionsOf(t){var e=offsetOf(t);return{left:e.left-OFFSET_PX,top:e.top-OFFSET_PX,width:Math.max(MIN_WIDTH,t.offsetWidth)+2*OFFSET_PX,height:Math.max(MIN_HEIGHT,t.offsetHeight)+2*OFFSET_PX}}function offsetOf(t){var e=t.getBoundingClientRect(),a=scrollOffset(),n=docElement.clientTop||body.clientTop,o=docElement.clientLeft||body.clientLeft;return{top:e.top+a.top-n||0,left:e.left+a.left-o||0}}function scrollOffset(){return{top:win.pageYOffset||docElement.scrollTop||0,left:win.pageXOffset||docElement.scrollLeft||0}}function dist(t,e,a,n){var o=t-a,i=e-n;return Math.sqrt(o*o+i*i)}function constrain(t,e,a){return t<=e?e:t>=a?a:t}function Dialog(t,e){this.dialogEl=t,this.overlayEl=e,this.focusedElBeforeOpen;var a=this.dialogEl.querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]');this.focusableEls=Array.prototype.slice.call(a),this.firstFocusableEl=this.focusableEls[0],this.lastFocusableEl=this.focusableEls[this.focusableEls.length-1],this.close()}function createCookie(t,e,a){if(a){var n=new Date;n.setTime(n.getTime()+24*a*60*60*1e3);var o="; expires="+n.toGMTString()}else o="";document.cookie=t+"="+e+o+"; path=/; SameSite=Lax"}function readCookie(t){for(var e=t+"=",a=document.cookie.split(";"),n=0;n<a.length;n++){for(var o=a[n];" "==o.charAt(0);)o=o.substring(1,o.length);if(0==o.indexOf(e))return o.substring(e.length,o.length)}return null}function eraseCookie(t){createCookie(t,"",-1)}Dialog.prototype.open=function(){var t=this;this.dialogEl.removeAttribute("aria-hidden"),this.overlayEl.removeAttribute("aria-hidden"),this.focusedElBeforeOpen=document.activeElement,this.dialogEl.addEventListener("keydown",function(e){t._handleKeyDown(e)}),this.overlayEl.addEventListener("click",function(){t.close()}),this.firstFocusableEl.focus()},Dialog.prototype.close=function(){this.dialogEl.setAttribute("aria-hidden",!0),this.overlayEl.setAttribute("aria-hidden",!0),this.focusedElBeforeOpen&&this.focusedElBeforeOpen.focus()},Dialog.prototype._handleKeyDown=function(t){var e=this;switch(t.keyCode){case 9:if(1===e.focusableEls.length){t.preventDefault();break}t.shiftKey?document.activeElement===e.firstFocusableEl&&(t.preventDefault(),e.lastFocusableEl.focus()):document.activeElement===e.lastFocusableEl&&(t.preventDefault(),e.firstFocusableEl.focus());break;case 27:e.close()}},Dialog.prototype.addEventListeners=function(t,e){for(var a=this,n=document.querySelectorAll(t),o=0;o<n.length;o++)n[o].addEventListener("click",function(){a.open()});var i=document.querySelectorAll(e);for(o=0;o<i.length;o++)i[o].addEventListener("click",function(){a.close()})},jQuery(document).ready(function(t){t(document).on("keyup",function(e){"Escape"===e.key&&t(".toolbar-buttons").hasClass("toggled-on")&&(t(".toolbar-buttons").removeClass("toggled-on"),t(".toolbar-buttons-open").removeClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","false"),t(".toolbar-buttons").css("display","none"),t("#skip-to-content").focus())});var e=t("#toolbar-buttons-table button"),a=[];t.each(e,function(e,n){var o=t(n).attr("class");-1===t.inArray(o,a)&&a.push(o)}),t.each(a,function(e,a){var n=readCookie(a);if(n)t("html").addClass(n),t("#"+n).attr("disabled","true");else{var o=a+"-0";t("html").addClass(o),t("#"+o).attr("disabled","true")}t("."+a).click(function(){var e=t(this).attr("id");t("."+a).removeAttr("disabled"),t(this).attr("disabled","true");var n="";for($i=0;$i<5;$i++){var o=a+"-"+$i+" ";n=n.concat(o)}var i=new Date;t("html").removeClass(n),t("html").addClass(e),i.setFullYear(i.getFullYear()+10),document.cookie=a+"="+e+"; expires="+i.toGMTString()+"; path=/"})});var n,o,i,s,r,l,d=t("html").hasClass("animation-0");t(".target").on("click",function(){location.reload()}),n=t(".megamenu-parent"),o=n.find(".menu-toggle"),i=n.find(".megamenu"),s=n.find(".megamenu > ul"),r=t(".toolbar-buttons"),l=t(".toolbar-buttons-open"),o.length&&(o.attr("aria-expanded","false"),o.on("click.manduca",function(){d?i.slideToggle(300):i.slideToggle(),i.toggleClass("toggled-on"),o.toggleClass("toggled-on"),l.removeClass("toggled-on"),l.attr("aria-expanded","false"),r.removeClass("toggled-on"),r.css("display","none"),t(this).attr("aria-expanded",i.hasClass("toggled-on"))})),function(){var e,a;s.length&&s.children().length&&(e=t(".main-navigation"),a=t("<button />",{class:"dropdown-toggle","aria-expanded":!1}).append(manducaVariables.icon).append(t("<span />",{class:"screen-reader-text",text:manducaVariables.expand})),e.find(".menu-item-has-children > a, .page_item_has_children > a").after(a),e.find(".dropdown-toggle").click(function(e){var a=t(this),n=a.find(".screen-reader-text");e.preventDefault(),a.toggleClass("toggled-on"),a.next(".children, .sub-nav").toggleClass("toggled-on"),a.attr("aria-expanded","false"===a.attr("aria-expanded")?"true":"false"),n.text(n.text()===manducaVariables.expand?manducaVariables.collapse:manducaVariables.expand)}),"ontouchstart"in window&&(t(window).on("resize.manduca",n),n()),s.find("a").on("focus.manduca blur.manduca",function(){t(this).parents(".menu-item, .page_item").toggleClass("focus")}));function n(){"none"===t(".menu-toggle").css("display")?(t(document.body).on("touchstart.manduca",function(e){t(e.target).closest(".main-navigation li").length||t(".main-navigation li").removeClass("focus")}),s.find(".menu-item-has-children > a, .page_item_has_children > a").on("touchstart.manduca",function(e){var a=t(this).parent("li");a.hasClass("focus")||(e.preventDefault(),a.toggleClass("focus"),a.siblings(".focus").removeClass("focus"))})):s.find(".menu-item-has-children > a, .page_item_has_children > a").unbind("touchstart.manduca")}}(),t("#manduca-back-to-top").click(function(t){return t.preventDefault(),jQuery("html, body").animate({scrollTop:0},800),jQuery("#menu-toggle").focus(),!1}),t(document).on("scroll",function(e){return e.preventDefault(),t(window).scrollTop()>100?t(".manduca-back-to-top-div").addClass("show"):t(".manduca-back-to-top-div").removeClass("show"),!1}),t("a").click(function(){var e=t("html").hasClass("link-target-2");t("html").hasClass("link-target-1")&&t(this).attr("target","_self"),e&&t(this).attr("target","_blank")}),t("#manduca_archive-month-submit").click(function(){var e=t("#manduca-archive-year-dropdown").val(),a=t("#manduca-archive-month-dropdown").val(),n=window.location.protocol+"//"+window.location.host+"/"+e+"/"+a+"/";document.location.href=n}),t("#manduca-archive-year-dropdown").change(function(){var e=t("#manduca-archive-year-dropdown").val(),a=window.location.protocol+"//"+window.location.host+"/?manduca=ajax";jQuery.ajax({url:a,type:"post",data:{action:"archives",year:e,hash:manducaVariables.hash},success:function(e){t("#manduca-archive-month-dropdown option").remove(),t("#manduca-archive-month-dropdown").append(e).focus()}})});var c=t(".js-expandmore"),u=t("#wrapper"),p=window.location.hash.replace("#","");c.length&&c.each(function(e){var a=t(this),n=e+1,o=a.data(),i=void 0!==o.hideshowPrefixClass?o.hideshowPrefixClass+"-":"",s=void 0!==o.notAllExpands,r=a.next(".js-to_expand"),l=a.html();a.html('<button type="button" class="'+i+'expandmore__button js-expandmore-button"'+(s?'data-not-all-expands="true"':"")+'><span class="'+i+'expandmore__symbol" aria-hidden="true"></span>'+l+"</button>");var d=a.children(".js-expandmore-button");r.addClass(i+"expandmore__to_expand").stop().delay(1500).queue(function(){var e=t(this);e.hasClass("js-first_load")&&e.removeClass("js-first_load")}),d.attr("id","label_expand_"+n),d.attr("data-controls","expand_"+n),d.attr("aria-expanded","false"),r.attr("id","expand_"+n),r.attr("data-hidden","true"),r.attr("data-labelledby","label_expand_"+n),s&&r.attr("data-not-all-expands","true"),(r.hasClass("is-opened")||""!==p&&r.find(t("#"+p)).length)&&(d.addClass("is-opened").attr("aria-expanded","true"),r.removeClass("is-opened").removeAttr("data-hidden"))}),u.on("click",".js-expandmore-button",function(e){var a=t(this),n=t("#"+a.attr("data-controls"));"false"===a.attr("aria-expanded")?(a.addClass("is-opened").attr("aria-expanded","true"),n.removeAttr("data-hidden")):(a.removeClass("is-opened").attr("aria-expanded","false"),n.attr("data-hidden","true")),e.preventDefault()}),u.on("keydown",".js-expandmore-button",function(e){var a=t(this),n=t("#"+a.attr("data-controls"));27===e.keyCode&&"true"===a.attr("aria-expanded")&&(a.removeClass("is-opened").attr("aria-expanded","false"),n.attr("data-hidden","true"),a.focus())}),u.on("click keydown",".js-expandmore",function(e){var a=t(this),n=t(e.target),o=a.find(".js-expandmore-button");if(!n.is(o)&&!n.closest(o).length){if("click"===e.type)return o.trigger("click"),!1;if("keydown"===e.type&&(13===e.keyCode||32===e.keyCode))return o.trigger("click"),!1}}),u.on("click keydown",".js-expandmore-all",function(e){var a=t(this),n=a.data(),o=a.attr("data-expand"),i=void 0!==n.textExpandAll?n.textExpandAll:manducaVariables.expand_all,s=void 0!==n.textCloseAll?n.textCloseAll:manducaVariables.collapse_all,r=t(".js-expandmore-button:not([data-not-all-expands])"),l=t(".js-to_expand:not([data-not-all-expands])");"click"!==e.type&&("keydown"!==e.type||13!==e.keyCode&&32!==e.keyCode)||("true"===o?(r.addClass("is-opened").attr("aria-expanded","true"),l.removeAttr("data-hidden"),a.attr("data-expand","false").html(s)):(r.removeClass("is-opened").attr("aria-expanded","false"),l.attr("data-hidden","true"),a.attr("data-expand","true").html(i)))}),new Dialog(document.querySelector(".toolbar-buttons"),document.querySelector(".dialog-overlay")).addEventListeners(".toolbar-buttons-open",".toolbar-buttons-close")}),function(){"use strict";function t(t){var e=jQuery(this),a=(t=t||e.data()).simpletooltipText||"",n=void 0!==t.simpletooltipPrefixClass?t.simpletooltipPrefixClass+"-":"",o=void 0!==t.simpletooltipContentId?"#"+t.simpletooltipContentId:"",i=Math.random().toString(32).slice(2,12),s=e.attr("aria-describedby")||"";e.attr({"aria-describedby":("label_simpletooltip_"+i+" "+s).trim()}),e.wrap('<span class="'+n+'simpletooltip_container"></span>');var r='<span class="js-simpletooltip '+n+'simpletooltip" id="label_simpletooltip_'+i+'" role="tooltip" aria-hidden="true">';if(""!==a)r+=""+a;else{var l=jQuery(o);""!==o&&l.length&&(r+=l.html())}r+="</span>",jQuery(r).insertAfter(e)}jQuery(document).ready(function(e){e.fn.accessibleSimpleTooltipAria=t,e(".js-simple-tooltip").each(function(){t.apply(this)}),e("body").on("mouseenter focusin",".js-simple-tooltip",function(){var t=e(this).attr("aria-describedby").trimEnd(" "),a=e("#"+t);a.attr("aria-hidden","false"),a.addClass("tooltip-show")}).on("mouseleave",".js-simple-tooltip",function(t){var a=e(this).attr("aria-describedby").trimEnd(" "),n=e("#"+a);n.is(":hover")||(n.attr("aria-hidden","true"),n.removeClass("tooltip-show"))}).on("focusout",".js-simple-tooltip",function(t){var a=e(this).attr("aria-describedby").trimEnd(" "),n=e("#"+a);n.attr("aria-hidden","true"),n.removeClass("tooltip-show")}).on("mouseleave",".js-simple-tooltip",function(){var t=e(this);t.attr("aria-hidden","true");var a=t.attr("aria-describedby").trimEnd(" ");e("#"+a).removeClass("tooltip-show")}).on("keydown",".js-simple-tooltip",function(t){var a=e(this).attr("aria-describedby").trimEnd(" "),n=e("#"+a);27==t.keyCode&&(n.attr("aria-hidden","true"),n.removeClass("tooltip-show"))})})}();