<?php


		$issue = get_field('issue', $context)[0];
		$parent = get_term($context->parent, 'category');




		//Job Details

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


