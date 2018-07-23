<?php

$qo = get_queried_object();

Timber::render('hero.twig', array(

	'title' => $qo->label,
	
	));
//setting list
$county_list = array(
	'heading' => 'County List',
	'container' => ''
	);

$county_list['args'] = array(
	'orderby' => 'title',
	'order'   => 'ASC',
	'post_type' => $qo->query_var,
	'posts_per_page' => -1
	);

//get link list
	ob_start();
	Components\build_with($county_list, 'list_links');
	$counties = ob_get_contents();
	ob_end_clean();

Timber::render('content-css-columns.twig', array(
	'content' => $counties,
	'row_first' => true,
	'container' => true,
	));

