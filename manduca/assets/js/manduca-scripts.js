/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2020 Zsolt Edelényi (ezs@web25.hu)

    Manduca is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in /assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/
jQuery.noConflict(),function(){var t=navigator.userAgent.toLowerCase().indexOf("webkit")>-1,e=navigator.userAgent.toLowerCase().indexOf("opera")>-1,a=navigator.userAgent.toLowerCase().indexOf("msie")>-1;(t||e||a)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus(),window.scrollBy(0,-53))},!1)}();var OFFSET_PX=0,MIN_WIDTH=12,MIN_HEIGHT=8,START_FRACTION=.4,MIDDLE_FRACTION=.8,focusSnail={enabled:!0,trigger:trigger};function trigger(t,e){svg?onEnd():initialize();var a=dimensionsOf(t),n=dimensionsOf(e),o=0,r=0,i=0,s=0,d=animationDuration(dist(a.left,a.top,n.left,n.top));var l=!0;animate(function(t){var e;l&&(e=scrollOffset(),svg.style.left=e.left+"px",svg.style.top=e.top+"px",svg.setAttribute("width",win.innerWidth),svg.setAttribute("height",win.innerHeight),svg.classList.add("focus-snail_visible"),o=n.left-e.left,r=a.left-e.left,i=n.top-e.top,s=a.top-e.top,setGradientAngle(gradient,r,s,a.width,a.height,o,i,n.width,n.height),enclose(getPointsList({top:s,right:r+a.width,bottom:s+a.height,left:r},{top:i,right:o+n.width,bottom:i+n.height,left:o}),polygon));var d=t>START_FRACTION?easeOutQuad((t-START_FRACTION)/(1-START_FRACTION)):0,u=t<MIDDLE_FRACTION?easeOutQuad(t/MIDDLE_FRACTION):1;start.setAttribute("offset",100*d+"%"),middle.setAttribute("offset",100*u+"%"),t>=1&&onEnd(),l=!1},d)}function animationDuration(t){return 50*Math.pow(constrain(t,32,1024),1/3)}function easeOutQuad(t){return 2*t-t*t}var win=window,doc=document,docElement=doc.documentElement,body=doc.body,prevFocused=null,animationId=0,keyDownTime=0;function setGradientAngle(t,e,a,n,o,r,i,s,d){var l=rectCentroid(e,a,n,o),u=rectCentroid(r,i,s,d),c=angleToLine(Math.atan2(l.y-u.y,l.x-u.x));t.setAttribute("x1",c.x1),t.setAttribute("y1",c.y1),t.setAttribute("x2",c.x2),t.setAttribute("y2",c.y2)}function rectCentroid(t,e,a,n){return{x:t+a/2,y:e+n/2}}function angleToLine(t){var e=Math.floor(t/Math.PI*2)+2,a=Math.PI/4+Math.PI/2*e,n=Math.sqrt(2),o=Math.cos(Math.abs(a-t))*n,r=o*Math.cos(t),i=o*Math.sin(t);return{x1:r<0?1:0,y1:i<0?1:0,x2:r>=0?r:r+1,y2:i>=0?i:i+1}}docElement.addEventListener("keydown",function(t){if(focusSnail.enabled){var e=t.which;(9===e||e>36&&e<41)&&(keyDownTime=Date.now())}},!1),docElement.addEventListener("blur",function(t){focusSnail.enabled&&(onEnd(),prevFocused=isJustPressed()?t.target:null)},!0),docElement.addEventListener("focus",function(t){prevFocused&&isJustPressed()&&trigger(prevFocused,t.target)},!0);var svg=null,polygon=null,start=null,middle=null,end=null,gradient=null;function htmlFragment(){var t=doc.createElement("div");return t.innerHTML='<svg id="focus-snail_svg" width="1000" height="800">\t\t<linearGradient id="focus-snail_gradient">\t\t\t<stop id="focus-snail_start" offset="0%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0"/>\t\t\t<stop id="focus-snail_middle" offset="80%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0.8"/>\t\t\t<stop id="focus-snail_end" offset="100%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0"/>\t\t</linearGradient>\t\t<polygon id="focus-snail_polygon" fill="url(#focus-snail_gradient)"/>\t</svg>',t}function initialize(){var t=htmlFragment();svg=getId(t,"svg"),polygon=getId(t,"polygon"),start=getId(t,"start"),middle=getId(t,"middle"),end=getId(t,"end"),gradient=getId(t,"gradient"),body.appendChild(svg)}function getId(t,e){return t.querySelector("#focus-snail_"+e)}function onEnd(){animationId&&(cancelAnimationFrame(animationId),animationId=0,svg.classList.remove("focus-snail_visible"))}function isJustPressed(){return Date.now()-keyDownTime<42}function animate(t,e){var a=Date.now();!function n(){animationId=requestAnimationFrame(function(){var o=Date.now()-a;t(o/e),o<e&&n()})}()}function getPointsList(t,e){var a=0;t.top<e.top&&(a=1),t.right>e.right&&(a+=2),t.bottom>e.bottom&&(a+=4),t.left<e.left&&(a+=8);for(var n=rectPoints(t).concat(rectPoints(e)),o=[],r=[[],[0,1],[1,2],[0,1,2],[2,3],[0,1],[1,2,3],[0,1,2,3],[3,0],[3,0,1],[3,0],[3,0,1,2],[2,3,0],[2,3,0,1],[1,2,3,0],[0,1,2,3,0]][a],i=0;i<r.length;i++)o.push(n[r[i]]);for(;i--;)o.push(n[r[i]+4]);return o}function enclose(t,e){e.points.clear();for(var a=0;a<t.length;a++){addPoint(e,t[a])}}function addPoint(t,e){var a=t.ownerSVGElement.createSVGPoint();a.x=e.x,a.y=e.y,t.points.appendItem(a)}function rectPoints(t){return[{x:t.left,y:t.top},{x:t.right,y:t.top},{x:t.right,y:t.bottom},{x:t.left,y:t.bottom}]}function dimensionsOf(t){var e=offsetOf(t);return{left:e.left-OFFSET_PX,top:e.top-OFFSET_PX,width:Math.max(MIN_WIDTH,t.offsetWidth)+2*OFFSET_PX,height:Math.max(MIN_HEIGHT,t.offsetHeight)+2*OFFSET_PX}}function offsetOf(t){var e=t.getBoundingClientRect(),a=scrollOffset(),n=docElement.clientTop||body.clientTop,o=docElement.clientLeft||body.clientLeft;return{top:e.top+a.top-n||0,left:e.left+a.left-o||0}}function scrollOffset(){return{top:win.pageYOffset||docElement.scrollTop||0,left:win.pageXOffset||docElement.scrollLeft||0}}function dist(t,e,a,n){var o=t-a,r=e-n;return Math.sqrt(o*o+r*r)}function constrain(t,e,a){return t<=e?e:t>=a?a:t}function createCookie(t,e,a){if(a){var n=new Date;n.setTime(n.getTime()+24*a*60*60*1e3);var o="; expires="+n.toGMTString()}else o="";document.cookie=t+"="+e+o+"; path=/; SameSite=Lax"}function readCookie(t){for(var e=t+"=",a=document.cookie.split(";"),n=0;n<a.length;n++){for(var o=a[n];" "==o.charAt(0);)o=o.substring(1,o.length);if(0==o.indexOf(e))return o.substring(e.length,o.length)}return null}function eraseCookie(t){createCookie(t,"",-1)}!function(t){var e,a,n,o,r,i;e=t(".megamenu-parent"),a=e.find(".menu-toggle"),n=e.find(".megamenu"),o=e.find(".megamenu > ul"),r=t(".toolbar-buttons"),i=t(".toolbar-buttons-open"),a.length&&(a.attr("aria-expanded","false"),a.on("click.manduca",function(){n.toggleClass("toggled-on"),a.toggleClass("toggled-on"),i.removeClass("toggled-on"),i.attr("aria-expanded","false"),r.removeClass("toggled-on"),r.css("display","none"),t(this).attr("aria-expanded",n.hasClass("toggled-on"))})),function(){var e,a;o.length&&o.children().length&&(e=t(".main-navigation"),a=t("<button />",{class:"dropdown-toggle","aria-expanded":!1}).append(manducaVariables.icon).append(t("<span />",{class:"screen-reader-text",text:manducaVariables.expand})),e.find(".menu-item-has-children > a, .page_item_has_children > a").after(a),e.find(".dropdown-toggle").click(function(e){var a=t(this),n=a.find(".screen-reader-text");e.preventDefault(),a.toggleClass("toggled-on"),a.next(".children, .sub-nav").toggleClass("toggled-on"),a.attr("aria-expanded","false"===a.attr("aria-expanded")?"true":"false"),n.text(n.text()===manducaVariables.expand?manducaVariables.collapse:manducaVariables.expand)}),"ontouchstart"in window&&(t(window).on("resize.manduca",n),n()),o.find("a").on("focus.manduca blur.manduca",function(){t(this).parents(".menu-item, .page_item").toggleClass("focus")}));function n(){"none"===t(".menu-toggle").css("display")?(t(document.body).on("touchstart.manduca",function(e){t(e.target).closest(".main-navigation li").length||t(".main-navigation li").removeClass("focus")}),o.find(".menu-item-has-children > a, .page_item_has_children > a").on("touchstart.manduca",function(e){var a=t(this).parent("li");a.hasClass("focus")||(e.preventDefault(),a.toggleClass("focus"),a.siblings(".focus").removeClass("focus"))})):o.find(".menu-item-has-children > a, .page_item_has_children > a").unbind("touchstart.manduca")}}(),t(".toolbar-buttons-open").click(function(){t(".toolbar-buttons").slideToggle(200),t(".menu-toggle").hasClass("toggled-on")&&(t(".megamenu").removeClass("toggled-on"),t(".menu-toggle").removeClass("toggled-on")),t(".toolbar-buttons").hasClass("toggled-on")?(t(".toolbar-buttons").removeClass("toggled-on"),t(".toolbar-buttons-open").removeClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","false"),t("#toolbar-buttons-open").focus()):(t(".toolbar-buttons").addClass("toggled-on"),t(".toolbar-buttons-open").addClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","true"))}),t("#buttons-close").click(function(){t("#toolbar-buttons").slideUp(),t(".toolbar-buttons-open").removeClass("toggled-on"),t(".toolbar-buttons").removeClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","false"),t("#toolbar-buttons-open").focus()}),t(document).on("keyup",function(e){"Escape"===e.key&&t(".toolbar-buttons").hasClass("toggled-on")&&(t(".toolbar-buttons").removeClass("toggled-on"),t(".toolbar-buttons-open").removeClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","false"),t(".toolbar-buttons").css("display","none"),t("#skip-to-content").focus())});var s=t("#toolbar-buttons button"),d=[];t.each(s,function(e,a){var n=t(a).attr("class");-1===t.inArray(n,d)&&d.push(n)}),t.each(d,function(e,a){var n=readCookie(a);if(n)t("body").addClass(n),t("#"+n).attr("disabled","true");else{var o=a+"-0";t("body").addClass(o),t("#"+o).attr("disabled","true")}t("."+a).click(function(){var e=t(this).attr("id");t("."+a).removeAttr("disabled"),t(this).attr("disabled","true");var n="";for($i=0;$i<5;$i++){var o=a+"-"+$i+" ";n=n.concat(o)}var r=new Date;t("body").removeClass(n),t("body").addClass(e),r.setFullYear(r.getFullYear()+10),document.cookie=a+"="+e+"; expires="+r.toGMTString()+"; path=/"})}),t(".target").on("click",function(){location.reload()}),t("#skip-to-content").click(function(t){t.preventDefault();var e=jQuery("#primary").position(),a=parseInt(e.top);return jQuery("html, body").animate({scrollTop:a},800),jQuery("#primary").find("h1").first().focus(),!1}),t("#skip-to-sidebar").click(function(t){t.preventDefault();var e=jQuery("#secondary").position(),a=parseInt(e.top);return jQuery("html, body").animate({scrollTop:a},800),jQuery("#secondary").find("h1").first().focus(),!1}),t("#skip-to-footer").click(function(t){t.preventDefault();var e=jQuery("#footer-wrapper").position(),a=parseInt(e.top);return jQuery("html, body").animate({scrollTop:a},800),jQuery("#footer-wrapper").find("h1").first().focus(),!1}),t("#manduca-back-to-top").click(function(t){return t.preventDefault(),jQuery("html, body").animate({scrollTop:0},800),jQuery("#menu-toggle").focus(),!1}),t(document).on("scroll",function(e){return e.preventDefault(),t(window).scrollTop()>100?t(".manduca-back-to-top-div").addClass("show"):t(".manduca-back-to-top-div").removeClass("show"),!1}),t("a.extlink").click(function(){var e=readCookie("linkTarget");"self"==e&&t(this).attr("target","_self"),"blank"==e&&t(this).attr("target","_blank")}),t("#manduca_archive-month-submit").click(function(){var e=t("#manduca-archive-year-dropdown").val(),a=t("#manduca-archive-month-dropdown").val(),n=window.location.protocol+"//"+window.location.host+"/"+e+"/"+a+"/";document.location.href=n}),t("#manduca-archive-year-dropdown").change(function(){var e=t("#manduca-archive-year-dropdown").val(),a=window.location.protocol+"//"+window.location.host+"/?manduca=ajax";jQuery.ajax({url:a,type:"post",data:{action:"archives",year:e,hash:manducaVariables.hash},success:function(e){t("#manduca-archive-month-dropdown option").remove(),t("#manduca-archive-month-dropdown").append(e).focus()}})})}(jQuery),jQuery(document).ready(function(t){var e=t(".js-expandmore"),a=t("#wrapper"),n=window.location.hash.replace("#","");e.length&&e.each(function(e){var a=t(this),o=e+1,r=a.data(),i=void 0!==r.hideshowPrefixClass?r.hideshowPrefixClass+"-":"",s=void 0!==r.notAllExpands,d=a.next(".js-to_expand"),l=a.html();a.html('<button type="button" class="'+i+'expandmore__button js-expandmore-button"'+(s?'data-not-all-expands="true"':"")+'><span class="'+i+'expandmore__symbol" aria-hidden="true"></span>'+l+"</button>");var u=a.children(".js-expandmore-button");d.addClass(i+"expandmore__to_expand").stop().delay(1500).queue(function(){var e=t(this);e.hasClass("js-first_load")&&e.removeClass("js-first_load")}),u.attr("id","label_expand_"+o),u.attr("data-controls","expand_"+o),u.attr("aria-expanded","false"),d.attr("id","expand_"+o),d.attr("data-hidden","true"),d.attr("data-labelledby","label_expand_"+o),s&&d.attr("data-not-all-expands","true"),(d.hasClass("is-opened")||""!==n&&d.find(t("#"+n)).length)&&(u.addClass("is-opened").attr("aria-expanded","true"),d.removeClass("is-opened").removeAttr("data-hidden"))}),a.on("click",".js-expandmore-button",function(e){var a=t(this),n=t("#"+a.attr("data-controls"));"false"===a.attr("aria-expanded")?(a.addClass("is-opened").attr("aria-expanded","true"),n.removeAttr("data-hidden")):(a.removeClass("is-opened").attr("aria-expanded","false"),n.attr("data-hidden","true")),e.preventDefault()}),a.on("keydown",".js-expandmore-button",function(e){var a=t(this),n=t("#"+a.attr("data-controls"));27===e.keyCode&&"true"===a.attr("aria-expanded")&&(a.removeClass("is-opened").attr("aria-expanded","false"),n.attr("data-hidden","true"),a.focus())}),a.on("click keydown",".js-expandmore",function(e){var a=t(this),n=t(e.target),o=a.find(".js-expandmore-button");if(!n.is(o)&&!n.closest(o).length){if("click"===e.type)return o.trigger("click"),!1;if("keydown"===e.type&&(13===e.keyCode||32===e.keyCode))return o.trigger("click"),!1}}),a.on("click keydown",".js-expandmore-all",function(e){var a=t(this),n=a.data(),o=a.attr("data-expand"),r=void 0!==n.textExpandAll?n.textExpandAll:manducaVariables.expand_all,i=void 0!==n.textCloseAll?n.textCloseAll:manducaVariables.collapse_all,s=t(".js-expandmore-button:not([data-not-all-expands])"),d=t(".js-to_expand:not([data-not-all-expands])");"click"!==e.type&&("keydown"!==e.type||13!==e.keyCode&&32!==e.keyCode)||("true"===o?(s.addClass("is-opened").attr("aria-expanded","true"),d.removeAttr("data-hidden"),a.attr("data-expand","false").html(i)):(s.removeClass("is-opened").attr("aria-expanded","false"),d.attr("data-hidden","true"),a.attr("data-expand","true").html(r)))})});