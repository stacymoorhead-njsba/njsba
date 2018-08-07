<?php

$navigation = array();

$menu = '';
$home = '<li><a href="'.get_site_url().'">Home</a></li>';
$here = array();


$context = get_queried_object();

//these are the parts of the url we dont' care about
$nope = array(
	'/category/',
	'/uncategorized/',
	'/people/',
	'/jobs/',
	);

//the current link
$current_link =  "$_SERVER[REQUEST_URI]";


	//get all all the paths
		
		$parents = explode('/', trim($current_link,'/') );

	//get rid of the last one because that's in the context
		unset( $parents[ count($parents) -1] );

if(get_class($context) == 'WP_Post_Type'){
	if($context->name == 'tribe_events'){
  	$here = array(
  		'text' => $context->label,
    );
  }

} else if(get_class($context) == 'WP_Post'){

	if($context->post_type == 'page'){

		
		foreach ($parents as $slug) {
				
				$link = implode('/', $parents);

				if($parent = get_page_by_path($link)){

					if ($parent->post_title != $context->post_title ){
						$navigation[] = array(
						'text' => $parent->post_title,
						'url' => get_permalink($parent->ID),
						);	
					}
				}

				array_pop($parents);

		}

		$navigation = array_reverse($navigation);

	}else if($context->post_type == 'tribe_events'){

		$navigation[] = array(
			'text' => 'Events',
      'url' => '/events/',
		);

	}elseif($context->post_type == 'counties'){

		$menu_parameters = array(
		    'theme_location' => 'counties',
		    'container'       => false,
  			'echo'            => false,
  			'items_wrap'      => '%3$s',
  			'depth'           => 0,
		  	);

		$menu .= strip_tags(wp_nav_menu( $menu_parameters ), '<li> <a>' );

	}elseif($context->post_type == 'post'){


		foreach ($parents as $parent) {

			$parent = get_category_by_slug($parent);


			if ($page = get_page_by_title( html_entity_decode($parent->name) ) ) {

				$navigation[] = array(
					'text' => $parent->name,
					'url' => get_permalink($page->ID ),
					);
			}else{

				$navigation[] = array(
					'text' => $parent->name,
					'url' => get_term_link($parent->cat_ID, 'category'),
					);


			}//end else	

		}
				
	}elseif($context->post_type == 'people'){


		$menu_parameters = array(
		    'theme_location' => 'people',
		    'container'       => false,
  			'echo'            => false,
  			'items_wrap'      => '%3$s',
  			'depth'           => 0,
		  	);

		$menu .= strip_tags(wp_nav_menu( $menu_parameters ), '<li> <a>' );

	}elseif($context->post_type == 'jobs'){


		$menu_parameters = array(
		    'theme_location' => 'jobs',
		    'container'       => false,
  			'echo'            => false,
  			'items_wrap'      => '%3$s',
  			'depth'           => 0,
		  	);

		$menu .= strip_tags(wp_nav_menu( $menu_parameters ), '<li> <a>' );

	}

	$here = array(
		'text' => $context->post_title,
		);

}elseif (get_class($context) == 'WP_Term') {
	


	if($context->taxonomy == 'category'){

		foreach ($parents as $parent) {

			

			if ($parent = get_category_by_slug($parent)) {

				if ($page = get_page_by_title( html_entity_decode($parent->name) ) ) {

					$navigation[] = array(
						'text' => $parent->name,
						'url' => get_permalink($page->ID ),
						);

				}else{

					$navigation[] = array(
						'text' => $parent->name,
						'url' => get_term_link($parent->cat_ID, 'category'),
						);


				}//else end

			}//if ($parent  end
			
		}//foreach end

	}elseif($context->taxonomy == 'category'){

		$menu_parameters = array(
		    'theme_location' => 'people',
		    'container'       => false,
  			'echo'            => false,
  			'items_wrap'      => '%3$s',
  			'depth'           => 0,
		  	);
		$menu .= strip_tags(wp_nav_menu( $menu_parameters ), '<li> <a>' );


	}elseif($context->taxonomy == 'event-categories'){

		$menu_parameters = array(
		    'theme_location' => 'meetings',
		    'container'       => false,
  			'echo'            => false,
  			'items_wrap'      => '%3$s',
  			'depth'           => 0,
		  	);

		$menu .= strip_tags(wp_nav_menu( $menu_parameters ), '<li> <a>' );

	}

	$here = array(
		'text' => $context->name,
		);

}elseif ($current_link == '/meetings/') {
	
	$menu_parameters = array(
		    'theme_location' => 'meetings',
		    'container'       => false,
  			'echo'            => false,
  			'items_wrap'      => '%3$s',
  			'depth'           => 0,
		  	);

	$menu .= strip_tags(wp_nav_menu( $menu_parameters ), '<li> <a>' );

	$here = array(
		'text' => 'Upcoming Meetings',
		);

}

$navigation[] = $here;

$breadcrumbs = array(
	'navigation' => $navigation,
	'menu' => $menu,
	'home' => $home,
	);

Timber::render('breadcrumbs.twig', $breadcrumbs);
