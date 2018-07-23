<?php

	/*

	This is a build with componenent.
	It wont' do much without being called with
	Components\build_with();
	
	This componenent can use
		$context['args'] - required
		$context['heading'] - optional
	
*/

	if( !empty($context) ){

		$context['posts'] = new WP_Query( $context['args'] );

		$context['posts'] = get_object_vars($context['posts']);

		$context['posts'] = $context['posts']['posts'];

		foreach ($context['posts'] as $key => &$post) {
			
			$post = get_object_vars($post);
			$post['url'] = get_permalink($post['ID']);
			$post['post_excerpt'] = strip_shortcodes( wp_trim_words( $post['post_content'],25) );

		}

		if (empty($context)) return;

		Timber::render('table-results.twig', $context);

		wp_reset_query();

	}
	
