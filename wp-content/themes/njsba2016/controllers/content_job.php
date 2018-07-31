<?php


$context['content'] = apply_filters('the_content', get_the_content());
$content['container'] = 'bob';

/*$job_details['job_description'] = $job_details['job_description'][0];
$job_details['job_closes'] = $job_details['job_closes'][0];
$job_details['location'] = $job_details['location'][0];
$job_details['job_title'] = $job_details['job_title'][0];
$job_details['job_contact'] = $job_details['job_contact'][0];
$job_details['application_link'] = $job_details['application_link'][0];
$job_details['map'] = $job_details['map'][0];*/





if(!empty($context['content'])){
	$job_closes = get_field('job_closes');
	$location = get_field('location');
	$job_title = get_field('job_title');
	$job_contact = get_field('job_contact');
	$application_link = get_field('application_link');
	$map = get_field('map');

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


	Timber::render('content_job.twig', $context);
	
}
