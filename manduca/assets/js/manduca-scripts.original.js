/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2019 Zsolt Edelényi (ezs@web25.hu)

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



/**
 * Makes "skip to content" link work correctly in IE9, Chrome, and Opera
 * for better accessibility.
 *
 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
 */

 ( function() {
	var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
		isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
		isIE     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( isWebkit || isOpera || isIE ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();

				// Repositions the window on jump-to-anchor to account for admin bar and border height.
				window.scrollBy( 0, -53 );
			}
		}, false );
	}
} )();






/*
 * Focus snail  applied to Manduca
 *
 * 
 * @original   : https://github.com/NV/focus-snail/
 * @theme      : Manduca - focus on accessiblilty
 * @param      : manducaVariables.red
 *               manducaVariables.green
 *               manducaVariables.blue
 **/

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







/*
 * Contains handlers for navigation and widget area.
 * based on the script in theme twenty seventeen.
 */

(function( $ ) {
	var masthead, menuToggle, siteNavContain, siteNavigation, toolbarButtons, toolbarButtonsOpen;

  

	masthead       = $( '.megamenu-parent' );
	menuToggle     = masthead.find( '.menu-toggle' );
	siteNavContain = masthead.find( '.megamenu' );   
	siteNavigation = masthead.find( '.megamenu > ul' );
    toolbarButtons = $( '.toolbar-buttons' );
    toolbarButtonsOpen=$( '.toolbar-buttons-open' );

	// Enable menuToggle.
	(function() {

		// Return early if menuToggle is missing.
		if ( ! menuToggle.length ) {
			return;
		}

		// Add an initial value for the attribute.
		menuToggle.attr( 'aria-expanded', 'false' );

      //Click menu-toggle
		menuToggle.on( 'click.manduca', function() {
			siteNavContain.toggleClass( 'toggled-on' );
            menuToggle.toggleClass( 'toggled-on' );
            toolbarButtonsOpen.removeClass( 'toggled-on');
            toolbarButtonsOpen.attr( 'aria-expanded',  'false' );
            toolbarButtons.removeClass( 'toggled-on');
            toolbarButtons.css( 'display', 'none' ); 
            

			$( this ).attr( 'aria-expanded', siteNavContain.hasClass( 'toggled-on' ) );
		});
	})();

	
	
 
 
 
 
 
 
 -
	
	/*
	 *Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	 *
	 *last change @20.3
	 *
	 **/
	(function() {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}

  function initMainNavigation( container ) {

		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
			.append( manducaVariables.icon )
			.append( $( '<span />', { 'class': 'screen-reader-text', text: manducaVariables.expand }) );

		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this = $( this ),
				screenReaderSpan = _this.find( '.screen-reader-text' );

			e.preventDefault();
			_this.toggleClass( 'toggled-on' );
			_this.next( '.children, .sub-nav' ).toggleClass( 'toggled-on' );

			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

			screenReaderSpan.text( screenReaderSpan.text() === manducaVariables.expand ? manducaScreenReaderText.collapse : manducaScreenReaderText.expand );
		});
	}

	initMainNavigation( $( '.main-navigation' ) );
  
  
  
		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( 'none' === $( '.menu-toggle' ).css( 'display' ) ) {

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

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.manduca', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

		siteNavigation.find( 'a' ).on( 'focus.manduca blur.manduca', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		});
	})();
    
	
 
 
 
 
 
 
	
     /*
      * Accessibility/reading options TOOLBAR scripts
      *
      * Author: Zsolt Edelényi
      * @since 17.8
      *
      **/
   
      /*
       * Read cookies to set user's preferences
       * */
      
      var contrastType=readCookie( "contrastType" );
      if ( contrastType ) {
          $('body').addClass( contrastType );
		  $( '#' + contrastType ).attr( 'disabled' , 'true' );
       }
       else {
          $('body').addClass( "high-contrast-0" );
		  $( '#high-contrast-0').attr( 'disabled', 'true' );
       }
   
      
      var fontType=readCookie( "fontType" );
         if ( fontType ) {
             $('body').addClass( fontType );
			 $( '#' + fontType ).attr( 'disabled' , 'true' );
          }
          else {
             $('body').addClass( "font-type-0" );
			 $( '#font-type-0').attr( 'disabled', 'true' );
          }
          
              
      var fontSize=readCookie( "fontSize" );
         if ( fontSize ) {
             $('body').addClass( fontSize );
			 $( '#' + fontSize ).attr( 'disabled' , 'true' );
          }
          else {
             $('body').addClass( "font-size-0" );
			 $( '#font-size-0').attr( 'disabled', 'true' );
          }
      
      
    // Set target selector value @since 19.3
    var linkTarget=readCookie( "linkTarget" );
    if( linkTarget ) {
        $( '#target-' + linkTarget ).attr( 'disabled', 'true');
    }
    else {
        $( '#target-default').attr( 'disabled', 'true');
    }
	  
   
      /*
       * Behaviour open toolbar button of reading options 
       **/
   
          //Toggle tollbar
      $('.toolbar-buttons-open').click(function(){
         $('.toolbar-buttons').slideToggle( 200 );
         //close toolbar, if menu opens    
          if ( $( ".menu-toggle" ).hasClass( "toggled-on" ) ) {
            $( ".megamenu" ).removeClass( "toggled-on" );
            $( ".menu-toggle" ).removeClass( "toggled-on" );
        }
         //add toggle on to toolbar-buttons
         if ( $( ".toolbar-buttons" ).hasClass( "toggled-on") ) {
             $( ".toolbar-buttons" ).removeClass( "toggled-on" );
             $( ".toolbar-buttons-open" ).removeClass( "toggled-on" );
             $( ".toolbar-buttons-open" ).attr( 'aria-expanded', 'false' );
			 $('#toolbar-buttons-open').focus();  
         }
         else {
             $( ".toolbar-buttons" ).addClass( "toggled-on" );
             $( ".toolbar-buttons-open" ).addClass( "toggled-on" );
             $( ".toolbar-buttons-open" ).attr( 'aria-expanded', 'true' );
         }
    });
      
	
     //close toolbar with close button also    
    $( '#buttons-close' ).click(function() {
        $('#toolbar-buttons').slideUp();
        $( ".toolbar-buttons-open" ).removeClass( "toggled-on" );
        $( ".toolbar-buttons" ).removeClass( "toggled-on" );
		$( ".toolbar-buttons-open" ).attr( 'aria-expanded', 'false' );
		$('#toolbar-buttons-open').focus();  
    });
    
	
	
    /*
	 *Close toolbar for escape button and add focus back to the toolbar-button
	 *
	 *@since 19.2
	 **/
	$(document).on('keyup',function(evt) {
		if (evt.key === 'Escape') {
    		if ( $( ".toolbar-buttons" ).hasClass( "toggled-on") ) {
			    $( ".toolbar-buttons" ).removeClass( "toggled-on" );
			    $( ".toolbar-buttons-open" ).removeClass( "toggled-on" );
			    $( ".toolbar-buttons-open" ).attr( 'aria-expanded', 'false' );
				$( ".toolbar-buttons" ).css( 'display', 'none' );
                $('#toolbar-buttons-open').focus();
			}
		}	
    });
 
   
   
   /*
    * Toolbar settings
    * set cookies based on toolbar-buttons clicks
    **/
    //change font size
    $('.change-font-size').click(function () {
         var fontSize = $(this).attr('data-zoom');
         $( '.change-font-size').removeAttr( 'disabled' );
        $(this).attr('disabled' , 'true' );
         var CookieDate = new Date();

         $('body').removeClass('font-size-0 font-size-1 font-size-2 font-size-3');
         $('body').addClass(fontSize);
         CookieDate.setFullYear(CookieDate.getFullYear() + 10);
         document.cookie = 'fontSize=' + fontSize + '; expires=' + CookieDate.toGMTString() + '; path=/';
     });
     
      
      
    ///change contrast
    $('.high-contrast').click(function () {
        var contrastType = $(this).attr('data-contrast-type');
        $( '.high-contrast').removeAttr( 'disabled' );
        $(this).attr('disabled' , 'true' );
        var CookieDate = new Date();
        $('body').removeClass('high-contrast-1 high-contrast-2 high-contrast-3 high-contrast-0');
        $('body').addClass(contrastType);
        CookieDate.setFullYear(CookieDate.getFullYear() + 10);
        document.cookie = 'contrastType=' + contrastType + '; expires=' + CookieDate.toGMTString() + '; path=/';
    });
    
    //change font family
    $('.change-font-type').click(function () {
        var fontType= $(this).attr('data-font-type');
        $( '.change-font-type').removeAttr( 'disabled' );
        $(this).attr('disabled' , 'true' );
        var CookieDate = new Date();

        $('body').removeClass('font-type-1 font-type-2 font-type-0');
        $('body').addClass(fontType);
        CookieDate.setFullYear(CookieDate.getFullYear() + 10);
        document.cookie = 'fontType=' + fontType + '; expires=' + CookieDate.toGMTString() + '; path=/';
    });
	
	 
    //change target
    $('.target-selector').on( 'click' ,function () {
        var selectTarget= $(this).attr( 'data-target' ) ;
        $( '.target-selector' ).removeAttr( 'disabled');
		$(this).attr( 'disabled', 'true');
		var CookieDate = new Date();
        CookieDate.setFullYear(CookieDate.getFullYear() + 10);
        document.cookie = 'linkTarget=' + selectTarget + '; expires=' + CookieDate.toGMTString() + '; path=/';
    	location.reload();
      
    });
   
   
   
    
    /*
    * Skiplinks 
    * Because Voiceover cannot handle the internal links ( eg href='#content'),
    * necessary to apply javascripts to have jump links accessible
    * This is tested with all kind of clients
    *
    * @since: 19.1
    * @see: https://www.alkosoft.hu/public/web/js/scripts_v9.js
    **/
	
     $('#skip-to-content').click(function( event ) {
        event.preventDefault( );
       var pos = jQuery('#primary').position(); 
        var y = parseInt(pos.top);
        jQuery('html, body').animate({scrollTop : y}, 800);
        jQuery('#primary').find('h1').first().focus();
		return false;
     });
     $('#skip-to-sidebar').click(function( event ) {
        event.preventDefault( );
       var pos = jQuery('#secondary').position(); 
        var y = parseInt(pos.top);
        jQuery('html, body').animate({scrollTop : y}, 800);
        jQuery('#secondary').find('h1').first().focus();
		return false;
     });
	 
	 $('#skip-to-footer').click(function( event ) {
        event.preventDefault( );
		var pos = jQuery('#footer-wrapper').position(); 
        var y = parseInt(pos.top);
        jQuery('html, body').animate({scrollTop : y}, 800);
        jQuery('#footer-wrapper').find('h1').first().focus();
		return false;
     });
     
     $('#manduca-back-to-top').click(function( event ){
		event.preventDefault( );
        jQuery('html, body').animate({scrollTop : 0}, 800);
		jQuery('#menu-toggle').focus();
		return false;
       });

	/*
	 * Show button only when your below from the bove-folder area
	 * */
	$(document).on( 'scroll', function( event ){
		event.preventDefault();
		if ($(window).scrollTop() > 100) {
			$('.manduca-back-to-top-div').addClass('show');
		} else {
			$('.manduca-back-to-top-div').removeClass('show');
		}
		return false;
	});
    
    
	/*
	 *Change link target
	 *based on cookie. 
	 *@since 19.2
	 **/
	$('a.extlink').click(function(){
		var linkTarget=readCookie( "linkTarget" );
		if ( linkTarget == 'self' ) {
          $(this).attr('target', '_self');
       }
	   if ( linkTarget == 'blank' ) {
          $(this).attr('target', '_blank');
       }
	   
    });
	
	
	
	
	
	
    /*
     * Manduca's user-friendly archive widget function 
     *
     *@since 19.2
     **/
    $('#manduca_archive-month-submit').click(function(){
            var year = $( '#manduca-archive-year-dropdown' ).val();
            var month = $( '#manduca-archive-month-dropdown' ).val();
            //var url = "/${year}/${month}/}";
			var url = window.location.protocol + "//" + window.location.host + "/" + year + "/" + month + "/";
			document.location.href=url;
    });
	$( '#manduca-archive-year-dropdown' ).change(function(){
		var year = $( '#manduca-archive-year-dropdown' ).val();
		var url = window.location.protocol + "//" + window.location.host +'/?manduca=ajax';
		jQuery.ajax({
		url: url,
		type : 'post',
		data : {
			action : 'archives',
			year: year,
			hash: manducaVariables.hash
		},
		success : function( response ) {
				$( '#manduca-archive-month-dropdown option').remove();
				$( '#manduca-archive-month-dropdown').append( response ).focus();
				
			}
		});
		
	});
	
    
    
