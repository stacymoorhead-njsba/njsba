<?php

if(in_the_loop()==true && empty($context['title'])){

	$context = get_field('hero')[0];
	$context['title'] = get_the_title();
	$context['thumbnail'] = get_the_post_thumbnail();
	

}else{
	/*
	
		if not in the loop
		required fileds are
		'acf_arg' => the 2nd argument for get field, for example, get_field('hero', taxonomy_term_object);
		'title' => whatever you want to show up
	*/

	$title = $context['title'];
	

	//FEATURED IMAGE
	$thumbnail ='';

	if(isset($context['thumbnail']) ){

		$thumbnail = $context['thumbnail']['sizes']['medium'];
	}

	$context = get_field( 'hero', $context['acf_arg'] )[0];
	$context['title'] = $title;
}

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$context['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero-job.twig', $context);
