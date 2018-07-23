<?php
$suffixes = Components\get_suffixes();
$qo = get_queried_object();
$hero = array(
	'title' => ucfirst($qo->name),
	);

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$hero['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero.twig', $hero);



echo '<div class="container">';

	$event_categories = get_terms('event-categories');

	foreach ($event_categories as &$category) {
		$cat = $category;
		$category = array(
			'link_text' => $cat->name,
			'link_url' => get_term_link($cat)
			);

		if($county = get_page_by_title($cat->name, 'OBJECT', 'counties' )){

			$category['link_url'] = get_permalink($county->ID);

		}
	}

	$event_categories = array_merge(array(array('link_text'=>'All Meetings', 'link_url' => '/meetings')),$event_categories);


Timber::render('select_form.twig', array(
	'options' => $event_categories,
	'title'=> 'All Meetings',
	));
	
  $today = time(date('Ymd'));

	$meetings['args'] = array(
		'post_type' => 'meetings',
		'posts_per_page' 	=> get_option( 'posts_per_page' ),
		'meta_key'			=> 'meeting_start_date',
    'meta_query' => array(
          array(
              'key' => 'meeting_start_date',
              'value' => $today,
              'compare' => '>='
          )
      ),
		'orderby'			=> 'meta_value_num',
		'order'				=> 'ASC'
		);

if ($suffixes[0] =='taxonomy-event-categories') {

	$meetings['args']['tax_query'] = array(
		array(
			'taxonomy' => 'event-categories',
			'field'    => 'slug',
			'terms'    => $qo->slug,
		),
	);


}

Components\build_with( $meetings, 'event-feed');


Timber::render('pagenation.twig', array(
	'pagenation' => array(
		'prev' => get_previous_posts_link('<i class="fa fa-arrow-left"></i>'),
		'next' => get_next_posts_link('<i class="fa fa-arrow-right"></i>')
		),
	));
echo '</div>';
