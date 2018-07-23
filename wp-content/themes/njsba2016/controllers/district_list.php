<?php
$district_list = get_field('personal_info',$context->ID)[0];

//Check to see if we have a district list



	$district_list = $district_list['counties_and_districts'];

	if(!empty($district_list)){

		foreach ($district_list as &$county) {
			$county['county'] = get_the_title($county['county']);
			$county['district'] = str_replace(', ', ',', $county['district']);
			$county['district'] = explode(',', $county['district']);
		}

		$district_list = array(
			'counties' => $district_list,
			'districts_heading' => 'Districts '.$context->post_title.' Covers',
			);

		if (empty($district_list)) return;



		Timber::render('district_list.twig', $district_list);

	}