//end of ($)functions
})( jQuery ); 


jQuery(document).ready(function($) {

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
     */
    // loading expand paragraphs
    // these are recommended settings by a11y experts. You may update to fulfill your needs, but be sure of what you’re doing.
    var attr_control = 'data-controls',
        attr_expanded = 'aria-expanded',
        attr_labelledby = 'data-labelledby',
        attr_hidden = 'data-hidden',
        $expandmore = $('.js-expandmore'),
        $body = $('#wrapper'),
        delay = 1500,
        hash = window.location.hash.replace("#", ""),
        multiexpandable = true;
        


    if ($expandmore.length) { // if there are at least one :)
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
  

});


/*
 **Cookie functions
 *
 *https://www.quirksmode.org/js/cookies.html
 *
 */
 function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}


/*
*   This content is licensed according to the W3C Software License at
*   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
*/
var MenubarItem = function (domNode, menuObj) {

  this.menu = menuObj;
  this.domNode = domNode;
  this.popupMenu = false;

  this.hasFocus = false;
  this.hasHover = false;

  this.isMenubarItem = true;

  this.keyCode = Object.freeze({
    'TAB': 9,
    'RETURN': 13,
    'ESC': 27,
    'SPACE': 32,
    'PAGEUP': 33,
    'PAGEDOWN': 34,
    'END': 35,
    'HOME': 36,
    'LEFT': 37,
    'UP': 38,
    'RIGHT': 39,
    'DOWN': 40
  });
};

