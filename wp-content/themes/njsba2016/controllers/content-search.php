<div class="container">
<?php
//Normal Archive Feed

		$post_in = array();

		while (have_posts()) :

				the_post();
				$post_in[] = get_the_id();

		endwhile;

		$content = array(
			'args' => array(
				'post__in' => $post_in,
				'post_type' => array('post','page','people'),
				),
			'dates' => true,
			'pagenation' => array(
				'prev' => get_previous_posts_link('<i class="fa fa-arrow-left"></i>'),
				'next' => get_next_posts_link('<i class="fa fa-arrow-right"></i>')
				),
			);

		Components\build_with( $content, 'table_results');

?>
</div>
