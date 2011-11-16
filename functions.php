<?php

/* enable theme capability */
add_theme_support( 'menus' );
register_nav_menu( 'primary', 'Primary menu near the top of the webpages' );
register_nav_menu( 'footer', 'Footer menu near the bottom of the webpages' );
// add_theme_support( 'post-thumbnails' );
// set_post_thumbnail_size( 50, 50, true );


/* Although HTML5 Boilerplate suggests to have jQuery before the end of body, too many WordPress features/plugins depend on it.
   Put it before the end of head to be safe.
   CDN loading code based on http://wp.tutsplus.com/tutorials/load-jquery-from-google-cdn-with-local-fallback-for-wordpress/
   For the record, jQuery comes with WordPress is version 1.6.4 but this uses latest jQuery version. Change it for backward-compatibility. */

$url = 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js'; // the URL to check against
$test_url = @fopen($url,'r'); // test parameters
if($test_url !== false) { // test if the URL exists
	function load_external_jQuery() {
		wp_deregister_script( 'jquery' );
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js');
	}
	add_action('wp_enqueue_scripts', 'load_external_jQuery'); // initiate the function
} else {
	function load_local_jQuery() {
		wp_deregister_script('jquery');
		wp_register_script('jquery', bloginfo('template_url').'/js/libs/jquery-1.7.0.min.js', __FILE__, false, '1.7.0', false /* load in <head>, too many plugins depend on it */ );
	}
	add_action('wp_enqueue_scripts', 'load_local_jQuery'); // initiate the function
}

wp_enqueue_script( 'jquery' ); // enqueue jQuery only when needed. Comment this if it's not needed.



add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

function my_enqueue_scripts() {
  /* All JavaScript at the bottom, except this Modernizr build incl. Respond.js
     Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects;
     for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ */
	wp_enqueue_script( 'modernizr', get_bloginfo('template_directory').'/js/libs/modernizr-2.0.6.min.js', array(), '2.0.6', false );

	
  /* scripts concatenated and minified via ant build script */
	wp_enqueue_script( 'my_plugins', get_bloginfo('template_directory').'/js/plugins.js', array(), false, true /* in_footer */ );
	wp_enqueue_script( 'my_script', get_bloginfo('template_directory').'/js/script.js', array(), false, true /* in_footer */ );
  	
}


add_action('wp_footer', 'my_footer_scripts');

function my_footer_scripts() {
	?>
	<!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview'],['_trackPageLoadTime']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>

	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
		chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
		<script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
	<?php
}