MenubarItem.prototype.init = function () {
  this.domNode.tabIndex = -1;

  this.domNode.addEventListener('keydown', this.handleKeydown.bind(this));
  this.domNode.addEventListener('focus', this.handleFocus.bind(this));
  this.domNode.addEventListener('blur', this.handleBlur.bind(this));
  this.domNode.addEventListener('mouseover', this.handleMouseover.bind(this));
  this.domNode.addEventListener('mouseout', this.handleMouseout.bind(this));

  // Initialize pop up menus

  var nextElement = this.domNode.nextElementSibling;

  if (nextElement && nextElement.tagName === 'UL') {
    this.popupMenu = new PopupMenu(nextElement, this);
    this.popupMenu.init();
  }

};

MenubarItem.prototype.handleKeydown = function (event) {
  var tgt = event.currentTarget,
    char = event.key,
    flag = false,
    clickEvent;

  function isPrintableCharacter (str) {
    return str.length === 1 && str.match(/\S/);
  }

  switch (event.keyCode) {
    case this.keyCode.SPACE:
    case this.keyCode.RETURN:
    case this.keyCode.DOWN:
      if (this.popupMenu) {
        this.popupMenu.open();
        this.popupMenu.setFocusToFirstItem();
        flag = true;
      }
      break;

    case this.keyCode.LEFT:
      this.menu.setFocusToPreviousItem(this);
      flag = true;
      break;

    case this.keyCode.RIGHT:
      this.menu.setFocusToNextItem(this);
      flag = true;
      break;

    case this.keyCode.UP:
      if (this.popupMenu) {
        this.popupMenu.open();
        this.popupMenu.setFocusToLastItem();
        flag = true;
      }
      break;

    case this.keyCode.HOME:
    case this.keyCode.PAGEUP:
      this.menu.setFocusToFirstItem();
      flag = true;
      break;

    case this.keyCode.END:
    case this.keyCode.PAGEDOWN:
      this.menu.setFocusToLastItem();
      flag = true;
      break;

    case this.keyCode.TAB:
      this.popupMenu.close(true);
      break;

    case this.keyCode.ESC:
      this.popupMenu.close(true);
      break;

    default:
      if (isPrintableCharacter(char)) {
        this.menu.setFocusByFirstCharacter(this, char);
        flag = true;
      }
      break;
  }

  if (flag) {
    event.stopPropagation();
    event.preventDefault();
  }
};

