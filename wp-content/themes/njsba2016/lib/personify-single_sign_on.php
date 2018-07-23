<?php


/*global $post;




}*/


function personify_cookie_check(){ 

	$login_url = get_theme_mod('personify_login_url');

	$login_host = parse_url($login_url);
	
	echo '
	<!-- |||||
	';

	print_r($login_host);



	echo '
	||||| -->';

	if(get_field('personify_check')){

		if ( !isset( $_COOKIE['NJSBACookie'] ) ){
         
			if ($personify_login_url = get_theme_mod('personify_login_url')) {
        
        header("Location: $personify_login_url".get_permalink());
        die();

			}else{

				exit;

			}
		
		}

	}//if get_field end

}

add_action('wp_head', 'personify_cookie_check');
