<?php
	
	$suffixes = Components\get_suffixes();

	echo '<!-- *suffixes included* :';
	print_r($suffixes);
	echo ' -->';
	
	if( $suffixes[0] == 'issue' ){


		Components\build_with( get_queried_object(),'issue');

  }elseif( $suffixes[0] == 'list'){

		Components\build_with( get_queried_object(),'list');

  }elseif( $suffixes[0] == 'list_landing' ){

		Components\build_with( get_queried_object(),'list_landing');
	
	}elseif( $suffixes[0] == 'single-people' ){

		Components\build_with( get_queried_object(),'person');

	}elseif( $suffixes[0] == 'single-jobs' ){

		Components\build_with( get_queried_object(),'job');	

	}elseif( $suffixes[1] == 'archive' || $suffixes[1] == 'paged' && $suffixes[2] == 'archive' || $suffixes[0] == 'publication'){


		Components\build_with( get_queried_object(),'archive');


	}elseif($suffixes[0] == 'search'){

		global $query_string;

		$comps = array(
			'hero',
			'content',
			);

		foreach ($comps as $comp) {

			Components\build_with( $query_string, $comp);
			
		}

	}elseif($suffixes[0]==404){

		$comps = array(
			'hero',
			'content',
			);

		foreach ($comps as $comp) {

			Components\build_with(array(),$comp);
			
		}

	}else{


		while (have_posts()) :

			the_post();
			Components\build();

		endwhile;

	}
