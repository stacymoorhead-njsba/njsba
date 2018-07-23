<?php


$context['content'] = apply_filters('the_content', get_the_content());

if(!empty($context['content'])){

	$post_footer_check = get_field('post_footer_check');

	if($post_footer_check == 'default'){

		if( !empty( get_theme_mod('post_footer') ) ){

			$context['post_footer'] = get_theme_mod('post_footer');

		}//if end

	}elseif($post_footer_check == 'custom'){

		$context['post_footer'] = get_field('post_footer');

	}elseif($post_footer_check == 'false'){

		/* Nope don't do anything, just here to make it easier if something else comes up */

	}//elseif end

	Timber::render('content-post.twig', $context);
	
}