MenubarItem.prototype.setExpanded = function (value) {
  if (value) {
    this.domNode.setAttribute('aria-expanded', 'true');
  }
  else {
    this.domNode.setAttribute('aria-expanded', 'false');
  }
};

MenubarItem.prototype.handleFocus = function (event) {
  this.menu.hasFocus = true;
};

MenubarItem.prototype.handleBlur = function (event) {
  this.menu.hasFocus = false;
};

MenubarItem.prototype.handleMouseover = function (event) {
  this.hasHover = true;
  this.popupMenu.open();
};

MenubarItem.prototype.handleMouseout = function (event) {
  this.hasHover = false;
  setTimeout(this.popupMenu.close.bind(this.popupMenu, false), 300);
};


/*
*   This content is licensed according to the W3C Software License at
*   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
*/

var Menubar = function (domNode) {
  var elementChildren,
    msgPrefix = 'Menubar constructor argument menubarNode ';

  // Check whether menubarNode is a DOM element
  if (!domNode instanceof Element) {
    throw new TypeError(msgPrefix + 'is not a DOM Element.');
  }

  // Check whether menubarNode has descendant elements
  if (domNode.childElementCount === 0) {
    throw new Error(msgPrefix + 'has no element children.');
  }

  // Check whether menubarNode has A elements
  e = domNode.firstElementChild;
  while (e) {
    var menubarItem = e.firstElementChild;
    if (e && menubarItem && menubarItem.tagName !== 'A') {
      throw new Error(msgPrefix + 'has child elements are not A elements.');
    }
    e = e.nextElementSibling;
  }

  this.isMenubar = true;

  this.domNode = domNode;

  this.menubarItems = []; // See Menubar init method
  this.firstChars = []; // See Menubar init method

  this.firstItem = null; // See Menubar init method
  this.lastItem = null; // See Menubar init method

  this.hasFocus = false; // See MenubarItem handleFocus, handleBlur
  this.hasHover = false; // See Menubar handleMouseover, handleMouseout
};

