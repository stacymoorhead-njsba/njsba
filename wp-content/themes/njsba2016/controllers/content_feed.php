<?php

$feeds = get_field('content_feed');

$content = '<div class="container"><div class="row">';



foreach ($feeds as $feed) {

		if($feed['acf_fc_layout'] == 'feed'){
			//get the archive link
				$feed['button_url'] = get_term_link($feed['category']);
			//set the heading
				$feed['heading'] = $feed['category']->name;
			
			//posts
				$feed['posts'] = new WP_Query( array(
					'cat' => $feed['category']->term_id,
					'posts_per_page' => 3,
					));
				wp_reset_query();

				$feed['posts'] = get_object_vars($feed['posts']);

				$feed['posts'] = $feed['posts']['posts'];

			foreach ($feed['posts'] as $key => &$post) {
				
				$post = array(
					'txt' 		=> $post->post_title,
					'url' 		=> get_permalink($post->ID),
					'date' 		=> $post->post_date,
				);

				if($feed['date']!=1){
					unset($post['date']);
				}

			}//foreach end



				ob_start();

					Timber::render('content_feed-'.$feed['acf_fc_layout'].'.twig', $feed);
					$content .= ob_get_contents();

				ob_end_clean();


		}elseif($feed['acf_fc_layout'] == 'external_feed'){

				ob_start();

					Timber::render('content_feed-'.$feed['acf_fc_layout'].'.twig', $feed);
					$content .= ob_get_contents();

				ob_end_clean();


		}

		
		


}//end foreach
echo $content.'</div></div>';

