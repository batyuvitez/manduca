<?php
/**
 * Displays an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
* layout with multiple posts/pages shown gets confusing.
 **/
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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
?>

<?php if( is_user_logged_in() ) : ?> 

<div class="edit-link">
    
    <?php manduca_get_svg ( array( 'icon' => 'pencil' ) ); ?>
    
    <a href="<?php echo get_edit_post_link(); ?>">
        <?php _e( 'Edit', 'manduca' ); ?>
        <span class="screen-reader-text">
            "<?php the_title(); ?>"
        </span>
    </a>
</div>

<?php endif; ?>