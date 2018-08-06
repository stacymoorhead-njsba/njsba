<?php

if (empty($context)) return;

$job_details = get_fields($context->ID);
$job_details['hero'] = $job_details['hero'][0];

//$job_details = $job_details['hero'][0];

$job_details['post_title'] = $context->post_title;


/*if(!empty($job_details['job_image'])){

	foreach ($job_details['job_image']['counties_and_districts'] as &$county) {

		$county['county'] = get_the_title($county['county']);

	}//foreach end

}// if end*/

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$job_details['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero-single-job.twig', $job_details);
