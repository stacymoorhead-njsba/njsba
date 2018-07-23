<?php

		/*

			this is a a larger component that requires an issue term
	
		*/

		$issue = get_field('issue', $context)[0];
		$parent = get_term($context->parent, 'category');




		//hero

			$hero = array(
				'acf_arg' => $parent,
				'title' => $parent->name,
				'archive' => get_term_link($parent,'category'),
				);

			if(!empty($issue['pdf_link'])){

				$hero['pdf_link'] = $issue['pdf_link'];

				if(!empty($issue['cover_image'])){
					$hero['cover_image'] = $issue['cover_image'];
				}

			}

			Components\build_with($hero,'hero');


		//Issue Heading
			$issue_heading = array(
				'heading' => $context->name
				);


			Components\build_with($issue_heading,'issue_heading');
			

		//Features

			if(empty($issue['featured'])){

				$issue['featured'] = array();

			}else{

				$features = array(
					'args' => array(
						'orderby' => 'post__in',
						'post__in'=> $issue['featured'],
						),
					);
				
				Components\build_with($features,'features');
				
			}

		//Special Section

			if(empty($issue['special_section'])){

				$issue['special_section'] = array();

			}else{


				$special_section = array(
					'args' => array(
						'orderby' => 'post__in',
						'post__in'=> $issue['special_section']
						),
					'heading' => 'Special Section',
					);

				Components\build_with( $special_section, 'article_teasers');
			}

		//Articles

			$not_in = array_merge($issue['featured'],$issue['special_section']);

			$articles = array(
				'args' => array(
					'cat' => $context->term_id,
					'post_type' => 'post',
					'post__not_in' => $not_in,
					'posts_per_page' => -1,
					),
				'heading' => 'Articles',
				'not_first' => true,
				);
			
			Components\build_with( $articles, 'article_teasers');

		//About

			$about = array(
				'heading' => $context->name,
				'text' => $context->description,
				);

			Components\build_with( $about, 'about.php');
