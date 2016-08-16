<?php
/**
 * Manduca
 *
 * @since 1.8 */

?>

<h2 id="authors"><?php _e( 'Authors:', 'manduca' ) ?></h2>
<ul>
  <?php wp_list_authors( array( 'exclude_admin' => true, ) ); ?>
</ul>

<h2 id="pages"><?php _e( 'Pages:' , 'manduca' ) ?></h2>
<ul>
  <?php wp_list_pages( array(
                             'exclude'        => '',
                             'title_li'     => '',
                             'sort_column'  => 'post_title'
                             ) ); ?>
</ul>

<h2 id="posts"><?php _e( 'Posts:', 'manduca' ) ?></h2>
  <ol>
    <?php
    
        /* Boolean filter
		 * @ name: manduca_sitemap_display_category
		 * @ true : default : use category breakdown (as in previous versions of Manduca)
		 * @ false : use alphabetic order
		 * */
		$type_flag = apply_filters( 'manduca_sitemap_display_category' , '__return_true');
    
    if ( $type_flag ) :
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
     
    
    
    else: 
        $list_posts = new WP_Query( array( 
            'post_type'       => 'post', 
            'posts_per_page'  => -1, 
            'post_status'     => 'publish',
            'order'           => 'ASC',
            'orderby'         => 'title'
            ) );
    
      while ( $list_posts->have_posts() ) : $list_posts->the_post(); 
        
          
                printf( '<li><a href="%1$s">%2$s</a></li>',
                       get_permalink(),
                       get_the_title()
                      );
      endwhile;
    
    endif;  
      ?>
  </ol>
  
  
<h2 id="posts"><?php _e( 'Images:', 'manduca' ) ?></h2>
  <ol>
  <?php 
        $query_images_args = array(
          'post_type' => 'attachment',
          'post_mime_type' =>'image',
          'post_status' => 'inherit',
          'posts_per_page' => -1,
          'order'           => 'ASC',
          'orderby'         => 'title'
      );
  
      $query_images = new WP_Query( $query_images_args );
      $images = array();
      foreach ( $query_images->posts as $image) {
          setup_postdata($image);
          
          printf( '<li><a href="%1$s">%2$s</a></li>',
                 get_attachment_link( $image->ID ),
                 $image->post_title
                 );
          
      }
  ?>
</ol>
  
  
  <h2 id="posts"><?php _e( 'PDFs:', 'manduca' ) ?></h2>
  <ol>
  <?php 
          
      $query_pdf = new WP_Query( array(
              'post_type' => 'attachment',
              'post_mime_type' =>'application/pdf',
              'post_status' => 'inherit',
              'posts_per_page' => -1,
              'order'           => 'ASC',
              'orderby'         => 'title'
          )
      );
      
    $pdf = array();
      foreach ( $query_pdf->posts as $pdf) {
          setup_postdata($pdf);
          
          printf( '<li><a href="%1$s">%2$s</a></li>',
                 wp_get_attachment_url( $pdf->ID ),
                 $pdf->post_title
                 );
          
      }
  ?>
</ol>