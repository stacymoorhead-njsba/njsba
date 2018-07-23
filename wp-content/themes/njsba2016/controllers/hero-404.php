<?php


$context = array(
	'title' => get_theme_mod('the_404_page_headline'),
	);


Timber::render('hero.twig', $context);
