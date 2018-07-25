<?php


if(in_the_loop()==true && empty($context['title'])){

		$context['title'] = get_the_title();

}else{
	/*
	
		if not in the loop
		required fileds are
		'acf_arg' => the 2nd argument for get field, for example, get_field('hero', taxonomy_term_object);
		'title' => whatever you want to show up
	*/

	$title = $context['title'];

	//JOB IMAGE
	$job_image ='';

	if(isset($context['job_image'])){
		
		$job_image = get_field(job_image);
		//$job_image = $context['job_image']['sizes']['medium'];

	}

	$context['job_image'] = $job_image;

	$context['title'] = $title;

	if (empty($context['title'])) {

		$context['title'] = get_the_title();
		
	}
}

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$context['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('job_header.twig', $context);
