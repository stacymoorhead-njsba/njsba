<?php

$context = array(
	'logo_url' 		=> get_site_url(),
	'nav' 			=> wp_nav_menu( array(
	    'container'      	=> 'nav',
	    'container_class'	=> '',
	    'menu_class'     	=> 'list--links',
	    'echo'            	=> false,
	    'theme_location'  	=> 'footer',
	    'depth'				=> 1,
	  	)),
	'name' 			=> get_bloginfo('name'),
	'street'		=> get_theme_mod('street_address'),
	'city' 			=> get_theme_mod('city'),
	'state' 		=> get_theme_mod('state'),
	'zip' 			=> get_theme_mod('zip'),
	'phone' 		=> get_theme_mod('phone'),
	'free_phone'	=> get_theme_mod('free_phone'),
	'fax' 			=> get_theme_mod('fax'),
	'mission' 		=> get_theme_mod('mission'),
	'copyright' 	=> get_theme_mod('copyright'),
	'twitter'  		=> get_theme_mod('twitter'),
	'facebook'  	=> get_theme_mod('facebook'),
	'youtube'  		=> get_theme_mod('youtube'),
	);



if (empty($context)) return;
Timber::render('footer.twig', $context);
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99306747-1', 'auto');
  ga('send', 'pageview');

</script></body>
</html>
