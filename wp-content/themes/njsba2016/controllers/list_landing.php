<?php
  
//hero

// on category lists, this page is the parent. On this template, we just set parent to self.
$parent = $context;
$cat = $context->term_id;

$hero = array(
 	'acf_arg' => $parent,
  'title' => $context->name,
);

Components\build_with($hero,'hero');

?>			

<div class="container">
	<section class="row row--second">
    <div class="col--primary col--primary--larger col--right">
      
      <?php
      
      $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  
      $args = array(
      	'posts_per_page' => 10,
      	'paged' => $paged,
      	'order' => 'DESC',
      	'cat' => $cat,
      );
      
      $wp_query = new WP_Query($args);
      
      if($wp_query->have_posts()) {
      
        echo '<div class="webinar-archives">';
      
        while($wp_query->have_posts()) {
          $wp_query->the_post();
          ?>
          <article class="webinar">
          	<?php if(has_post_thumbnail()) : ?>
            	<?php $thumbnail_id = get_post_thumbnail_id(); ?>
            	<?php $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'list-featured-image'); ?>
      	    	<div class="webinar__figure"><a href="<?php the_permalink(); ?>"><img src="<?php echo $thumbnail_src[0]; ?>" class="webinar__img"></a></div>
          	<?php endif; ?>
          	<div class="webinar__body">
            	<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            	<p class="subhead"><?php echo get_the_date(); ?></p>
            	<div class="webinar-description">
        	    	<?php the_excerpt(); ?>
            	</div>
      
            	<a class="btn btn--primary" href="<?php the_permalink(); ?>">Read More</a>
          	</div>
          </article>
          <?php
      
        }
        echo '</div>';
      
        echo paginate_links(
        	array(
        		//'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        		'format' => '/page/%#%',
        		'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages
        	)
        );
        ?>
      
      </div>
    
      <div class="col--secondary col--secondary--smaller col--left">
        <?php
    
        $taxonomy = 'category';
        $terms = get_terms( array( 'taxonomy' => $taxonomy,'parent' => $parent->term_id)); // Get all terms of a taxonomy
    
        if ( $terms && !is_wp_error( $terms ) ) :
        ?>
        	<h2 class="category_title subhead">Categories:</h2>
          <ul class="category-menu list--plain">
      	    
      	    <?php $parent_term = get_term($parent->term_id); ?>
      	    <li><a href="<?php echo get_term_link($parent_term->term_id); ?>"<?php if($parent->term_id == $cat) echo ' class="active"'; ?>>Most Recent</a></li>
    
              <?php foreach ( $terms as $term ) { ?>
                  <li>
                  	<a href="<?php echo get_term_link($term->term_id);  ?>" class="<?php if($term->term_id == $cat) echo 'active'; ?>"><?php echo $term->name; ?></a>
                  </li>
              <?php } ?>
          </ul>
    
        <?php endif;?>
    
      </div>    
  	</section>
  </div>

<?php
  wp_reset_postdata();
}