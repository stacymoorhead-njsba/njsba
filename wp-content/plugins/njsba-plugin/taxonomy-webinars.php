<?php

if ( ! function_exists( 'webinar_categories' ) ) {

// Register Custom Taxonomy
function webinar_categories() {

	$labels = array(
		'name'                       => _x( 'Webinar Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Webinar Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Webinar Categories', 'text_domain' ),
		'all_items'                  => __( 'All Webinar Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Webinar Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Webinar Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Webinar Category', 'text_domain' ),
		'add_new_item'               => __( 'Add New Webinar Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Webinar Category', 'text_domain' ),
		'update_item'                => __( 'Update Category', 'text_domain' ),
		'view_item'                  => __( 'View Webinar Categories', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Webinar Categories with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Webinar Categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Webinar Categories', 'text_domain' ),
		'search_items'               => __( 'Search Webinar Categories', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No Webinar Categories', 'text_domain' ),
		'items_list'                 => __( 'Webinar category list', 'text_domain' ),
		'items_list_navigation'      => __( 'Webinar category list navigation', 'text_domain' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'query_var' 				 => 'webinars',
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'               => array( 'slug' => 'training/webinars' ),
	);
	register_taxonomy( 'webinar_categories', 'webinars', $args );


	//Forcing a couple of publications
}
add_action( 'init', 'webinar_categories', 0 );

}
