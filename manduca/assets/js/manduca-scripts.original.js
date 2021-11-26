/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021 Zsolt Edelényi (ezs@web25.hu)

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



 
 
jQuery.noConflict();

	
/*------------------------------------------------
 *
 *
 *          Section 1. Executed on loading
 *
 * 
 *
 **---------------------------------------------------*/
    //hide while pageloads, if JS enabled
	document.getElementById ("page").setAttribute('style','display:none');











///////////////////////////////////////////////   
/*
 *
 *      Focus snail  applied to Manduca
 *      pure JavaScript
 *
 * 
 * @original   : https://github.com/NV/focus-snail/
 * @theme      : Manduca - focus on accessiblilty
 * @param      : manducaVariables.red
 *               manducaVariables.green
 *               manducaVariables.blue
 */

'use strict';

var OFFSET_PX = 0;
var MIN_WIDTH = 12;
var MIN_HEIGHT = 8;

var START_FRACTION = 0.4;
var MIDDLE_FRACTION = 0.8;

var focusSnail = {
	enabled: true,
	trigger: trigger
};


/**
 * @param {Element} prevFocused
 * @param {Element} target
 */
function trigger(prevFocused, target) {
	if (svg) {
		onEnd();
	} else {
		initialize();
	}

	var prev = dimensionsOf(prevFocused);
	var current = dimensionsOf(target);

	var left = 0;
	var prevLeft = 0;
	var top = 0;
	var prevTop = 0;

	var distance = dist(prev.left, prev.top, current.left, current.top);
	var duration = animationDuration(distance);

	function setup() {
		var scroll = scrollOffset();
		svg.style.left = scroll.left + 'px';
		svg.style.top = scroll.top + 'px';
		svg.setAttribute('width', win.innerWidth);
		svg.setAttribute('height', win.innerHeight);
		svg.classList.add('focus-snail_visible');
		left = current.left - scroll.left;
		prevLeft = prev.left - scroll.left;
		top = current.top - scroll.top;
		prevTop = prev.top - scroll.top;
	}

	var isFirstCall = true;

	animate(function(fraction) {
		if (isFirstCall) {
			setup();
			setGradientAngle(gradient, prevLeft, prevTop, prev.width, prev.height, left, top, current.width, current.height);
			var list = getPointsList({
				top: prevTop,
				right: prevLeft + prev.width,
				bottom: prevTop + prev.height,
				left: prevLeft
			}, {
				top: top,
				right: left + current.width,
				bottom: top + current.height,
				left: left
			});
			enclose(list, polygon);
		}

		var startOffset = fraction > START_FRACTION ? easeOutQuad((fraction - START_FRACTION) / (1 - START_FRACTION)) : 0;
		var middleOffset = fraction < MIDDLE_FRACTION ? easeOutQuad(fraction / MIDDLE_FRACTION) : 1;
		start.setAttribute('offset', startOffset * 100 + '%');
		middle.setAttribute('offset', middleOffset * 100 + '%');

		if (fraction >= 1) {
			onEnd();
		}

		isFirstCall = false;
	}, duration);
}


function animationDuration(distance) {
	return Math.pow(constrain(distance, 32, 1024), 1/3) * 50;
}


function easeOutQuad(x) {
	return 2*x - x*x;
}


var win = window;
var doc = document;
var docElement = doc.documentElement;
var body = doc.body;

var prevFocused = null;
var animationId = 0;
var keyDownTime = 0;


docElement.addEventListener('keydown', function(event) {
	if (!focusSnail.enabled) {
		return;
	}
	var code = event.which;
	// Show animation only upon Tab or Arrow keys press.
	if (code === 9 || (code > 36 && code < 41)) {
		keyDownTime = Date.now();
	}
}, false);


docElement.addEventListener('blur', function(e) {
	if (!focusSnail.enabled) {
		return;
	}
	onEnd();
	if (isJustPressed()) {
		prevFocused = e.target;
	} else {
		prevFocused = null;
	}
}, true);


docElement.addEventListener('focus', function(event) {
	if (!prevFocused) {
		return;
	}
	if (!isJustPressed()) {
		return;
	}
	trigger(prevFocused, event.target);
}, true);


