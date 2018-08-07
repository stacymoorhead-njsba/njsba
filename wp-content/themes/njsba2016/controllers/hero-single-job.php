<?php

if (empty($context)) return;

$job_hero = get_fields($context->ID);
$job_hero['hero'] = $job_hero['hero'][0];
$job_hero['post_title'] = $context->post_title;

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$job_hero['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero-single-job.twig', $job_hero);
