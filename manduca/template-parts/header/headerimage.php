<?php
/**
 * Generate header image
 * Header template file
 * 
 * @ Theme: Manduca - focus on accessibility 
 **/

  /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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

$img=Manduca\helpers\Header_Image::get_header_image ();

?>


<?php  if( $img && ( is_home() || is_front_page() )) : ?>
        <div id="wp-custom-header" class="wp-custom-header">
            <?php echo $img; ?>
        </div>
<?php endif; ?>