function setGradientAngle(gradient, ax, ay, aWidth, aHeight, bx, by, bWidth, bHeight) {
	var centroidA = rectCentroid(ax, ay, aWidth, aHeight);
	var centroidB = rectCentroid(bx, by, bWidth, bHeight);
	var angle = Math.atan2(centroidA.y - centroidB.y, centroidA.x - centroidB.x);
	var line = angleToLine(angle);
	gradient.setAttribute('x1', line.x1);
	gradient.setAttribute('y1', line.y1);
	gradient.setAttribute('x2', line.x2);
	gradient.setAttribute('y2', line.y2);
}


function rectCentroid(x, y, width, height) {
	return {
		x: x + width / 2,
		y: y + height / 2
	};
}


function angleToLine(angle) {
	var segment = Math.floor(angle / Math.PI * 2) + 2;
	var diagonal = Math.PI/4 + Math.PI/2 * segment;

	var od = Math.sqrt(2);
	var op = Math.cos(Math.abs(diagonal - angle)) * od;
	var x = op * Math.cos(angle);
	var y = op * Math.sin(angle);

	return {
		x1: x < 0 ? 1 : 0,
		y1: y < 0 ? 1 : 0,
		x2: x >= 0 ? x : x + 1,
		y2: y >= 0 ? y : y + 1
	};
}


/** @type {SVGSVGElement} */
var svg = null;

/** @type {SVGPolygonElement} */
var polygon = null;

/** @type SVGStopElement */
var start = null;
/** @type SVGStopElement */
var middle = null;
/** @type SVGStopElement */
var end = null;

/** @type SVGLinearGradientElement */
var gradient = null;



function htmlFragment() {
	var div = doc.createElement('div');
	div.innerHTML = '<svg id="focus-snail_svg" width="1000" height="800">\
		<linearGradient id="focus-snail_gradient">\
			<stop id="focus-snail_start" offset="0%" stop-color="rgb(' + manducaVariables.red +', ' +manducaVariables.green + ', ' + manducaVariables.blue + ')" stop-opacity="0"/>\
			<stop id="focus-snail_middle" offset="80%" stop-color="rgb(' + manducaVariables.red +', ' +manducaVariables.green + ', ' + manducaVariables.blue + ')" stop-opacity="0.8"/>\
			<stop id="focus-snail_end" offset="100%" stop-color="rgb(' + manducaVariables.red +', ' +manducaVariables.green + ', ' + manducaVariables.blue + ')" stop-opacity="0"/>\
		</linearGradient>\
		<polygon id="focus-snail_polygon" fill="url(#focus-snail_gradient)"/>\
	</svg>';
	return div;
}


function initialize() {
	var html = htmlFragment();
	svg = getId(html, 'svg');
	polygon = getId(html, 'polygon');
	start = getId(html, 'start');
	middle = getId(html, 'middle');
	end = getId(html, 'end');
	gradient = getId(html, 'gradient');
	body.appendChild(svg);
}


function getId(elem, name) {
	return elem.querySelector('#focus-snail_' + name);
}


function onEnd() {
	if (animationId) {
		cancelAnimationFrame(animationId);
		animationId = 0;
		svg.classList.remove('focus-snail_visible');
	}
}


function isJustPressed() {
	return Date.now() - keyDownTime < 42;
}


function animate(onStep, duration) {
	var start = Date.now();
	(function loop() {
		animationId = requestAnimationFrame(function() {
			var diff = Date.now() - start;
			var fraction = diff / duration;
			onStep(fraction);
			if (diff < duration) {
				loop();
			}
		});
	})();
}


function getPointsList(a, b) {
	var x = 0;

	if (a.top < b.top)
		x = 1;

	if (a.right > b.right)
		x += 2;

	if (a.bottom > b.bottom)
		x += 4;

	if (a.left < b.left)
		x += 8;

	var dict = [
		[],
		[0, 1],
		[1, 2],
		[0, 1, 2],
		[2, 3],
		[0, 1], // FIXME: do two polygons
		[1, 2, 3],
		[0, 1, 2, 3],
		[3, 0],
		[3, 0, 1],
		[3, 0], // FIXME: do two polygons
		[3, 0, 1, 2],
		[2, 3, 0],
		[2, 3, 0, 1],
		[1, 2, 3, 0],
		[0, 1, 2, 3, 0]
	];

	var points = rectPoints(a).concat(rectPoints(b));
	var list = [];
	var indexes = dict[x];
	for (var i = 0; i < indexes.length; i++) {
		list.push(points[indexes[i]]);
	}
	while (i--) {
		list.push(points[indexes[i] + 4]);
	}
	return list;
}


