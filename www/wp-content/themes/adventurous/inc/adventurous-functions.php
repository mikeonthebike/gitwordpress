<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

/**
 * Enqueue scripts and styles
 */
function adventurous_scripts() {
	
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $adventurous_options_settings;
   	$options = $adventurous_options_settings;
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	/**
	 * Loads up main stylesheet.
	 */
	wp_enqueue_style( 'adventurous-style', get_stylesheet_uri() );		
	
	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.3' );	

	/**
	 * Loads up Responsive stylesheet
	 */
	wp_enqueue_style( 'adventurous-responsive', get_template_directory_uri() . '/css/responsive.css' );
	
	/**
	 * Loads up Responsive Video Script
	 */	
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array( 'jquery' ), '20140317', true );	
	
	/**
	 * Loads up jQuery Waypoints and Custom Scripts
	 */	
	wp_register_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), '2.0.5', true);
	wp_enqueue_script( 'adventurous-custom', get_template_directory_uri() . '/js/adventurous-custom.js', array( 'waypoints' ), '20140317', true );	
	
	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	/**
	 * Register JQuery circle all and JQuery set up as dependent on Jquery-cycle
	 */			
	wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '20140317', true );
	
	/**
	 * Loads up adventurous-slider and jquery-cycle set up as dependent on adventurous-slider
	 */	
	$enableslider = $options[ 'enable_slider' ];	
	if ( ( $enableslider == 'enable-slider-allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'enable-slider-homepage' ) ) {	
		wp_enqueue_script( 'adventurous-slider', get_template_directory_uri() . '/js/adventurous-slider.js', array( 'jquery-cycle' ), '20140317', true );
	}	
	
	/**
	 * Browser Specific Enqueue Script
	 */		
	$adventurous_ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-8]/',$adventurous_ua)) {
	 	wp_enqueue_script( 'selectivizr', get_template_directory_uri() . '/js/selectivizr.min.js', array( 'jquery' ), '20130114', false );		
		wp_enqueue_style( 'adventurous-iecss', get_template_directory_uri() . '/css/ie.css' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'adventurous_scripts' );


/**
 * Responsive Layout
 *
 * @get the data value of responsive layout from theme options
 * @display responsive meta tag 
 * @action wp_head
 */
function adventurous_responsive() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
} // adventurous_responsive
add_filter( 'wp_head', 'adventurous_responsive', 1 );


/**
 * Get the favicon Image from theme options
 *
 * @uses favicon 
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default favicon if favicon field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function adventurous_favicon() {
	//delete_transient( 'adventurous_favicon' );	
	
	if( ( !$adventurous_favicon = get_transient( 'adventurous_favicon' ) ) ) {
		global $adventurous_options_settings;
   		$options = $adventurous_options_settings;
		
		echo '<!-- refreshing cache -->';
		if ( $options[ 'remove_favicon' ] == "0" ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'fav_icon' ] ) ) :
				$adventurous_favicon = '<link rel="shortcut icon" href="'.esc_url( $options[ 'fav_icon' ] ).'" type="image/x-icon" />'; 	
			else:
				// if empty fav_icon on theme options, display default fav icon
				$adventurous_favicon = '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/images/favicon.ico" type="image/x-icon" />';
			endif;
		endif;
		
		set_transient( 'adventurous_favicon', $adventurous_favicon, 86940 );	
	}	
	echo $adventurous_favicon ;	
} // adventurous_favicon

//Load Favicon in Header Section
add_action('wp_head', 'adventurous_favicon');

//Load Favicon in Admin Section
add_action( 'admin_head', 'adventurous_favicon' );


if ( ! function_exists( 'adventurous_content_image' ) ) :
/**
 * Template for Featured Image in Content
 *
 * To override this in a child theme
 * simply create your own adventurous_content_image(), and that function will be used instead.
 *
 * @since Adventurous 1.0
 */
