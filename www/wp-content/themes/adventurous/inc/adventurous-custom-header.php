<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses adventurous_header_style()
 * @uses adventurous_admin_header_style()
 * @uses adventurous_header_image()
 *
 * @package Adventurous
 */
function adventurous_custom_header_setup() {
	
	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'highway' => array(
			'url' => '%s/images/demo/header-1-1600x400.jpg',
			'thumbnail_url' => '%s/images/demo/header-1-320x66.jpg',
			/* translators: header image description */
			'description' => __( 'Highway', 'adventurous' )
		),
		'buddha' => array(
			'url' => '%s/images/demo/header-2-1600x400.jpg',
			'thumbnail_url' => '%s/images/demo/header-2-320x66.jpg',
			/* translators: header image description */
			'description' => __( 'Buddha', 'adventurous' )
		),
	) );
	
	$args = array(
		// Header image random rotation default
		'random-default'		=> false,
		
		// Text color and image (empty to use none).
		'default-text-color'     => '000',
		
		// Set height and width, with a maximum value for the width.
		'height'                 => 400,
		'width'                  => 1600,
		
		// Support flexible height and width.
		'flex-height'            => false,
		'flex-width'             => false,
			
		// Random image rotation off by default.
		'random-default'         => false,	
			
		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'adventurous_header_style',
		'admin-head-callback'    => 'adventurous_admin_header_style',
		'admin-preview-callback' => 'adventurous_admin_header_image',
	);

	$args = apply_filters( 'adventurous_custom_header_args', $args );
	
	/*
	 * This theme supports custom header for logo
	 * 
	 */	
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'adventurous_custom_header_setup' );


/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}


if ( ! function_exists( 'adventurous_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see adventurous_custom_header_setup().
 *
 * @since Adventurous 1.0
 */
function adventurous_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' != get_header_textcolor() ) { ?>
			#site-title a,
			#site-description {
				color: #<?php echo get_header_textcolor(); ?> !important;
			}
	<?php
	} ?>
	</style>
	<?php
}
endif; // adventurous_header_style


if ( ! function_exists( 'adventurous_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see adventurous_custom_header_setup().
 *
 * @since Adventurous 1.0
 */
function adventurous_admin_header_style() {
	?>
	<style type="text/css">
	<?php if ( HEADER_TEXTCOLOR == get_header_textcolor() ) : ?>
		#site-logo,
		#hgroup {
			display: inline-block;
			float: left;
		}
		#hgroup.logo-enable.logo-left {
			padding-left: 15px;
		}
		#hgroup.logo-enable.logo-right {
			padding-right: 15px;
		}
		#site-title {
			font-size: 22px;
			font-weight: bold;
			line-height: 1.1;
			margin: 0;
		}
		#site-title a {
			color: #000;
			text-decoration: none;
		}		
		#site-description  {
			color: #333;
			font-size: 14px;
			font-style: italic;
			line-height: 1.2;
			padding: 0;
			
		}
	<?php endif; ?>
	
	<?php 
	$image = get_header_image();
	if ( $image ) : ?>
		#header-featured-image {
			border: none;
			clear: both;
			display: block;
			overflow: hidden;
			width: 70%;
		}
		#header-featured-image img {
			max-width: 95%;
			height: auto;
		}
	<?php endif; ?>	
	
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#hgroup { padding: 0; }
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // adventurous_admin_header_style


