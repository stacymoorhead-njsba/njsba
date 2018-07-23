<?php


$pt = 'issues';
$tx = 'publications';

// Register Custom Post Type
function Issue() {
	global $tx;
	$labels = array(
		'name'                  => _x( 'Issues', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Issue', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Issues', 'text_domain' ),
		'name_admin_bar'        => __( 'Issues', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All Issues', 'text_domain' ),
		'add_new_item'          => __( 'Add New Issue', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Issues', 'text_domain' ),
		'edit_item'             => __( 'Edit Issues', 'text_domain' ),
		'update_item'           => __( 'Update Issues', 'text_domain' ),
		'view_item'             => __( 'View Issue', 'text_domain' ),
		'search_items'          => __( 'Search Issue', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'items_list'            => __( 'Issues list', 'text_domain' ),
		'items_list_navigation' => __( 'Issues list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Issues list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Issue', 'text_domain' ),
		'description'           => __( 'A collection of Articles under a publication', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array('thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		'has_archive'			=> true,
		'rewrite'				=> array(
			'with_front' => false,
			),
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,	
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);

	register_post_type( 'issues', $args );
	flush_rewrite_rules();
}
add_action( 'init', 'Issue', 0 );

//add title and alias when a issue is created

	add_filter('acf/update_value/name=volume', 'my_acf_update_titlevalue', 10, 3);

	function my_acf_update_titlevalue( $value, $post_id, $field ) {

		global $post;

		if($post->post_type == 'issues'){

			// vars (title comes from person_name field that is looked for at the filter, after that the alias is generated)	
			
			$terms = wp_get_post_terms($post_id,'publications');

			$term = '';

			foreach ($terms as $t) {

				$term = $t->name;

			}

			$new_title = $term.' - '.$value;

			$new_slug = sanitize_title( $new_title );

			// update post with the "new" title and alias (because we may hide them at our custom post)
			$my_post = array('ID'=> $post_id,'post_title' => $new_title,'post_name' => $new_slug );

			//Sets the title
				wp_update_post( $my_post );

			//Sets the issue_cat
				wp_set_object_terms( $post->ID, $new_title, 'issues_cat', false);

			return $value;

		}
	}


// This removes the issue taxonomy metabox from the issue post types */
	add_action( 'add_meta_boxes' , 'remove_post_custom_fields' );

	function remove_post_custom_fields() {

		remove_meta_box( 'tagsdiv-issues_cat','issues','side');

	}
	


// Dipslays the title but doesn't allow you to edit it

	add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );
	
	function myplugin_add_meta_box() {

			add_meta_box( 'issue_title', 'Issue Title', 'myplugin_meta_box_callback', 'issues', 'normal' , 'high');

	}

	function myplugin_meta_box_callback( $post ) {

		// Add a nonce field so we can check for it later.

			$value = get_the_title( $post->ID);

			if($value != 'Auto Draft'){

				echo '<h1><strong>'.$value.'</strong></h1>';

			}
		}

//hides the taxonomy column on the edit posts screen
	add_filter( 'manage_issues_posts_columns', 'remove_issues_cat_columns');

	function remove_issues_cat_columns($columns){

	    unset( $columns['taxonomy-issues_cat'] );

	    return $columns;
	}


//only show articles and events from the same category

function my_post_object_query( $args, $field, $post ){
    $terms = wp_get_post_terms( $post, 'issues_cat');
    if( !is_wp_error( $terms ) ){
        $name = array();
        foreach ($terms as $term) {
            $name[] = $term->slug;
        }
        $args['post_type'] = 'articles';
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'issues_cat',
                'field'    => 'slug',
                'terms'    => $name,
            ),
        );
        return $args;
    } else {
        return $args;
    }
}
add_filter('acf/fields/post_object/query/name=special_section', 'my_post_object_query', 10, 3);
add_filter('acf/fields/post_object/query/name=features', 'my_post_object_query', 10, 3);


