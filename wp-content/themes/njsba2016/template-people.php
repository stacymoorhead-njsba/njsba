<?php
/**
 * Template Name: People
 */

while (have_posts()) :

	the_post();
	Components\build();

endwhile;
