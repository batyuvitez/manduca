jQuery.noConflict();var OFFSET_PX=0,MIN_WIDTH=12,MIN_HEIGHT=8,START_FRACTION=.4,MIDDLE_FRACTION=.8,focusSnail={enabled:!0,trigger:trigger};function trigger(t,e){svg?onEnd():initialize();var a=dimensionsOf(t),o=dimensionsOf(e),n=0,i=0,r=0,s=0,l=animationDuration(dist(a.left,a.top,o.left,o.top));var d=!0;animate(function(t){var e;d&&(e=scrollOffset(),svg.style.left=e.left+"px",svg.style.top=e.top+"px",svg.setAttribute("width",win.innerWidth),svg.setAttribute("height",win.innerHeight),svg.classList.add("focus-snail_visible"),n=o.left-e.left,i=a.left-e.left,r=o.top-e.top,s=a.top-e.top,setGradientAngle(gradient,i,s,a.width,a.height,n,r,o.width,o.height),enclose(getPointsList({top:s,right:i+a.width,bottom:s+a.height,left:i},{top:r,right:n+o.width,bottom:r+o.height,left:n}),polygon));var l=t>START_FRACTION?easeOutQuad((t-START_FRACTION)/(1-START_FRACTION)):0,u=t<MIDDLE_FRACTION?easeOutQuad(t/MIDDLE_FRACTION):1;start.setAttribute("offset",100*l+"%"),middle.setAttribute("offset",100*u+"%"),t>=1&&onEnd(),d=!1},l)}function animationDuration(t){return 50*Math.pow(constrain(t,32,1024),1/3)}function easeOutQuad(t){return 2*t-t*t}var win=window,doc=document,docElement=doc.documentElement,body=doc.body,prevFocused=null,animationId=0,keyDownTime=0;function setGradientAngle(t,e,a,o,n,i,r,s,l){var d=rectCentroid(e,a,o,n),u=rectCentroid(i,r,s,l),c=angleToLine(Math.atan2(d.y-u.y,d.x-u.x));t.setAttribute("x1",c.x1),t.setAttribute("y1",c.y1),t.setAttribute("x2",c.x2),t.setAttribute("y2",c.y2)}function rectCentroid(t,e,a,o){return{x:t+a/2,y:e+o/2}}function angleToLine(t){var e=Math.floor(t/Math.PI*2)+2,a=Math.PI/4+Math.PI/2*e,o=Math.sqrt(2),n=Math.cos(Math.abs(a-t))*o,i=n*Math.cos(t),r=n*Math.sin(t);return{x1:i<0?1:0,y1:r<0?1:0,x2:i>=0?i:i+1,y2:r>=0?r:r+1}}docElement.addEventListener("keydown",function(t){if(focusSnail.enabled){var e=t.which;(9===e||e>36&&e<41)&&(keyDownTime=Date.now())}},!1),docElement.addEventListener("blur",function(t){focusSnail.enabled&&(onEnd(),prevFocused=isJustPressed()?t.target:null)},!0),docElement.addEventListener("focus",function(t){prevFocused&&isJustPressed()&&trigger(prevFocused,t.target)},!0);var svg=null,polygon=null,start=null,middle=null,end=null,gradient=null;function htmlFragment(){var t=doc.createElement("div");return t.innerHTML='<svg id="focus-snail_svg" width="1000" height="800">\t\t<linearGradient id="focus-snail_gradient">\t\t\t<stop id="focus-snail_start" offset="0%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0"/>\t\t\t<stop id="focus-snail_middle" offset="80%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0.8"/>\t\t\t<stop id="focus-snail_end" offset="100%" stop-color="rgb('+manducaVariables.red+", "+manducaVariables.green+", "+manducaVariables.blue+')" stop-opacity="0"/>\t\t</linearGradient>\t\t<polygon id="focus-snail_polygon" fill="url(#focus-snail_gradient)"/>\t</svg>',t}function initialize(){var t=htmlFragment();svg=getId(t,"svg"),polygon=getId(t,"polygon"),start=getId(t,"start"),middle=getId(t,"middle"),end=getId(t,"end"),gradient=getId(t,"gradient"),body.appendChild(svg)}function getId(t,e){return t.querySelector("#focus-snail_"+e)}function onEnd(){animationId&&(cancelAnimationFrame(animationId),animationId=0,svg.classList.remove("focus-snail_visible"))}function isJustPressed(){return Date.now()-keyDownTime<42}function animate(t,e){var a=Date.now();!function o(){animationId=requestAnimationFrame(function(){var n=Date.now()-a;t(n/e),n<e&&o()})}()}function getPointsList(t,e){var a=0;t.top<e.top&&(a=1),t.right>e.right&&(a+=2),t.bottom>e.bottom&&(a+=4),t.left<e.left&&(a+=8);for(var o=rectPoints(t).concat(rectPoints(e)),n=[],i=[[],[0,1],[1,2],[0,1,2],[2,3],[0,1],[1,2,3],[0,1,2,3],[3,0],[3,0,1],[3,0],[3,0,1,2],[2,3,0],[2,3,0,1],[1,2,3,0],[0,1,2,3,0]][a],r=0;r<i.length;r++)n.push(o[i[r]]);for(;r--;)n.push(o[i[r]+4]);return n}function enclose(t,e){e.points.clear();for(var a=0;a<t.length;a++){addPoint(e,t[a])}}function addPoint(t,e){var a=t.ownerSVGElement.createSVGPoint();a.x=e.x,a.y=e.y,t.points.appendItem(a)}function rectPoints(t){return[{x:t.left,y:t.top},{x:t.right,y:t.top},{x:t.right,y:t.bottom},{x:t.left,y:t.bottom}]}function dimensionsOf(t){var e=offsetOf(t);return{left:e.left-OFFSET_PX,top:e.top-OFFSET_PX,width:Math.max(MIN_WIDTH,t.offsetWidth)+2*OFFSET_PX,height:Math.max(MIN_HEIGHT,t.offsetHeight)+2*OFFSET_PX}}function offsetOf(t){var e=t.getBoundingClientRect(),a=scrollOffset(),o=docElement.clientTop||body.clientTop,n=docElement.clientLeft||body.clientLeft;return{top:e.top+a.top-o||0,left:e.left+a.left-n||0}}function scrollOffset(){return{top:win.pageYOffset||docElement.scrollTop||0,left:win.pageXOffset||docElement.scrollLeft||0}}function dist(t,e,a,o){var n=t-a,i=e-o;return Math.sqrt(n*n+i*i)}function constrain(t,e,a){return t<=e?e:t>=a?a:t}function createCookie(t,e,a){if(a){var o=new Date;o.setTime(o.getTime()+24*a*60*60*1e3);var n="; expires="+o.toGMTString()}else n="";document.cookie=t+"="+e+n+"; path=/; SameSite=Lax"}function readCookie(t){for(var e=t+"=",a=document.cookie.split(";"),o=0;o<a.length;o++){for(var n=a[o];" "==n.charAt(0);)n=n.substring(1,n.length);if(0==n.indexOf(e))return n.substring(e.length,n.length)}return null}function eraseCookie(t){createCookie(t,"",-1)}!function(t){var e,a,o,n,i,r;e=t(".megamenu-parent"),a=e.find(".menu-toggle"),o=e.find(".megamenu"),n=e.find(".megamenu > ul"),i=t(".toolbar-buttons"),r=t(".toolbar-buttons-open"),a.length&&(a.attr("aria-expanded","false"),a.on("click.manduca",function(){o.toggleClass("toggled-on"),a.toggleClass("toggled-on"),r.removeClass("toggled-on"),r.attr("aria-expanded","false"),i.removeClass("toggled-on"),i.css("display","none"),t(this).attr("aria-expanded",o.hasClass("toggled-on"))})),function(){var e,a;n.length&&n.children().length&&(e=t(".main-navigation"),a=t("<button />",{class:"dropdown-toggle","aria-expanded":!1}).append(manducaVariables.icon).append(t("<span />",{class:"screen-reader-text",text:manducaVariables.expand})),e.find(".menu-item-has-children > a, .page_item_has_children > a").after(a),e.find(".dropdown-toggle").click(function(e){var a=t(this),o=a.find(".screen-reader-text");e.preventDefault(),a.toggleClass("toggled-on"),a.next(".children, .sub-nav").toggleClass("toggled-on"),a.attr("aria-expanded","false"===a.attr("aria-expanded")?"true":"false"),o.text(o.text()===manducaVariables.expand?manducaVariables.collapse:manducaVariables.expand)}),"ontouchstart"in window&&(t(window).on("resize.manduca",o),o()),n.find("a").on("focus.manduca blur.manduca",function(){t(this).parents(".menu-item, .page_item").toggleClass("focus")}));function o(){"none"===t(".menu-toggle").css("display")?(t(document.body).on("touchstart.manduca",function(e){t(e.target).closest(".main-navigation li").length||t(".main-navigation li").removeClass("focus")}),n.find(".menu-item-has-children > a, .page_item_has_children > a").on("touchstart.manduca",function(e){var a=t(this).parent("li");a.hasClass("focus")||(e.preventDefault(),a.toggleClass("focus"),a.siblings(".focus").removeClass("focus"))})):n.find(".menu-item-has-children > a, .page_item_has_children > a").unbind("touchstart.manduca")}}(),t("#skip-to-content").click(function(t){t.preventDefault();var e=jQuery("#primary").position(),a=parseInt(e.top);return jQuery("html, body").animate({scrollTop:a},800),jQuery("#primary").find("h1").first().focus(),!1}),t("#skip-to-sidebar").click(function(t){t.preventDefault();var e=jQuery("#secondary").position(),a=parseInt(e.top);return jQuery("html, body").animate({scrollTop:a},800),jQuery("#secondary").find("h1").first().focus(),!1}),t("#skip-to-footer").click(function(t){t.preventDefault();var e=jQuery("#footer-wrapper").position(),a=parseInt(e.top);return jQuery("html, body").animate({scrollTop:a},800),jQuery("#footer-wrapper").find("h1").first().focus(),!1}),t("#manduca-back-to-top").click(function(t){return t.preventDefault(),jQuery("html, body").animate({scrollTop:0},800),jQuery("#menu-toggle").focus(),!1}),t(document).on("scroll",function(e){return e.preventDefault(),t(window).scrollTop()>100?t(".manduca-back-to-top-div").addClass("show"):t(".manduca-back-to-top-div").removeClass("show"),!1}),t("a").click(function(){var e=t("html").hasClass("link-target-2");t("html").hasClass("link-target-1")&&t(this).attr("target","_self"),e&&t(this).attr("target","_blank")}),t("#manduca_archive-month-submit").click(function(){var e=t("#manduca-archive-year-dropdown").val(),a=t("#manduca-archive-month-dropdown").val(),o=window.location.protocol+"//"+window.location.host+"/"+e+"/"+a+"/";document.location.href=o}),t("#manduca-archive-year-dropdown").change(function(){var e=t("#manduca-archive-year-dropdown").val(),a=window.location.protocol+"//"+window.location.host+"/?manduca=ajax";jQuery.ajax({url:a,type:"post",data:{action:"archives",year:e,hash:manducaVariables.hash},success:function(e){t("#manduca-archive-month-dropdown option").remove(),t("#manduca-archive-month-dropdown").append(e).focus()}})})}(jQuery),jQuery(document).ready(function(t){t(document).on("keyup",function(e){"Escape"===e.key&&t(".toolbar-buttons").hasClass("toggled-on")&&(t(".toolbar-buttons").removeClass("toggled-on"),t(".toolbar-buttons-open").removeClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","false"),t(".toolbar-buttons").css("display","none"),t("#skip-to-content").focus())});var e=t("#toolbar-buttons-table button"),a=[];t.each(e,function(e,o){var n=t(o).attr("class");-1===t.inArray(n,a)&&a.push(n)}),t.each(a,function(e,a){var o=readCookie(a);if(o)t("html").addClass(o),t("#"+o).attr("disabled","true");else{var n=a+"-0";t("html").addClass(n),t("#"+n).attr("disabled","true")}t("."+a).click(function(){var e=t(this).attr("id");t("."+a).removeAttr("disabled"),t(this).attr("disabled","true");var o="";for($i=0;$i<5;$i++){var n=a+"-"+$i+" ";o=o.concat(n)}var i=new Date;t("html").removeClass(o),t("html").addClass(e),i.setFullYear(i.getFullYear()+10),document.cookie=a+"="+e+"; expires="+i.toGMTString()+"; path=/"})}),t(".target").on("click",function(){location.reload()}),t(".toolbar-buttons-open").click(function(){t("html").hasClass("animation-0")?t(".toolbar-buttons").slideToggle(300):t(".toolbar-buttons").slideToggle(0),t(".menu-toggle").hasClass("toggled-on")&&(t(".megamenu").removeClass("toggled-on"),t(".menu-toggle").removeClass("toggled-on")),t(".toolbar-buttons").hasClass("toggled-on")?(t(".toolbar-buttons").removeClass("toggled-on"),t(".toolbar-buttons-open").removeClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","false"),t("#toolbar-buttons-open").focus()):(t(".toolbar-buttons").addClass("toggled-on"),t(".toolbar-buttons-open").addClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","true"))}),t("#buttons-close").click(function(){t("#toolbar-buttons").slideUp(),t(".toolbar-buttons-open").removeClass("toggled-on"),t(".toolbar-buttons").removeClass("toggled-on"),t(".toolbar-buttons-open").attr("aria-expanded","false"),t("#toolbar-buttons-open").focus()});var o=t(".js-expandmore"),n=t("#wrapper"),i=window.location.hash.replace("#","");o.length&&o.each(function(e){var a=t(this),o=e+1,n=a.data(),r=void 0!==n.hideshowPrefixClass?n.hideshowPrefixClass+"-":"",s=void 0!==n.notAllExpands,l=a.next(".js-to_expand"),d=a.html();a.html('<button type="button" class="'+r+'expandmore__button js-expandmore-button"'+(s?'data-not-all-expands="true"':"")+'><span class="'+r+'expandmore__symbol" aria-hidden="true"></span>'+d+"</button>");var u=a.children(".js-expandmore-button");l.addClass(r+"expandmore__to_expand").stop().delay(1500).queue(function(){var e=t(this);e.hasClass("js-first_load")&&e.removeClass("js-first_load")}),u.attr("id","label_expand_"+o),u.attr("data-controls","expand_"+o),u.attr("aria-expanded","false"),l.attr("id","expand_"+o),l.attr("data-hidden","true"),l.attr("data-labelledby","label_expand_"+o),s&&l.attr("data-not-all-expands","true"),(l.hasClass("is-opened")||""!==i&&l.find(t("#"+i)).length)&&(u.addClass("is-opened").attr("aria-expanded","true"),l.removeClass("is-opened").removeAttr("data-hidden"))}),n.on("click",".js-expandmore-button",function(e){var a=t(this),o=t("#"+a.attr("data-controls"));"false"===a.attr("aria-expanded")?(a.addClass("is-opened").attr("aria-expanded","true"),o.removeAttr("data-hidden")):(a.removeClass("is-opened").attr("aria-expanded","false"),o.attr("data-hidden","true")),e.preventDefault()}),n.on("keydown",".js-expandmore-button",function(e){var a=t(this),o=t("#"+a.attr("data-controls"));27===e.keyCode&&"true"===a.attr("aria-expanded")&&(a.removeClass("is-opened").attr("aria-expanded","false"),o.attr("data-hidden","true"),a.focus())}),n.on("click keydown",".js-expandmore",function(e){var a=t(this),o=t(e.target),n=a.find(".js-expandmore-button");if(!o.is(n)&&!o.closest(n).length){if("click"===e.type)return n.trigger("click"),!1;if("keydown"===e.type&&(13===e.keyCode||32===e.keyCode))return n.trigger("click"),!1}}),n.on("click keydown",".js-expandmore-all",function(e){var a=t(this),o=a.data(),n=a.attr("data-expand"),i=void 0!==o.textExpandAll?o.textExpandAll:manducaVariables.expand_all,r=void 0!==o.textCloseAll?o.textCloseAll:manducaVariables.collapse_all,s=t(".js-expandmore-button:not([data-not-all-expands])"),l=t(".js-to_expand:not([data-not-all-expands])");"click"!==e.type&&("keydown"!==e.type||13!==e.keyCode&&32!==e.keyCode)||("true"===n?(s.addClass("is-opened").attr("aria-expanded","true"),l.removeAttr("data-hidden"),a.attr("data-expand","false").html(r)):(s.removeClass("is-opened").attr("aria-expanded","false"),l.attr("data-hidden","true"),a.attr("data-expand","true").html(i)))})}),function(){"use strict";function t(t){var e=jQuery(this),a=(t=t||e.data()).simpletooltipText||"",o=void 0!==t.simpletooltipPrefixClass?t.simpletooltipPrefixClass+"-":"",n=void 0!==t.simpletooltipContentId?"#"+t.simpletooltipContentId:"",i=Math.random().toString(32).slice(2,12),r=e.attr("aria-describedby")||"";e.attr({"aria-describedby":("label_simpletooltip_"+i+" "+r).trim()}),e.wrap('<span class="'+o+'simpletooltip_container"></span>');var s='<span class="js-simpletooltip '+o+'simpletooltip" id="label_simpletooltip_'+i+'" role="tooltip" aria-hidden="true">';if(""!==a)s+=""+a;else{var l=jQuery(n);""!==n&&l.length&&(s+=l.html())}s+="</span>",jQuery(s).insertAfter(e)}jQuery(document).ready(function(e){e.fn.accessibleSimpleTooltipAria=t,e(".js-simple-tooltip").each(function(){t.apply(this)}),e("body").on("mouseenter focusin",".js-simple-tooltip",function(){var t=e(this).attr("aria-describedby").trimEnd(" "),a=e("#"+t);a.attr("aria-hidden","false"),a.addClass("tooltip-show")}).on("mouseleave",".js-simple-tooltip",function(t){var a=e(this).attr("aria-describedby").trimEnd(" "),o=e("#"+a);o.is(":hover")||(o.attr("aria-hidden","true"),o.removeClass("tooltip-show"))}).on("focusout",".js-simple-tooltip",function(t){var a=e(this).attr("aria-describedby").trimEnd(" "),o=e("#"+a);o.attr("aria-hidden","true"),o.removeClass("tooltip-show")}).on("mouseleave",".js-simple-tooltip",function(){var t=e(this);t.attr("aria-hidden","true");var a=t.attr("aria-describedby").trimEnd(" ");e("#"+a).removeClass("tooltip-show")}).on("keydown",".js-simple-tooltip",function(t){var a=e(this).attr("aria-describedby").trimEnd(" "),o=e("#"+a);27==t.keyCode&&(o.attr("aria-hidden","true"),o.removeClass("tooltip-show"))})})}();