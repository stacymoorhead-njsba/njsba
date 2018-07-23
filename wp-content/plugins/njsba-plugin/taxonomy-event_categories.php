<?php

if ( ! function_exists( 'Event_Categories' ) ) {

// Register Custom Taxonomy
function Event_Categories() {

	$labels = array(
		'name'                       => _x( 'Event Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Event Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Event Categroies', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( '', 'text_domain' ),
		'parent_item_colon'          => __( '', 'text_domain' ),
		'new_item_name'              => __( 'New Event Category Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Categories', 'text_domain' ),
		'edit_item'                  => __( 'Edit Event Category', 'text_domain' ),
		'update_item'                => __( 'Update Category', 'text_domain' ),
		'view_item'                  => __( 'View Event Category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Event Categories with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Event Categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Event Categories', 'text_domain' ),
		'search_items'               => __( 'Search Event Categories', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'items_list'                 => __( 'Event Categories list', 'text_domain' ),
		'items_list_navigation'      => __( 'Event Categories list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'event-categories', array( 'meetings','counties' ), $args );

}
add_action( 'init', 'Event_Categories', 0 );

}


add_action( 'admin_menu', 'remove_event_category_from_county_post_type', 999 );
function remove_event_category_from_county_post_type() {
/*
	this removes the event categories menu from counties
	Each county creates an event category when it's created with the same name as the county
*/
 remove_submenu_page( 'edit.php?post_type=counties', 'edit-tags.php?taxonomy=event-categories&amp;post_type=counties' );
}

