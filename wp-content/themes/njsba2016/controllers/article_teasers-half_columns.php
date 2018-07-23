<?php

/*
	This is a build with componenent.
	It wont' do much without being called with
	Components\build_with();

	it requires a array setup like this
	$feeds = array(

		'feeds' => array(

			array(
				//HEADING (optional, string, default: null)()heading is text that shows up above the feed.
					'heading' 		=> 'News',
				
				//TAXONOMY_TAG (optional, true/false , default:false) taxonomy_tag tells this component to show category tags
					'taxonomy_tag' 	=> true,

				//TAXONOMY (optional, string, defualt: category) taxonomy is the slug of the taxonomy you want to create tags for if taxonomy_tag is selected.
					'taxonomy'		=> 'category',
				
				//LINK_URL (optional, string, default: null) sets the link for the view more link under the feed
					'link_url' 		=> '#',

				//LINK_TXT (optional, string, default: null) sets the text for the view more link under the feed
					'link_txt'		=> 'View all News',
				
				//ARGS (optional, string, default: will get three posts from the Post post-type) args get passed to the wp_query,
					'args' 			=> array(
						'post__in'		=> get_field('news'),
						),
				),//news end
			
			//takes as many arrays as you have.
			array(
				'heading' 		=> 'Meetings',
				'args'			=> array(
					'post_type' 	=> 'meetings',
					'post_count'	=> 3,
					),
				),//meetings end
			),

	);//$feeds end
*/



foreach ($context['feeds'] as &$feed) {

		$feed['posts'] = new WP_Query( $feed['args'] );

		$feed['posts'] = get_object_vars($feed['posts']);

		$feed['posts'] = $feed['posts']['posts'];

		if(empty($feed['args'])){
			$feed['args'] = array(
				'post_type' 	=> 'posts',
				'post_count'	=> 3,
				);
		}

		foreach ( $feed['posts'] as &$post ){
			
			$post = get_object_vars($post);

			if (isset($feed['url'])) {
				
			//	$post['url'] = get_field($feed['url'], $post['ID']);

                 $meetingid = get_field(meeting_id, $post['ID']);
				  $post['url'] = 'https://www.njsba.org/meeting-details?ProductId='.$meetingid;
				  
				if($mtg_date = get_field('meeting_start_date',$post['ID'])){

					$post['post_date'] = date('F d, Y', $mtg_date);
				}

			}else{

				$post['url'] = get_permalink($post['ID']);
			}

			//$post['post_excerpt'] = has_excerpt($post['ID']) ? wp_trim_words( get_the_excerpt($post['ID']),25) : strip_shortcodes( wp_trim_words( $post['post_content'],25) );
			$post['post_excerpt'] = strip_shortcodes( wp_trim_words( $post['post_content'],25));


			if(isset($feed['taxonomy_tag']) && $feed['taxonomy_tag'] == true) {

				//checks to see if taxonomy is empty
				if( empty( $feed['taxonomy'] ) ){

					$feed['taxonomy'] = 'category';
				}
				$term = wp_get_post_terms( $post['ID'], $feed['taxonomy'])[0];
				$post['tag'] = $term->name;

				//Weird stuff I have to do for issues
				if($feed['taxonomy'] == 'category' && get_field('category_type',$term) == 'issue' ){

					while ( get_field('category_type',$term) == 'issue' ) {
					
						$term = get_term($term->parent,'category');

						//get rid of this and uncomment the thing underneath if they want the volume number in there
						$post['tag'] = $term->name;
					}

					//$post['tag'] = $term->name.' '.$tag;
				}

			}//if $feed['category_tag'] /

		}//foreach $feed['posts'] /

}//foreach $context /

if (empty($context)) return;

Timber::render('article_teasers-half_columns.twig', $context);
