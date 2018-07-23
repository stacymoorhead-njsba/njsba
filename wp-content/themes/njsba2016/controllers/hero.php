<?php
//save the arch
$archive = array();
$navigation = '';


if(!empty($context['archive'])){

	$archive = array(
		'sub_nav_link_url' => $context['archive'],
		'sub_nav_link_text' => 'Archive',
		);

}



if(in_the_loop()==true && empty($context['title'])){

	$context = get_field('hero')[0];
	if (get_field('county_name')) {
		
		$context['title'] = get_field('county_name');

	}else{

		$context['title'] = get_the_title();
	}
	

}else{
	/*
	
		if not in the loop
		required fileds are
		'acf_arg' => the 2nd argument for get field, for example, get_field('hero', taxonomy_term_object);
		'title' => whatever you want to show up
	*/

	$title = $context['title'];

	//PDF COVER IMAGE
	$cover_image ='';
	$pdf_link = '';

	if(isset($context['cover_image']) && isset($context['pdf_link'])){

		$cover_image = $context['cover_image']['sizes']['medium'];
		$pdf_link = $context['pdf_link'];

	}

	$context = get_field( 'hero', $context['acf_arg'] )[0];

	$context['cover_image'] = $cover_image;
	$context['pdf_link'] = $pdf_link;

	$context['title'] = $title;

	if (get_field('county_name')) {
		
		$context['title'] = get_field('county_name');

	}elseif(empty($context['title'])) {


		$context['title'] = get_the_title();

		
	}
}

//navigation

	//save nav for later


	if(!empty($context['navigation'])){
		/*
		foreach ($context['navigation'] as &$nav) {

			$nav->link = get_permalink( $nav->ID );

		}
		*/
		$navigation = $context['navigation'];

		unset($context['navigation']);
	}

	if( !empty($archive) ){
		$navigation[] = $archive;
		}

	//flatten array to make it easier in timber


		$context = flatten_array($context);

	//reassign nav
		$context['navigation'] = $navigation;
		
//get contact stuff
	if(!empty($context['contact'])){

			$ID  = $context['contact']->ID;
			$context['contact'] = get_field('personal_info',$ID)[0];
			$context['contact']['link_url'] = get_permalink($ID);
			//print_r($context['contact']);
		
	}//if end

ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$context['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero.twig', $context);
