<?php
	
		
		$count = 0;

		while (have_posts()) :

				the_post();

				global $post;


				if( $post->post_type == 'page' || $post->post_type == 'post'  || $post->post_type == 'people'){

					$count++;

				}
					
		endwhile;

		$hero = array(
			'deck' => 'You Searched for: '.get_search_query(),
			'title' => 'Search Results',
			);

		Timber::render('hero.twig', $hero);
