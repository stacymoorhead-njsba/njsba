<?php




//if used outside the loop pass context['ID']

if(in_the_loop()){

	$context['page_teasers'] = get_field('page_teasers');

}else{

	$context['page_teasers'] = get_field('page_teasers',$context['ID']);

}

if (empty($context)) return;

Timber::render('page_teasers.twig', $context);
