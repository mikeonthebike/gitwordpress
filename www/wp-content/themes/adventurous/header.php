<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.min.js"></script>
	<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 
/** 
 * adventurous_before hook
 */
do_action( 'adventurous_before' ); ?>

<div id="page" class="hfeed site">

	<?php 
    /** 
     * adventurous_before_header hook
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * adventurous_header_top 10
     */
    do_action( 'adventurous_before_header' ); ?>
    
	<header id="masthead">
    
    	<?php 
		/** 
		 * adventurous_before_hgroup_wrap hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * adventurous_promotion_display 20
		 */
		do_action( 'adventurous_before_hgroup_wrap' ); ?>
        
    	<div id="hgroup-wrap" class="container">
        
       		<?php 
			/** 
			 * adventurous_hgroup_wrap hook
			 *
			 * HOOKED_FUNCTION_NAME PRIORITY
			 *
			 * adventurous_header_image 10
			 * adventurous_header_right 20
			 */
			do_action( 'adventurous_hgroup_wrap' ); ?>
            
        </div><!-- #hgroup-wrap -->
        
        <?php 
		/** 
		 * adventurous_after_hgroup_wrap hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * adventurous_homepage_featured_position 10
		 */
		do_action( 'adventurous_after_hgroup_wrap' ); ?>
        
	</header><!-- #masthead .site-header -->
    
	<?php 
    /** 
     * adventurous_after_header hook
     */
    do_action( 'adventurous_after_header' ); ?> 
    
    <div id="main-wrapper">
		<?php 
        /** 
         * adventurous_before_main hook
         *
         * HOOKED_FUNCTION_NAME PRIORITY
         *
	 	 * adventurous_featured_overall_image value after header 5
		 * adventurous_secondary_menu 10
		 * content_sidebar_check 20
         * adventurous_slider_display 40
         * adventurous_homepage_headline value after slider 60
         * adventurous_homepage_featured_display 80
         */
        do_action( 'adventurous_before_main' ); ?>    
        
		<?php 
        /** 
         * adventurous_main hook
         *
         * HOOKED_FUNCTION_NAME PRIORITY
         *
         * adventurous_main_wrapper 10
         */
        do_action( 'adventurous_main' ); ?> 
                 
			<?php 
            /** 
             * adventurous_content_sidebar hook
             *
             * HOOKED_FUNCTION_NAME PRIORITY
             *
             * adventurous_content_sidebar_wrapper 10
			 * adventurous_breadcrumb_display 20
             */
            do_action( 'adventurous_content_sidebar' ); ?> 