function enclose(list, polygon) {
	polygon.points.clear();
	for (var i = 0; i < list.length; i++) {
		var p = list[i];
		addPoint(polygon, p);
	}
}


function addPoint(polygon, point) {
	var pt = polygon.ownerSVGElement.createSVGPoint();
	pt.x = point.x;
	pt.y = point.y;
	polygon.points.appendItem(pt);
}


function rectPoints(rect) {
	return [
		{
			x: rect.left,
			y: rect.top
		},
		{
			x: rect.right,
			y: rect.top
		},
		{
			x: rect.right,
			y: rect.bottom
		},
		{
			x: rect.left,
			y: rect.bottom
		}
	];
}


function dimensionsOf(element) {
	var offset = offsetOf(element);
	return {
		left: offset.left - OFFSET_PX,
		top: offset.top - OFFSET_PX,
		width: Math.max(MIN_WIDTH, element.offsetWidth) + 2*OFFSET_PX,
		height: Math.max(MIN_HEIGHT, element.offsetHeight) + 2*OFFSET_PX
	};
}

function offsetOf(elem) {
	var rect = elem.getBoundingClientRect();
	var scroll = scrollOffset();

	var clientTop  = docElement.clientTop  || body.clientTop,
	clientLeft = docElement.clientLeft || body.clientLeft,
	top  = rect.top  + scroll.top  - clientTop,
	left = rect.left + scroll.left - clientLeft;

	return {
		top: top || 0,
		left: left || 0
	};
}

function scrollOffset() {
	var top = win.pageYOffset || docElement.scrollTop;
	var left = win.pageXOffset || docElement.scrollLeft;
	return {
		top: top || 0,
		left: left || 0
	};
}


function dist(x1, y1, x2, y2) {
	var dx = x1 - x2;
	var dy = y1 - y2;
	return Math.sqrt(dx*dx + dy*dy);
}


function constrain(amt, low, high) {
	if (amt <= low) {
		return low;
	}
	if (amt >= high) {
		return high;
	}
	return amt;
}

///////////////////////////////////////////////
// THE END of focus snake















/*----------------------------------------------------------
* Modal dialog focus trap
*
* @see: https://github.com/ireade/accessible-modal-dialog
* @since 21.2
*----------------------------------------------------------*/



function Dialog(dialogEl, overlayEl, dialogToggler) {

   this.dialogEl = dialogEl;
   this.overlayEl = overlayEl;
   this.dialogToggler = dialogToggler;
   this.focusedElBeforeOpen;

   var focusableEls = this.dialogEl.querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]');
   this.focusableEls = Array.prototype.slice.call(focusableEls);

   this.firstFocusableEl = this.focusableEls[0];
   this.lastFocusableEl = this.focusableEls[ this.focusableEls.length - 1 ];

   this.close(); // Reset
}


Dialog.prototype.open = function() {

	var Dialog = this;
	this.dialogEl.classList.add("active");
	if (this.dialogToggler)
		this.dialogToggler.classList.add("toggled-on");
   if (this.overlayEl)
	this.overlayEl.classList.add("active");
   this.focusedElBeforeOpen = document.activeElement;

   this.dialogEl.addEventListener('keydown', function(e) {
	   Dialog._handleKeyDown(e);
   });

   if (this.overlayEl) {
		this.overlayEl.addEventListener('click', function() {
		   Dialog.close();
		});
   }
   
   this.firstFocusableEl.focus();
};

Dialog.prototype.close = function() {

   this.dialogEl.classList.remove('active');
   if (this.overlayEl) {
	   this.overlayEl.classList.remove('active');
	   this.dialogToggler.classList.remove('toggled-on');
   }

   if ( this.focusedElBeforeOpen ) {
	   this.focusedElBeforeOpen.focus();
   }
};


