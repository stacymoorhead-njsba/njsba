<?php

$personify = array();

if(isset( $_COOKIE['NJSBACookie'] )){


	$del = '|||||';

	$username = str_replace( array('CustomerName=','&MasterCustomerID'), $del, $_COOKIE['NJSBACookie']);

	$username = explode($del, $username);

	$username = $username[1];

	$logged_in_menu =  wp_nav_menu( array(
								    'container'      		=> false,
								    'menu_class'     		=> 'nav',
								    'echo'            		=> false,
								    'theme_location'  		=> 'personify_logged_in',
								  	));

	$logged_in_menu = strip_tags($logged_in_menu, '<a>');

	$logged_in_menu = '<span class="welcome">Welcome '.$username.'</span>'.$logged_in_menu;
	
 	$personify['logged_in'] = $logged_in_menu;
}else{

	$personify['login'] = get_theme_mod('personify_login_url')."http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

}


$context = array(
	'logo_url' 	=> get_site_url(),
	'nav' 		=> wp_nav_menu( array(
	    'container'      		=> false,
	    'menu_class'     		=> 'nav',
	    'echo'            		=> false,
	    'theme_location'  		=> 'header',
	  	)),
 	'personify' => $personify,
	'search' 	=> get_search_form(false),
	);

if (empty($context)) return;

Timber::render('header.twig', $context);
