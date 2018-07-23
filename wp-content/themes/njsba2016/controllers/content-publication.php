<?php

/*

	this is a build_with component

	Fields

		['primary_args']
		['primary_heading']
		['secondary_args']
		['secondary_heading']


*/
	if($context['primary_args']){
			
		$categories = get_categories( $context['primary_args'] );
		$context['primary_args']['include'] = array();

		foreach ($categories as &$category) {

			$pub_date = get_field('issue', $category);
			$pub_date = $pub_date[0];
			$pub_date = $pub_date['date'];
			$category->pub_date  = $pub_date;
			$category->pub_date = date("Ymd", strtotime($category->pub_date));
			$context['primary_args']['include']['i'.$category->pub_date] = $category->term_id;
		}
		krsort($context['primary_args']['include']);
		unset($context['primary_args']['child_of']);

		//custom list of categories
		$list = '';

		foreach ($context['primary_args']['include'] as $cat_id) {
				
			$name = get_cat_name($cat_id);
			$link = get_category_link($cat_id);
			$list .= '<li><a href="'.$link.'">'.$name.'</a></li>';
		}
		
		
		$context['primary_list_links'] = $list;

	}

	if($context['secondary_args']){
		$context['secondary_args']['title_li'] = '';
		$context['secondary_args']['echo'] = 0;
		$context['secondary_list_links'] = wp_list_categories( $context['secondary_args'] );
	}

	
if (empty($context)) return;

Timber::render('content-publications.twig', $context);



	

	
