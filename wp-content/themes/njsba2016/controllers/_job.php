<?php

//Hero
	Components\build_with( $context ,'job_header');

//Content
	while (have_posts()) :

	  	the_post();

		Components\build(array('content'));

	endwhile; 

	