/*
*   @method Menubar.prototype.init
*
*   @desc
*       Adds ARIA role to the menubar node
*       Traverse menubar children for A elements to configure each A element as a ARIA menuitem
*       and populate menuitems array. Initialize firstItem and lastItem properties.
*/
Menubar.prototype.init = function () {
  var menubarItem, childElement, menuElement, textContent, numItems;


  // Traverse the element children of menubarNode: configure each with
  // menuitem role behavior and store reference in menuitems array.
  elem = this.domNode.firstElementChild;

  while (elem) {
    var menuElement = elem.firstElementChild;

    if (elem && menuElement && menuElement.tagName === 'A') {
      menubarItem = new MenubarItem(menuElement, this);
      menubarItem.init();
      this.menubarItems.push(menubarItem);
      textContent = menuElement.textContent.trim();
      this.firstChars.push(textContent.substring(0, 1).toLowerCase());
    }

    elem = elem.nextElementSibling;
  }

  // Use populated menuitems array to initialize firstItem and lastItem.
  numItems = this.menubarItems.length;
  if (numItems > 0) {
    this.firstItem = this.menubarItems[ 0 ];
    this.lastItem = this.menubarItems[ numItems - 1 ];
  }
  this.firstItem.domNode.tabIndex = 0;
};

/* FOCUS MANAGEMENT METHODS */

Menubar.prototype.setFocusToItem = function (newItem) {

  var flag = false;

  for (var i = 0; i < this.menubarItems.length; i++) {
    var mbi = this.menubarItems[i];

    if (mbi.domNode.tabIndex == 0) {
      flag = mbi.domNode.getAttribute('aria-expanded') === 'true';
    }

    mbi.domNode.tabIndex = -1;
    if (mbi.popupMenu) {
      mbi.popupMenu.close();
    }
  }

  newItem.domNode.focus();
  newItem.domNode.tabIndex = 0;

  if (flag && newItem.popupMenu) {
    newItem.popupMenu.open();
  }
};

Menubar.prototype.setFocusToFirstItem = function (flag) {
  this.setFocusToItem(this.firstItem);
};

Menubar.prototype.setFocusToLastItem = function (flag) {
  this.setFocusToItem(this.lastItem);
};

Menubar.prototype.setFocusToPreviousItem = function (currentItem) {
  var index;

  if (currentItem === this.firstItem) {
    newItem = this.lastItem;
  }
  else {
    index = this.menubarItems.indexOf(currentItem);
    newItem = this.menubarItems[ index - 1 ];
  }

  this.setFocusToItem(newItem);

};

Menubar.prototype.setFocusToNextItem = function (currentItem) {
  var index;

  if (currentItem === this.lastItem) {
    newItem = this.firstItem;
  }
  else {
    index = this.menubarItems.indexOf(currentItem);
    newItem = this.menubarItems[ index + 1 ];
  }

  this.setFocusToItem(newItem);

};

