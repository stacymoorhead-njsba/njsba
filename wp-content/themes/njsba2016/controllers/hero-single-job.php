<?php

if (empty($context)) return;

$job_details = get_fields($context->ID);
$job_details['job_image'] = $job_details['job_image'][0];
$job_details['post_title'] = $context->post_title;

$job_details['job_image']['image'] = $job_details['job_image']['image']['sizes']['thumbnail'];

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
