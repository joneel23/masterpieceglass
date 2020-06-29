<?php
/**
 * MX child theme functions and definitions
 *
 * @since MX 4.6
 */

function custom_register_scripts(){
    wp_enqueue_script('masterpice-js', get_stylesheet_directory_uri() . '/inc/js/masterpiece.js', array('jquery') ,'1.4.1', true);
    wp_enqueue_script('isotope-js', get_stylesheet_directory_uri() . '/js-plugins/isotope.pkgd.min.js', array('jquery') ,'3.0.6', true);
}
add_action('wp_enqueue_scripts','custom_register_scripts');

require_once( dirname( __FILE__ ) . '/custom-widgets/mp-widgets.php' );

require_once( dirname( __FILE__ ) . '/custom-shortcodes/mx-shortcode.php' );

//require_once( dirname( __FILE__ ) . '/custom-widgets/hero-button-widget.php' );