function adventurous_content_image() {
	global $post, $wp_query;
	
	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if( $post) {
 		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$individual_featured_image = get_post_meta( $parent,'adventurous-featured-image', true );
		} else {
			$individual_featured_image = get_post_meta( $page_id,'adventurous-featured-image', true ); 
		}
	}

	if( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
		$individual_featured_image='default';
	}
	
	// Getting data from Theme Options
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;
	
	$featured_image = $options['featured_image'];
		
	if ( ( $individual_featured_image == 'disable' || '' == get_the_post_thumbnail() || ( $individual_featured_image=='default' && $featured_image == 'disable') ) ) {
		return false;
	}
	else { ?>
		<figure class="featured-image">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'adventurous' ), the_title_attribute( 'echo=0' ) ) ); ?>">
                <?php 
				if ( ( is_front_page() && $featured_image == 'featured' ) ||  $individual_featured_image == 'featured' || ( $individual_featured_image=='default' && $featured_image == 'featured' ) ) {
                     the_post_thumbnail( 'featured' );
                }	
				elseif ( ( is_front_page() && $featured_image == 'slider' ) || $individual_featured_image == 'slider' || ( $individual_featured_image=='default' && $featured_image == 'slider' ) ) {
					the_post_thumbnail( 'slider' );
				}
				else {
					the_post_thumbnail( 'full' );
				} ?>
			</a>
        </figure>
   	<?php
	}
}
endif; //adventurous_content_image 


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since Adventurous 1.0
 */
function adventurous_inline_css() {
	//delete_transient( 'adventurous_inline_css' );	 
	
	if ( ( !$adventurous_inline_css = get_transient( 'adventurous_inline_css' ) ) ) {
		// Getting data from Theme Options
		global $adventurous_options_settings, $adventurous_options_defaults;
   		$options = $adventurous_options_settings;
		$defaults = $adventurous_options_defaults;

		if ( !empty( $options[ 'custom_css' ] ) )  {
			
			$adventurous_inline_css	.= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $adventurous_inline_css .= '<style type="text/css" media="screen">' . "\n";
			$adventurous_inline_css .=  $options['custom_css'] . "\n";
			$adventurous_inline_css .= '</style>' . "\n";
			
		}
			
	set_transient( 'adventurous_inline_css', $adventurous_inline_css, 86940 );
	}
	echo $adventurous_inline_css;
}
add_action('wp_head', 'adventurous_inline_css');


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Adventurous 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function adventurous_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'adventurous' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'adventurous_wp_title', 10, 2 );


/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 * @uses filter excerpt_length
 */
function adventurous_excerpt_length( $length ) {
	// Getting data from Theme Options
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;

	return $options[ 'excerpt_length' ];
}
add_filter( 'excerpt_length', 'adventurous_excerpt_length' );


/**
 * Change the defult excerpt length of 30 to whatever passed as value
 * 
 * @use excerpt(10) or excerpt (..)  if excerpt length needs only 10 or whatevere
 * @uses get_permalink, get_the_excerpt
 */
function adventurous_excerpt_desired( $num ) {
    $limit = $num+1;
    $excerpt = explode( ' ', get_the_excerpt(), $limit );
    array_pop( $excerpt );
    $excerpt = implode( " ",$excerpt )."<a href='" .get_permalink() ." '></a>";
    return $excerpt;
}


/**
 * Returns a "Continue Reading" link for excerpts
 */
function adventurous_continue_reading() {
	// Getting data from Theme Options
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;
    
	$more_tag_text = $options[ 'more_tag_text' ];
	return ' <a class="more-link" href="'. get_permalink() . '">' .  $more_tag_text . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with adventurous_continue_reading().
 *
 */
function adventurous_excerpt_more( $more ) {
	return adventurous_continue_reading();
}
add_filter( 'excerpt_more', 'adventurous_excerpt_more' );


/**
 * Adds Continue Reading link to post excerpts.
 *
 * function tied to the get_the_excerpt filter hook.
 */
function adventurous_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= adventurous_continue_reading();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'adventurous_custom_excerpt' );