if ( ! function_exists( 'adventurous_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see adventurous_custom_header_setup().
 *
 * @since Adventurous 1.0
 */
function adventurous_header_image() { 
	//Get Theme Options Data
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;	
	$text_color = get_header_textcolor();
	
	echo '<div id="header-left">';
	
		// Check Seconddary Menu 
		if ( has_nav_menu( 'secondary' ) ) {
    		echo '<div id="secondary-mobile-menu"><a href="#" class="mobile-nav closed"><span class="mobile-menu-bar"></span></a></div>';
		}
         
		// Check Logo
		if ( empty( $options['remove_header_logo'] ) ) { 

			$sitedetails = 'logo-enable logo-left';
			
			// Check Logo URL
			$adventurous_header_logo = '
			<div id="site-logo">
            	<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
					
					
					if ( !empty( $options[ 'featured_logo_header' ] ) ) {
						$adventurous_header_logo .= '<img src="' . esc_url( $options['featured_logo_header'] ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
					} else {
						// if empty featured_logo_header on theme options, display default logo
						$adventurous_header_logo .='<img src="' . esc_url( $defaults['featured_logo_header'] ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
					}
					$adventurous_header_logo .= '
				</a>
			</div><!-- #site-logo -->';
		}
		else {
			$sitedetails = 'logo-disable'; 
			$adventurous_header_logo = '';	
		}
		
		if ( 'blank' == get_header_textcolor() ) {
			$sitedetails .= ' assistive-text';
		}
		
		
		// Checking Header Details
		$adventurous_header_details = '
		<div id="hgroup" class="' . $sitedetails . '">
			<h1 id="site-title">
				<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>
			</h1>
			<h2 id="site-description"> ' . esc_attr( get_bloginfo( 'description', 'display' ) ) . '</h2>
		</div><!-- #hgroup -->';  		
		
		echo $adventurous_header_logo;
		echo $adventurous_header_details;
		   
		?>
	</div><!-- #header-left"> -->
<?php }
endif; // adventurous_header_image

add_action( 'adventurous_hgroup_wrap', 'adventurous_header_image', 10 );


/**
 * Shows Header Right Sidebar
 */
function adventurous_header_right() { 

	/* A sidebar in the Header Right 
	*/
	get_sidebar( 'header-right' ); 

}
add_action( 'adventurous_hgroup_wrap', 'adventurous_header_right', 20 );


if ( ! function_exists( 'adventurous_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @since Adventurous 1.0
 */
function adventurous_admin_header_image() {
	
	adventurous_header_image(); 
	adventurous_featured_image();

}
endif; // adventurous_admin_header_image


if ( ! function_exists( 'adventurous_featured_image' ) ) :
/**
 * Template for Custom Header Image
 *
 * To override this in a child theme
 * simply create your own adventurous_featured_image(), and that function will be used instead.
 *
 * @since Adventurous 1.0
 */
function adventurous_featured_image() {

	// Getting Data from Theme Options Panel
	global $adventurous_options_settings, $_wp_default_headers;
   	$options = $adventurous_options_settings;
	$header_image = get_header_image();
	$enableheaderimage = $options[ 'enable_featured_header_image' ];
		
	if ( !empty( $header_image ) ) {	

		// Header Image Title/Alt
		if ( !empty( $options[ 'featured_header_image_alt' ] ) ) :
			$title = esc_attr($options[ 'featured_header_image_alt' ]); 	
		else:
			$title = ''; 	
		endif;
		
		// Header Image Link 
		if ( !empty( $options[ 'featured_header_image_url' ] ) ) :
			//support for qtranslate custom link
			if ( function_exists( 'qtrans_convertURL' ) ) {
				$link = qtrans_convertURL($options[ 'featured_header_image_url' ]);
			}
			else {
				$link = esc_url($options[ 'featured_header_image_url' ]);
			}
			if ( !empty( $options[ 'featured_header_image_base' ] ) ) :
				$base = '_blank'; 	
			else:
				$base = '_self'; 	
			endif;
			$linkopen = '<a title="'.$title.'" href="'.$link.'" target="'.$base.'">';
			$linkclose = '</a>';
		else:
			$link = ''; 
			$base = ''; 
			$linkopen = '';
			$linkclose = '';
		endif;
		
		echo '<div id="header-featured-image">' . $linkopen . '<img id="main-feat-img" alt="' . $title . '" src="' . esc_url( $header_image ) . '" />' . $linkclose . '</div><!-- #header-featured-image -->';	
	}
	
} // adventurous_featured_image
endif;


if ( ! function_exists( 'adventurous_featured_page_post_image' ) ) :
/**
 * Template for Featured Header Image from Post and Page
 *
 * To override this in a child theme
 * simply create your own adventurous_featured_imaage_pagepost(), and that function will be used instead.
 *
 * @since Adventurous 1.0
 */
function adventurous_featured_page_post_image() {

	global $post, $wp_query, $adventurous_options_settings, $adventurous_options_defaults;
   	$options = $adventurous_options_settings;
	$defaults = $adventurous_options_defaults; 
	$enableheaderimage =  $options[ 'enable_featured_header_image' ];
	$featured_image = $options['page_featured_image'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	//Individual Page/Post Image Setting
	$individual_featured_image = get_post_meta( $post->ID, 'adventurous-header-image', true ); 
	
	if ( $individual_featured_image == 'disable' || ( $individual_featured_image == 'default' && $enableheaderimage == 'disable' ) ) {
		echo '<!-- Page/Post Disable Header Image -->';
	}
	elseif ( is_home() || is_archive() ) {
		if ( $enableheaderimage == 'postpage' ) {
			adventurous_featured_image();
		}
		else {
			echo '<!-- Page/Post will not display in Home/Archive -->';
		}
	}		
	elseif ( has_post_thumbnail() ) {
		
		echo '<div id="header-featured-image">';
			
			if ( !empty( $options[ 'featured_header_image_url' ] ) ) {
				// Header Image Link Target
				if ( !empty( $options[ 'featured_header_image_base' ] ) ) :
					$base = '_blank'; 	
				else:
					$base = '_self'; 	
				endif;
				
				// Header Image Title/Alt
				if ( !empty( $options[ 'featured_header_image_alt' ] ) ) :
					$title = esc_attr( $options[ 'featured_header_image_alt' ] ); 
				else:
					$title = ''; 	
				endif;
				
				$linkopen = '<a title="'.$title.'" href="'.$options[ 'featured_header_image_url' ] .'" target="'.$base.'">';
				$linkclose = '</a>';
			}
			else {
				$linkopen = '';
				$linkclose = '';
			}
		
			echo $linkopen;
				if ( $individual_featured_image == 'featured' || ( $individual_featured_image=='default' && $featured_image == 'featured' ) ) { 
					echo get_the_post_thumbnail($post->ID, 'featured', array('id' => 'main-feat-img'));
				} 
				elseif ( $individual_featured_image == 'slider' || ( $individual_featured_image=='default' && $featured_image == 'slider' ) ) {
					echo get_the_post_thumbnail($post->ID, 'slider', array('id' => 'main-feat-img'));
				}
				else { 
					echo get_the_post_thumbnail($post->ID, 'full', array('id' => 'main-feat-img'));
				}
			echo $linkclose;
		echo '</div><!-- #header-featured-image -->';
	}	
	else {
		adventurous_featured_image();
	}	
	
} // adventurous_featured_page_post_image
endif;


if ( ! function_exists( 'adventurous_featured_overall_image' ) ) :
/**
 * Template for Featured Header Image from theme options
 *
 * To override this in a child theme
 * simply create your own adventurous_featured_pagepost_image(), and that function will be used instead.
 *
 * @since Adventurous 1.0
 */
function adventurous_featured_overall_image() {

	global $post, $wp_query, $adventurous_options_settings, $adventurous_options_defaults;
   	$options = $adventurous_options_settings;
	$defaults = $adventurous_options_defaults; 
	$enableheaderimage =  $options[ 'enable_featured_header_image' ];
	$featured_image = $options['page_featured_image'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	//Individual Page/Post Image Setting
	$individual_featured_image = get_post_meta( $post->ID, 'adventurous-header-image', true ); 
	
	if ( $individual_featured_image  == 'disable' ) {
		echo '<!-- Disable Header Image in Page/Post -->';	
	}
	elseif ( $individual_featured_image  == 'enable' ) {
		adventurous_featured_page_post_image();
	}
	elseif ( $enableheaderimage == 'allpage' || ( $enableheaderimage == 'homepage' && ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) ) ) {
		adventurous_featured_image();
	}
	elseif ( $enableheaderimage == 'excludehome' && !(is_home() ) ) {
		adventurous_featured_image();
	}
	elseif ( $enableheaderimage == 'postpage' || $enableheaderimage == 'pagespostes' ) {
		adventurous_featured_page_post_image();
	}
	else {
		echo '<!-- Disable Header Image -->';
	}
	
} // adventurous_featured_overall_image
endif;


add_action( 'adventurous_before_main', 'adventurous_featured_overall_image', 5 );