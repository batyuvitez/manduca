<?php
/**
 * back to top service 
 * Inserted after footer, just before the end of div.site 
 *
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

?>
<div class="manduca-back-to-top-div">
   <button id="manduca-back-to-top"
      class="manduca-back-to-top"
      aria-label="<?php _e( 'Back to top', 'manduca' ); ?>">
      <?php manduca_icon( 'back-to-top'); ?>
   </button>
</div>