/**
 * Replacing Continue Reading link to the_content more.
 *
 * function tied to the the_content_more_link filter hook.
 */
function adventurous_more_link( $more_link, $more_link_text ) {
	// Getting data from Theme Options
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;
	
	$more_tag_text = $options[ 'more_tag_text' ];
	
	return str_replace( $more_link_text, $more_tag_text, $more_link );
}
add_filter( 'the_content_more_link', 'adventurous_more_link', 10, 2 );


/**
 * Adds custom classes to the array of body classes.
 *
 * @since Adventurous 1.0
 */
function adventurous_body_classes( $classes ) {
	global $post, $adventurous_options_settings;
	$options = $adventurous_options_settings;
	
	if ( ( class_exists( 'Woocommerce' ) && is_woocommerce() ) &&  !is_active_sidebar( 'adventurous_woocommerce_sidebar' ) ) {
		$classes[] = 'woocommerce-nosidebar';
	}		
	
	if ( is_page_template( 'page-blog.php') ) {
		$classes[] = 'page-blog';
	}
	
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	if ( $post) {
 		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent,'adventurous-sidebarlayout', true );
		} else {
			$layout = get_post_meta( $post->ID,'adventurous-sidebarlayout', true ); 
		}
	}

	if ( empty( $layout ) || ( !is_page() && !is_single() ) ) {
		$layout='default';
	}
	
	$themeoption_layout = $options['sidebar_layout'];
	
	if( ( $layout == 'no-sidebar' || ( $layout=='default' && $themeoption_layout == 'no-sidebar') ) ) {
		$classes[] = 'no-sidebar';
	}
	elseif( ( $layout == 'left-sidebar' || ( $layout=='default' && $themeoption_layout == 'left-sidebar') ) ){
		$classes[] = 'left-sidebar';
	}
	elseif( ( $layout == 'right-sidebar' || ( $layout=='default' && $themeoption_layout == 'right-sidebar') ) ){
		$classes[] = 'right-sidebar';
	}	
	
	$current_content_layout = $options['content_layout'];
	if( $current_content_layout == 'full' ) {
		$classes[] = 'content-full';
	}
	elseif ( $current_content_layout == 'excerpt' ) {
		$classes[] = 'content-excerpt';
	}
	
	return $classes;
}
add_filter( 'body_class', 'adventurous_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Adventurous 1.0
 */
function adventurous_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'adventurous_enhanced_image_navigation', 10, 2 );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Adventurous 1.0
 */
function adventurous_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'adventurous_page_menu_args' );


/**
 * Removes div from wp_page_menu() and replace with ul.
 *
 * @since Adventurous 1.0 
 */
function adventurous_wp_page_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
        return $new_markup; }

add_filter( 'wp_page_menu', 'adventurous_wp_page_menu' );
 

if ( ! function_exists( 'adventurous_main_wrapper' ) ) :
/**
 * Open Div ID main
 *
 */
function adventurous_main_wrapper() {
	echo '<div id="main">';
}
endif; // adventurous_main_wrapper


if ( ! function_exists( 'adventurous_main_wrapper_close' ) ) :
/**
 * Close Div ID main
 *
 */
function adventurous_main_wrapper_close() {
	echo '</div><!-- #main -->';
}
endif; // adventurous_main_wrapper_close



if ( ! function_exists( 'adventurous_content_sidebar_wrapper' ) ) :
/**
 * Open Div ID content-sidebar
 *
 */
function adventurous_content_sidebar_wrapper() {
	echo '<div id="content-sidebar" class="container">';
}
endif; // adventurous_content_sidebar_wrapper


if ( ! function_exists( 'adventurous_content_sidebar_wrapper_close' ) ) :
/**
 * Close Div ID content-sidebar
 *
 */
