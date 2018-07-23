<?php


//Hero
	$hero = array(
		'acf_arg' => $context,
		'title' => $context->name,
		);
	Components\build_with($hero,'hero');


if( get_field('category_type',$context)=='publication'){

	$content = array(
		'primary_heading' => 'Issues',
		'primary_args' => array(
			'child_of' => $context->term_id,

			),
		'secondary_heading' => 'Tags',
		'secondary_args' => array(
			'taxonomy' => 'post_tag',
			),
		);

	Components\build_with( $content ,'content');

}else{


	//Normal Archive Feed
		$post_in = array();

		while (have_posts()) :

				the_post();
				$post_in[] = get_the_id();

		endwhile;

		$content = array(
			'args' => array(
				'post__in' => $post_in,
				),
			'dates' => true,
			'pagenation' => array(
				'prev' => get_previous_posts_link('Newer Releases'),
				'next' => get_next_posts_link('Older Releases')
				),
			);

		Components\build_with( $content, 'article_teasers');
}

//About Footer

	if(!empty($context->description)){

	$about = array(
		'heading' => 'About '.$context->name,
		'text' => $context->description,
		);

	Components\build_with( $about, 'about');

	}




