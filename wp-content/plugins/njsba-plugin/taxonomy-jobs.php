<?php

if ( ! function_exists( 'job_categories' ) ) {

// Register Custom Taxonomy
function job_categories() {

	$labels = array(
		'name'                       => _x( 'Job Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Job Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Job Categories', 'text_domain' ),
		'all_items'                  => __( 'All Job Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Job Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Job Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Job Category', 'text_domain' ),
		'add_new_item'               => __( 'Add New Job Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Job Category', 'text_domain' ),
		'update_item'                => __( 'Update Category', 'text_domain' ),
		'view_item'                  => __( 'View Job Categories', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Job Categories with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Job Categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Job Categories', 'text_domain' ),
		'search_items'               => __( 'Search Job Categories', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No Job Categories', 'text_domain' ),
		'items_list'                 => __( 'Job category list', 'text_domain' ),
		'items_list_navigation'      => __( 'Job category list navigation', 'text_domain' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'query_var' 				 => 'jobs',
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'               => array( 'slug' => 'services/field-services/jobs/' ),
	);
	register_taxonomy( 'job_categories', 'jobs', $args );


	//Forcing a couple of publications
}
add_action( 'init', 'job_categories', 0 );

}
