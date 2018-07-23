<?php

if ( ! function_exists( 'issues_taxonomy' ) ) {

// Register Custom Taxonomy
function issues_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Issue', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Issue', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Issues', 'text_domain' ),
		'all_items'                  => __( 'All Issues', 'text_domain' ),
		'parent_item'                => __( '', 'text_domain' ),
		'parent_item_colon'          => __( '', 'text_domain' ),
		'new_item_name'              => __( 'New Issue Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Issue', 'text_domain' ),
		'edit_item'                  => __( 'Edit Issue', 'text_domain' ),
		'update_item'                => __( 'Update Issue', 'text_domain' ),
		'view_item'                  => __( 'View Issue', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Issues with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Issues', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Issues', 'text_domain' ),
		'search_items'               => __( 'Search Issues', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'items_list'                 => __( 'Issues list', 'text_domain' ),
		'items_list_navigation'      => __( 'Issues list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'issues_cat', array('issues','articles','events'), $args );

}
add_action( 'init', 'issues_taxonomy', 0 );

}


//this removes the issue taxonomy from the issue post type drop down list


add_action( 'admin_menu', 'remove_issues_tax_from_issue_post_type', 999 );

function remove_issues_tax_from_issue_post_type() {
 remove_submenu_page( 'edit.php?post_type=issues', 'edit-tags.php?taxonomy=issues_cat&amp;post_type=issues' );
}

