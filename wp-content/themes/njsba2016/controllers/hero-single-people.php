<?php

if (empty($context)) return;

$hero = get_fields($context->ID);
$hero['personal_info'] = $hero['personal_info'][0];
$hero['post_title'] = $context->post_title;

$hero['personal_info']['image'] = $hero['personal_info']['image']['sizes']['thumbnail'];

if(!empty($hero['personal_info']['counties_and_districts'])){

	foreach ($hero['personal_info']['counties_and_districts'] as &$county) {

		$county['county'] = get_the_title($county['county']);

	}//foreach end

}// if end

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$hero['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero-single-people.twig', $hero);
