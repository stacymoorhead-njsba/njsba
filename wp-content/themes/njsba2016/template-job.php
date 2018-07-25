<?php
/**
 * Template Name: Job
 */

while (have_posts()) :

	the_post();
	Components\build();

endwhile;
