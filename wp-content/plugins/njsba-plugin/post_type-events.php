<?php

// Register Custom Post Type
function meetings() {

	$labels = array(
		'name'                  => _x( 'Meetings', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Meeting', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Meetings', 'text_domain' ),
		'name_admin_bar'        => __( 'Meetings', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All Meetings', 'text_domain' ),
		'add_new_item'          => __( 'Add New Meetings', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Meetings', 'text_domain' ),
		'edit_item'             => __( 'Edit Meetings', 'text_domain' ),
		'update_item'           => __( 'Update Meeting', 'text_domain' ),
		'view_item'             => __( 'View Meeting', 'text_domain' ),
		'search_items'          => __( 'Search Meeting', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'items_list'            => __( 'Meetings list', 'text_domain' ),
		'items_list_navigation' => __( 'Meetings list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Meetings list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Meeting', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'meetings', $args );

}

add_action( 'init', 'meetings', 0 );
