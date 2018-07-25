<?php

$context = array(
	'jobs_sections' => get_field('job_details'),
	);

foreach ($context['jobs_sections'] as &$jobs_section) {
	
	foreach ($jobs_section['jobs'] as &$job) {


		$job->job_image = get_field('job_image',$job->ID)[0];
		$job->job_description = get_field('job_description', $job->ID);
		$job->job_closes = get_field('job_closes', $job->ID);
		$job->location = get_field('location', $job->ID);
		$job->job_title = get_field('job_title', $job->ID);
		$job->job_contact = get_field('job_contact', $job->ID);
		$job->application_link = get_field('application_link', $job->ID);
		$job->map = get_field('map', $job->ID);
		$job = get_object_vars($job);
		$job = flatten_array($job);
/*
		foreach ($job as $key => $thing) {
			echo '<p>'.$key.' \ '.$thing.'</p>';
		};
		echo '<hr>';
		*/
	}

}

if (empty($context)) return;

Timber::render('job.twig', $context);

