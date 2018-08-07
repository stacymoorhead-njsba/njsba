<?php

/*$context['job_map'] = get_field('job_map');
$context['job_closes'] = get_field('job_closes');
$context['job_location'] = get_field('job_location');
$context['job_title'] = get_field('job_title');
$context['job_contact'] = get_field('job_contact');
$context['application_link'] = get_field('application_link');*/

ob_start();

	Components\build_with( array(), 'job_details' );

	$context['job_details'] = ob_get_contents();

ob_end_clean();

Timber::render('job-details.twig', $context);
?>