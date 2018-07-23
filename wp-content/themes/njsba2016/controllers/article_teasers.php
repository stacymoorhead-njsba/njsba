<?php

/*

	This is a build with componenent.
	It wont' do much without being called with
	Components\build_with();
	
	This componenent needs
	
		$context['args'] - required
		$context['heading'] - optional
		$context['subheading'] - optional
		$context['dates'] - optional
	
*/

	if( !empty($context) ){

		$context['posts'] = new WP_Query( $context['args'] );

		$context['posts'] = get_object_vars($context['posts']);

		$context['posts'] = $context['posts']['posts'];


		foreach ($context['posts'] as $key => &$post) {
			
			$post = get_object_vars($post);
			$post['url'] = get_permalink($post['ID']);
			//$post['post_excerpt'] = has_excerpt($post['ID']) ? wp_trim_words( get_the_excerpt($post['ID']),25) : strip_shortcodes( wp_trim_words( $post['post_content'],25) );
			$post['post_excerpt'] = has_excerpt($post['ID']) ? get_the_excerpt($post['ID']) : strip_shortcodes( wp_trim_words( $post['post_content'],25));
		}

		if (empty($context)) return;

		Timber::render('article_teasers.twig', $context);

		wp_reset_query();

	}
	
