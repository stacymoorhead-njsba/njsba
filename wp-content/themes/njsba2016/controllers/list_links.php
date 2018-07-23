<?php
/*
	BUILD_WITH

		REQUIRED
			['args']
		OPTIONAL
			['heading']


*/

if( !empty($context) ){

		$context['links'] = new WP_Query( $context['args'] );

		$context['links'] = get_object_vars($context['links']);

		$context['links'] = $context['links']['posts'];

		foreach ($context['links'] as $key => &$post) {
			
			$post = get_object_vars($post);
			$post['url'] = get_permalink($post['ID']);

		}

		if (empty($context)) return;

		Timber::render('list-links.twig', $context);

		wp_reset_query();

	}
