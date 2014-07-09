<?php
/**
 * Adventurous functions and definitions
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

if ( ! function_exists( 'adventurous_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Adventurous 1.0
 */
function adventurous_setup() {
	
	global $content_width;
	/**
	 * Global content width.
	 */
	 if (!isset($content_width))
     	$content_width = 1190;
				
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Adventurous, use a find and replace
	 * to change 'adventurous' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'adventurous', get_template_directory() . '/languages' );	
	
	/**
	 * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
	 * @see http://codex.wordpress.org/Function_Reference/add_editor_style
	 */
	add_editor_style();	
	
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Theme Options Defaults
	 */	
	require( get_template_directory() . '/inc/panel/adventurous-theme-options-defaults.php' );	

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/panel/adventurous-theme-options.php' );	
	
	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/adventurous-functions.php' );	
	
	/**
	 * Slider Function
	 */
	require( get_template_directory() . '/inc/adventurous-slider.php' );
	
	/**
	 * Headlines Function
	 */
	require( get_template_directory() . '/inc/adventurous-promotion-headlines.php' );

	/**
	 * Featured Content Function
	 */
	require( get_template_directory() . '/inc/adventurous-featured-content.php' );	
	
	/**
	 * Metabox
	 */
	require( get_template_directory() . '/inc/adventurous-metabox.php' );

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/adventurous-template-tags.php' );

	/**
	 * Register Sidebar and Widget.
	 */
	require( get_template_directory() . '/inc/adventurous-widgets.php' );		
	
	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		'default-color' => 'f9f9f9', 
	) );

	/**
     * This feature enables custom-menus support for a theme.
     * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
     */		
	register_nav_menus(array(
		'primary' 	=> __( 'Header Right Menu', 'adventurous' ),
		'secondary'	=> __( 'Header Secondary Menu', 'adventurous' )
	) );
	
	/**
	 * Custom Menus Functions.
	 */
	require( get_template_directory() . '/inc/adventurous-menus.php' );	

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio' ) );
	
	/**
     * This feature enables Jetpack plugin Infinite Scroll
     */		
    add_theme_support( 'infinite-scroll', array(
		'type'           => 'click',										
        'container'      => 'content',
        'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4' ),
        'footer'         => 'page'
    ) );
	
	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'slider', 1600, 600, true); //Featured Post Slider Image
	add_image_size( 'featured', 800, 324, true); //Featured Image
	add_image_size( 'small-featured', 400, 267, true); //Small Featured Image
		

}
endif; // adventurous_setup
add_action( 'after_setup_theme', 'adventurous_setup' );


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/adventurous-custom-header.php' );