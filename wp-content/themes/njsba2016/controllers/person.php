<?php

//Hero
	Components\build_with( $context ,'hero', 'single-people');

//Content
	while (have_posts()) :

	  	the_post();

		Components\build(array('content'));

	endwhile; 
// District List
	Components\build_with( $context ,'district_list');
	

