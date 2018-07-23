<?php
echo '<div class="container">';



if( $context['people_sections'] = get_field('county_people') ){

	foreach ($context['people_sections'] as &$people_section) {
		
		foreach ($people_section['people'] as &$person) {

			$person->info = get_field('personal_info',$person->ID)[0];
			$person->department_name = get_field('department_name', $person->ID);
			$person->link_url = get_permalink($person->ID);
			$person = get_object_vars($person);
			$person = flatten_array($person);


		}

	}

}

//getting the counties feed
	$meetings = array(
		'heading' => 'Meetings',
		);

	$meetings_cat = wp_get_post_terms(get_the_id(),'event-categories');
	$meetings_cat = $meetings_cat[0];
	$meetings['args'] = array(
		'post_type' => 'meetings',
		'meta_key'			=> 'meeting_start_date',
		'orderby'			=> 'meta_value_num',
		'order'				=> 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'event-categories',
				'field'    => 'slug',
				'terms'    => $meetings_cat->slug,
				),
			),

		);

	
	//building the feed
	ob_start();
	Components\build_with( $meetings,'event-feed');
	$meetings = ob_get_contents();
	ob_end_clean();

	//adding it to the context
	$context['secondary_content'] = $meetings;

	$context['row_first'] = 'row--first';

	$context['content'] = apply_filters('the_content', get_the_content());

	Timber::render('content-1.twig', $context);

	//Timber::render('content-counties-1.twig', $context);




echo '</div><!-- /div.container -->';

	Timber::render('people.twig', $context);
