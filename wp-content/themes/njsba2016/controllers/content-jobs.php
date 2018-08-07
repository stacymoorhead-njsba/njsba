<?php


$context['content'] = apply_filters('the_content', get_the_content());
$content['container'] = 'bob';




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

	/*SIDEBAR*/
	if (get_post_type() == 'jobs') {
		$context['job_details'] = get_fields(get_the_ID());
		Timber::render('content-job.twig', $context);
	} else {
		Timber::render('content-jobs.twig', $context);
	}

		

	
	
}