Dialog.prototype._handleKeyDown = function(e) {

   var Dialog = this;
   var KEY_TAB = 9;
   var KEY_ESC = 27;

   function handleBackwardTab() {
	   if ( document.activeElement === Dialog.firstFocusableEl ) {
		   e.preventDefault();
		   Dialog.lastFocusableEl.focus();
	   }
   }
   function handleForwardTab() {
	   if ( document.activeElement === Dialog.lastFocusableEl ) {
		   e.preventDefault();
		   Dialog.firstFocusableEl.focus();
	   }
   }

   switch(e.keyCode) {
   case KEY_TAB:
	   if ( Dialog.focusableEls.length === 1 ) {
		   e.preventDefault();
		   break;
	   } 
	   if ( e.shiftKey ) {
		   handleBackwardTab();
	   } else {
		   handleForwardTab();
	   }
	   break;
   case KEY_ESC:
	   Dialog.close();
	   break;
   default:
	   break;
   }


};


Dialog.prototype.addEventListeners = function(openDialogSel, closeDialogSel) {

   var Dialog = this;

   var openDialogEls = document.querySelectorAll(openDialogSel);
   for ( var i = 0; i < openDialogEls.length; i++ ) {
	   openDialogEls[i].addEventListener('click', function() { 
		   Dialog.open();
	   });
   }

	if (closeDialogSel) {
		var closeDialogEls = document.querySelectorAll(closeDialogSel);
		for ( var i = 0; i < closeDialogEls.length; i++ ) {
			closeDialogEls[i].addEventListener('click', function() {
				Dialog.close();
			});
		}
	}

};




























/*------------------------------------------------
 *
 *
 *          Section 2. After page is loaded
 *
 * 
 *
 **---------------------------------------------------*/


