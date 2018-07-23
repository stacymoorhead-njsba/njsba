<?php


$context = array();

if ( $context['assertive_teasers'] = get_field('assertive_teaser') ){

	foreach ($context['assertive_teasers'] as &$teaser) {

		if(!empty($teaser['icon'])){

		$teaser['icon']['src'] = $teaser['icon']['sizes']['thumbnail'];
		
		}//if end

	}//foreach end

	if (empty($context)) return;

	Timber::render('assertive_teasers.twig', $context);

}//if end
