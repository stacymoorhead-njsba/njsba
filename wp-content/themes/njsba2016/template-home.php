<?php
/**
 * Template Name: Home
 */

/* easy stuff */



	$order = array(
		'hero-bg',
		'cards',
		'banner',
		);

	while (have_posts()) :

	  	the_post();

		Components\build($order);

	endwhile; 

$homeapage_meetings = 7;
if (get_theme_mod('number_of_homepage_meetings' )) {
	$homeapage_meetings = get_theme_mod('number_of_homepage_meetings' );
}

$today = time(date('Ymd'));

$feeds = array(

	'feeds' => array(

		array(
			'heading' 		=> 'News',
			'link_url' 		=> get_field('news_link_url'),
			'link_txt'		=> get_field('news_link_text'),
			'args' 			=> array(
				'post__in'		=> get_field('news'),
				),
			),//news end

		array(
			'heading' 		=> 'Events',
			'link_url' 		=> get_post_type_archive_link( 'meetings' ),
			'link_txt'		=> 'View More',
			'url'			=> 'personify_url',
			'args'			=> array(
				'post_type' 		=> 'meetings',
				'posts_per_page'	=> $homeapage_meetings,
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
				),
			),//Meetings end
		),

	);//$feeds end

Components\build_with($feeds,'article_teasers-half_columns');

Components\build_with( array( 'ID' => get_the_id(), 'not_first' => true ),'page_teasers');



