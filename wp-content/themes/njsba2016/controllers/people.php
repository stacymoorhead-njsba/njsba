<?php

$context = array(
	'people_sections' => get_field('people'),
	);

foreach ($context['people_sections'] as &$people_section) {
	
	foreach ($people_section['people'] as &$person) {


		$person->info = get_field('personal_info',$person->ID)[0];
		$person->department_name = get_field('department_name', $person->ID);
		$person->link_url = get_permalink($person->ID);
		$person = get_object_vars($person);
		$person = flatten_array($person);
/*
		foreach ($person as $key => $thing) {
			echo '<p>'.$key.' \ '.$thing.'</p>';
		};
		echo '<hr>';
		*/
	}

}

if (empty($context)) return;

Timber::render('people.twig', $context);

