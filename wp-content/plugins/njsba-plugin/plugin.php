<?php
/*
Plugin Name: NJSBA
Version: 2015.1209
Author: Eric Mikkelsen
Description: This plugin adds the post types counties, events, and people.
*/


function plugin_includes($includes){
	foreach ($includes as $include) {
		require_once $include.'.php';
	}
}


$plugin_includes = array(
	'acf-json',
	//'post_type-articles',
	'post_type-counties',
	'post_type-events',
	//'post_type-issues',
	'post_type-people',
	'post_type-webinars',
 	'taxonomy-webinars',
	'post_type-jobs',
	'taxonomy-jobs',
	'support-svg',
	'taxonomy-event_categories',
	//'taxonomy-issues',
	//'taxonomy-publications',
	//'personify-event_integration/WebServicesWidgets',
	'personify-event_integration/personify-cron_job',

	);


plugin_includes($plugin_includes);
