<?php
if ( ! function_exists( 'publications' ) ) {

// Register Custom Taxonomy
function publications() {

	$labels = array(
		'name'                       => _x( 'Publications', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Publication', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Publications', 'text_domain' ),
		'all_items'                  => __( 'All Publications', 'text_domain' ),
		'parent_item'                => __( 'Parent Publication', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Publications:', 'text_domain' ),
		'new_item_name'              => __( 'New Publication Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Publication', 'text_domain' ),
		'edit_item'                  => __( 'Edit Publication', 'text_domain' ),
		'update_item'                => __( 'Update Publication', 'text_domain' ),
		'view_item'                  => __( 'View Publications', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Publications with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Publications', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Publications', 'text_domain' ),
		'search_items'               => __( 'Search Publications', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No Publications', 'text_domain' ),
		'items_list'                 => __( 'Publications list', 'text_domain' ),
		'items_list_navigation'      => __( 'Publications list navigation', 'text_domain' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'query_var' 				 => 'publications',
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'publications', 'issues', $args );


	//Forcing a couple of publications
		wp_insert_term(
	    'School Board Notes',   // the term 
	    'publications', // the taxonomy
	    array(
	        'slug'        => 'school-board-notes',
	    ));

	    wp_insert_term(
	    'School Leader',   // the term 
	    'publications', // the taxonomy
	    array(
	        'slug'        => 'school-leader',
	    ));

}
add_action( 'init', 'publications', 0 );

}
