<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;


      get_template_part('templates/head'); 

      do_action('get_header');
      
      get_template_part('templates/header');
      
      include Wrapper\template_path();

      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
