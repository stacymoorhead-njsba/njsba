<?php

if (empty($context)) return;

$job_hero = get_fields($context->ID);
$job_hero['hero'] = $job_hero['hero'][0];

//$job_details = $job_details['hero'][0];

$job_hero['post_title'] = $context->post_title;

$job_details = get_fields($context->ID);
if (isset($job_details['job_image'])) 
{ 
	$job_details['job_image'] = $job_details['job_image'][0];

} 

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$job_details['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero-single-job.twig', $job_hero);
