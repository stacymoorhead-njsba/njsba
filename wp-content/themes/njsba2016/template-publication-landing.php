<?php
/**
 * Template Name: Publication Landing
 */

	$suffixes = Components\get_suffixes();

	global $post;

	$slug = get_post( $post )->post_name;

	$publication = get_term_by('slug', $slug ,'category');

	$taxonomies = array( 
	    'category',
		);

	$args = array(
	    'parent'         => $publication->term_id,
	    'hide_empty'	 => false,
		); 

	$terms = get_terms($taxonomies, $args);

	$date = 0;
	$showing_category = '';

	foreach ($terms as $term) {
			
		$issue = get_field('issue',$term)[0];

		if($issue['date'] > $date){
			$date = $issue['date'];
			$showing_category = $term;
		}

	}
	
	Components\build_with($showing_category,'issue');





