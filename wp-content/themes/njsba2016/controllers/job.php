<?php

//Hero
	Components\build_with( $context ,'hero', 'single-job');

//Content
	while (have_posts()) :

	  	the_post();

		Components\build(array('content'));

	endwhile; 

	

