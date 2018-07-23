<?php
/**
 * Template Name: List Landing
 */

	global $post;

	$slug = get_post( $post )->post_name;

	$category_with_same_name = get_term_by('slug', $slug ,'category');
	
	Components\build_with($category_with_same_name,'list_landing');
