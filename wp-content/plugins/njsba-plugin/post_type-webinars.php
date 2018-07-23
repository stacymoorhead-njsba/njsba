<?php 
if ( ! function_exists('webinars') ) {

// Register articles post type
function webinars() {

	$labels = array(
		'name'                  => _x( 'Webinars', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Webinar', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Webinars', 'text_domain' ),
		'name_admin_bar'        => __( 'Webinars', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All Webinars', 'text_domain' ),
		'add_new_item'          => __( 'Add New Webinar', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Webinar', 'text_domain' ),
		'edit_item'             => __( 'Edit Webinar', 'text_domain' ),
		'update_item'           => __( 'Update Webinar', 'text_domain' ),
		'view_item'             => __( 'View Webinar', 'text_domain' ),
		'search_items'          => __( 'Search Webinars', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'items_list'            => __( 'Webinar list', 'text_domain' ),
		'items_list_navigation' => __( 'Webinar list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Webinars list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Webinar', 'text_domain' ),
		'description'           => __( 'Webinars', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true ,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
 		'taxonomies'  => array( 'webinars','webinar_categories' ),
		'capability_type'       => 'post',
	);
	register_post_type( 'webinars', $args );

}
add_action( 'init', 'webinars', 0 );

}
