<?php
if ( ! function_exists( 'adventurous_homepage_headline' ) ) :
/**
 * Template for Homepage Headline
 *
 * To override this in a child theme
 * simply create your own adventurous_homepage_headline(), and that function will be used instead.
 *
 * @uses adventurous_before_main action to add it in the header
 * @since Adventurous 1.0
 */
function adventurous_homepage_headline() { 
	//delete_transient( 'adventurous_homepage_headline' );
	
	global $post, $wp_query, $adventurous_options_settings;
   	$options = $adventurous_options_settings;
	
	// Getting data from Theme Options
	$disable_headline = $options[ 'disable_homepage_headline' ];
	$disable_subheadline = $options[ 'disable_homepage_subheadline' ];
	$disable_button = $options[ 'disable_homepage_button' ];
	$homepage_headline = $options[ 'homepage_headline' ];
	$homepage_subheadline = $options[ 'homepage_subheadline' ];
	$homepage_headline_button = $options[ 'homepage_headline_button' ];
	$homepage_headline_target = $options[ 'homepage_headline_target' ];
	
	//support qTranslate plugin
	if ( function_exists( 'qtrans_convertURL' ) ) {
		$homepage_headline_url = qtrans_convertURL($options[ 'homepage_headline_url' ]);
	}
	else {
		$homepage_headline_url = $options[ 'homepage_headline_url' ];
	}
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	 if ( empty( $disable_headline ) || empty( $disable_subheadline ) || empty( $disable_button ) ) { 
		
		if ( !$adventurous_homepage_headline = get_transient( 'adventurous_homepage_headline' ) ) {
			
			echo '<!-- refreshing cache -->';	
			
			$adventurous_homepage_headline = '<div id="homepage-message"><div class="container"><div class="left-section">';
			
			if ( $disable_headline == "0" ) {
				$adventurous_homepage_headline .= '<h2>' . $homepage_headline . '</h2>';
			}
			if ( $disable_subheadline == "0" ) {
				$adventurous_homepage_headline .= '<p>' . $homepage_subheadline . '</p>';
			}			
			
			$adventurous_homepage_headline .= '</div><!-- .left-section -->';  
			
			if ( !empty ( $homepage_headline_url ) && $disable_button == "0" ) {
				if ( !empty ( $homepage_headline_target ) ) {
					$headlinetarget = '_blank';
				}
				else {
					$headlinetarget = '_self';
				}
				
				$adventurous_homepage_headline .= '<div class="right-section"><a href="' . $homepage_headline_url . '" target="' . $headlinetarget . '">' . $homepage_headline_button . '</a></div><!-- .right-section -->';
			}
			
			$adventurous_homepage_headline .= '</div><!-- .container --></div><!-- #homepage-message -->';
			
			set_transient( 'adventurous_homepage_headline', $adventurous_homepage_headline, 86940 );
		}
		echo $adventurous_homepage_headline;	
	 }
}
endif; // adventurous_homepage_featured_content


if ( ! function_exists( 'adventurous_promotion_display' ) ) :
/**
 * Shows Promotion Headline
 */
function adventurous_promotion_display() {
	global $post, $wp_query, $adventurous_options_settings;;
   	$options = $adventurous_options_settings;

	// get data value from theme options
	$enablepromotion = $options[ 'enable_promotion' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if ( ( $enablepromotion == 'allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enablepromotion == 'homepage' ) ) :
		add_action( 'adventurous_before_main', 'adventurous_homepage_headline', 60 );
	endif;	
}
endif; // adventurous_promotion_display

add_action( 'adventurous_before_hgroup_wrap', 'adventurous_promotion_display', 20 );