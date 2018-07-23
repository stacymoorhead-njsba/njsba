<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>

<?php
$suffixes = Components\get_suffixes();
$qo = get_queried_object();
$title = get_class($qo) == 'WP_Post' ? $qo->post_title : $qo->label;
$hero = array(
	'title' => ucfirst($title),
);
	
ob_start();

	Components\build_with( array(), 'breadcrumbs' );

	$hero['breadcrumbs'] = ob_get_contents();

ob_end_clean();

Timber::render('hero.twig', $hero);
?>

<main id="site-main">
  <div class="container">
    <div id="tribe-events-pg-template" class="tribe-events-pg-template">
    	<?php tribe_events_before_html(); ?>
    	<?php tribe_get_view(); ?>
    	<?php tribe_events_after_html(); ?>
    </div> <!-- #tribe-events-pg-template -->
  </div>
</main>
<?php
//get_footer();