jQuery(document).ready(function($)
{
    
	///////////////////////////////////////////////////
	// hide spinner, show content
	
	$('#page').css('display','block' );
    $('#pageload-spinner').hide();
	
   
    ///////////////////////////////////////////////
	// Read cookies, set <html> element classes. Also set reading options buttons attributes. 
    
	var $blocks=$('#toolbar-buttons-table button');
    var $uniqueNames = [];
    $.each ($blocks, function ( i, $element )
    {
       var $class=$($element).attr('class');
       if($.inArray($class, $uniqueNames) === -1) $uniqueNames.push($class);
    }); 
    $.each ($uniqueNames, function ( i, $block )
    {
    
        var $cookieValue =readCookie( $block );
          if ( $cookieValue )
          {
                $('html').addClass( $cookieValue );
                $( '#' + $cookieValue ).attr( 'disabled' , 'true' );
           }
           else
           {
            var $default=$block+ '-0';
              $('html').addClass( $default );
             $( '#'+$default).attr( 'disabled', 'true' );
           }
       
        
        $('.'+$block).click(function () {
          var $id= $(this).attr('id');
          $( '.'+$block).removeAttr ('disabled');
          $(this).attr('disabled' , 'true' );
          var $removes='';
          for ($i=0; $i<5; $i++) {
            var $new=$block + '-' + $i + ' ';
             $removes=$removes.concat($new);
          }   
          var CookieDate = new Date();
          $('html').removeClass($removes);
          $('html').addClass($id);
          CookieDate.setFullYear(CookieDate.getFullYear() + 10);
          document.cookie = $block + '=' + $id + '; expires=' + CookieDate.toGMTString() + '; path=/';
        });
        
    });
    var animation=$('html').hasClass('animation-0');
	
		
	
    ///////////////////////////////////////////////
	// Target change should followed with reload

    $('.target').on( 'click' ,function () {
        location.reload();
    });
    
   
   
   
   
   
   
   
   	///////////////////////////////////////////////
	// Handlers for navigation and widget area.
	
	var masthead, menuToggle, siteNavContain, siteNavigation;
   
    masthead       = $( '.megamenu-parent' );
    menuToggle     = masthead.find( '.menu-toggle' );
    siteNavContain = masthead.find( '.megamenu' );   
    siteNavigation = masthead.find( '.megamenu > ul' );
    
	
	
    // Escape handler  */
	 $(document).keyup(function(e) {
         if (e.keyCode === 27) {
			var toggleOffs = $('button.dropdown-toggle.toggled-on, div.sub-nav.toggled-on');
			$.each (toggleOffs, function ( index, el) {
				$(el).removeClass( 'active');
			});
         }            
      });
	 
	 
	//Keyboard trap in menu toggle
	var navDialogEl = document.querySelector('.megamenu');
	var dialogOverlay = document.querySelector('.dialog-overlay');
	var dialogToggler = document.querySelector('.menu-toggle');
	
	var myDialog = new Dialog(navDialogEl, dialogOverlay, dialogToggler);
	myDialog.addEventListeners('.menu-toggle', '.modal-window-close');
 
	 
	 //Keyboard trap in submenus 
	$( '.sub-nav').each(function (){
		modal_id=this.id;
		modal_controller=modal_id.replace ('sub-nav', 'button');
		var navDialogEl = document.querySelector("#" + modal_id);
		var myDialog = new Dialog(navDialogEl, null);
		myDialog.addEventListeners('#' + modal_controller, null);
	});
	
	



	
	
 
 
 
 
 
 	
    ///////////////////////////////////////////////
	// Handle the dropdown buttons of main navigation 

    (function touchDevice()
    {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
		 return;
		}
	
		function initMainNavigation( container )
		{
			container.find( '.dropdown-toggle' ).click( function( e ) //Click dropdown-toggle
			{
				var _this = $( this );
				
				
				e.preventDefault();
				var subnav=getSubNavObj (_this);
					
				if( _this.hasClass ('toggled-on') ) {
					_this.removeClass( 'toggled-on' );
					_this.attr( 'aria-expanded', false);
					subnav.removeClass( 'active' );
				}
				else {
					var $blocks=$('.dropdown-toggle');
					$.each( $blocks, function  ( i, e) {  //Close other dropdowns 
						$element=$(e);
						if( $element.hasClass('toggled-on') ) {
							$element.removeClass( 'toggled-on');
							var $subNavObj=getSubNavObj ($element);
							$subNavObj.removeClass( 'active');
							
						}
					});
					_this.addClass( 'toggled-on' );
					subnav.addClass( 'active' );
					_this.attr( 'aria-expanded', 'true' );
				}
				
				
				
			});
	   }
	   
	   function getSubNavObj ($element) {
			var $id=$element.attr('id');
			var $subNavId=$id.replace('button', 'sub-nav');
			return $('#'+$subNavId);
	   }
		
		initMainNavigation( $( '.main-navigation' ) );
        
      
        /////////////////////////////////////////////////
		// Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen()
        {
            if ( 'none' === $( '.menu-toggle' ).css( 'display' ) )
			{
         
				$( document.body ).on( 'touchstart.manduca', function( e ) {
				 if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
				  $( '.main-navigation li' ).removeClass( 'focus' );
				 }
				});
			
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' )
				 .on( 'touchstart.manduca', function( e ) {
				  var el = $( this ).parent( 'li' );
			
				  if ( ! el.hasClass( 'focus' ) ) {
				   e.preventDefault();
				   el.toggleClass( 'focus' );
				   el.siblings( '.focus' ).removeClass( 'focus' );
				  }
				 });
         
            } else {
             siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.manduca' );
            }
        }
      
        if ( 'ontouchstart' in window )
        {
             $( window ).on( 'resize.manduca', toggleFocusClassTouchScreen );
             toggleFocusClassTouchScreen();
        }
      
        siteNavigation.find( 'a' ).on( 'focus.manduca blur.manduca', function()
        {
             $( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
        });
    })();
    
	///////////////////////////////////////////////
	// THIS IS THE END of handlers for navigation and widget area.    
	
 
 
 
 
 
 
 
 
	
    
    
    /*////////////////////////////////////////////
    * Back to top*/
	
     $('#manduca-back-to-top').click(function( event )
    {
        event.preventDefault( );
        jQuery('html, body').animate({scrollTop : 0}, 800);
        jQuery('#menu-toggle').focus();
        return false;
    });
	 
	 $('#skip-to-content').click(function( event ) {
        event.preventDefault( );
       var pos = jQuery('#primary').position(); 
        var y = parseInt(pos.top);
        jQuery('html, body').animate({scrollTop : y}, 800);
        jQuery('#content').find('h1').first().attr('tabindex','0').focus();
		return false;
     });
    
    
    
    
    ///////////////////////////////////////////////////////////
	// Show button only when your below from the bove-folder area
     
    $(document).on( 'scroll', function( event )
    {
         event.preventDefault();
         if ($(window).scrollTop() > 100)
         {
            $('.manduca-back-to-top-div').addClass('show');
         } else
         {
             $('.manduca-back-to-top-div').removeClass('show');
         }
        return false;
    });
       
       
    ///////////////////////////////////////////////
	// Change link-target 
     
    $('a').click(function()
    {
		var linkTargetBlank=$('html').hasClass('link-target-2');
		var linkTargetSelf=$('html').hasClass('link-target-1');
		if ( linkTargetSelf)
		{
             $(this).attr('target', '_self');
        }
        if ( linkTargetBlank)
        {
            $(this).attr('target', '_blank');
        }
    });
	
	
	
	
	
    /*//////////////////////////////////////////////////
    *Manduca's user-friendly archive widget function  */
     
    $('#manduca_archive-month-submit').click(function()
    {
            var year = $( '#manduca-archive-year-dropdown' ).val();
            var month = $( '#manduca-archive-month-dropdown' ).val(); 
            var url = window.location.protocol + "//" + window.location.host + "/" + year + "/" + month + "/";
        			document.location.href=url;
    });
    $( '#manduca-archive-year-dropdown' ).change(function()
    {
         var year = $( '#manduca-archive-year-dropdown' ).val();
         var url = window.location.protocol + "//" + window.location.host +'/?manduca=ajax';
         jQuery.ajax(
        {
            url: url,
            type : 'post',
            data :
            {
             action : 'archives',
             year: year,
             hash: manducaVariables.hash
            },
            success : function( response )
            {
                $( '#manduca-archive-month-dropdown option').remove();
                $( '#manduca-archive-month-dropdown').append( response ).focus();
           }
        });
    });
	
	
	
	
	
   
   
   
   
   
   
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*------------------------------------------------
    /*
     * jQuery simple and accessible hide-show system (collapsible regions), using ARIA
     * @version v1.9.0   
     * Website: https://a11y.nicolas-hoffmann.net/hide-show/
     * License MIT: https://github.com/nico3333fr/jquery-accessible-hide-show-aria/blob/master/LICENSE
     *
     *
     *@package Manduca
     *@copyright Zsolt Edelényi
     *@since 19.3
    /*------------------------------------------------    */
    var attr_control = 'data-controls',
        attr_expanded = 'aria-expanded',
        attr_labelledby = 'data-labelledby',
        attr_hidden = 'data-hidden',
        $expandmore = $('.js-expandmore'),
        $body = $('#wrapper'),
        delay = 1500,
        hash = window.location.hash.replace("#", ""),
        multiexpandable = true;
        


    if ($expandmore.length)
    { // if there are at least one :)
        $expandmore.each(function(index_to_expand) {
            var $this = $(this),
                index_lisible = index_to_expand + 1,
                options = $this.data(),
                $hideshow_prefix_classes = typeof options.hideshowPrefixClass !== 'undefined' ? options.hideshowPrefixClass + '-' : '',
                not_all_expands = typeof options.notAllExpands !== 'undefined' ? true : false,
                $to_expand = $this.next(".js-to_expand"),
                $expandmore_text = $this.html();

            $this.html('<button type="button" class="' + $hideshow_prefix_classes + 'expandmore__button js-expandmore-button"' + ( not_all_expands ? 'data-not-all-expands="true"' : '' ) + '><span class="' + $hideshow_prefix_classes + 'expandmore__symbol" aria-hidden="true"></span>' + $expandmore_text + '</button>');
            var $button = $this.children('.js-expandmore-button');

            $to_expand.addClass($hideshow_prefix_classes + 'expandmore__to_expand').stop().delay(delay).queue(function() {
                var $this = $(this);
                if ($this.hasClass('js-first_load')) {
                    $this.removeClass('js-first_load');
                }
            });

            $button.attr('id', 'label_expand_' + index_lisible);
            $button.attr(attr_control, 'expand_' + index_lisible);
            $button.attr(attr_expanded, 'false');

            $to_expand.attr('id', 'expand_' + index_lisible);
            $to_expand.attr(attr_hidden, 'true');
            $to_expand.attr(attr_labelledby, 'label_expand_' + index_lisible);
            
            if (not_all_expands) {
               $to_expand.attr('data-not-all-expands', 'true');
            }

            // quick tip to open (if it has class is-opened or if hash is in expand)
            if ($to_expand.hasClass('is-opened') || (hash !== "" && $to_expand.find($("#" + hash)).length)) {
                $button.addClass('is-opened').attr(attr_expanded, 'true');
                $to_expand.removeClass('is-opened').removeAttr(attr_hidden);
            }


        });
    }
    
    

    $body.on('click', '.js-expandmore-button', function(event) {
        
        var $this = $(this),
            $destination = $('#' + $this.attr(attr_control));

        if ($this.attr(attr_expanded) === 'false') {

            if (multiexpandable === false) {
                $('.js-expandmore-button').removeClass('is-opened').attr(attr_expanded, 'false');
                $('.js-to_expand').attr(attr_hidden, 'true');
            }

            $this.addClass('is-opened').attr(attr_expanded, 'true');
            $destination.removeAttr(attr_hidden);
        } else {
            $this.removeClass('is-opened').attr(attr_expanded, 'false');
            $destination.attr(attr_hidden, 'true');
        }

        event.preventDefault();

    });
    
    $body.on('keydown', '.js-expandmore-button', function(event) {
      var $this = $(this),
          $destination = $('#' + $this.attr(attr_control));
      if (event.keyCode === 27 && $this.attr(attr_expanded) === 'true') {
        $this.removeClass('is-opened').attr(attr_expanded, 'false');
        $destination.attr(attr_hidden, 'true');
		$this.focus();
      }
    });

    $body.on('click keydown', '.js-expandmore', function(event) {
        var $this = $(this),
            $target = $(event.target),
            $button_in = $this.find('.js-expandmore-button');
                    
        if (!$target.is($button_in) && !$target.closest($button_in).length) {
            if (event.type === 'click') {
                $button_in.trigger('click');
                return false;
            }
            if (event.type === 'keydown' && (event.keyCode === 13 || event.keyCode === 32)) {
                $button_in.trigger('click');
                return false;
            }
        }

    });

    $body.on('click keydown', '.js-expandmore-all', function(event) {
        var $this = $(this),
            options = $this.data(),
            is_expanded = $this.attr('data-expand'),
            txt_expand_all = typeof options.textExpandAll !== 'undefined' ? options.textExpandAll : manducaVariables.expand_all,
            txt_collapse_all = typeof options.textCloseAll !== 'undefined' ? options.textCloseAll : manducaVariables.collapse_all,
            $all_buttons = $('.js-expandmore-button:not([data-not-all-expands])'),
            $all_destinations = $('.js-to_expand:not([data-not-all-expands])');

        if (
            event.type === 'click' ||
            (event.type === 'keydown' && (event.keyCode === 13 || event.keyCode === 32))
        ) {
            if (is_expanded === 'true') {

                $all_buttons.addClass('is-opened').attr(attr_expanded, 'true');
                $all_destinations.removeAttr(attr_hidden);
                $this.attr('data-expand', 'false').html(txt_collapse_all);
            } else {
                $all_buttons.removeClass('is-opened').attr(attr_expanded, 'false');
                $all_destinations.attr(attr_hidden, 'true');
                $this.attr('data-expand', 'true').html(txt_expand_all);
            }

        }
    });
	
	
	
	
	
	/////////////////////////////////////////
	// Toolbar buttons (Reading options)
	
	var navDialogEl = document.querySelector('.toolbar-buttons');
	var dialogOverlay = document.querySelector('.dialog-overlay');
	var dialogToggler = document.querySelector('.toolbar-buttons-open');
	
	var myDialog = new Dialog(navDialogEl, dialogOverlay, dialogToggler);
	myDialog.addEventListeners('.toolbar-buttons-open', '.modal-window-close');






	
	
});
// THE END of functions executed after pageload */
///////////////////////////////////////////////









