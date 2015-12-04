<?php
/**
 * Manduca
 *
 * @since 1.8 */

?>

<h2 id="authors"><?php _e( 'Authors:', 'manduca' ) ?></h2>
<ul>
  <?php wp_list_authors( array( 'exclude_admin' => false, ) ); ?>
</ul>

<h2 id="pages"><?php _e( 'Pages:' , 'manduca' ) ?></h2>
<ul>
  <?php wp_list_pages( array( 'exclude' => '', 'title_li' => '', ) ); ?>
</ul>

<h2 id="posts"><?php _e( 'Posts:', 'manduca' ) ?></h2>
<?php
  $cats = get_categories();
    foreach ( $cats as $cat ) {
      echo '<h3>' .esc_html( $cat->cat_name ) .'</h3>';
      echo '<ul>';
      query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
      
      while ( have_posts() ) {
        the_post();
        $category = get_the_category();
        
        if ( $category[0] -> cat_ID == $cat->cat_ID ) {
          echo '<li><a href="'.get_permalink() .'">' .get_the_title() .'</a></li>';
        }
      }
      echo '</ul>';
      echo '</li>';
  }
?>