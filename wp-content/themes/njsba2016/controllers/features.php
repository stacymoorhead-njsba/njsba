<?php

	if( !empty($context) ){

		
		$context['features'] = new WP_Query( $context['args'] );

		$context['features'] = get_object_vars($context['features']);

		$context['features'] = $context['features']['posts'];


		
		foreach ($context['features'] as $key => &$feature) {
			
			$feature = get_object_vars($feature);

			if ( has_post_thumbnail( $feature['ID'])){

				$size = 'large';

				$image = wp_get_attachment_image_src(get_post_thumbnail_id($feature['ID']), $size);
				$image = array(
					'src' => $image[0],
					'ratio' => $image[2]/$image[1]/2*100,
					);

				$feature['image'] = $image;
			}

			$feature['url'] = get_permalink( $feature['ID'] );
			$feature['post_excerpt'] = wp_trim_words( $feature['post_content'],25);

		}

		if (empty($context)) return;

		Timber::render('features.twig', $context);

		wp_reset_query();
		
	}
	


