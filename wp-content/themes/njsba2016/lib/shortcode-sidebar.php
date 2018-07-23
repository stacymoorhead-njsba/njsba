<?php

function sidebar_shortcode( $atts, $content = null ) {

$content = apply_filters('the_content', $content );
	return '
			</div><!-- /col--primary -->
				<div class="col--secondary">
					<aside class="fsr-search">
						'. $content .'
					</aside>
				</div>
			<div class="col--primary">
			';

}
add_shortcode( 'sidebar', 'sidebar_shortcode' );
