<?php
if ( ! function_exists( 'adventurous_primary_menu' ) ) :
/**
 * Shows the Primary Menu 
 *
 * default load in sidebar-header-right.php
 */
function adventurous_primary_menu() { ?>
        <div id="header-menu">
            <nav id="access" role="navigation">
                <h2 class="assistive-text"><?php _e( 'Primary Menu', 'adventurous' ); ?></h2>
                <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'adventurous' ); ?>"><?php _e( 'Skip to content', 'adventurous' ); ?></a></div>
                <?php if ( has_nav_menu( 'primary' ) ) {
					$adventurous_primary_menu_args = array(
						'theme_location'    => 'primary',
						'container_class' 	=> 'menu-header-container', 
						'items_wrap'        => '<ul class="menu">%3$s</ul>' 
					);
					wp_nav_menu( $adventurous_primary_menu_args );
				}
				else {
                    echo '<div class="menu-header-container">';
                    	wp_page_menu( array( 'menu_class'  => 'menu' ) );
                    echo '</div>';					
				} ?> 	       
            </nav><!-- .site-navigation .main-navigation -->  
        </div>
<?php
}
endif; // adventurous_primary_menu


if ( ! function_exists( 'adventurous_secondary_menu' ) ) :
/**
 * Shows the Secondary Menu 
 *
 * Hooked to adventurous_after_hgroup_wrap
 */
function adventurous_secondary_menu() { 
	global $adventurous_options_settings;
	$options = $adventurous_options_settings;
	if ( has_nav_menu( 'secondary' ) ) { ?>
        <div id="secondary-menu">
            <nav id="access-secondary" role="navigation">
                <h2 class="assistive-text"><?php _e( 'Secondary Menu', 'adventurous' ); ?></h2>
                <?php     
				$adventurous_secondary_menu_args = array(
					'theme_location'    => 'secondary',
					'container_class' 	=> 'menu-secondary-container', 
					'items_wrap'        => '<ul class="menu">%3$s</ul>' 
				);
				wp_nav_menu( $adventurous_secondary_menu_args );			
                ?> 	         
            </nav><!-- .site-navigation .main-navigation -->  
        </div>
	<?php
	}
}
endif; // adventurous_secondary_menu

add_action( 'adventurous_before_main', 'adventurous_secondary_menu', 10 );