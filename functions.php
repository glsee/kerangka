<?php

add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

function my_enqueue_scripts() {
  /* All JavaScript at the bottom, except for Modernizr and Respond.
     Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
     For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ */
	wp_enqueue_script( 'modernizr', get_bloginfo('stylesheet_directory').'/js/libs/modernizr-2.0.min.js', array(), '2.0', false );
	wp_enqueue_script( 'respond', get_bloginfo('stylesheet_directory').'/js/libs/respond.min.js', array(), false, false );
	
	
	/* Although HTML5 Boilerplate suggests to have jQuery before the end of body, too many WordPress features/plugins depend on it.
	   Put it before the end of head to be safe. */
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js');
	//wp_enqueue_script( 'jquery' );
	
  /* scripts concatenated and minified via ant build script */
	wp_enqueue_script( 'my_plugins', get_bloginfo('stylesheet_directory').'/js/plugins.js', array(), false, true /* in_footer */ );
	wp_enqueue_script( 'my_script', get_bloginfo('stylesheet_directory').'/js/script.js', array(), false, true /* in_footer */ );
  	
}


add_action('wp_footer', 'my_footer_scripts');

function my_footer_scripts() {
	if ( wp_script_is( 'jquery', 'queue' ) ) {
?>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script>window.jQuery || document.write('<script src="<?php bloginfo('stylesheet_directory'); ?>/js/libs/jquery-1.6.1.min.js"><\/script>')</script>
<?php
	}
?>

  <!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  
<?php
}


?>