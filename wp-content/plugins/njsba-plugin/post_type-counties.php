<?php
// Register county post type
function county() {

	$labels = array(
		'name'                  => _x( 'Counties', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'County', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Counties', 'text_domain' ),
		'name_admin_bar'        => __( 'Counties', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All Counties', 'text_domain' ),
		'add_new_item'          => __( 'Add New County', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New County', 'text_domain' ),
		'edit_item'             => __( 'Edit County', 'text_domain' ),
		'update_item'           => __( 'Update County', 'text_domain' ),
		'view_item'             => __( 'View County', 'text_domain' ),
		'search_items'          => __( 'Search Counties', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'items_list'            => __( 'Counties list', 'text_domain' ),
		'items_list_navigation' => __( 'Counties list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Counties list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'County', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-location-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'counties', $args );

}
add_action( 'init', 'county', 0 );


//hides the taxonomy column on the edit posts screen
	add_filter( 'manage_counties_columns', 'remove_event_categories_columns');

	function remove_event_categories_columns($columns){

	    unset( $columns['taxonomy-event-categories'] );

	    return $columns;
	}


//hiding event category meta box
if (is_admin()) :
	function counties_remove_meta_boxes() {

	  		remove_meta_box('event-categoriesdiv', 'counties', 'side');
	  		remove_meta_box('mb_component_field_order', 'counties', 'side');

	}

add_action( 'add_meta_boxes', 'counties_remove_meta_boxes' );
endif;

