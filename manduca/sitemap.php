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
<h2 id="posts"><?php _e( 'Images:', 'manduca' ) ?></h2>
<?php 
      $query_images_args = array(
        'post_type' => 'attachment',
        'post_mime_type' =>'image',
        'post_status' => 'inherit',
        'posts_per_page' => -1,
    );

    $query_images = new WP_Query( $query_images_args );
    $images = array();
    foreach ( $query_images->posts as $image) {
        setup_postdata($image);
        ?>
        <div class="sitemap-images">
          
          <h3><?php echo $image->post_title; ?> </h3>

          <?php
            the_attachment_link($image->ID, false);
             $image_alt = get_post_meta( $image->ID, '_wp_attachment_image_alt', true);
            if ( empty( $image_alt )) {
               $image_alt = $image->post_excerpt; 
            } ?>
          
          <p> <?php echo $image_alt; ?> </p>
        
        </div>
        
        <?php
    }
?>