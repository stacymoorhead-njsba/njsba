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

	if ($sidebar = get_field('sidebar')) {
		$context['find_your_fsr'] = $sidebar[0]['find_your_fsr'];
	}
	
	/*JOB PAGE DETAILS*/
	if ($job_details = get_field('job_map')) {
		$context['job_map'] = $job_details[0]['job_map'];
	}
	
	if ($job_details = get_field('job_details')) {
		$context['job_closes'] = $job_details[0]['job_closes'];
		$context['job_location'] = $job_details[0]['job_location'];
		$context['job_title'] = $job_details[0]['job_title'];
		$context['job_contact'] = $job_details[0]['job_contact'];
		$context['application_link'] = $job_details[0]['application_link'];
	}	


	Timber::render('content.twig', $context);
	
}
