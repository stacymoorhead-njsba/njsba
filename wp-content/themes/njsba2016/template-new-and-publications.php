<?php
/**
 * Template Name: News and Publications
 */


while (have_posts()) :

	the_post();
	Components\build();

endwhile;