Menubar.prototype.setFocusByFirstCharacter = function (currentItem, char) {
  var start, index, char = char.toLowerCase();
  var flag = currentItem.domNode.getAttribute('aria-expanded') === 'true';

  // Get start index for search based on position of currentItem
  start = this.menubarItems.indexOf(currentItem) + 1;
  if (start === this.menubarItems.length) {
    start = 0;
  }

  // Check remaining slots in the menu
  index = this.getIndexFirstChars(start, char);

  // If not found in remaining slots, check from beginning
  if (index === -1) {
    index = this.getIndexFirstChars(0, char);
  }

  // If match was found...
  if (index > -1) {
    this.setFocusToItem(this.menubarItems[ index ]);
  }
};

Menubar.prototype.getIndexFirstChars = function (startIndex, char) {
  for (var i = startIndex; i < this.firstChars.length; i++) {
    if (char === this.firstChars[ i ]) {
      return i;
    }
  }
  return -1;
};

/*
*   This content is licensed according to the W3C Software License at
*   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
*/
var MenuItem = function (domNode, menuObj) {

  if (typeof popupObj !== 'object') {
    popupObj = false;
  }

  this.domNode = domNode;
  this.menu = menuObj;
  this.popupMenu = false;
  this.isMenubarItem = false;

  this.keyCode = Object.freeze({
    'TAB': 9,
    'RETURN': 13,
    'ESC': 27,
    'SPACE': 32,
    'PAGEUP': 33,
    'PAGEDOWN': 34,
    'END': 35,
    'HOME': 36,
    'LEFT': 37,
    'UP': 38,
    'RIGHT': 39,
    'DOWN': 40
  });
};

MenuItem.prototype.init = function () {
  this.domNode.tabIndex = -1;

  this.domNode.addEventListener('keydown', this.handleKeydown.bind(this));
  this.domNode.addEventListener('click', this.handleClick.bind(this));
  this.domNode.addEventListener('focus', this.handleFocus.bind(this));
  this.domNode.addEventListener('blur', this.handleBlur.bind(this));
  this.domNode.addEventListener('mouseover', this.handleMouseover.bind(this));
  this.domNode.addEventListener('mouseout', this.handleMouseout.bind(this));

  // Initialize flyout menu

  var nextElement = this.domNode.nextElementSibling;

  if (nextElement && nextElement.tagName === 'UL') {
    this.popupMenu = new PopupMenu(nextElement, this);
    this.popupMenu.init();
  }

};

MenuItem.prototype.isExpanded = function () {
  return this.domNode.getAttribute('aria-expanded') === 'true';
};

/* EVENT HANDLERS */

MenuItem.prototype.handleKeydown = function (event) {
  var tgt  = event.currentTarget,
    char = event.key,
    flag = false,
    clickEvent;

  function isPrintableCharacter (str) {
    return str.length === 1 && str.match(/\S/);
  }

  switch (event.keyCode) {
    case this.keyCode.SPACE:
    case this.keyCode.RETURN:
      if (this.popupMenu) {
        this.popupMenu.open();
        this.popupMenu.setFocusToFirstItem();
      }
      else {

        // Create simulated mouse event to mimic the behavior of ATs
        // and let the event handler handleClick do the housekeeping.
        try {
          clickEvent = new MouseEvent('click', {
            'view': window,
            'bubbles': true,
            'cancelable': true
          });
        }
        catch (err) {
          if (document.createEvent) {
            // DOM Level 3 for IE 9+
            clickEvent = document.createEvent('MouseEvents');
            clickEvent.initEvent('click', true, true);
          }
        }
        tgt.dispatchEvent(clickEvent);
      }

      flag = true;
      break;

    case this.keyCode.UP:
      this.menu.setFocusToPreviousItem(this);
      flag = true;
      break;

    case this.keyCode.DOWN:
      this.menu.setFocusToNextItem(this);
      flag = true;
      break;

    case this.keyCode.LEFT:
      this.menu.setFocusToController('previous', true);
      this.menu.close(true);
      flag = true;
      break;

    case this.keyCode.RIGHT:
      if (this.popupMenu) {
        this.popupMenu.open();
        this.popupMenu.setFocusToFirstItem();
      }
      else {
        this.menu.setFocusToController('next', true);
        this.menu.close(true);
      }
      flag = true;
      break;

    case this.keyCode.HOME:
    case this.keyCode.PAGEUP:
      this.menu.setFocusToFirstItem();
      flag = true;
      break;

    case this.keyCode.END:
    case this.keyCode.PAGEDOWN:
      this.menu.setFocusToLastItem();
      flag = true;
      break;

    case this.keyCode.ESC:
      this.menu.setFocusToController();
      this.menu.close(true);
      flag = true;
      break;

    case this.keyCode.TAB:
      this.menu.setFocusToController();
      break;

    default:
      if (isPrintableCharacter(char)) {
        this.menu.setFocusByFirstCharacter(this, char);
        flag = true;
      }
      break;
  }

  if (flag) {
    event.stopPropagation();
    event.preventDefault();
  }
};

