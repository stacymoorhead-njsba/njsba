<?php

if ( ! function_exists('people') ) {

// Register Custom Post Type
function people() {

	$labels = array(
		'name'                  => _x( 'People', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Person', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'People', 'text_domain' ),
		'name_admin_bar'        => __( 'People', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All People', 'text_domain' ),
		'add_new_item'          => __( 'Add New People', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Person', 'text_domain' ),
		'edit_item'             => __( 'Edit Person', 'text_domain' ),
		'update_item'           => __( 'Update Person', 'text_domain' ),
		'view_item'             => __( 'View Person', 'text_domain' ),
		'search_items'          => __( 'Search Person', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'items_list'            => __( 'People list', 'text_domain' ),
		'items_list_navigation' => __( 'People list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Person', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'people', $args );

}
add_action( 'init', 'People', 0 );

}

//This creates json for fsr agents in the wp_uploads/people
function write_people_json( $post_id ) {


	//create array of people and date
	$people = array(
		'date' => date('l jS \of F Y h:i:s A'),
		'people' => array(),
		);

		$people_array = get_posts(array(
			'post_type' => 'people',
			'posts_per_page'   => -1,

			));

		foreach ($people_array as $person) {
			
			$personal_info = get_field('personal_info',$person->ID);
			$personal_info = $personal_info[0];

			$counties = $personal_info['counties_and_districts'];

			if (!empty($counties)) {

					foreach ($counties as &$county) {
						$county['county'] = get_the_title($county['county']);
						$county['district'] = explode(',', $county['district']);
						foreach ($county['district'] as &$district) {
							$district = trim($district);
						}//foreach end

					}//forech end

					$avatar = $personal_info['image'];
					$avatar = $avatar['sizes'];
					$avatar = $avatar['medium'];

					$people['people'][] = array(
					'title' => $person->post_title,
					'url' => get_permalink($person->ID),
					'position' => $personal_info['position'],
					'email' => $personal_info['email'],
					'phone' => $personal_info['phone'],
					'avatar' => $avatar,
					'fsr' => $counties,
					);


			}//if counties not empty end



		}// foreach end

	//covert from php array to json array
	$people_json = json_encode($people, JSON_UNESCAPED_SLASHES);

	//directory location
		$upload_dir = wp_upload_dir();
		$people_dir = $upload_dir['basedir'].'/people/';

		//if the directory doesn't exist make it
			if ( ! file_exists( $user_dirname ) ) {
		    	wp_mkdir_p( $people_dir );
			}

	//write the json file
		$myfile = fopen($people_dir."people.json", "w");
		fwrite($myfile, $people_json);
		fclose($myfile);

}
add_action( 'save_post_people', 'write_people_json' );
