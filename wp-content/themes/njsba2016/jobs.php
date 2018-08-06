<?php

/* Template Name: Job Archive */

?>


<!-- START TESTING -->

<!-- END TESTING -->

<?php

$context = get_queried_object();

// Build the hero banner

$hero = array(
	'acf_arg' => $context,
	'title' => $context->name,
	);
Components\build_with($hero,'hero');


// Prolly should be a separate component...Build the default page content area

$content2 = array( 'content' => $context->content);

Components\build_with($content2,'content');

?>

<div class="container">
	<section class="row row--second">

    <div class="col--primary col--primary--larger col--right">

<?php

// Loop through jobs CPT

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
	'post_type' => 'jobs',
	'posts_per_page' => 6,
	'paged' => $paged,
    'meta_key' => 'location',
    'meta_type' => 'Text',
	'orderby' => 'meta_value',
	'order' => 'DESC',
);

if( isset($_GET["category"]) ){
    $args['tax_query'] =  array(
        array(
            'taxonomy' => 'job_categories',
            'field' => 'slug',
            'terms' => $_GET['category'],
            'paged' => $paged,
            'meta_key' => 'location',
            'meta_type' => 'Text',
			'orderby' => 'meta_value',
			'order' => 'DESC',
        )
    );
}

$wp_query = new WP_Query($args);

if($wp_query->have_posts()) {

  echo '<div class="webinar-archives">';

  while($wp_query->have_posts()) {
    $wp_query->the_post();
    ?>
    <article class="job">
    	<?php /* if(has_post_thumbnail()) {
	    	echo '<div class="webinar__figure">' . the_post_thumbnail('medium', array('class' => 'webinar__img')) . '</div>';
    	}
    	*/?>
		
		<?php if( get_field('job_image') ): ?>

			<div class="webinar__figure">	
				<?php print_r(get_sub_field('job_image'));?>
				
				<?php if( have_rows('hero') ): ?>
					<?php while ( have_rows('hero') ) : the_row(); ?>
						<img src="<?php the_sub_field('job_image'); ?>" class="webinar__img" />
					<?php	endwhile; ?>
					<?php else : ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

    	<div class="job__body">
      	<h3 class="title"><a href="<?php echo esc_url( get_permalink() ) ?>"><?php the_title(); ?></a></h3>
      	<p class="subhead"><?php the_field('location'); ?></p>
      	<div class="job-description">
  	    	<?php the_field('job_description'); ?>
      	</div>

      	<a class="btn btn--primary" href="<?php echo esc_url( get_permalink() ) ?>"><?php echo('More Info'); ?></a>
    	</div>
    </article>
    <?php

  }
  echo '</div>';

  $big = 999999999; // need an unlikely integer

echo paginate_links(
	array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	)
);
?>

  </div>

  <div class="col--secondary col--secondary--smaller col--left">
    <?php

    // Setup Category Menu. $active determines which link appears 'active'

    $taxonomy = 'job_categories';
    $terms = get_terms( array( 'taxonomy' => $taxonomy,'hide_empty' => false)); // Get all terms of a taxonomy

    if ( $terms && !is_wp_error( $terms ) ) :
    ?>
    	<h2 class="category_title subhead">Categories:</h2>
      <ul class="category-menu list--plain">

  	    <?php $active = !isset($_GET['category']) ? ' active ' : ''; ?>
  	    <li><a href="/services/field-services/jobs/" class="<?php echo $active; ?>">Most Recent</a></li>

          <?php foreach ( $terms as $term ) { ?>
              <li>

              	<?php
                	if (isset($_GET['category'])) {


                	$active = $_GET['category'] == $term->slug ? 'active' : '';

                	} else {

                	$active = '';

                	}?>
              	<a href="<?php echo '/services/field-services/jobs/?category=' . $term->slug;  ?>" class="<?php echo $active; ?>"><?php echo $term->name; ?></a>
              </li>
          <?php } ?>
      </ul>

    <?php endif;?>

  </div>



<?php
  wp_reset_postdata();
}

?>


	</section>
</div>

