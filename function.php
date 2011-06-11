<?php

add_action('wp_enqueue_scripts', 'my_scripts');

function my_scripts() {
  /* All JavaScript at the bottom, except for Modernizr and Respond.
     Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
     For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ */
	wp_enqueue_script( 'modernizr', get_bloginfo('stylesheet_directory').'/js/libs/modernizr-2.0.min.js', array(), '2.0', false );
	wp_enqueue_script( 'respond', get_bloginfo('stylesheet_directory').'/js/libs/respond.min.js', array(), false, false );
	
}



?>