<?php
/**
 * Shows Default Featued Content
 *
 * @uses adventurous_main action to add it in the header
 */
function adventurous_default_featured_content() { 
	//delete_transient( 'adventurous_default_featured_content' ); 
	
	// Getting data from Theme Options
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;
	$layouts = $options [ 'homepage_featured_layout' ];
	
	if ( !$adventurous_default_featured_content = get_transient( 'adventurous_default_featured_content' ) ) {	
	
		//Checking Layout 
		if ( $layouts == 'four-columns' ) {
			$classes = "layout-four";
		} 
		else { 
			$classes = "layout-three"; 
		}
			
		$adventurous_default_featured_content = '
		<div id="featured-post" class="' . $classes . '">
			<section class="container" >
				<div id="featured-heading">
					<h2>Featured Content</h2>
					<p>Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance => Theme Options => Featured Content Option".</p>
				</div>
				<div class="featued-content-wrap">
					<article id="featured-post-1" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Mountain Risk Caution">
								<img title="Mountain Risk Caution" alt="Mountain Risk Caution" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured-1-400x267.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Mountain Risk Caution" href="#">Mountain Risk Caution</a>
								</h1>
							</header>
							<div class="entry-content">
								Chocolate bar tiramisu chocolate cake jelly-o cotton candy. Apple pie bear claw jelly-o tootsie roll chocolate halvah jujubes jujubes biscuit.
							</div>
						</div><!-- .entry-container -->			
					</article>
		
					<article id="featured-post-2" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Rhino Nepal National Park">
								<img title="Rhino Nepal National Park" alt="Rhino Nepal National Park" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured-2-400x267.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Rhino Nepal National Park" href="#">Rhino Nepal National Park</a>
								</h1>
							</header>
							<div class="entry-content">
								Chocolate cake sweet pie chocolate bar. Danish tart cookie topping tootsie roll pie tart jujubes donut. Dragee bear claw tootsie roll chocolate cake.
							</div>
						</div><!-- .entry-container -->			
					</article>
					
					<article id="featured-post-3" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Nepal Yak Tibetan">
								<img title="Nepal Yak Tibetan" alt="Nepal Yak Tibetan" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured-3-400x267.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Nepal Yak Tibetan" href="#">Nepal Yak Tibetan</a>
								</h1>
							</header>
							<div class="entry-content">
								Marshmallow cotton candy candy cotton candy cake apple pie. Jelly-o donut cotton candy. Cheesecake ice cream chupa chups fruitcake jelly-o marshmallow. 
								
							</div>
						</div><!-- .entry-container -->			
					</article>
					
					<article id="featured-post-4" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="White Water Rafting">
								<img title="White Water Rafting" alt="White Water Rafting" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured-4-400x267.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="White Water Rafting" href="#">White Water Rafting</a>
								</h1>
							</header>
							<div class="entry-content">
								Marshmallow chocolate muffin gingerbread chupa chups carrot cake wafer cheesecake. Pudding chocolate cake lollipop lollipop tootsie roll jelly souffle bonbon sugar plum. 
							</div>
						</div><!-- .entry-container -->			
					</article>
				</div><!-- .featued-content-wrap -->
			</section><!-- .container -->
		</div><!-- #featured-post -->';
		echo $adventurous_default_featured_content;
	}
}


if ( ! function_exists( 'adventurous_homepage_featured_content' ) ) :
/**
 * Template for Homepage Featured Content
 *
 * To override this in a child theme
 * simply create your own adventurous_homepage_featured_content(), and that function will be used instead.
 *
 * @uses adventurous_main action to add it in the header
 * @since Adventurous 1.0
 */
