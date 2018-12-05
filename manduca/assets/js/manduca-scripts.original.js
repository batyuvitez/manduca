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
 * @param      : manducaFocusSnailColour.red
 *               manducaFocusSnailColour.green
 *               manducaFocusSnailColour.blue
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
			<stop id="focus-snail_start" offset="0%" stop-color="rgb(' + manducaFocusSnailColour.red +', ' +manducaFocusSnailColour.green + ', ' + manducaFocusSnailColour.blue + ')" stop-opacity="0"/>\
			<stop id="focus-snail_middle" offset="80%" stop-color="rgb(' + manducaFocusSnailColour.red +', ' +manducaFocusSnailColour.green + ', ' + manducaFocusSnailColour.blue + ')" stop-opacity="0.8"/>\
			<stop id="focus-snail_end" offset="100%" stop-color="rgb(' + manducaFocusSnailColour.red +', ' +manducaFocusSnailColour.green + ', ' + manducaFocusSnailColour.blue + ')" stop-opacity="0"/>\
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
	return Date.now() - keyDownTime < 42
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

    function initMainNavigation( container ) {

		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
			.append( manducaScreenReaderText.icon )
			.append( $( '<span />', { 'class': 'screen-reader-text', text: manducaScreenReaderText.expand }) );

		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this = $( this ),
				screenReaderSpan = _this.find( '.screen-reader-text' );

			e.preventDefault();
			_this.toggleClass( 'toggled-on' );
			_this.next( '.children, .sub-nav' ).toggleClass( 'toggled-on' );

			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

			screenReaderSpan.text( screenReaderSpan.text() === manducaScreenReaderText.expand ? manducaScreenReaderText.collapse : manducaScreenReaderText.expand );
		});
	}

	initMainNavigation( $( '.main-navigation' ) );

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

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	(function() {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}

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
      
      var contrastType=readCookie( "contrastType" )
      if ( contrastType ) {
          $('body').addClass( contrastType );
       }
       else {
          $('body').addClass( "high-contrast-0" );
       }
   
      
      var fontType=readCookie( "fontType" )
         if ( fontType ) {
             $('body').addClass( fontType );
          }
          else {
             $('body').addClass( "font-type-0" );
          }
          
              
      var fontSize=readCookie( "fontSize" )
         if ( fontSize ) {
             $('body').addClass( fontSize );
          }
          else {
             $('body').addClass( "font-size-0" );
          }
      
   
      /*
       * Behaviour of open toolbar button
       * */
   
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
    });
    
    
 
   /*
    *Toolbar-buttons behaviour
    **/
 
    //change font size
    $('.change-font-size').click(function () {
         var fontSize = $(this).attr('data-zoom');
         var CookieDate = new Date;

         $('body').removeClass('font-size-0 font-size-1 font-size-2 font-size-3');
         $('body').addClass(fontSize);
         CookieDate.setFullYear(CookieDate.getFullYear() + 10);
         document.cookie = 'fontSize=' + fontSize + '; expires=' + CookieDate.toGMTString() + '; path=/';
     });
     
      
      
    ///change contrast
    $('.high-contrast').click(function () {
        var contrastType = $(this).attr('data-contrast-type');
        var CookieDate = new Date;

        $('body').removeClass('high-contrast-1 high-contrast-2 high-contrast-3 high-contrast-0');
        $('body').addClass(contrastType);
        CookieDate.setFullYear(CookieDate.getFullYear() + 10);
        document.cookie = 'contrastType=' + contrastType + '; expires=' + CookieDate.toGMTString() + '; path=/';
    });
    
    //change font family
    $('.change-font-type').click(function () {
        var fontType= $(this).attr('data-font-type');
        var CookieDate = new Date;

        $('body').removeClass('font-type-1 font-type-2 font-type-0');
        $('body').addClass(fontType);
        CookieDate.setFullYear(CookieDate.getFullYear() + 10);
        document.cookie = 'fontType=' + fontType + '; expires=' + CookieDate.toGMTString() + '; path=/';
    });
    
    
//end of ($)functions
})( jQuery ); 


/*
 **Cookie functions.
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
 *
 * Smart Underline
 *
 * https://github.com/EagerIO/SmartUnderline
 *
 * Licence: MIT
 *
 * built ind to Manduca since 17.9.4
 */
 