MenuItem.prototype.setExpanded = function (value) {
  if (value) {
    this.domNode.setAttribute('aria-expanded', 'true');
  }
  else {
    this.domNode.setAttribute('aria-expanded', 'false');
  }
};

MenuItem.prototype.handleClick = function (event) {
  this.menu.setFocusToController();
  this.menu.close(true);
};

MenuItem.prototype.handleFocus = function (event) {
  this.menu.hasFocus = true;
};

MenuItem.prototype.handleBlur = function (event) {
  this.menu.hasFocus = false;
  setTimeout(this.menu.close.bind(this.menu, false), 300);
};

MenuItem.prototype.handleMouseover = function (event) {
  this.menu.hasHover = true;
  this.menu.open();
  if (this.popupMenu) {
    this.popupMenu.hasHover = true;
    this.popupMenu.open();
  }
};

MenuItem.prototype.handleMouseout = function (event) {
  if (this.popupMenu) {
    this.popupMenu.hasHover = false;
    this.popupMenu.close(true);
  }

  this.menu.hasHover = false;
  setTimeout(this.menu.close.bind(this.menu, false), 300);
};

/*
*   This content is licensed according to the W3C Software License at
*   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
*/
var PopupMenu = function (domNode, controllerObj) {
  var elementChildren,
    msgPrefix = 'PopupMenu constructor argument domNode ';

  // Check whether domNode is a DOM element
  if (!domNode instanceof Element) {
    throw new TypeError(msgPrefix + 'is not a DOM Element.');
  }
  // Check whether domNode has child elements
  if (domNode.childElementCount === 0) {
    throw new Error(msgPrefix + 'has no element children.');
  }
  // Check whether domNode descendant elements have A elements
  var childElement = domNode.firstElementChild;
  while (childElement) {
    var menuitem = childElement.firstElementChild;
    if (menuitem && menuitem === 'A') {
      throw new Error(msgPrefix + 'has descendant elements that are not A elements.');
    }
    childElement = childElement.nextElementSibling;
  }

  this.isMenubar = false;

  this.domNode    = domNode;
  this.controller = controllerObj;

  this.menuitems = []; // See PopupMenu init method
  this.firstChars = []; // See PopupMenu init method

  this.firstItem = null; // See PopupMenu init method
  this.lastItem = null; // See PopupMenu init method

  this.hasFocus = false; // See MenuItem handleFocus, handleBlur
  this.hasHover = false; // See PopupMenu handleMouseover, handleMouseout
};

/*
*   @method PopupMenu.prototype.init
*
*   @desc
*       Add domNode event listeners for mouseover and mouseout. Traverse
*       domNode children to configure each menuitem and populate menuitems
*       array. Initialize firstItem and lastItem properties.
*/
PopupMenu.prototype.init = function () {
  var childElement, menuElement, menuItem, textContent, numItems, label;

  // Configure the domNode itself

  this.domNode.addEventListener('mouseover', this.handleMouseover.bind(this));
  this.domNode.addEventListener('mouseout', this.handleMouseout.bind(this));

  // Traverse the element children of domNode: configure each with
  // menuitem role behavior and store reference in menuitems array.
  childElement = this.domNode.firstElementChild;

  while (childElement) {
    menuElement = childElement.firstElementChild;

    if (menuElement && menuElement.tagName === 'A') {
      menuItem = new MenuItem(menuElement, this);
      menuItem.init();
      this.menuitems.push(menuItem);
      textContent = menuElement.textContent.trim();
      this.firstChars.push(textContent.substring(0, 1).toLowerCase());
    }
    childElement = childElement.nextElementSibling;
  }

  // Use populated menuitems array to initialize firstItem and lastItem.
  numItems = this.menuitems.length;
  if (numItems > 0) {
    this.firstItem = this.menuitems[ 0 ];
    this.lastItem = this.menuitems[ numItems - 1 ];
  }
};

/* EVENT HANDLERS */

PopupMenu.prototype.handleMouseover = function (event) {
  this.hasHover = true;
};

PopupMenu.prototype.handleMouseout = function (event) {
  this.hasHover = false;
  setTimeout(this.close.bind(this, false), 1);
};

