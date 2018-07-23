<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */

$sage_includes = [
  'componentizer/componentizer.php',
  'lib/assets.php',    // Scripts and stylesheets
  'lib/custom_functions.php', //custom functions written for us
  'lib/customization_fields.php',
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/personify-single_sign_on.php', // single sign on stuff
  'lib/shortcode-sidebar.php',
  'lib/template-home-functions.php',   // backend stuff for the homepage template
  'lib/tinymce.php',   // Tiny MCE stuff
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php', // Theme customizer
  'lib/wp-garbage.php',
  //'lib/webservices-widgets.php' //the thing that gets the events feed
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

add_image_size('list-featured-image', 550, 550, true);