<?php
/**
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

/**
 * Set the default values for all the settings. If no user-defined values
 * is available for any setting, these defaults will be used.
 */
global $adventurous_options_defaults;
$adventurous_options_defaults = array(
	'fav_icon'								=> get_template_directory_uri().'/images/favicon.ico',
 	'remove_favicon'						=> '1',
	'web_clip'								=> get_template_directory_uri().'/images/apple-touch-icon.png',
 	'remove_web_clip'						=> '1',
	'remove_header_logo'					=> '1',
	'featured_logo_header'					=> get_template_directory_uri().'/images/logo.png',
	'enable_promotion'						=> 'homepage',
	'homepage_headline'						=> __( 'Adventurous is a Simple, Clean and Responsive WordPress Theme', 'adventurous' ),
	'homepage_subheadline'					=> __( 'This is Promotion Headine. You can edit this from "Appearance => Theme Options => Promotion Headeline Options"', 'adventurous' ),
	'homepage_headline_button'				=> __( 'Reviews', 'adventurous' ),
	'homepage_headline_url'					=> esc_url( 'http://wordpress.org/support/view/theme-reviews/adventurous' ),
	'homepage_headline_target'				=> '1',
	'reset_featured_image'					=> '2',
	'enable_featured_header_image'			=> 'homepage',
	'page_featured_image'					=> 'full',
	'featured_header_image_url'				=> '',
	'featured_header_image_alt'				=> '',
	'featured_header_image_base'			=> '0',
 	'disable_header_right_sidebar'			=> '0',
	'reset_typography'						=> '2',	
	'custom_css'							=> '',	
	'sidebar_layout'						=> 'right-sidebar',
	'content_layout'						=> 'full',
	'featured_image'						=> 'featured',
	'reset_layout'							=> '2',
	'more_tag_text'							=> __( 'Continue Reading &rarr;', 'adventurous' ),
	'reset_moretag'							=> '2',
	'excerpt_length'						=> 30,
 	'search_display_text'					=> __( 'Search &hellip;', 'adventurous' ),
	'disable_homepage_headline'				=> '0',
	'disable_homepage_subheadline'			=> '0',
	'disable_homepage_button'				=> '0',
	'enable-featured'						=> 'homepage',
	'homepage_featured_headline'			=> '',
	'homepage_featured_subheadline'			=> '',
	'homepage_featured_qty'					=> 4,
	'homepage_featured_layout'				=> 'four-columns',
	'homepage_featured_image'				=> array(),
	'homepage_featured_url'					=> array(),
	'homepage_featured_base'				=> array(),
	'homepage_featured_title'				=> array(),
	'homepage_featured_content'				=> array(),
	'enable_posts_home'						=> '0',
 	'front_page_category'					=> array(),
	'select_slider_type'					=> 'demo-slider',
	'enable_slider'							=> 'enable-slider-homepage',
	'disable_slider_text'					=> '1',
 	'featured_slider'						=> array(),
	'slider_category'						=> array(),
	'slider_qty'							=> 4,
 	'transition_effect'						=> 'fade',
 	'transition_delay'						=> 4,
 	'transition_duration'					=> 1,	
	'exclude_slider_post'					=> '0',
 	'social_facebook'						=> '',
 	'social_twitter'						=> '',
 	'social_googleplus'						=> '',
 	'social_pinterest'						=> '',
 	'social_youtube'						=> '',
 	'social_vimeo'							=> '',
 	'social_linkedin'						=> '',
 	'social_slideshare'						=> '',
 	'social_foursquare'						=> '',
 	'social_flickr'							=> '',
 	'social_tumblr'							=> '',
 	'social_deviantart'						=> '',
 	'social_dribbble'						=> '',
 	'social_myspace'						=> '',
 	'social_wordpress'						=> '',
 	'social_rss'							=> '',
 	'social_delicious'						=> '',
 	'social_lastfm'							=> '',
	'social_instagram'						=> '',
	'social_github'							=> '',
	'social_vkontakte'						=> '',
	'social_myworld'						=> '',
	'social_odnoklassniki'					=> '',
	'social_goodreads'						=> '',
	'social_skype'							=> '',
	'social_soundcloud'						=> '',
	'footer_code'							=> '<div class="copyright">'. esc_attr__( 'Copyright', 'adventurous' ) . ' &copy; [the-year] [site-link]. '. esc_attr__( 'All Rights Reserved', 'adventurous' ) . '.</div><div class="powered">'. esc_attr__( 'Powered by', 'adventurous' ) . ': [wp-link] | '. esc_attr__( 'Theme', 'adventurous' ) . ': [theme-link]</div>',
	'reset_footer'							=> '2'
);
global $adventurous_options_settings;
$adventurous_options_settings = adventurous_options_set_defaults( $adventurous_options_defaults );

function adventurous_options_set_defaults( $adventurous_options_defaults ) {
	$adventurous_options_settings = array_merge( $adventurous_options_defaults, (array) get_option( 'adventurous_options', array() ) );
	return $adventurous_options_settings;
}

?>