function manducaUnderline() {
  var PHI, backgroundPositionYCache, calculateBaselineYRatio, calculateTextHighestY, calculateTypeMetrics, clearCanvas, containerIdAttrName, containsAnyNonInlineElements, containsInvalidElements, countParentContainers, destroy, fontAvailable, getBackgroundColor, getBackgroundColorNode, getFirstAvailableFont, getLinkColor, getUnderlineBackgroundPositionY, hasValidLinkContent, init, initLink, initLinkOnHover, isTransparent, isUnderlined, linkAlwysAttrName, linkBgPosAttrName, linkColorAttrName, linkContainers, linkHoverAttrName, linkLargeAttrName, linkSmallAttrName, performanceTimes, renderStyles, selectionColor, sortContainersForCSSPrecendence, styleNode, time, uniqueLinkContainerID;

  window.SmartUnderline = {
    init: function() {},
    destroy: function() {}
  };

  if (!(window['getComputedStyle'] && document.documentElement.getAttribute)) {
    return;
  }

  PHI = 1.618034;

  selectionColor = '#b4d5fe';

  linkColorAttrName = 'data-smart-underline-link-color';

  linkSmallAttrName = 'data-smart-underline-link-small';

  linkLargeAttrName = 'data-smart-underline-link-large';

  linkAlwysAttrName = 'data-smart-underline-link-always';

  linkBgPosAttrName = 'data-smart-underline-link-background-position';

  linkHoverAttrName = 'data-smart-underline-link-hover';

  containerIdAttrName = 'data-smart-underline-container-id';

  performanceTimes = [];

  time = function() {
    return +(new Date);
  };

  linkContainers = {};

  uniqueLinkContainerID = (function() {
    var id;
    id = 0;
    return function() {
      return id += 1;
    };
  })();

  clearCanvas = function(canvas, context) {
    return context.clearRect(0, 0, canvas.width, canvas.height);
  };

  calculateTextHighestY = function(text, canvas, context) {
    var alpha, highestY, i, j, pixelData, r, ref, ref1, textWidth, x, y;
    clearCanvas(canvas, context);
    context.fillStyle = 'red';
    textWidth = context.measureText(text).width;
    context.fillText(text, 0, 0);
    highestY = void 0;
    for (x = i = 0, ref = textWidth; 0 <= ref ? i <= ref : i >= ref; x = 0 <= ref ? ++i : --i) {
      for (y = j = 0, ref1 = canvas.height; 0 <= ref1 ? j <= ref1 : j >= ref1; y = 0 <= ref1 ? ++j : --j) {
        pixelData = context.getImageData(x, y, x + 1, y + 1);
        r = pixelData.data[0];
        alpha = pixelData.data[3];
        if (r === 255 && alpha > 50) {
          if (!highestY) {
            highestY = y;
          }
          if (y > highestY) {
            highestY = y;
          }
        }
      }
    }
    clearCanvas(canvas, context);
    return highestY;
  };

  calculateTypeMetrics = function(computedStyle) {
    var baselineY, canvas, context, descenderHeight, gLowestPixel;
    canvas = document.createElement('canvas');
    context = canvas.getContext('2d');
    canvas.height = canvas.width = 2 * parseInt(computedStyle.fontSize, 10);
    context.textBaseline = 'top';
    context.textAlign = 'start';
    context.fontStretch = 1;
    context.angle = 0;
    context.font = computedStyle.fontVariant + " " + computedStyle.fontStyle + " " + computedStyle.fontWeight + " " + computedStyle.fontSize + "/" + computedStyle.lineHeight + " " + computedStyle.fontFamily;
    baselineY = calculateTextHighestY('I', canvas, context);
    gLowestPixel = calculateTextHighestY('g', canvas, context);
    descenderHeight = gLowestPixel - baselineY;
    return {
      baselineY: baselineY,
      descenderHeight: descenderHeight
    };
  };

  calculateBaselineYRatio = function(node) {
    var baselinePositionY, baselineYRatio, height, large, largeRect, small, smallRect, test;
    test = document.createElement('div');
    test.style.display = 'block';
    test.style.position = 'absolute';
    test.style.bottom = 0;
    test.style.right = 0;
    test.style.width = 0;
    test.style.height = 0;
    test.style.margin = 0;
    test.style.padding = 0;
    test.style.visibility = 'hidden';
    test.style.overflow = 'hidden';
    test.style.wordWrap = 'normal';
    test.style.whiteSpace = 'nowrap';
    small = document.createElement('span');
    large = document.createElement('span');
    small.style.display = 'inline';
    large.style.display = 'inline';
    small.style.fontSize = '0px';
    large.style.fontSize = '2000px';
    small.innerHTML = 'X';
    large.innerHTML = 'X';
    test.appendChild(small);
    test.appendChild(large);
    node.appendChild(test);
    smallRect = small.getBoundingClientRect();
    largeRect = large.getBoundingClientRect();
    node.removeChild(test);
    baselinePositionY = smallRect.top - largeRect.top;
    height = largeRect.height;
    return baselineYRatio = Math.abs(baselinePositionY / height);
  };

  backgroundPositionYCache = {};

  getFirstAvailableFont = function(fontFamily) {
    var font, fonts, i, len;
    fonts = fontFamily.split(',');
    for (i = 0, len = fonts.length; i < len; i++) {
      font = fonts[i];
      if (fontAvailable(font)) {
        return font;
      }
    }
    return false;
  };

  fontAvailable = function(font) {
    var baselineSize, canvas, context, newSize, text;
    canvas = document.createElement('canvas');
    context = canvas.getContext('2d');
    text = 'abcdefghijklmnopqrstuvwxyz0123456789';
    context.font = '72px monospace';
    baselineSize = context.measureText(text).width;
    context.font = "72px " + font + ", monospace";
    newSize = context.measureText(text).width;
    if (newSize === baselineSize) {
      return false;
    }
    return true;
  };

  getUnderlineBackgroundPositionY = function(node) {
    var adjustment, backgroundPositionY, backgroundPositionYPercent, baselineY, baselineYRatio, cache, cacheKey, clientRects, computedStyle, descenderHeight, descenderY, firstAvailableFont, fontSizeInt, minimumCloseness, ref, textHeight;
    computedStyle = getComputedStyle(node);
    firstAvailableFont = getFirstAvailableFont(computedStyle.fontFamily);
    if (!firstAvailableFont) {
      cacheKey = "" + (Math.random());
    } else {
      cacheKey = "font:" + firstAvailableFont + "size:" + computedStyle.fontSize + "weight:" + computedStyle.fontWeight;
    }
    cache = backgroundPositionYCache[cacheKey];
    if (cache) {
      return cache;
    }
    ref = calculateTypeMetrics(computedStyle), baselineY = ref.baselineY, descenderHeight = ref.descenderHeight;
    clientRects = node.getClientRects();
    if (!(clientRects != null ? clientRects.length : void 0)) {
      return;
    }
    adjustment = 1;
    textHeight = clientRects[0].height - adjustment;
    if (-1 < navigator.userAgent.toLowerCase().indexOf('firefox')) {
      adjustment = .98;
      baselineYRatio = calculateBaselineYRatio(node);
      baselineY = baselineYRatio * textHeight * adjustment;
    }
    descenderY = baselineY + descenderHeight;
    fontSizeInt = parseInt(computedStyle.fontSize, 10);
    minimumCloseness = 3;
    backgroundPositionY = baselineY + Math.max(minimumCloseness, descenderHeight / PHI);
    if (descenderHeight === 4) {
      backgroundPositionY = descenderY - 1;
    }
    if (descenderHeight === 3) {
      backgroundPositionY = descenderY;
    }
    backgroundPositionYPercent = Math.round(100 * backgroundPositionY / textHeight);
    if (descenderHeight > 2 && fontSizeInt > 10 && backgroundPositionYPercent <= 100) {
      backgroundPositionYCache[cacheKey] = backgroundPositionYPercent;
      return backgroundPositionYPercent;
    }
  };

  isTransparent = function(color) {
    var alpha, rgbaAlphaMatch;
    if (color === 'transparent' || color === 'rgba(0, 0, 0, 0)') {
      return true;
    }
    rgbaAlphaMatch = color.match(/^rgba\(.*,(.+)\)/i);
    if ((rgbaAlphaMatch != null ? rgbaAlphaMatch.length : void 0) === 2) {
      alpha = parseFloat(rgbaAlphaMatch[1]);
      if (alpha < .0001) {
        return true;
      }
    }
    return false;
  };

  getBackgroundColorNode = function(node) {
    var backgroundColor, computedStyle, parentNode, reachedRootNode;
    computedStyle = getComputedStyle(node);
    backgroundColor = computedStyle.backgroundColor;
    parentNode = node.parentNode;
    reachedRootNode = !parentNode || parentNode === document.documentElement || parentNode === node;
    if (computedStyle.backgroundImage !== 'none') {
      return null;
    }
    if (isTransparent(backgroundColor)) {
      if (reachedRootNode) {
        return node.parentNode || node;
      } else {
        return getBackgroundColorNode(parentNode);
      }
    } else {
      return node;
    }
  };

  hasValidLinkContent = function(node) {
    return containsInvalidElements(node) || containsAnyNonInlineElements(node);
  };

  containsInvalidElements = function(node) {
    var child, i, len, ref, ref1, ref2;
    ref = node.children;
    for (i = 0, len = ref.length; i < len; i++) {
      child = ref[i];
      if ((ref1 = (ref2 = child.tagName) != null ? ref2.toLowerCase() : void 0) === 'img' || ref1 === 'video' || ref1 === 'canvas' || ref1 === 'embed' || ref1 === 'object' || ref1 === 'iframe') {
        return true;
      }
      return containsInvalidElements(child);
    }
    return false;
  };

  containsAnyNonInlineElements = function(node) {
    var child, i, len, ref, style;
    ref = node.children;
    for (i = 0, len = ref.length; i < len; i++) {
      child = ref[i];
      style = getComputedStyle(child);
      if (style.display !== 'inline') {
        return true;
      }
      return containsAnyNonInlineElements(child);
    }
    return false;
  };

  getBackgroundColor = function(node) {
    var backgroundColor;
    backgroundColor = getComputedStyle(node).backgroundColor;
    if (node === document.documentElement && isTransparent(backgroundColor)) {
      return 'rgb(255, 255, 255)';
    } else {
      return backgroundColor;
    }
  };

  getLinkColor = function(node) {
    return getComputedStyle(node).color;
  };

  styleNode = document.createElement('style');

  countParentContainers = function(node, count) {
    var parentNode, reachedRootNode;
    if (count == null) {
      count = 0;
    }
    parentNode = node.parentNode;
    reachedRootNode = !parentNode || parentNode === document || parentNode === node;
    if (reachedRootNode) {
      return count;
    } else {
      if (parentNode.hasAttribute(containerIdAttrName)) {
        count += 1;
      }
      return count + countParentContainers(parentNode);
    }
  };

  sortContainersForCSSPrecendence = function(containers) {
    var container, id, sorted;
    sorted = [];
    for (id in containers) {
      container = containers[id];
      container.depth = countParentContainers(container.container);
      sorted.push(container);
    }
    sorted.sort(function(a, b) {
      if (a.depth < b.depth) {
        return -1;
      }
      if (a.depth > b.depth) {
        return 1;
      }
      return 0;
    });
    return sorted;
  };

  isUnderlined = function(style) {
    var i, len, property, ref, ref1;
    ref = ['textDecorationLine', 'textDecoration'];
    for (i = 0, len = ref.length; i < len; i++) {
      property = ref[i];
      if ((ref1 = style[property]) != null ? ref1.match(/\bunderline\b/) : void 0) {
        return true;
      }
    }
    return false;
  };

  initLink = function(link) {
    var backgroundPositionY, container, fontSize, id, style;
    style = getComputedStyle(link);
    fontSize = parseFloat(style.fontSize);
    if (isUnderlined(style) && style.display === 'inline' && fontSize >= 10 && !hasValidLinkContent(link)) {
      container = getBackgroundColorNode(link);
      if (container) {
        backgroundPositionY = getUnderlineBackgroundPositionY(link);
        if (backgroundPositionY) {
          link.setAttribute(linkColorAttrName, getLinkColor(link));
          link.setAttribute(linkBgPosAttrName, backgroundPositionY);
          id = container.getAttribute(containerIdAttrName);
          if (id) {
            linkContainers[id].links.push(link);
          } else {
            id = uniqueLinkContainerID();
            container.setAttribute(containerIdAttrName, id);
            linkContainers[id] = {
              id: id,
              container: container,
              links: [link]
            };
          }
          return true;
        }
      }
    }
    return false;
  };

  renderStyles = function() {
    var backgroundColor, backgroundPositionY, color, container, containersWithPrecedence, i, j, len, len1, link, linkBackgroundPositionYs, linkColors, linkSelector, ref, styles;
    styles = '';
    containersWithPrecedence = sortContainersForCSSPrecendence(linkContainers);
    linkBackgroundPositionYs = {};
    for (i = 0, len = containersWithPrecedence.length; i < len; i++) {
      container = containersWithPrecedence[i];
      linkColors = {};
      ref = container.links;
      for (j = 0, len1 = ref.length; j < len1; j++) {
        link = ref[j];
        linkColors[getLinkColor(link)] = true;
        linkBackgroundPositionYs[getUnderlineBackgroundPositionY(link)] = true;
      }
      backgroundColor = getBackgroundColor(container.container);
      for (color in linkColors) {
        linkSelector = function(modifier) {
          if (modifier == null) {
            modifier = '';
          }
          return "[" + containerIdAttrName + "=\"" + container.id + "\"] a[" + linkColorAttrName + "=\"" + color + "\"][" + linkAlwysAttrName + "]" + modifier + ",\n[" + containerIdAttrName + "=\"" + container.id + "\"] a[" + linkColorAttrName + "=\"" + color + "\"][" + linkHoverAttrName + "]" + modifier + ":hover";
        };
        styles += (linkSelector()) + ", " + (linkSelector(':visited')) + " {\n  color: " + color + ";\n  text-decoration: none !important;\n  text-shadow: 0.03em 0 " + backgroundColor + ", -0.03em 0 " + backgroundColor + ", 0 0.03em " + backgroundColor + ", 0 -0.03em " + backgroundColor + ", 0.06em 0 " + backgroundColor + ", -0.06em 0 " + backgroundColor + ", 0.09em 0 " + backgroundColor + ", -0.09em 0 " + backgroundColor + ", 0.12em 0 " + backgroundColor + ", -0.12em 0 " + backgroundColor + ", 0.15em 0 " + backgroundColor + ", -0.15em 0 " + backgroundColor + ";\n  background-color: transparent;\n  background-image: -webkit-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -webkit-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -webkit-linear-gradient(" + color + ", " + color + ");\n  background-image: -moz-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -moz-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -moz-linear-gradient(" + color + ", " + color + ");\n  background-image: -o-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -o-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -o-linear-gradient(" + color + ", " + color + ");\n  background-image: -ms-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -ms-linear-gradient(" + backgroundColor + ", " + backgroundColor + "), -ms-linear-gradient(" + color + ", " + color + ");\n  background-image: linear-gradient(" + backgroundColor + ", " + backgroundColor + "), linear-gradient(" + backgroundColor + ", " + backgroundColor + "), linear-gradient(" + color + ", " + color + ");\n  -webkit-background-size: 0.05em 1px, 0.05em 1px, 1px 1px;\n  -moz-background-size: 0.05em 1px, 0.05em 1px, 1px 1px;\n  background-size: 0.05em 1px, 0.05em 1px, 1px 1px;\n  background-repeat: no-repeat, no-repeat, repeat-x;\n}\n\n" + (linkSelector('::selection')) + " {\n  text-shadow: 0.03em 0 " + selectionColor + ", -0.03em 0 " + selectionColor + ", 0 0.03em " + selectionColor + ", 0 -0.03em " + selectionColor + ", 0.06em 0 " + selectionColor + ", -0.06em 0 " + selectionColor + ", 0.09em 0 " + selectionColor + ", -0.09em 0 " + selectionColor + ", 0.12em 0 " + selectionColor + ", -0.12em 0 " + selectionColor + ", 0.15em 0 " + selectionColor + ", -0.15em 0 " + selectionColor + ";\n  background: " + selectionColor + ";\n}\n\n" + (linkSelector('::-moz-selection')) + " {\n  text-shadow: 0.03em 0 " + selectionColor + ", -0.03em 0 " + selectionColor + ", 0 0.03em " + selectionColor + ", 0 -0.03em " + selectionColor + ", 0.06em 0 " + selectionColor + ", -0.06em 0 " + selectionColor + ", 0.09em 0 " + selectionColor + ", -0.09em 0 " + selectionColor + ", 0.12em 0 " + selectionColor + ", -0.12em 0 " + selectionColor + ", 0.15em 0 " + selectionColor + ", -0.15em 0 " + selectionColor + ";\n  background: " + selectionColor + ";\n}";
      }
    }
    for (backgroundPositionY in linkBackgroundPositionYs) {
      styles += "a[" + linkBgPosAttrName + "=\"" + backgroundPositionY + "\"] {\n  background-position: 0% " + backgroundPositionY + "%, 100% " + backgroundPositionY + "%, 0% " + backgroundPositionY + "%;\n}";
    }
    return styleNode.innerHTML = styles;
  };

  initLinkOnHover = function() {
    var alreadyMadeSmart, link, madeSmart;
    link = this;
    alreadyMadeSmart = link.hasAttribute(linkHoverAttrName);
    if (!alreadyMadeSmart) {
      madeSmart = initLink(link);
      if (madeSmart) {
        link.setAttribute(linkHoverAttrName, '');
        return renderStyles();
      }
    }
  };

  init = function(options) {
    var i, len, link, links, madeSmart, startTime;
    startTime = time();
    links = document.querySelectorAll((options.location ? options.location + ' ' : '') + "a");
    if (!links.length) {
      return;
    }
    linkContainers = {};
    for (i = 0, len = links.length; i < len; i++) {
      link = links[i];
      madeSmart = initLink(link);
      if (madeSmart) {
        link.setAttribute(linkAlwysAttrName, '');
      } else {
        link.removeEventListener('mouseover', initLinkOnHover);
        link.addEventListener('mouseover', initLinkOnHover);
      }
    }
    renderStyles();
    document.body.appendChild(styleNode);
    return performanceTimes.push(time() - startTime);
  };

  destroy = function() {
    var attribute, i, len, ref, ref1, results;
    if ((ref = styleNode.parentNode) != null) {
      ref.removeChild(styleNode);
    }
    Array.prototype.forEach.call(document.querySelectorAll("[" + linkHoverAttrName + "]"), function(node) {
      return node.removeEventListener(initLinkOnHover);
    });
    ref1 = [linkColorAttrName, linkSmallAttrName, linkLargeAttrName, linkAlwysAttrName, linkHoverAttrName, containerIdAttrName];
    results = [];
    for (i = 0, len = ref1.length; i < len; i++) {
      attribute = ref1[i];
      results.push(Array.prototype.forEach.call(document.querySelectorAll("[" + attribute + "]"), function(node) {
        return node.removeAttribute(attribute);
      }));
    }
    return results;
  };

  window.SmartUnderline = {
    init: function(options) {
      if (options == null) {
        options = {};
      }
      if (document.readyState === 'loading') {
        window.addEventListener('DOMContentLoaded', function() {
          return init(options);
        });
        return window.addEventListener('load', function() {
          destroy();
          return init(options);
        });
      } else {
        destroy();
        return init(options);
      }
    },
    destroy: function() {
      return destroy();
    },
    performanceTimes: function() {
      return performanceTimes;
    }
  };
SmartUnderline.init({
            'location': ''
        })
  
}


/*
 * Activate smart underline function in all browser except Firefox
 *
 * This prevent Firefox to apply it. This is good, since firefox has a bug, and cannot handle this script. 
 *
 * &since 17.9.16
 * 
 * */
var isFirefox = document.getElementsByClassName('gecko');
var isHighContrast1 = document.getElementsByClassName('high-contrast-1');
var isHighContrast2 = document.getElementsByClassName('high-contrast-2');
var isHighContrast3 = document.getElementsByClassName('high-contrast-3');
if ( isFirefox.length !=1 && isHighContrast1.length !=1 && isHighContrast2.length != 1 ) {
      manducaUnderline.call(this); 
}