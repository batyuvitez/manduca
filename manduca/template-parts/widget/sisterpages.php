<?php
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
// translators: name of Manduca's  sister page widget (same as defined in class-page-sisters.php)
$aria_label=__( 'Sister pages', 'manduca' )
?>		
<?php echo $args['before_widget']; ?>

	<?php if ($args ['title']) : ?> 
		<?php echo $args['before_title'] . $args['title'] . $args['after_title']; ?> 
	<?php endif; ?>
	<nav aria-label="<?php echo $aria_label; ?>">
		<ul>
			<?php echo $args['list']; ?>
		</ul>
	</nav>

<?php echo $args['after_widget']; ?>
