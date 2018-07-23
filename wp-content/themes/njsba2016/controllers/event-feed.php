<?php
/*
	
	REQUIRED ARGUMENTS
		$context['args']

	OPTIONAL ARGUMENTS
		$context['heading']

*/


if( !empty($context) ){

		$paged = get_query_var('paged');

		if($paged != 0){

			$context['args']['paged'] = $paged;

		}

		$context['posts'] = new WP_Query( $context['args'] );
		$context['posts'] = get_object_vars($context['posts']);
		$context['posts'] = $context['posts']['posts'];

		foreach ($context['posts'] as $key => &$post) {

			$post = get_object_vars($post);

			$post['url'] = get_permalink($post['ID']);

			if($context['args']['post_type']=='meetings'){
				$post['url'] = get_field('personify_url', $post['ID']);
			}

			//$post['post_excerpt'] = strip_shortcodes( wp_trim_words( $post['post_content'],25) );

			$meta_fields = array(
				'meeting_loc_link',
				'meeting_add_1',
				'meeting_city',
				'meeting_end_date',
				'meeting_postal',
				'meeting_start_date',
				'meeting_state',
				'personify_url',
				'meeting_id'
				);

			foreach ($meta_fields as $field) {
				$post[$field] = get_field($field, $post['ID']);
			}

			$startDate = $post['meeting_start_date'];

			//echo '<h1>unfiltered:'.$post['endDate'].'<br>'.$post['startDate'].'</h1><hr>';

			$post['startDate'] = date("F j, Y", $startDate);

			$post['startDateNoYear'] = date("F j", $startDate);

			$post['endDate'] = date("F j, Y", $post['meeting_end_date']);
			
			$post['meetingid'] = $post['meeting_id'];

			//echo '<h1>filtered:'.$post['endDate'].'<br>'.$post['startDate'].'</h1><hr>';

		}

		if (empty($context)) return;

		Timber::render('event_feed.twig', $context);

		wp_reset_query();

	}
	
