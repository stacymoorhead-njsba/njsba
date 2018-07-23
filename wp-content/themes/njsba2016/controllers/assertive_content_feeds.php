<?php

$feed = get_field('assertive_content_feeds');

$content = '';

foreach ($feed as $key => &$category) {

	$category['category_type'] = get_field( 'category_type', $category['feed_category'] );
	
	//fill out button text if empty
	if(empty($category['button_text'])){
		$category['button_text'] = 'Older Posts';
		}

	//Publication
		if($category['category_type'] == 'publication'){


			//find latest child if this is a publication
				$args = array(
			    	'parent'         => $category['feed_category']->term_id,
			    	'hide_empty'	 => false,
					); 

				$taxonomies = array( 
				    'category',
					);

				$terms = get_terms($taxonomies, $args);

				$date = 0;

				$showing_category = '';

				foreach ($terms as $term) {
						
					$issue = get_field('issue',$term)[0];

					if($issue['date'] > $date){
						$date = $issue['date'];
						$showing_category = $term;
					}//if end

				}//foreach end


				//setting the category link
				$link = get_page_by_path($category['feed_category']->slug);

				if(!empty($link)){

					$link = get_permalink($link->ID);

				}else{

					$link = get_term_link($category['feed_category']);

				}

				//create args for loop

				if (is_object($showing_category)) {

						$context = array(
						'args' => array(
							'cat' => $showing_category->term_id,
							'posts_per_page' => 3,
							),
						'heading' => $category['feed_category']->name,
						'subhead' => date(" F d, Y", strtotime($date)).' • '.$showing_category->name,
						'archive_link_url' => $link,
						'archive_link_txt' => $category['button_text'],
						);

						if($key != 0){
							$context['not_first'] = true;
						}

						ob_start();

							Components\build_with($context,'article_teasers');
							$content .= ob_get_contents();

						ob_end_clean();
				}

				


		}else{	
	//Any other category that's not a publication

				$context = array(
					'args' => array(
						'cat' => $category['feed_category']->term_id,
						'posts_per_page' => 3,
						),
					'heading' => $category['feed_category']->name,
					'archive_link_url' => get_term_link($category['feed_category']),
					'archive_link_txt' => $category['button_text'],
					);

					if($key != 0){
						$context['not_first'] = true;
					}

				ob_start();

					Components\build_with($context,'article_teasers');
					$content .= ob_get_contents();

				ob_end_clean();

		}//if end
	
}//end foreach feed



echo ''.$content.'';

