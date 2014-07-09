<?php
/**
 * The Header Right widget areas.
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
?>
<?php 
/** 
 * adventurous_before_header_right hook
 */
do_action( 'adventurous_before_header_right' ); ?> 
<?php 
global $adventurous_options_settings;
$options = $adventurous_options_settings;

if ( $options[ 'disable_header_right_sidebar' ] == "0" ) {	?>
    <div id="header-right" class="header-sidebar widget-area">
        <aside class="widget widget_nav_menu">
            <?php adventurous_primary_menu(); ?>
        </aside>
        <aside class="widget widget_search" id="header-search-widget">
            <span id="header-search" href="#"></span>
            <div class="header-search-wrap displaynone">
                <?php echo get_search_form(); ?>
            </div>
        </aside>
        <div id="header-mobile-menu"><a href="#" class="mobile-nav closed"><span class="mobile-menu-bar"></span></a></div>  
    </div><!-- #header-right .widget-area -->
<?php 
}
/** 
 * adventurous_after_header_right hook
 */
do_action( 'adventurous_after_header_right' ); ?> 