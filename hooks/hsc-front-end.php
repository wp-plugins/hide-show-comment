<?php
// add hsc-comment-class to comment list
add_filter('comment_class', 'add_hsc_class');
function add_hsc_class( $classes ) 
{
	array_push($classes, 'hsc-comment-class');

	return $classes;
}


// enqueue_scripts
add_action('wp_enqueue_scripts', 'hsc_wp_enqueue_scripts', 100);
function hsc_wp_enqueue_scripts()
{
    HSCGenerate::generate_in_frontend();
    HSCGenerate::generate_in_frontend('load-more');
}