function adventurous_content_sidebar_wrapper_close() {
	echo '</div><!-- #content-sidebar -->';
}
endif; // adventurous_content_sidebar_wrapper_close


if ( ! function_exists( 'content_sidebar_check' ) ) :
/**
 * Cheking in Condition for main Wrap
 *
 */
function content_sidebar_check() {
	global $post, $wp_query, $adventurous_options_settings;
	// Getting data from Theme Options
	$options = $adventurous_options_settings;
	$enable_post = $options[ 'enable_posts_home' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');
	
	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();	
	
	if ( is_front_page() && is_home() && !empty( $enable_post ) ) {
		return;
	} 
	elseif ( is_front_page() ) {
		add_action( 'adventurous_main', 'adventurous_main_wrapper', 10 );
		add_action( 'adventurous_content_sidebar', 'adventurous_content_sidebar_wrapper', 10 );
		add_action( 'adventurous_content_sidebar_close', 'adventurous_content_sidebar_wrapper_close', 10 );
		add_action( 'adventurous_main_close', 'adventurous_main_wrapper_close', 10 );
	} 
	elseif ( is_home() && !empty( $enable_post ) && empty( $page_id ) ) {
		return;
	}
	else {
		add_action( 'adventurous_main', 'adventurous_main_wrapper', 10 );
		add_action( 'adventurous_content_sidebar', 'adventurous_content_sidebar_wrapper', 10 );
		add_action( 'adventurous_content_sidebar_close', 'adventurous_content_sidebar_wrapper_close', 10 );
		add_action( 'adventurous_main_close', 'adventurous_main_wrapper_close', 10 );
	}
}
endif; // content_sidebar_check

add_action( 'adventurous_before_main', 'content_sidebar_check', 20 );


/**
 * Footer Sidebar
 *
 * @Hooked in adventurous_footer
 * @since Adventurous 1.0
 */
function adventurous_footer_sidebar() {
	get_sidebar( 'footer' ); 
}  
add_action( 'adventurous_footer', 'adventurous_footer_sidebar', 10 ); 


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function adventurous_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;
		
	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;		

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one container';
			break;
		case '2':
			$class = 'two container';
			break;
		case '3':
			$class = 'three container';
			break;
		case '4':
			$class = 'four container';
			break;			
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


/**
 * Footer Site Generator Open
 *
 * @Hooked in adventurous_site_generator
 * @since Adventurous 1.0
 */
function adventurous_site_generator_open() {
	echo '<div id="site-generator"><div class="site-info container">';
}  
add_action( 'adventurous_site_generator', 'adventurous_site_generator_open', 10 ); 


/**
 * Footer Site Generator Close
 *
 * @Hooked in adventurous_site_generator
 * @since Adventurous 1.0
 */
function adventurous_site_generator_close() {
	echo '</div><!-- .site-info container --></div><!-- #site-generator -->';
}  
add_action( 'adventurous_site_generator', 'adventurous_site_generator_close', 100 ); 


if ( ! function_exists( 'adventurous_footer_content' ) ) :
/**
 * Template for Footer Content
 *
 * To override this in a child theme
 * simply create your own adventurous_footer_content(), and that function will be used instead.
 *
 * @uses adventurous_site_generator action to add it in the footer
 * @since Adventurous 1.0
 */
function adventurous_footer_content() { 
	//delete_transient( 'adventurous_footer_content' );	
	
	if ( ( !$adventurous_footer_content = get_transient( 'adventurous_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';
		
		// get the data value from theme options
		global $adventurous_options_settings;
   	 	$options = $adventurous_options_settings;
		
       // $adventurous_footer_content = $options[ 'footer_code' ];
		$adventurous_footer_content = $options[ 'footer_code' ];
		
    	set_transient( 'adventurous_footer_content', $adventurous_footer_content, 86940 );
    }
	echo do_shortcode( $adventurous_footer_content );
}
endif;
add_action( 'adventurous_site_generator', 'adventurous_footer_content', 20 );


/**
 * Alter the query for the main loop in homepage
 * @uses pre_get_posts hook
 */
function adventurous_alter_home( $query ){
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;
		
    $cats = $options[ 'front_page_category' ];

    if ( $options[ 'exclude_slider_post'] != "0" && !empty( $options[ 'featured_slider' ] ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['post__not_in'] = $options[ 'featured_slider' ];
		}
	}
	if ( !in_array( '0', $cats ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['category__in'] = $options[ 'front_page_category' ];
		}
	}
}
add_action( 'pre_get_posts','adventurous_alter_home' );


if ( ! function_exists( 'adventurous_social_networks' ) ) :
/**
 * Template for Social Icons
 *
 * To override this in a child theme
 * simply create your own adventurous_social_networks(), and that function will be used instead.
 *
 * @since Adventurous 1.0
 */
function adventurous_social_networks() {
	//delete_transient( 'adventurous_social_networks' );
	
	// get the data value from theme options
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;

    $elements = array();

	$elements = array( 	$options[ 'social_facebook' ], 
						$options[ 'social_twitter' ],
						$options[ 'social_googleplus' ],
						$options[ 'social_linkedin' ],
						$options[ 'social_pinterest' ],
						$options[ 'social_youtube' ],
						$options[ 'social_vimeo' ],
						$options[ 'social_slideshare' ],
						$options[ 'social_foursquare' ],
						$options[ 'social_flickr' ],
						$options[ 'social_tumblr' ],
						$options[ 'social_deviantart' ],
						$options[ 'social_dribbble' ],
						$options[ 'social_myspace' ],
						$options[ 'social_wordpress' ],
						$options[ 'social_rss' ],
						$options[ 'social_delicious' ],
						$options[ 'social_lastfm' ],
						$options[ 'social_instagram' ],
						$options[ 'social_github' ],
						$options[ 'social_vkontakte' ],
						$options[ 'social_myworld' ],
						$options[ 'social_odnoklassniki' ],
						$options[ 'social_goodreads' ],
						$options[ 'social_skype' ],
						$options[ 'social_soundcloud' ]
					);
	$flag = 0;
	if( !empty( $elements ) ) {
		foreach( $elements as $option) {
			if( !empty( $option ) ) {
				$flag = 1;
			}
			else {
				$flag = 0;
			}
			if( $flag == 1 ) {
				break;
			}
		}
	}	
	
	if ( ( !$adventurous_social_networks = get_transient( 'adventurous_social_networks' ) ) && ( $flag == 1 || !empty ( $options[ 'social_custom_image' ] ) ) )  {
		echo '<!-- refreshing cache -->';
		
		$adventurous_social_networks .='
		<ul class="social-profile">';
	
			//facebook
			if ( !empty( $options[ 'social_facebook' ] ) ) {
				$adventurous_social_networks .=
					'<li class="facebook"><a href="'.esc_url( $options[ 'social_facebook' ] ).'" title="'.sprintf( esc_attr__( '%s on Facebook', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Facebook </a></li>';
			}
			//Twitter
			if ( !empty( $options[ 'social_twitter' ] ) ) {
				$adventurous_social_networks .=
					'<li class="twitter"><a href="'.esc_url( $options[ 'social_twitter' ] ).'" title="'.sprintf( esc_attr__( '%s on Twitter', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
			}
			//Google+
			if ( !empty( $options[ 'social_googleplus' ] ) ) {
				$adventurous_social_networks .=
					'<li class="google-plus"><a href="'.esc_url( $options[ 'social_googleplus' ] ).'" title="'.sprintf( esc_attr__( '%s on Google+', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Google+ </a></li>';
			}
			//Linkedin
			if ( !empty( $options[ 'social_linkedin' ] ) ) {
				$adventurous_social_networks .=
					'<li class="linkedin"><a href="'.esc_url( $options[ 'social_linkedin' ] ).'" title="'.sprintf( esc_attr__( '%s on Linkedin', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Linkedin </a></li>';
			}
			//Pinterest
			if ( !empty( $options[ 'social_pinterest' ] ) ) {
				$adventurous_social_networks .=
					'<li class="pinterest"><a href="'.esc_url( $options[ 'social_pinterest' ] ).'" title="'.sprintf( esc_attr__( '%s on Pinterest', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
			}				
			//Youtube
			if ( !empty( $options[ 'social_youtube' ] ) ) {
				$adventurous_social_networks .=
					'<li class="you-tube"><a href="'.esc_url( $options[ 'social_youtube' ] ).'" title="'.sprintf( esc_attr__( '%s on YouTube', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' YouTube </a></li>';
			}
			//Vimeo
			if ( !empty( $options[ 'social_vimeo' ] ) ) {
				$adventurous_social_networks .=
					'<li class="viemo"><a href="'.esc_url( $options[ 'social_vimeo' ] ).'" title="'.sprintf( esc_attr__( '%s on Vimeo', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Vimeo </a></li>';
			}				
			//Slideshare
			if ( !empty( $options[ 'social_slideshare' ] ) ) {
				$adventurous_social_networks .=
					'<li class="slideshare"><a href="'.esc_url( $options[ 'social_slideshare' ] ).'" title="'.sprintf( esc_attr__( '%s on Slideshare', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Slideshare </a></li>';
			}				
			//Foursquare
			if ( !empty( $options[ 'social_foursquare' ] ) ) {
				$adventurous_social_networks .=
					'<li class="foursquare"><a href="'.esc_url( $options[ 'social_foursquare' ] ).'" title="'.sprintf( esc_attr__( '%s on Foursquare', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' foursquare </a></li>';
			}
			//Flickr
			if ( !empty( $options[ 'social_flickr' ] ) ) {
				$adventurous_social_networks .=
					'<li class="flickr"><a href="'.esc_url( $options[ 'social_flickr' ] ).'" title="'.sprintf( esc_attr__( '%s on Flickr', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Flickr </a></li>';
			}
			//Tumblr
			if ( !empty( $options[ 'social_tumblr' ] ) ) {
				$adventurous_social_networks .=
					'<li class="tumblr"><a href="'.esc_url( $options[ 'social_tumblr' ] ).'" title="'.sprintf( esc_attr__( '%s on Tumblr', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Tumblr </a></li>';
			}
			//deviantART
			if ( !empty( $options[ 'social_deviantart' ] ) ) {
				$adventurous_social_networks .=
					'<li class="deviantart"><a href="'.esc_url( $options[ 'social_deviantart' ] ).'" title="'.sprintf( esc_attr__( '%s on deviantART', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' deviantART </a></li>';
			}
			//Dribbble
			if ( !empty( $options[ 'social_dribbble' ] ) ) {
				$adventurous_social_networks .=
					'<li class="dribbble"><a href="'.esc_url( $options[ 'social_dribbble' ] ).'" title="'.sprintf( esc_attr__( '%s on Dribbble', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Dribbble </a></li>';
			}
			//MySpace
			if ( !empty( $options[ 'social_myspace' ] ) ) {
				$adventurous_social_networks .=
					'<li class="myspace"><a href="'.esc_url( $options[ 'social_myspace' ] ).'" title="'.sprintf( esc_attr__( '%s on MySpace', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' MySpace </a></li>';
			}
			//WordPress
			if ( !empty( $options[ 'social_wordpress' ] ) ) {
				$adventurous_social_networks .=
					'<li class="wordpress"><a href="'.esc_url( $options[ 'social_wordpress' ] ).'" title="'.sprintf( esc_attr__( '%s on WordPress', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' WordPress </a></li>';
			}				
			//RSS
			if ( !empty( $options[ 'social_rss' ] ) ) {
				$adventurous_social_networks .=
					'<li class="rss"><a href="'.esc_url( $options[ 'social_rss' ] ).'" title="'.sprintf( esc_attr__( '%s on RSS', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' RSS </a></li>';
			}
			//Delicious
			if ( !empty( $options[ 'social_delicious' ] ) ) {
				$adventurous_social_networks .=
					'<li class="delicious"><a href="'.esc_url( $options[ 'social_delicious' ] ).'" title="'.sprintf( esc_attr__( '%s on Delicious', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Delicious </a></li>';
			}				
			//Last.fm
			if ( !empty( $options[ 'social_lastfm' ] ) ) {
				$adventurous_social_networks .=
					'<li class="lastfm"><a href="'.esc_url( $options[ 'social_lastfm' ] ).'" title="'.sprintf( esc_attr__( '%s on Last.fm', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Last.fm </a></li>';
			}				
			//Instagram
			if ( !empty( $options[ 'social_instagram' ] ) ) {
				$adventurous_social_networks .=
					'<li class="instagram"><a href="'.esc_url( $options[ 'social_instagram' ] ).'" title="'.sprintf( esc_attr__( '%s on Instagram', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Instagram </a></li>';
			}
			//GitHub
			if ( !empty( $options[ 'social_github' ] ) ) {
				$adventurous_social_networks .=
					'<li class="github"><a href="'.esc_url( $options[ 'social_github' ] ).'" title="'.sprintf( esc_attr__( '%s on GitHub', 'adventurous' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' GitHub </a></li>';
			}	
			//Vkontakte
			if ( !empty( $options[ 'social_vkontakte' ] ) ) {
				$adventurous_social_networks .=
					'<li class="vkontakte"><a href="'.esc_url( $options[ 'social_vkontakte' ] ).'" title="'.sprintf( esc_attr__( '%s on Vkontakte', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Vkontakte </a></li>';
			}				
			//My World
			if ( !empty( $options[ 'social_myworld' ] ) ) {
				$adventurous_social_networks .=
					'<li class="myworld"><a href="'.esc_url( $options[ 'social_myworld' ] ).'" title="'.sprintf( esc_attr__( '%s on My World', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' My World </a></li>';
			}				
			//Odnoklassniki
			if ( !empty( $options[ 'social_odnoklassniki' ] ) ) {
				$adventurous_social_networks .=
					'<li class="odnoklassniki"><a href="'.esc_url( $options[ 'social_odnoklassniki' ] ).'" title="'.sprintf( esc_attr__( '%s on Odnoklassniki', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Odnoklassniki </a></li>';
			}
			//Goodreads
			if ( !empty( $options[ 'social_goodreads' ] ) ) {
				$adventurous_social_networks .=
					'<li class="goodreads"><a href="'.esc_url( $options[ 'social_goodreads' ] ).'" title="'.sprintf( esc_attr__( '%s on Goodreads', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Goodreads </a></li>';
			}
			//Skype
			if ( !empty( $options[ 'social_skype' ] ) ) {
				$adventurous_social_networks .=
					'<li class="skype"><a href="'.esc_attr( $options[ 'social_skype' ] ).'" title="'.sprintf( esc_attr__( '%s on Skype', 'adventurous' ),get_bloginfo( 'name' ) ).'">'.get_bloginfo( 'name' ).' Skype </a></li>';
			}
			//Soundcloud
			if ( !empty( $options[ 'social_soundcloud' ] ) ) {
				$adventurous_social_networks .=
					'<li class="soundcloud"><a href="'.esc_url( $options[ 'social_soundcloud' ] ).'" title="'.sprintf( esc_attr__( '%s on Soundcloud', 'adventurous' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Soundcloud </a></li>';
			}
			
			$adventurous_social_networks .='
		</ul>';
		
		set_transient( 'adventurous_social_networks', $adventurous_social_networks, 86940 );	 
	}
	echo $adventurous_social_networks;
}
endif; // adventurous_social_networks


/**
 * Adds in post and Page ID when viewing lists of posts and pages
 * This will help the admin to add the post ID in featured slider
 * 
 * @param mixed $post_columns
 * @return post columns
 */
function adventurous_post_id_column( $post_columns ) {
	$beginning = array_slice( $post_columns, 0 ,1 );
	$beginning[ 'postid' ] = __( 'ID', 'adventurous'  );
	$ending = array_slice( $post_columns, 1 );
	$post_columns = array_merge( $beginning, $ending );
	return $post_columns;
}
add_filter( 'manage_posts_columns', 'adventurous_post_id_column' );
add_filter( 'manage_pages_columns', 'adventurous_post_id_column' );

function adventurous_posts_id_column( $col, $val ) {
	if( $col == 'postid' ) echo $val;
}
add_action( 'manage_posts_custom_column', 'adventurous_posts_id_column', 10, 2 );
add_action( 'manage_pages_custom_column', 'adventurous_posts_id_column', 10, 2 );

function adventurous_posts_id_column_css() {
	echo '<style type="text/css">#postid { width: 40px; }</style>';
}
add_action( 'admin_head-edit.php', 'adventurous_posts_id_column_css' );


if ( ! function_exists( 'adventurous_pagemenu_filter' ) ) :
/**
 * @uses wp_page_menu filter hook
 */
function adventurous_pagemenu_filter( $text ) {
	$replace = array(
		'current_page_item'     => 'current-menu-item'
	);

	$text = str_replace( array_keys( $replace ), $replace, $text );
  	return $text;
	
}
endif; // adventurous_pagemenu_filter
add_filter('wp_page_menu', 'adventurous_pagemenu_filter');



/**
 * Get the Web Clip Icon Image from theme options
 *
 * @uses web_clip and remove_web_clip 
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default Web Click Icon if web_clip field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function adventurous_web_clip() {
	//delete_transient( 'adventurous_web_clip' );	
	
	if( ( !$adventurous_web_clip = get_transient( 'adventurous_web_clip' ) ) ) {
		
		// get the data value from theme options
		global $adventurous_options_settings;
   		$options = $adventurous_options_settings;
		
		echo '<!-- refreshing cache -->';
		if ( empty( $options[ 'remove_web_clip' ] ) ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'web_clip' ] ) ) :
				$adventurous_web_clip = '<link rel="apple-touch-icon-precomposed" href="'.esc_url( $options[ 'web_clip' ] ).'" />'; 	
			else:
				// if empty fav_icon on theme options, display default fav icon
				$adventurous_web_clip = '<link rel="apple-touch-icon-precomposed" href="'. get_template_directory_uri() .'/images/apple-touch-icon.png" />';
			endif;
		endif;
		
		set_transient( 'adventurous_web_clip', $adventurous_web_clip, 86940 );	
	}	
	echo $adventurous_web_clip ;	
} // adventurous_web_clip

//Load Favicon in Header Section
add_action( 'wp_head', 'adventurous_web_clip' );


if ( ! function_exists( 'adventurous_breadcrumb_display' ) ) :
/**
 * Display breadcrumb on header
 */
function adventurous_breadcrumb_display() {
	global $post, $wp_query;
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
		return false;
	}
	else {
		if ( function_exists( 'bcn_display_list' ) ) {
			echo 
			'<div class="breadcrumb container">
				<ul>';
					bcn_display_list();
					echo '	
				</ul>
				<div class="row-end"></div>
			</div> <!-- .breadcrumb -->';	
		}
	}
	
} // adventurous_breadcrumb_display
endif;

// Load  breadcrumb in adventurous_after_hgroup_wrap hook
add_action( 'adventurous_content_sidebar', 'adventurous_breadcrumb_display', 20 );