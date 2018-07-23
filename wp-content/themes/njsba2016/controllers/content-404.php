<?php

$context = array(
	'content' => get_theme_mod('the_404_page_body'),
	'row_first' => 'row--first',
	'container' => true,
	);


Timber::render('content-1.twig', $context);