function adventurous_homepage_featured_content() { 
	//delete_transient( 'adventurous_homepage_featured_content' );
	
	// Getting data from Theme Options
	global $adventurous_options_settings;
   	$options = $adventurous_options_settings;
	$quantity = $options [ 'homepage_featured_qty' ];
	$headline = $options [ 'homepage_featured_headline' ];
	$subheadline = $options [ 'homepage_featured_subheadline' ];
	$layouts = $options [ 'homepage_featured_layout' ];
		
	if ( !$adventurous_homepage_featured_content = get_transient( 'adventurous_homepage_featured_content' ) ) {
		
		//Checking Layout 
		if ( $layouts == 'four-columns' ) {
			$classes = "layout-four";
		} 
		else { 
			$classes = "layout-three"; 
		}
			
		//Checking headline and subheadline	
		$adventurous_homepage_featured_content = '<div id="featured-post" class="' . $classes . '"><section class="container" >';
			
			if ( !empty( $headline ) || !empty( $subheadline ) ) {
				$adventurous_homepage_featured_content .= '<div id="featured-heading">';
				if ( !empty( $headline ) ) {
					$adventurous_homepage_featured_content .= '<h2>' . $headline . '</h2>';
				}
				if ( !empty( $subheadline ) ) {
					$adventurous_homepage_featured_content .= '<p>' . $subheadline . '</p>';
				}
				$adventurous_homepage_featured_content .= '</div><!-- #featured-heading -->';
			}		
		
		//Checking Featured Content Details
		if ( !empty( $options[ 'homepage_featured_image' ] ) || !empty( $options[ 'homepage_featured_title' ] ) || !empty( $options[ 'homepage_featured_content' ] ) ) {

			$adventurous_homepage_featured_content .= '<div class="featued-content-wrap">';
			
				for ( $i = 1; $i <= $quantity; $i++ ) {
					
					if ( !empty ( $options[ 'homepage_featured_base' ][ $i ] ) ) {
						$target = '_blank';
					} else {
						$target = '_self';
					}
					
					//Checking Link
					if ( !empty ( $options[ 'homepage_featured_url' ][ $i ] ) ) {
						//support qTranslate plugin
						if ( function_exists( 'qtrans_convertURL' ) ) {
							$link = qtrans_convertURL($options[ 'homepage_featured_url' ][ $i ]);
						}
						else {
							$link = $options[ 'homepage_featured_url' ][ $i ];
						}
					} else {
						$link = '#';
					}
						
					//Checking Title
					if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) ) {
						$title = $options[ 'homepage_featured_title' ][ $i ];
					} else {
						$title = '';
					}			
					
					if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) || !empty ( $options[ 'homepage_featured_content' ][ $i ] ) || !empty ( $options[ 'homepage_featured_image' ][ $i ] ) ) {
						$adventurous_homepage_featured_content .= '
						<article id="featured-post-'.$i.'" class="post hentry">';
							if ( !empty ( $options[ 'homepage_featured_image' ][ $i ] ) ) {
								$adventurous_homepage_featured_content .= '
								<figure class="featured-homepage-image">
									<a title="'.$title.'" href="'.$link.'" target="'.$target.'">
										<img src="'.$options[ 'homepage_featured_image' ][ $i ].'" class="wp-post-image" alt="'.$title.'" title="'.$title.'">
									</a>
								</figure>';  
							}
							if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) || !empty ( $options[ 'homepage_featured_content' ][ $i ] ) ) {
								$adventurous_homepage_featured_content .= '
								<div class="entry-container">';
								
									if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) ) { 
										$adventurous_homepage_featured_content .= '
										<header class="entry-header">
											<h1 class="entry-title">
												<a href="'.$link.'" title="'.$title.'" target="'.$target.'">'.$title.'</a>
											</h1>
										</header>';
									}
									if ( !empty ( $options[ 'homepage_featured_content' ][ $i ] ) ) { 
										$adventurous_homepage_featured_content .= '
										<div class="entry-content">
											' . $options[ 'homepage_featured_content' ][ $i ] . '
										</div>';
									}
								$adventurous_homepage_featured_content .= '
								</div><!-- .entry-container -->';	
							}
						$adventurous_homepage_featured_content .= '			
						</article><!-- .slides -->'; 	
					}
			
				}
				
			$adventurous_homepage_featured_content .= '</div><!-- .featued-content-wrap -->';
			
		}
			
		$adventurous_homepage_featured_content .= '</section><!-- .container --></div><!-- #featured-post -->';	
		
		
		echo $adventurous_homepage_featured_content;	
	}
	
}
endif; // adventurous_homepage_featured_content


/**
 * Homepage Featured Content
 *
 */
function adventurous_homepage_featured_display() { 
	global $post, $wp_query, $adventurous_options_settings;
	
	// Getting data from Theme Options
   	$options = $adventurous_options_settings;
	$enablefeatured = $options[ 'enable-featured' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if ( ( $enablefeatured == 'allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enablefeatured == 'homepage' ) ) {
		if  ( !empty( $options[ 'homepage_featured_headline' ] ) || !empty( $options[ 'homepage_featured_subheadline' ] ) || !empty( $options[ 'homepage_featured_image' ] ) || !empty( $options[ 'homepage_featured_title' ] ) || !empty( $options[ 'homepage_featured_content' ] ) ) {
			adventurous_homepage_featured_content();
		} else {
			adventurous_default_featured_content();
		}
	}
	
} // adventurous_homepage_featured_content	

add_action( 'adventurous_before_main', 'adventurous_homepage_featured_display', 80 );