///////////////////////////////////////////////
// immediately-invoked functgion expression   */

(function otherFunctions()
{

    
    /*------------------------------------------------
     *
     * jQuery accessible simple (non-modal) tooltip window, using ARIA
     *
     * @version v2.2.0 
     * Website: https://a11y.nicolas-hoffmann.net/simple-tooltip/
     * License MIT: https://github.com/nico3333fr/jquery-accessible-simple-tooltip-aria/blob/master/LICENSE
     /*
     ------------------------------------------------*/

    function accessibleSimpleTooltipAria(options)
    {
        var element = jQuery(this);
        options = options || element.data();
        var text = options.simpletooltipText || '';
        var prefix_class = typeof options.simpletooltipPrefixClass !== 'undefined' ? options.simpletooltipPrefixClass + '-' : '';
        var content_id = typeof options.simpletooltipContentId !== 'undefined' ? '#' + options.simpletooltipContentId : '';

        var index_lisible = Math.random().toString(32).slice(2, 12);
        var aria_describedby = element.attr('aria-describedby') || '';

        element.attr({
            'aria-describedby': ('label_simpletooltip_' + index_lisible + ' ' + aria_describedby).trim()
        });

        element.wrap('<span class="' + prefix_class + 'simpletooltip_container"></span>');

        var html = '<span class="js-simpletooltip ' + prefix_class + 'simpletooltip" id="label_simpletooltip_' + index_lisible + '" role="tooltip" aria-hidden="true">';

        if (text !== '') {
            html += '' + text + '';
        } else {
            var $contentId = jQuery(content_id);
            if (content_id !== '' && $contentId.length) {
                html += $contentId.html();
            }
        }
        html += '</span>';

        jQuery(html).insertAfter(element);
    }

    
    jQuery(document).ready(function($) {
        
        // Bind as a jQuery plugin
            $.fn.accessibleSimpleTooltipAria = accessibleSimpleTooltipAria;


        $('.js-simple-tooltip')
            .each(function() {
                // Call the function with this as the current tooltip
                accessibleSimpleTooltipAria.apply(this);
            });

        // events ------------------
        $('body')
            .on('mouseenter focusin', '.js-simple-tooltip', function() {
                var $this = $(this);
                var aria_describedby = $this.attr('aria-describedby');
                var tooltip_to_show_id = aria_describedby.trimEnd(' ');
                var $tooltip_to_show = $('#' + tooltip_to_show_id);
                $tooltip_to_show.attr('aria-hidden', 'false');
                $tooltip_to_show.addClass('tooltip-show');
            })
            .on('mouseleave', '.js-simple-tooltip', function(event) {
                var $this = $(this);
                var aria_describedby = $this.attr('aria-describedby');
                var tooltip_to_show_id = aria_describedby.trimEnd(' ');
                var $tooltip_to_show = $('#' + tooltip_to_show_id);
                var $is_target_hovered = $tooltip_to_show.is(':hover');

                if (!$is_target_hovered) {
                    $tooltip_to_show.attr('aria-hidden', 'true');
                    $tooltip_to_show.removeClass('tooltip-show');
                }
            })
            .on('focusout', '.js-simple-tooltip', function(event) {
                var $this = $(this);
                var aria_describedby = $this.attr('aria-describedby');
                var tooltip_to_show_id = aria_describedby.trimEnd(' ');
                var $tooltip_to_show = $('#' + tooltip_to_show_id);

                $tooltip_to_show.attr('aria-hidden', 'true');
                $tooltip_to_show.removeClass('tooltip-show');
            })
            .on('mouseleave', '.js-simple-tooltip', function() {
                var $this = $(this);
                $this.attr('aria-hidden', 'true');
                var aria_describedby = $this.attr('aria-describedby');
                var tooltip_to_show_id = aria_describedby.trimEnd(' ');
                var $tooltip_to_show = $('#' + tooltip_to_show_id);
                $tooltip_to_show.removeClass('tooltip-show');
            })
            .on('keydown', '.js-simple-tooltip', function(event) {
                // close esc key

                var $this = $(this);
                var aria_describedby = $this.attr('aria-describedby');
                var tooltip_to_show_id = aria_describedby.trimEnd(' ');
                var $tooltip_to_show = $('#' + tooltip_to_show_id);

                if (event.keyCode == 27) { // esc
                    $tooltip_to_show.attr('aria-hidden', 'true');
                    $tooltip_to_show.removeClass('tooltip-show');
                }
            });
    });

})();














/*---------------------------------------------------
 **Cookie functions
 * pure JavaScripts
 *
 * @since 2.0
 * @see:https://www.quirksmode.org/js/cookies.html
 *
 *--------------------------------------------------*/
 
function createCookie(name,value,days)
{
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/; SameSite=Lax";
}


function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}


function eraseCookie(name)
{
	createCookie(name,"",-1);
}



