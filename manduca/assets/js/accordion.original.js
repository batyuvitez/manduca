/**
 * Accessible Hide-show system- collapsed paragraph
 * Prepare page for usage.
 *
 * @see:page-templates:accordion.php
 *
 * 
 
 */
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
        Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)
        Source code is available at https://github.com/batyuvitez/manduca

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/


(function($) {
    
        //Wrap all elements to be preparing for accordion
        $( manducaAccordionArgs.selector ).each(function() { 
         $(this).nextUntil( manducaAccordionArgs.selector ).wrapAll('<div class="accordion-body" />');
        });
        
        // Inital values of the collapsed items.
        $(".accordion-body").addClass( "collapsed" );
        $( manducaAccordionArgs.selector ).addClass( "collapsed" )
                                .prepend( manducaAccordionArgs.icon );
                                
        var notCollapsed= $('.accordion-body > '+ manducaAccordionArgs.skip);
        notCollapsed.parent().after(notCollapsed);
        
        // Click 
         $(  manducaAccordionArgs.selector ).click(function(){
            
            // If svg or use is clicked, the clas should be added alwayst to h2
            if( event.target.tagName.toLowerCase() === 'svg' ) {
                accordionHeader = $( event.target ).parent();
            }
            
            if( event.target.tagName.toLowerCase() ===  manducaAccordionArgs.header) {
                accordionHeader = $( event.target );
            }
            var accordionBody = accordionHeader.next();
                
            if ( accordionBody.hasClass( 'collapsed') ) {
                accordionBody.addClass('expanded');
                accordionBody.removeClass('collapsed');
                accordionHeader.addClass('expanded');
                accordionHeader.removeClass('collapsed');
            }
            else {
                accordionBody.addClass('collapsed');
                accordionBody.removeClass('expanded');
                accordionHeader.addClass('collapsed');
                accordionHeader.removeClass('expanded');
            }
            
            event.preventDefault();
         });
  
})(jQuery);

