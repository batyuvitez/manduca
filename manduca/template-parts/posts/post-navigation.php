<?php
/*
 * Post navigation in archive pages, categories, tags, etc.
 * */

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

    Source code is available at https://github.com/batyuvitez/manduca
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

//Translators: posts navigation at the bottom of archive pages
$label=__( 'Posts navigation', 'manduca' );   
 
?>



<nav id="post-navigation" class="post-navigation" aria-label="<?php echo $label; ?>">
	<div class="nav-links">
        <?php echo Manduca\helpers\Template_Functions::post_navigation(); ?>        
    </div>
</nav>
							