/* FOCUS MANAGEMENT METHODS */

PopupMenu.prototype.setFocusToController = function (command, flag) {

  if (typeof command !== 'string') {
    command = '';
  }

  function setFocusToMenubarItem (controller, close) {
    while (controller) {
      if (controller.isMenubarItem) {
        controller.domNode.focus();
        return controller;
      }
      else {
        if (close) {
          controller.menu.close(true);
        }
        controller.hasFocus = false;
      }
      controller = controller.menu.controller;
    }
    return false;
  }

  if (command === '') {
    if (this.controller && this.controller.domNode) {
      this.controller.domNode.focus();
    }
    return;
  }

  if (!this.controller.isMenubarItem) {
    this.controller.domNode.focus();
    this.close();

    if (command === 'next') {
      var menubarItem = setFocusToMenubarItem(this.controller, false);
      if (menubarItem) {
        menubarItem.menu.setFocusToNextItem(menubarItem, flag);
      }
    }
  }
  else {
    if (command === 'previous') {
      this.controller.menu.setFocusToPreviousItem(this.controller, flag);
    }
    else if (command === 'next') {
      this.controller.menu.setFocusToNextItem(this.controller, flag);
    }
  }

};

PopupMenu.prototype.setFocusToFirstItem = function () {
  this.firstItem.domNode.focus();
};

PopupMenu.prototype.setFocusToLastItem = function () {
  this.lastItem.domNode.focus();
};

PopupMenu.prototype.setFocusToPreviousItem = function (currentItem) {
  var index;

  if (currentItem === this.firstItem) {
    this.lastItem.domNode.focus();
  }
  else {
    index = this.menuitems.indexOf(currentItem);
    this.menuitems[ index - 1 ].domNode.focus();
  }
};

PopupMenu.prototype.setFocusToNextItem = function (currentItem) {
  var index;

  if (currentItem === this.lastItem) {
    this.firstItem.domNode.focus();
  }
  else {
    index = this.menuitems.indexOf(currentItem);
    this.menuitems[ index + 1 ].domNode.focus();
  }
};

PopupMenu.prototype.setFocusByFirstCharacter = function (currentItem, char) {
  var start, index, char = char.toLowerCase();

  // Get start index for search based on position of currentItem
  start = this.menuitems.indexOf(currentItem) + 1;
  if (start === this.menuitems.length) {
    start = 0;
  }

  // Check remaining slots in the menu
  index = this.getIndexFirstChars(start, char);

  // If not found in remaining slots, check from beginning
  if (index === -1) {
    index = this.getIndexFirstChars(0, char);
  }

  // If match was found...
  if (index > -1) {
    this.menuitems[ index ].domNode.focus();
  }
};

PopupMenu.prototype.getIndexFirstChars = function (startIndex, char) {
  for (var i = startIndex; i < this.firstChars.length; i++) {
    if (char === this.firstChars[ i ]) {
      return i;
    }
  }
  return -1;
};

/* MENU DISPLAY METHODS */

PopupMenu.prototype.open = function () {
  // Get position and bounding rectangle of controller object's DOM node
  var rect = this.controller.domNode.getBoundingClientRect();

  // Set CSS properties
  if (!this.controller.isMenubarItem) {
    this.domNode.parentNode.style.position = 'relative';
    this.domNode.style.display = 'block';
    this.domNode.style.position = 'absolute';
    this.domNode.style.left = rect.width + 'px';
    this.domNode.style.zIndex = 100;
  }
  else {
    this.domNode.style.display = 'block';
    this.domNode.style.position = 'absolute';
    this.domNode.style.top = (rect.height - 1) + 'px';
    this.domNode.style.zIndex = 100;
  }

  this.controller.setExpanded(true);

};

PopupMenu.prototype.close = function (force) {

  var controllerHasHover = this.controller.hasHover;

  var hasFocus = this.hasFocus;

  for (var i = 0; i < this.menuitems.length; i++) {
    var mi = this.menuitems[i];
    if (mi.popupMenu) {
      hasFocus = hasFocus | mi.popupMenu.hasFocus;
    }
  }

  if (!this.controller.isMenubarItem) {
    controllerHasHover = false;
  }

  if (force || (!hasFocus && !this.hasHover && !controllerHasHover)) {
    this.domNode.style.display = 'none';
    this.domNode.style.zIndex = 0;
    this.controller.setExpanded(false);
  }
};


