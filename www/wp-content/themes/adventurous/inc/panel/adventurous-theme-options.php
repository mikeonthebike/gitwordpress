<?php
/**
 * Adventurous Theme Options
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
add_action( 'admin_init', 'adventurous_register_settings' );
add_action( 'admin_menu', 'adventurous_options_menu' );


/**
 * Enqueue admin script and styles
 *
 * @uses wp_register_script, wp_enqueue_script and wp_enqueue_style
 * @Calling jquery, jquery-ui-tabs,jquery-cookie, jquery-ui-sortable, jquery-ui-draggable, media-upload, thickbox, farbtastic
 */
function adventurous_admin_scripts() {
	//jQuery Cookie
	wp_register_script( 'jquery-cookie', get_template_directory_uri() . '/inc/panel/js/jquery.cookie.min.js', array( 'jquery' ), '1.0', true );
	
	wp_enqueue_script( 'adventurous_admin', get_template_directory_uri().'/inc/panel/js/admin.min.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-cookie', 'jquery-ui-sortable', 'jquery-ui-draggable' ) );
	wp_enqueue_script( 'adventurous_upload', get_template_directory_uri().'/inc/panel/js/add_image_scripts.js', array( 'jquery','media-upload','thickbox' ) );
	
	wp_enqueue_style( 'adventurous_admin_style',get_template_directory_uri().'/inc/panel/admin.min.css', array( 'thickbox'), '1.0', 'screen' );

}
add_action('admin_print_styles-appearance_page_theme_options', 'adventurous_admin_scripts');


/*
 * Create a function for Theme Options Page
 *
 * @uses add_menu_page
 * @add action admin_menu 
 */
function adventurous_options_menu() {

	add_theme_page( 
        __( 'Theme Options', 'adventurous' ),           // Name of page
        __( 'Theme Options', 'adventurous' ),           // Label in menu
        'edit_theme_options',                           // Capability required
        'theme_options',                                // Menu slug, used to uniquely identify the page
        'adventurous_theme_options_do_page'             // Function that renders the options page
    );	

}


/*
 * Register options and validation callbacks
 *
 * @uses register_setting
 * @action admin_init
 */
function adventurous_register_settings() {
	register_setting( 'adventurous_options', 'adventurous_options', 'adventurous_theme_options_validate' );
}


/*
 * Render Adventurous Theme Options page
 *
 * @uses settings_fields, get_option, bloginfo
 * @Settings Updated
 */
function adventurous_theme_options_do_page() {
	if (!isset($_REQUEST['settings-updated']))
		$_REQUEST['settings-updated'] = false;
	?>
    
	<div id="catchthemes" class="wrap">
    	
    	<form method="post" action="options.php">
			<?php
                settings_fields( 'adventurous_options' );
                global $adventurous_options_settings;
                $options = $adventurous_options_settings;				
            ?>   
            <?php if (false !== $_REQUEST['settings-updated']) : ?>
            	<div class="updated fade"><p><strong><?php _e('Options Saved', 'adventurous'); ?></strong></p></div>
            <?php endif; ?>            
            
			<div id="theme-option-header">
            
                <div id="theme-option-title">
                    <h2 class="title"><?php _e( 'Theme Options By', 'adventurous' ); ?></h2>
                    <h2 class="logo">
                        <a href="<?php echo esc_url( __( 'http://catchthemes.com/', 'adventurous' ) ); ?>" title="<?php esc_attr_e( 'Catch Themes', 'adventurous' ); ?>" target="_blank">
                            <img src="<?php echo get_template_directory_uri().'/inc/panel/images/catch-themes.png'; ?>" alt="<?php _e( 'Catch Themes', 'adventurous' ); ?>" />
                        </a>
                    </h2>
                </div><!-- #theme-option-title -->
            
                <div id="upgradepro">
                	<a class="button" href="<?php echo esc_url( __( 'http://catchthemes.com/themes/adventurous-pro/', 'adventurous' ) ); ?>" title="<?php esc_attr_e( 'Upgrade to Adventurous Pro', 'adventurous' ); ?>" target="_blank"><?php printf( __( 'Upgrade to Adventurous Pro','adventurous') ); ?></a>
               	</div><!-- #upgradepro -->
                            
                <div id="theme-support">
                    <ul>
                    	<li><a class="button donate" href="<?php echo esc_url(__('http://catchthemes.com/donate/','adventurous')); ?>" title="<?php esc_attr_e('Donate to Adventurous', 'adventurous'); ?>" target="_blank"><?php printf(__('Donate Now','adventurous')); ?></a></li>
                        <li><a class="button" href="<?php echo esc_url(__('http://catchthemes.com/support/','adventurous')); ?>" title="<?php esc_attr_e('Support', 'adventurous'); ?>" target="_blank"><?php printf(__('Support','adventurous')); ?></a></li>
                        <li><a class="button" href="<?php echo esc_url(__('http://catchthemes.com/theme-instructions/adventurous-pro/','adventurous')); ?>" title="<?php esc_attr_e('Theme Instruction', 'adventurous'); ?>" target="_blank"><?php printf(__('Theme Instruction','adventurous')); ?></a></li>
                        <li><a class="button" href="<?php echo esc_url(__('https://www.facebook.com/catchthemes/','adventurous')); ?>" title="<?php esc_attr_e('Like Catch Themes on Facebook', 'adventurous'); ?>" target="_blank"><?php printf(__('Facebook','adventurous')); ?></a></li>
                        <li><a class="button" href="<?php echo esc_url(__('https://twitter.com/catchthemes/','adventurous')); ?>" title="<?php esc_attr_e('Follow Catch Themes on Twitter', 'adventurous'); ?>" target="_blank"><?php printf(__('Twitter','adventurous')); ?></a></li>
                        <li><a class="button" href="<?php echo esc_url(__('http://wordpress.org/support/view/theme-reviews/adventurous','adventurous')); ?>" title="<?php esc_attr_e('Rate us 5 Star on WordPress', 'adventurous'); ?>" target="_blank"><?php printf(__('5 Star Rating','adventurous')); ?></a></li>
                   	</ul>
                </div><!-- #theme-support --> 
                 
          	</div><!-- #theme-option-header -->              
 
            
            <div id="adventurous_ad_tabs">
                <ul class="tabNavigation" id="mainNav">
                    <li><a href="#themeoptions"><?php _e( 'Theme Options', 'adventurous' );?></a></li>
                    <li><a href="#featured-content"><?php _e( 'Featured Content', 'adventurous' );?></a></li>
                    <li><a href="#slidersettings"><?php _e( 'Featured Slider', 'adventurous' );?></a></li>
                    <li><a href="#sociallinks"><?php _e( 'Social Links', 'adventurous' );?></a></li>
                </ul><!-- .tabsNavigation #mainNav -->
                   
                   
                <!-- Theme Options -->
                <div id="themeoptions">     
                       
                  	<div id="fav-icons" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Favicon', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Favicon?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[remove_favicon]'>
                                    <input type="checkbox" id="favicon" name="adventurous_options[remove_favicon]" value="1" <?php checked( '1', $options['remove_favicon'] ); ?> /> <?php _e('Check to disable', 'adventurous'); ?>
                                </div>
                          	</div><!-- .row -->
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Fav Icon URL:', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<?php if ( !empty ( $options[ 'fav_icon' ] ) ) { ?>
                                        <input class="upload-url" size="65" type="text" name="adventurous_options[fav_icon]" value="<?php echo esc_url( $options [ 'fav_icon' ] ); ?>" /> <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Change Fav Icon','adventurous' );?>" />
                                    <?php } else { ?>
                                        <input class="upload-url" size="65" type="text" name="adventurous_options[fav_icon]" value="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" alt="fav" /> <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Upload Fav Icon','adventurous' );?>" />
                                    <?php }  ?> 
                                </div>
                          	</div><!-- .row -->                            
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Preview', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">                        
                        			<?php 
										if ( !empty( $options[ 'fav_icon' ] ) ) { 
											echo '<img src="'.esc_url( $options[ 'fav_icon' ] ).'" alt="fav" />';
										} else {
											echo '<img src="'. get_template_directory_uri().'/images/favicon.ico" alt="fav" />';
										}
									?>
                              	</div>
                            </div><!-- .row -->
                            <div class="row">
                      			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                          	</div><!-- .row -->      
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                              
                    <div id="webclip-icon" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Web Clip Icon Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Web Clip Icon?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                        			<input type='hidden' value='0' name='adventurous_options[remove_web_clip]'>
                        			<input type="checkbox" id="favicon" name="adventurous_options[remove_web_clip]" value="1" <?php checked( '1', $options['remove_web_clip'] ); ?> /> <?php _e('Check to disable', 'adventurous'); ?>
                              	</div>
                         	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Web Clip Icon URL:', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                        			<?php if ( !empty ( $options[ 'web_clip' ] ) ) { ?>
                                        <input class="upload-url" size="65" type="text" name="adventurous_options[web_clip]" value="<?php echo esc_url( $options [ 'web_clip' ] ); ?>" class="upload" />
                                    <?php } else { ?>
                                        <input size="65" type="text" name="adventurous_options[web_clip]" value="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png" alt="fav" />
                                    <?php }  ?> 
                                    <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Change Web Clip Icon','adventurous' );?>" />
                              	</div>
                         	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Preview', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">    
									<?php 
									if ( !empty( $options[ 'web_clip' ] ) ) { 
										echo '<img src="'.esc_url( $options[ 'web_clip' ] ).'" alt="Web Clip Icon" />';
									} else {
										echo '<img src="'. get_template_directory_uri().'/images/apple-touch-icon.png" alt="Web Clip Icon" />';
									}
									?>
                              	</div>
                         	</div><!-- .row -->
                            <div class="row">
                             	<?php esc_attr_e( 'Note: Web Clip Icon for Apple devices. Recommended Size - Width 144px and Height 144px height, which will support High Resolution Devices like iPad Retina.', 'adventurous' ); ?>
                           	</div><!-- .row -->
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->                    

                            
                    <div id="header-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Menu Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">  
                      		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Custom Menus', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<a class="button" href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Click to Create Custom Menus', 'adventurous'); ?></a>
                           		</div>
                         	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Assign Locations', 'adventurous' ); ?><br />
                                    <small><?php _e( 'Note: You can assign your custom menu to Header Right Menu Location and Header Secondary Menu Location. This will replace the WordPress default page menu', 'adventurous' ); ?></small>
                                </div>
                                <div class="col col-2">
                                	<a class="button" href="<?php echo admin_url('nav-menus.php?action=locations'); ?>"><?php _e('Click to Manage Menu Locations', 'adventurous'); ?></a>
                           		</div>
                         	</div><!-- .row -->
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->  
                                                
                    <div id="header-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Header Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                      		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Logo?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[remove_header_logo]'>
                                    <input type="checkbox" id="headerlogo" name="adventurous_options[remove_header_logo]" value="1" <?php checked( '1', $options['remove_header_logo'] ); ?> /> <?php _e('Check to disable', 'adventurous'); ?></td>
                           		</div>
                         	</div><!-- .row -->              
                      		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Logo url', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<?php  if ( !empty ( $options[ 'featured_logo_header' ] ) ) { ?>
                                    	<input  class="upload-url" size="65" type="text" name="adventurous_options[featured_logo_header]" value="<?php echo esc_url ( $options [ 'featured_logo_header' ]); ?>" class="upload" />
                                	<?php 
									} 
									else { ?>
                                    	<input class="upload-url" size="65" type="text" name="adventurous_options[featured_logo_header]" value="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="logo" />
                                    <?php } ?>
                                       	<input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Change Logo','adventurous' ); ?>" />
                           		</div>
                         	</div><!-- .row -->   
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Preview', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">    
									<?php 
									if ( !empty( $options[ 'featured_logo_header' ] ) ) { 
										echo '<img src="'.esc_url( $options[ 'featured_logo_header' ] ).'" alt="Logo" />';
									} else {
										echo '<img src="'. get_template_directory_uri().'/images/logo.png" alt="Logo" />';
									}
									?>
                              	</div>
                         	</div><!-- .row -->                              
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Header Right Section?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[disable_header_right_sidebar]'>
                                    <input type="checkbox" id="headerlogo" name="adventurous_options[disable_header_right_sidebar]" value="1" <?php checked( '1', $options['disable_header_right_sidebar'] ); ?> /> <?php _e('Check to Disable', 'catchthemes'); ?>
                           		</div>
                         	</div><!-- .row -->                              
							<div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->                            
                                                                   
                                       
                    <div id="header-featured-image" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Header Featured Image Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Enable Featured Header Image', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">
                                	<label title="enable-header-homepage">
                                    <input type="radio" name="adventurous_options[enable_featured_header_image]" id="enable-header-homepage" <?php checked($options['enable_featured_header_image'], 'homepage'); ?> value="homepage"  />
                                    <?php _e( 'Homepage', 'adventurous' ); ?>
                                    </label>
                                    
                                    <label title="enable-header-homepage">
                                    <input type="radio" name="adventurous_options[enable_featured_header_image]" id="enable-header-exclude-homepage" <?php checked($options['enable_featured_header_image'], 'excludehome'); ?> value="excludehome"  />
                                    <?php _e( 'Excluding Homepage', 'adventurous' ); ?>
                                    </label>                                            
          
                                    <label title="enable-header-allpage">
                                    <input type="radio" name="adventurous_options[enable_featured_header_image]" id="enable-header-allpage" <?php checked($options['enable_featured_header_image'], 'allpage'); ?> value="allpage"  />
                                     <?php _e( 'Entire Site', 'adventurous' ); ?>
                                    </label>
                                    
                                    <label title="enable-header-postpage">
                                    <input type="radio" name="adventurous_options[enable_featured_header_image]" id="enable-header-postpage" <?php checked($options['enable_featured_header_image'], 'postpage'); ?> value="postpage"  />
                                     <?php _e( 'Entire Site, Page/Post Featured Image', 'adventurous' ); ?>
                                    </label> 
                                    
                                    <label title="enable-header-pagespostes">
                                    <input type="radio" name="adventurous_options[enable_featured_header_image]" id="enable-header-pagespostes" <?php checked($options['enable_featured_header_image'], 'pagespostes'); ?> value="pagespostes"  />
                                     <?php _e( 'Pages & Posts', 'adventurous' ); ?>
                                    </label> 
                                    
                                    <label title="disable-header">
                                    <input type="radio" name="adventurous_options[enable_featured_header_image]" id="disable-header" <?php checked($options['enable_featured_header_image'], 'disable'); ?> value="disable" />
                                     <?php _e( 'Disable', 'adventurous' ); ?>
                                    </label> 
                                </div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Page/Post Featured Image Size', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">
                                	<label title="featured-image"><input type="radio" name="adventurous_options[page_featured_image]" id="image-full" <?php checked($options['page_featured_image'], 'full'); ?> value="full"  />
									<?php _e( 'Full Image', 'adventurous' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="adventurous_options[page_featured_image]" id="content-image-slider" <?php checked($options['page_featured_image'], 'slider'); ?> value="slider"  />
                                    <?php _e( 'Slider Image', 'adventurous' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="adventurous_options[page_featured_image]" id="image-featured" <?php checked($options['page_featured_image'], 'featured'); ?> value="featured"  />
                                    <?php _e( 'Featured Image', 'adventurous' ); ?>
                                    </label>
                            	</div>
                          	</div><!-- .row -->      
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Header Image', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<?php 
									$header_image = get_header_image();
									if ( !empty ( $header_image ) ) { 
										echo '<a class="button" href="' . admin_url('themes.php?page=custom-header') . '" title="' .esc_attr__( 'Click here to change header image', 'adventurous' ). '">' . __( 'Click here to change Header Image', 'adventurous' ) . '</a>';
									} else { 
										echo '<a class="button" href="' . admin_url('themes.php?page=custom-header') . '" title="' .esc_attr__( 'Click here to add header image', 'adventurous' ). '">' . __( 'Click here to add Header Image', 'adventurous' ) . '</a>';
									}  ?>        
                                	
                              	</div>
                          	</div><!-- .row --> 
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Preview', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<?php 
										if ( !empty( $header_image ) ) { 
											echo '<img src="'.esc_url( $header_image ).'" alt=""  style="width: 90%; height:auto" />';
										} else {
											_e( 'There is no Header Image', 'adventurous' );
										}
									?>
                              	</div>
                          	</div><!-- .row -->                                                                     
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Featured Header Image Alt/Title Tag', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input class="upload-url" size="65" type="text" name="adventurous_options[featured_header_image_alt]" value="<?php echo esc_attr( $options [ 'featured_header_image_alt' ] ); ?>" />
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Featured Header Image Link URL', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type="text" size="65" name="adventurous_options[featured_header_image_url]" value="<?php echo esc_url( $options [ 'featured_header_image_url' ] ); ?>" />
                              	</div>
                          	</div><!-- .row -->                            
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Target. Open Link in New Window?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type="hidden" value="0" name="adventurous_options[featured_header_image_base]"> 
                                    <input type="checkbox" id="header-image-base" name="adventurous_options[featured_header_image_base]" value="1" <?php checked( '1', $options['featured_header_image_base'] ); ?> /> <?php _e('Check to open in new window', 'catchthemes'); ?>
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php if( $options[ 'reset_featured_image' ] == "1" ) { $options[ 'reset_featured_image' ] = "0"; } ?>
                                	<?php _e( 'Reset Header Featured Image Options?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type='hidden' value='0' name='adventurous_options[reset_featured_image]'>
                                    <input type="checkbox" id="headerlogo" name="adventurous_options[reset_featured_image]" value="1" <?php checked( '1', $options['reset_featured_image'] ); ?> /> <?php _e('Check to reset', 'adventurous'); ?>
                              	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row --> 
						</div><!-- .option-content --> 
                 	</div><!-- .option-container -->    
                    
                    <div id="content-featured-image" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Content Featured Image Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Content Featured Image Size', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">
                                    <label title="featured-image"><input type="radio" name="adventurous_options[featured_image]" id="image-featured" <?php checked($options['featured_image'], 'featured'); ?> value="featured"  />
                                    <?php _e( 'Featured Image', 'adventurous' ); ?>
                                    </label>  
                                    
                                    <label title="featured-image"><input type="radio" name="adventurous_options[featured_image]" id="image-full" <?php checked($options['featured_image'], 'full'); ?> value="full"  />
                                    <?php _e( 'Full Image', 'adventurous' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="adventurous_options[featured_image]" id="content-image-slider" <?php checked($options['featured_image'], 'slider'); ?> value="slider"  />
                                    <?php _e( 'Slider Image', 'adventurous' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="adventurous_options[featured_image]" id="disable-image-slider" <?php checked($options['featured_image'], 'disable'); ?> value="disable"  />
                                    <?php _e( 'Disable Image', 'adventurous' ); ?>
                                   	</label>
                               	</div>
                            </div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->   
                  
                    <div id="promotion-headline-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Promotion Headline Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Enable Promotion', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">
                                	<label title="enable_promotion_homepage">
                                    <input type="radio" name="adventurous_options[enable_promotion]" id="enable_promotion_homepage" <?php checked($options['enable_promotion'], 'homepage'); ?> value="homepage"  />
                                    <?php _e( 'Homepage', 'adventurous' ); ?>
                                    </label>                                        
          
                                    <label title="enable_promotion_allpage">
                                    <input type="radio" name="adventurous_options[enable_promotion]" id="enable_promotion_allpage" <?php checked($options['enable_promotion'], 'allpage'); ?> value="allpage"  />
                                     <?php _e( 'Entire Site', 'adventurous' ); ?>
                                    </label>
                                    
                                    <label title="enable_promotion_disable">
                                    <input type="radio" name="adventurous_options[enable_promotion]" id="enable_promotion_disable" <?php checked($options['enable_promotion'], 'disable'); ?> value="disable" />
                                     <?php _e( 'Disable', 'adventurous' ); ?>
                                    </label> 
                                </div>
                          	</div><!-- .row -->                           
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Headline Text', 'adventurous' ); ?>
                                    <p><small><?php _e( 'The appropriate length for Headine is around 10 words.', 'adventurous' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<textarea class="textarea input-bg" name="adventurous_options[homepage_headline]" cols="70" rows="3"><?php echo esc_textarea( $options[ 'homepage_headline' ] ); ?></textarea>
                             	</div>
                          	</div><!-- .row -->        
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Subheadline Text', 'adventurous' ); ?>
                                    <p><small><?php _e( 'The appropriate length for Headine is around 15 words.', 'adventurous' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<textarea class="textarea input-bg" name="adventurous_options[homepage_subheadline]" cols="70" rows="3"><?php echo esc_textarea( $options[ 'homepage_subheadline' ] ); ?></textarea>
                             	</div>
                          	</div><!-- .row -->                                
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Button Text', 'adventurous' ); ?>
                                    <p><small><?php _e( 'The appropriate length for Headine is around 3 words.', 'adventurous' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<input type="text" size="45" name="adventurous_options[homepage_headline_button]" value="<?php echo esc_attr( $options[ 'homepage_headline_button' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Button Link', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" size="70" name="adventurous_options[homepage_headline_url]" value="<?php echo esc_url( $options[ 'homepage_headline_url' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Target. Open Link in New Window? ', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[homepage_headline_target]'>
                                    <input type="checkbox" id="headline_target" name="adventurous_options[homepage_headline_target]" value="1" <?php checked( '1', $options['homepage_headline_target'] ); ?> /> <?php _e('Check to open in new window', 'adventurous'); ?>
                                </div>
                          	</div><!-- .row -->                         
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Headline?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[disable_homepage_headline]'>
                                    <input type="checkbox" id="homepage-headline" name="adventurous_options[disable_homepage_headline]" value="1" <?php checked( '1', $options['disable_homepage_headline'] ); ?> /> <?php _e( 'Check to disable', 'adventurous'); ?>
                             	</div>
                          	</div><!-- .row -->                   
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Subheadline?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[disable_homepage_subheadline]'>
                                    <input type="checkbox" id="homepage-subheadline" name="adventurous_options[disable_homepage_subheadline]" value="1" <?php checked( '1', $options['disable_homepage_subheadline'] ); ?> /> <?php _e( 'Check to disable', 'adventurous'); ?>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Button?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[disable_homepage_button]'>
                                    <input type="checkbox" id="homepage-botton" name="adventurous_options[disable_homepage_button]" value="1" <?php checked( '1', $options['disable_homepage_button'] ); ?> /> <?php _e( 'Check to disable', 'adventurous'); ?>
                             	</div>
                          	</div><!-- .row -->                                             
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                                                               
                    <div id="homepage-settings" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Homepage / Frontpage Settings', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Latest Posts?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[enable_posts_home]'>
                                    <input type="checkbox" id="headerlogo" name="adventurous_options[enable_posts_home]" value="1" <?php checked( '1', $options['enable_posts_home'] ); ?> /> <?php _e( 'Check to Disable', 'adventurous'); ?>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Add Page instead of Latest Posts', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<a class="button" href="<?php echo esc_url( admin_url( 'options-reading.php' ) ) ; ?>" title="<?php esc_attr_e( 'Click Here to Set Static Front Page Instead of Latest Posts', 'adventurous' ); ?>" target="_blank"><?php _e( 'Click Here to Set Static Front Page Instead of Latest Posts', 'adventurous' );?></a>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Homepage posts categories:', 'adventurous' ); ?>
                                    <p><small><?php _e( 'Only posts that belong to the categories selected here will be displayed on the front page.', 'adventurous' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<select name="adventurous_options[front_page_category][]" id="frontpage_posts_cats" multiple="multiple" class="select-multiple">
                                        <option value="0" <?php if ( empty( $options['front_page_category'] ) ) { echo 'selected="selected"'; } ?>><?php _e( '--Disabled--', 'adventurous' ); ?></option>
                                        <?php /* Get the list of categories */  
                                            $categories = get_categories();
                                            if( empty( $options[ 'front_page_category' ] ) ) {
                                                $options[ 'front_page_category' ] = array();
                                            }
                                            foreach ( $categories as $category) :
                                        ?>
                                        <option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $options['front_page_category'] ) ) {echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
                                        <?php endforeach; ?>
                                    </select><br />
                                    <span class="description"><?php _e( 'You may select multiple categories by holding down the CTRL key.', 'adventurous' ); ?></span>
                             	</div>
                          	</div><!-- .row -->                            
                         	<div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                            </div><!-- .row --> 
                        </div><!-- .option-content -->
                  	</div><!-- .option-container -->  
                                                            
					<div id="layout-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Layout Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Sidebar Layout Options', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">
                                    <label title="right-sidebar" class="box first"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/right-sidebar.png" alt="Right Sidebar" /><br />
                                    <input type="radio" name="adventurous_options[sidebar_layout]" id="right-sidebar" <?php checked($options['sidebar_layout'], 'right-sidebar'); ?> value="right-sidebar"  />
                                    <?php _e( 'Right Sidebar', 'adventurous' ); ?>
                                    </label>  
                                    
                                    <label title="left-Sidebar" class="box"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/left-sidebar.png" alt="Left Sidebar" /><br />
                                    <input type="radio" name="adventurous_options[sidebar_layout]" id="left-sidebar" <?php checked($options['sidebar_layout'], 'left-sidebar'); ?> value="left-sidebar"  />
                                    <?php _e( 'Left Sidebar', 'adventurous' ); ?>
                                    </label>   
                                    
                                    <label title="no-sidebar" class="box"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/no-sidebar.png" alt="No Sidebar" /><br />
                                    <input type="radio" name="adventurous_options[sidebar_layout]" id="no-sidebar" <?php checked($options['sidebar_layout'], 'no-sidebar'); ?> value="no-sidebar"  />
                                    <?php _e( 'No Sidebar', 'adventurous' ); ?>
                                    </label>
                              	</div>
                            </div><!-- .row -->                                             
                         	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Content Layout', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">                                                                                                         
                                    <label title="content-full"><input type="radio" name="adventurous_options[content_layout]" id="content-full" <?php checked($options['content_layout'], 'full'); ?> value="full"  />
                                    <?php _e( 'Full Content Display', 'adventurous' ); ?>
                                    </label>   
                                    
                                    <label title="content-excerpt"><input type="radio" name="adventurous_options[content_layout]" id="content-excerpt" <?php checked($options['content_layout'], 'excerpt'); ?> value="excerpt"  />
                                    <?php _e( 'Excerpt/Blog Display', 'adventurous' ); ?>
                                    </label>                                    
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                            	<div class="col col-header">
                                	<?php if( $options[ 'reset_layout' ] == "1" ) { $options[ 'reset_layout' ] = "0"; } ?>
                                	<?php _e( 'Reset Layout?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-options">         
                                	<input type='hidden' value='0' name='adventurous_options[reset_layout]'>
                                    <input type="checkbox" id="headerlogo" name="adventurous_options[reset_layout]" value="1" <?php checked( '1', $options['reset_layout'] ); ?> /> <?php _e('Check to reset', 'adventurous'); ?>
                              	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->                             
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->                                                                            
 
                    <div id="search-settings" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Search Text Settings', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Default Display Text in Search', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<input type="text" size="45" name="adventurous_options[search_display_text]" value="<?php echo esc_attr( $options[ 'search_display_text'] ); ?>" />
                             	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                                        
                    <div id="excerpt-more-tag" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Excerpt / More Tag Settings', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'More Tag Text', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<input type="text" size="45" name="adventurous_options[more_tag_text]" value="<?php echo esc_attr( $options[ 'more_tag_text' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Excerpt length(words)', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<input type="text" size="3" name="adventurous_options[excerpt_length]" value="<?php echo intval( $options[ 'excerpt_length' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->                           
                            <div class="row">
                            	<div class="col col-1">
                                	<?php if( $options[ 'reset_moretag' ] == "1" ) { $options[ 'reset_moretag' ] = "0"; } ?>
                                	<?php _e( 'Reset Excerpt?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type='hidden' value='0' name='adventurous_options[reset_moretag]'>
                                    <input type="checkbox" id="headerlogo" name="adventurous_options[reset_moretag]" value="1" <?php checked( '1', $options['reset_moretag'] ); ?> /> <?php _e('Check to reset', 'adventurous'); ?>
                              	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->   
                  
                    <div id="custom-css" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Custom CSS', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside"> 
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Enter your custom CSS styles.', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2"> 
                                	<textarea name="adventurous_options[custom_css]" id="custom-css" cols="80" rows="10"><?php echo esc_attr( $options[ 'custom_css' ] ); ?></textarea>
                            	</div>
                          	</div><!-- .row --> 
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'CSS Tutorial from W3Schools.', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2"> 
                                	<a class="button" href="<?php echo esc_url( __( 'http://www.w3schools.com/css/default.asp','adventurous' ) ); ?>" title="<?php esc_attr_e( 'CSS Tutorial', 'adventurous' ); ?>" target="_blank"><?php _e( 'Click Here to Read', 'adventurous' );?></a>
                            	</div>
                          	</div><!-- .row -->                            
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                                       
                </div><!-- #themeoptions -->  

                    
				<!-- Options for Featured Content -->
                <div id="featured-content">  
                	<div class="option-container">
                		<h3 class="option-toggle"><a href="#"><?php _e( 'Featured Settings', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">                            
                            	<div class="col col-header">
                        			<?php _e( 'Enable Featured Content', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">                          
                                    <label title="enable-featured-homepage">
                                    <input type="radio" name="adventurous_options[enable-featured]" id="enable-featured-homepage" <?php checked($options['enable-featured'], 'homepage'); ?> value="homepage"  />
                                    <?php _e( 'Homepage', 'adventurous' ); ?>
                                    </label>
                                    <label title="enable-featured-allpage">
                                    <input type="radio" name="adventurous_options[enable-featured]" id="enable-featured-allpage" <?php checked($options['enable-featured'], 'allpage'); ?> value="allpage"  />
                                     <?php _e( 'Entire Site', 'adventurous' ); ?>
                                    </label>
                                    <label title="disable-slider">
                                    <input type="radio" name="adventurous_options[enable-featured]" id="disable-slider" <?php checked($options['enable-featured'], 'disable'); ?> value="disable"  />
                                     <?php _e( 'Disable', 'adventurous' ); ?>
                                    </label>                                
                              	</div>
                          	</div><!-- .row -->
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Featured Content Headline Text', 'adventurous' ); ?>
                                    <p><small><?php _e( 'Leave empty if you want to remove headline.', 'adventurous' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<textarea class="textarea input-bg" name="adventurous_options[homepage_featured_headline]" cols="70" rows="3"><?php echo esc_textarea( $options[ 'homepage_featured_headline' ] ); ?></textarea>
                             	</div>
                          	</div><!-- .row --> 
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Featured Content Subheadline Text', 'adventurous' ); ?>
                                    <p><small><?php _e( 'eave empty if you want to remove Subheadline', 'adventurous' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<textarea class="textarea input-bg" name="adventurous_options[homepage_featured_subheadline]" cols="70" rows="3"><?php echo esc_textarea( $options[ 'homepage_featured_subheadline' ] ); ?></textarea>
                             	</div>
                          	</div><!-- .row -->  
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Number of Featured Content', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" size="2" name="adventurous_options[homepage_featured_qty]" value="<?php echo intval( $options[ 'homepage_featured_qty' ] ); ?>" size="2" />
                             	</div>
                          	</div><!-- .row -->
                            <div class="row">                            
                            	<div class="col col-header">
                        			<?php _e( 'Featured Content Layout', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">  
                                	<label title="three-columns" class="box first">
                                    <input type="radio" name="adventurous_options[homepage_featured_layout]" id="three-columns" <?php checked($options['homepage_featured_layout'], 'three-columns'); ?> value="three-columns"  />
                                    <?php _e( '3 Columns', 'adventurous' ); ?>
                                    </label>
                                    
                                    <label title="four-columns" class="box">
                                    <input type="radio" name="adventurous_options[homepage_featured_layout]" id="four-columns" <?php checked($options['homepage_featured_layout'], 'four-columns'); ?> value="four-columns"  />
                                    <?php _e( '4 Columns', 'adventurous' ); ?>
                                    </label>	                        
           						
                                </div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                            </div><!-- .row -->
                  		</div><!-- .option-content -->
                  	</div><!-- .option-container -->      
                                  
                    
                    <div id="homepage-featured-content" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Featured Content Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">       
                         	
                           
							<?php for ( $i = 1; $i <= $options[ 'homepage_featured_qty' ]; $i++ ): ?> 
                                <div class="repeat-content-wrap">
                                    <h2 class="title"><?php printf( esc_attr__( 'Featured Content #%s', 'adventurous' ), $i ); ?></h2>
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Image', 'adventurous' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input class="upload-url" size="70" type="text" name="adventurous_options[homepage_featured_image][<?php echo $i; ?>]" value="<?php if( array_key_exists( 'homepage_featured_image', $options ) && array_key_exists( $i, $options[ 'homepage_featured_image' ] ) ) echo esc_url( $options[ 'homepage_featured_image' ][ $i ] ); ?>" />
                                            <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php if( array_key_exists( 'homepage_featured_image', $options ) && array_key_exists( $i, $options[ 'homepage_featured_image' ] ) ) { esc_attr_e( 'Change Image','adventurous' ); } else { esc_attr_e( 'Add Image','adventurous' ); } ?>" />
                                        </div>
                                    </div><!-- .row -->
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Link URL', 'adventurous' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type="text" size="70" name="adventurous_options[homepage_featured_url][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'homepage_featured_url', $options ) && array_key_exists( $i, $options[ 'homepage_featured_url' ] ) ) echo esc_url( $options[ 'homepage_featured_url' ][ $i ] ); ?>" /> <?php _e( 'Add in the Target URL for the content', 'adventurous' ); ?>
                                        </div>
                                    </div><!-- .row -->                                   
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Target. Open Link in New Window?', 'adventurous' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type='hidden' value='0' name='adventurous_options[homepage_featured_base][<?php echo absint( $i ); ?>]'>
                                            <input type="checkbox" name="adventurous_options[homepage_featured_base][<?php echo absint( $i ); ?>]" value="1" <?php if( array_key_exists( 'homepage_featured_base', $options ) && array_key_exists( $i, $options[ 'homepage_featured_base' ] ) ) checked( '1', $options[ 'homepage_featured_base' ][ $i ] ); ?> /> <?php _e( 'Check to open in new window', 'adventurous' ); ?>
                                        </div>
                                    </div><!-- .row -->                
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Title', 'adventurous' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type="text" size="70" name="adventurous_options[homepage_featured_title][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'homepage_featured_title', $options ) && array_key_exists( $i, $options[ 'homepage_featured_title' ] ) ) echo esc_attr( $options[ 'homepage_featured_title' ][ $i ] ); ?>" /> <?php _e( 'Leave empty if you want to remove title', 'adventurous' ); ?>
                                        </div>
                                    </div><!-- .row -->                                  
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Content', 'adventurous' ); ?>
                                             <p><small><?php _e( 'The appropriate length for Content is around 10 words.', 'adventurous' ); ?></small></p>
                                        </div>
                                        <div class="col col-2">
                                            <textarea class="textarea input-bg" name="adventurous_options[homepage_featured_content][<?php echo absint( $i ); ?>]" cols="70" rows="3"><?php if( array_key_exists( 'homepage_featured_content', $options ) && array_key_exists( $i, $options[ 'homepage_featured_content' ] ) ) echo esc_html( $options[ 'homepage_featured_content' ][ $i ] ); ?></textarea>
                                        </div>
                                    </div><!-- .row --> 
                                </div><!-- .repeat-content-wrap -->                           
                            <?php endfor; ?>    
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->                                     
                      
            	</div><!-- #featured-content -->       
                
                <!-- Options for Slider Settings -->
                <div id="slidersettings">
           			<div class="option-container">
                		<h3 class="option-toggle"><a href="#"><?php _e( 'Slider Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                            <div class="row">                            
                            	<div class="col col-header">
                        			<?php _e( 'Select Slider Type', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">
                                    <label title="demo-slider">
                                    <input type="radio" name="adventurous_options[select_slider_type]" id="demo-slider" <?php checked($options['select_slider_type'], 'demo-slider'); ?> value="demo-slider"  />
                                    <?php _e( 'Demo Slider', 'adventurous' ); ?>
                                    </label>                                
                                    <label title="post-slider">
                                    <input type="radio" name="adventurous_options[select_slider_type]" id="post-slider" <?php checked($options['select_slider_type'], 'post-slider'); ?> value="post-slider"  />
                                    <?php _e( 'Post Slider', 'adventurous' ); ?>
                                    </label>
                                    
                                    <label title="category-slider">
                                    <input type="radio" name="adventurous_options[select_slider_type]" id="category-slider" <?php checked($options['select_slider_type'], 'category-slider'); ?> value="category-slider"  />
                                    <?php _e( 'Category Slider', 'adventurous' ); ?>
                                    </label>
                                    
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">                            
                            	<div class="col col-header">
                        			<?php _e( 'Enable Slider', 'adventurous' ); ?>
                               	</div>
                                <div class="col col-options">                          
                                    <label title="enable-slider-homepager">
                                    <input type="radio" name="adventurous_options[enable_slider]" id="enable-slider-homepage" <?php checked($options['enable_slider'], 'enable-slider-homepage'); ?> value="enable-slider-homepage"  />
                                    <?php _e( 'Homepage', 'adventurous' ); ?>
                                    </label>
                                    <label title="enable-slider-allpage">
                                    <input type="radio" name="adventurous_options[enable_slider]" id="enable-slider-allpage" <?php checked($options['enable_slider'], 'enable-slider-allpage'); ?> value="enable-slider-allpage"  />
                                     <?php _e( 'Entire Site', 'adventurous' ); ?>
                                    </label>
                                    <label title="disable-slider">
                                    <input type="radio" name="adventurous_options[enable_slider]" id="disable-slider" <?php checked($options['enable_slider'], 'disable-slider'); ?> value="disable-slider"  />
                                     <?php _e( 'Disable', 'adventurous' ); ?>
                                    </label>                                
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Text in Slider?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[disable_slider_text]'>
                                    <input type="checkbox" id="slider-text" name="adventurous_options[disable_slider_text]" value="1" <?php checked( '1', $options['disable_slider_text'] ); ?> /> <?php _e('Check to disable', 'adventurous'); ?>
                             	</div>
                          	</div><!-- .row --> 
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Number of Slides', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" name="adventurous_options[slider_qty]" value="<?php echo intval( $options[ 'slider_qty' ] ); ?>" size="2" />
                             	</div>
                          	</div><!-- .row -->                            
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Transition Effect:', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<select id="adventurous_cycle_style" name="adventurous_options[transition_effect]">
                                        <option value="fade" <?php selected('fade', $options['transition_effect']); ?>><?php _e( 'fade', 'adventurous' ); ?></option>
                                        <option value="wipe" <?php selected('wipe', $options['transition_effect']); ?>><?php _e( 'wipe', 'adventurous' ); ?></option>
                                        <option value="scrollUp" <?php selected('scrollUp', $options['transition_effect']); ?>><?php _e( 'scrollUp', 'adventurous' ); ?></option>
                                        <option value="scrollDown" <?php selected('scrollDown', $options['transition_effect']); ?>><?php _e( 'scrollDown', 'adventurous' ); ?></option>
                                        <option value="scrollLeft" <?php selected('scrollLeft', $options['transition_effect']); ?>><?php _e( 'scrollLeft', 'adventurous' ); ?></option>
                                        <option value="scrollRight" <?php selected('scrollRight', $options['transition_effect']); ?>><?php _e( 'scrollRight', 'adventurous' ); ?></option>
                                        <option value="blindX" <?php selected('blindX', $options['transition_effect']); ?>><?php _e( 'blindX', 'adventurous' ); ?></option>
                                        <option value="blindY" <?php selected('blindY', $options['transition_effect']); ?>><?php _e( 'blindY', 'adventurous' ); ?></option>
                                        <option value="blindZ" <?php selected('blindZ', $options['transition_effect']); ?>><?php _e( 'blindZ', 'adventurous' ); ?></option>
                                        <option value="cover" <?php selected('cover', $options['transition_effect']); ?>><?php _e( 'cover', 'adventurous' ); ?></option>
                                        <option value="shuffle" <?php selected('shuffle', $options['transition_effect']); ?>><?php _e( 'shuffle', 'adventurous' ); ?></option>
                                    </select>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Transition Delay', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" name="adventurous_options[transition_delay]" value="<?php echo intval( $options[ 'transition_delay' ] ); ?>" size="2" />
                         			<span class="description"><?php _e( 'second(s)', 'adventurous' ); ?></span>
                             	</div>
                          	</div><!-- .row -->  
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Transition Length', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" name="adventurous_options[transition_duration]" value="<?php echo intval( $options[ 'transition_duration' ] ); ?>" size="2" />
                                 	<span class="description"><?php _e( 'second(s)', 'adventurous' ); ?></span>
                             	</div>
                          	</div><!-- .row -->                                 
                    		<div class="row">
        						<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                          	</div><!-- .row --> 
                        </div><!-- .option-content -->
            		</div><!-- .option-container --> 
              
            
            		<div id="featured-post-slider" class="option-container post-slider">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Featured Post Slider Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Exclude Slider post from Homepage posts?', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='adventurous_options[exclude_slider_post]'>
                                    <input type="checkbox" id="headerlogo" name="adventurous_options[exclude_slider_post]" value="1" <?php checked( '1', $options['exclude_slider_post'] ); ?> /> <?php _e('Check to exclude', 'adventurous'); ?>
                             	</div>
                          	</div><!-- .row --> 
                            <?php for ( $i = 1; $i <= $options[ 'slider_qty' ]; $i++ ): ?>
                                <div class="repeat-content-wrap">
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php printf( esc_attr__( 'Featured Post Slider #%s', 'adventurous' ), $i ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type="text" name="adventurous_options[featured_slider][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'featured_slider', $options ) && array_key_exists( $i, $options[ 'featured_slider' ] ) ) echo absint( $options[ 'featured_slider' ][ $i ] ); ?>" />
                                        <a href="<?php bloginfo ( 'url' );?>/wp-admin/post.php?post=<?php if( array_key_exists ( 'featured_slider', $options ) && array_key_exists ( $i, $options[ 'featured_slider' ] ) ) echo absint( $options[ 'featured_slider' ][ $i ] ); ?>&action=edit" class="button" title="<?php esc_attr_e('Click Here To Edit'); ?>" target="_blank"><?php _e( 'Click Here To Edit', 'adventurous' ); ?></a>
                                        </div>
                                    </div><!-- .row -->
                                </div><!-- .repeat-content-wrap -->  
                         	<?php endfor; ?>
                            <div class="row">
                           		<p><?php _e( 'Note: Here You can put your Post IDs which displays on Homepage as slider.', 'adventurous' ); ?>
                            </div><!-- .row --> 
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                           	</div><!-- .row -->      
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                            
                    <div id="featured-category-slider" class="option-container category-slider">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Featured Category Slider Options', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Select Slider Categories', 'adventurous' ); ?>
                                    <p><small><?php _e( 'Use this only is you want to display posts from Specific Categories in Featured Slider', 'adventurous' ); ?></small></p>
                                </div>
                                <div class="col col-2">	
                                    <select name="adventurous_options[slider_category][]" id="frontpage_posts_cats" multiple="multiple" class="select-multiple">
                                        <option value="0" <?php if ( empty( $options['slider_category'] ) ) { selected( true, true ); } ?>><?php _e( '--Disabled--', 'adventurous' ); ?></option>
                                        <?php /* Get the list of categories */ 
                                            if( empty( $options[ 'slider_category' ] ) ) {
                                                $options[ 'slider_category' ] = array();
                                            }
                                            $categories = get_categories();
                                            foreach ( $categories as $category) :
                                        ?>
                                        <option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $options['slider_category'] ) ) {echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
                                        <?php endforeach; ?>
                                    </select><br />
                                    <span class="description"><?php _e( 'You may select multiple categories by holding down the CTRL key.', 'adventurous' ); ?></span>
                               	</div>
                            </div><!-- .row --> 
                            <div class="row">
                                <?php _e( 'Note: Here you can select the categories from which latest posts will display on Featured Slider.', 'adventurous' ); ?>
                            </div><!-- .row --> 
                            <div class="row">
                                <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                            </div><!-- .row -->    
                        </div><!-- .option-content -->
                	</div><!-- .option-container -->                       
               
				</div><!-- #slidersettings -->
                
  
              	<!-- Options for Social Links -->
                <div id="sociallinks">
           			<div class="option-container">
                		<h3 class="option-toggle"><a href="#"><?php _e( 'Predefine Social Icons', 'adventurous' ); ?></a></h3>
                        <div class="option-content inside">
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Facebook', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_facebook]" value="<?php echo esc_url( $options[ 'social_facebook' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Twitter', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_twitter]" value="<?php echo esc_url( $options[ 'social_twitter'] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                    
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Google+', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_googleplus]" value="<?php echo esc_url( $options[ 'social_googleplus'] ); ?>" />
                                </div>
                            </div><!-- .row -->  
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Pinterest', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_pinterest]" value="<?php echo esc_url( $options[ 'social_pinterest'] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Youtube', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_youtube]" value="<?php echo esc_url( $options[ 'social_youtube' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Vimeo', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_vimeo]" value="<?php echo esc_url( $options[ 'social_vimeo' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                                                    
							<div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Linkedin', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_linkedin]" value="<?php echo esc_url( $options[ 'social_linkedin'] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Slideshare', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_slideshare]" value="<?php echo esc_url( $options[ 'social_slideshare'] ); ?>" />
                                </div>
                            </div><!-- .row -->                            
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Foursquare', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_foursquare]" value="<?php echo esc_url( $options[ 'social_foursquare' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Flickr', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_flickr]" value="<?php echo esc_url( $options[ 'social_flickr' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                   
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Tumblr', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_tumblr]" value="<?php echo esc_url( $options[ 'social_tumblr' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'deviantART', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_deviantart]" value="<?php echo esc_url( $options[ 'social_deviantart' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                                  
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Dribbble', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_dribbble]" value="<?php echo esc_url( $options[ 'social_dribbble' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'MySpace', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_myspace]" value="<?php echo esc_url( $options[ 'social_myspace' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                             
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'WordPress', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_wordpress]" value="<?php echo esc_url( $options[ 'social_wordpress' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'RSS', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_rss]" value="<?php echo esc_url( $options[ 'social_rss' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                     
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Delicious', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_delicious]" value="<?php echo esc_url( $options[ 'social_delicious' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Last.fm', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_lastfm]" value="<?php echo esc_url( $options[ 'social_lastfm' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                                 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Instagram', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_instagram]" value="<?php echo esc_url( $options[ 'social_instagram' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'GitHub', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_github]" value="<?php echo esc_url( $options[ 'social_github' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                    
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Vkontakte', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_vkontakte]" value="<?php echo esc_url( $options[ 'social_vkontakte'] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'My World', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_myworld]" value="<?php echo esc_url( $options[ 'social_myworld' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                            
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Odnoklassniki', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_odnoklassniki]" value="<?php echo esc_url( $options[ 'social_odnoklassniki' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Goodreads', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_goodreads]" value="<?php echo esc_url( $options[ 'social_goodreads' ] ); ?>" />
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Skype', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_skype]" value="<?php echo esc_attr( $options[ 'social_skype' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Soundcloud', 'adventurous' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="adventurous_options[social_soundcloud]" value="<?php echo esc_url( $options[ 'social_soundcloud' ] ); ?>" />
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'adventurous' ); ?>" />
                           	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->    
        
				</div><!-- #slidersettings -->

            </div><!-- #adventurous_ad_tabs -->
		</form>
	</div><!-- .wrap -->
<?php
}


/**
 * Validate content options
 * @param array $options
 * @uses esc_url_raw, absint, esc_textarea, sanitize_text_field, adventurous_invalidate_caches
 * @return array
 */
function adventurous_theme_options_validate( $options ) {
	global $adventurous_options_settings, $adventurous_options_defaults;
    $input_validated = $adventurous_options_settings;	
	
	$defaults = $adventurous_options_defaults;
	
    $input = array();
    $input = $options;

	// Data Validation for Favicon		
	if ( isset( $input[ 'fav_icon' ] ) ) {
		$input_validated[ 'fav_icon' ] = esc_url_raw( $input[ 'fav_icon' ] );
	}
	if ( isset( $input['remove_favicon'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'remove_favicon' ] = $input[ 'remove_favicon' ];
	}
	
	// Data Validation for web clip icon
	if ( isset( $input[ 'web_clip' ] ) ) {
		$input_validated[ 'web_clip' ] = esc_url_raw( $input[ 'web_clip' ] );
	}
	if ( isset( $input['remove_web_clip'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'remove_web_clip' ] = $input[ 'remove_web_clip' ];
	}	 	
	
	// Data Validation for Logo 
	if ( isset( $input['remove_header_logo'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'remove_header_logo' ] = $input[ 'remove_header_logo' ];
	}
	if ( isset( $input[ 'featured_logo_header' ] ) ) {
		$input_validated[ 'featured_logo_header' ] = esc_url_raw( $input[ 'featured_logo_header' ] );
	}
	
	// Data Validation for Promotion
	if ( isset( $input['enable_promotion'] ) ) {
		$input_validated[ 'enable_promotion' ] = $input[ 'enable_promotion' ];
	}		
	if( isset( $input[ 'homepage_headline' ] ) ) {
		$input_validated['homepage_headline'] =  sanitize_text_field( $input[ 'homepage_headline' ] ) ? $input [ 'homepage_headline' ] : $defaults[ 'homepage_headline' ];
	}
	if( isset( $input[ 'homepage_subheadline' ] ) ) {
		$input_validated['homepage_subheadline'] =  sanitize_text_field( $input[ 'homepage_subheadline' ] ) ? $input [ 'homepage_subheadline' ] : $defaults[ 'homepage_subheadline' ];
	}	
	if( isset( $input[ 'homepage_headline_button' ] ) ) {
		$input_validated['homepage_headline_button'] =  sanitize_text_field( $input[ 'homepage_headline_button' ] ) ? $input [ 'homepage_headline_button' ] : $defaults[ 'homepage_headline_button' ];
	}			
	if( isset( $input[ 'homepage_headline_url' ] ) ) {
		$input_validated['homepage_headline_url'] =  esc_url_raw( $input[ 'homepage_headline_url' ] ) ? $input [ 'homepage_headline_url' ] : $defaults[ 'homepage_headline_url' ];
	}	
	if ( isset( $input[ 'homepage_headline_target' ] ) ) {
		$input_validated[ 'homepage_headline_target' ] = $input[ 'homepage_headline_target' ];
	}
	if ( isset( $input[ 'disable_homepage_headline' ] ) ) {
		$input_validated[ 'disable_homepage_headline' ] = $input[ 'disable_homepage_headline' ];
	}
	if ( isset( $input[ 'disable_homepage_subheadline' ] ) ) {
		$input_validated[ 'disable_homepage_subheadline' ] = $input[ 'disable_homepage_subheadline' ];
	}
	if ( isset( $input[ 'disable_homepage_button' ] ) ) {
		$input_validated[ 'disable_homepage_button' ] = $input[ 'disable_homepage_button' ];
	}	
	
	// Data Validation for Header Sidebar	
	if ( isset( $input[ 'disable_header_right_sidebar' ] ) ) {
		$input_validated[ 'disable_header_right_sidebar' ] = $input[ 'disable_header_right_sidebar' ];
	}	
	
	// Data validation for Large Header Image
	if ( isset( $input[ 'enable_featured_header_image' ] ) ) {
		$input_validated[ 'enable_featured_header_image' ] = $input[ 'enable_featured_header_image' ];
	}	 	
	if ( isset( $input['page_featured_image'] ) ) {
		$input_validated[ 'page_featured_image' ] = $input[ 'page_featured_image' ];
	}	
	if ( isset( $input[ 'featured_header_image' ] ) ) {
		$input_validated[ 'featured_header_image' ] = esc_url_raw( $input[ 'featured_header_image' ] ) ? $input [ 'featured_header_image' ] : $defaults[ 'featured_header_image' ];
	}	
	if ( isset( $input[ 'featured_header_image_alt' ] ) ) {
		$input_validated[ 'featured_header_image_alt' ] = sanitize_text_field( $input[ 'featured_header_image_alt' ] );
	}	
	if ( isset( $input[ 'featured_header_image_url' ] ) ) {
		$input_validated[ 'featured_header_image_url' ] = esc_url_raw( $input[ 'featured_header_image_url' ] );
	}	
	if ( isset( $input['featured_header_image_base'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'featured_header_image_base' ] = $input[ 'featured_header_image_base' ];
	}	
	
	if ( isset( $input['reset_featured_image'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'reset_featured_image' ] = $input[ 'reset_featured_image' ];
	}	

	//Reset Header Featured Image Options
	if( $input[ 'reset_featured_image' ] == 1 ) {
		$input_validated[ 'enable_featured_header_image' ] = $defaults[ 'enable_featured_header_image' ];
		$input_validated[ 'page_featured_image' ] = $defaults[ 'page_featured_image' ];
		$input_validated[ 'featured_header_image' ] = $defaults[ 'featured_header_image' ];
		$input_validated[ 'featured_header_image_alt' ] = $defaults[ 'featured_header_image_alt' ];
		$input_validated[ 'featured_header_image_url' ] = $defaults[ 'featured_header_image_url' ];
		$input_validated[ 'featured_header_image_base' ] = $defaults[ 'featured_header_image_base' ];
	}
	
	// Data Validation for Custom CSS Style
	if ( isset( $input['custom_css'] ) ) {
		$input_validated['custom_css'] = wp_kses_stripslashes($input['custom_css']);
	}
	
	// Data Validation for Homepage Featured Content  
	if ( isset( $input[ 'enable-featured' ] ) ) {
		$input_validated[ 'enable-featured' ] = $input[ 'enable-featured' ];
	}		
	if ( isset( $input['disable_slider_text'] ) ) {
   		$input_validated[ 'disable_slider_text' ] = $input[ 'disable_slider_text' ];	
	
    }
	if( isset( $input[ 'homepage_featured_headline' ] ) ) {
		$input_validated['homepage_featured_headline'] =  sanitize_text_field( $input[ 'homepage_featured_headline' ] ) ? $input [ 'homepage_featured_headline' ] : $defaults[ 'homepage_featured_headline' ];
	}
	if( isset( $input[ 'homepage_featured_subheadline' ] ) ) {
		$input_validated['homepage_featured_subheadline'] =  sanitize_text_field( $input[ 'homepage_featured_subheadline' ] ) ? $input [ 'homepage_featured_subheadline' ] : $defaults[ 'homepage_featured_subheadline' ];
	}	
	if ( isset( $input[ 'homepage_featured_image' ] ) ) {
		$input_validated[ 'homepage_featured_image' ] = array();
	}
	if ( isset( $input[ 'homepage_featured_url' ] ) ) {
		$input_validated[ 'homepage_featured_url' ] = array();
	}
	if ( isset( $input[ 'homepage_featured_base' ] ) ) {
		$input_validated[ 'homepage_featured_base' ] = array();
	}	
	if ( isset( $input[ 'homepage_featured_title' ] ) ) {
		$input_validated[ 'homepage_featured_title' ] = array();
	}
	if ( isset( $input[ 'homepage_featured_content' ] ) ) {
		$input_validated[ 'homepage_featured_content' ] = array();
	}
	if( isset( $input[ 'homepage_featured_layout' ] ) ) {
		$input_validated[ 'homepage_featured_layout' ] = $input[ 'homepage_featured_layout' ];
	}	
	if ( isset( $input[ 'homepage_featured_qty' ] ) ) {
		$input_validated[ 'homepage_featured_qty' ] = absint( $input[ 'homepage_featured_qty' ] ) ? $input [ 'homepage_featured_qty' ] : $defaults[ 'homepage_featured_qty' ];
		for ( $i = 1; $i <= $input [ 'homepage_featured_qty' ]; $i++ ) {
			if ( !empty( $input[ 'homepage_featured_image' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_image' ][ $i ] = esc_url_raw($input[ 'homepage_featured_image' ][ $i ] );
			}
			if ( !empty( $input[ 'homepage_featured_url' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_url'][ $i ] = esc_url_raw($input[ 'homepage_featured_url'][ $i ]);
			}
			if ( !empty( $input[ 'homepage_featured_base' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_base'][ $i ] = $input[ 'homepage_featured_base'][ $i ];
			}
			if ( !empty( $input[ 'homepage_featured_title' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_title'][ $i ] = sanitize_text_field($input[ 'homepage_featured_title'][ $i ]);
			}
			if ( !empty( $input[ 'homepage_featured_content' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_content'][ $i ] = wp_kses_stripslashes($input[ 'homepage_featured_content'][ $i ]);
			}	
		}
	}	
	
	// Data Validation for Homepage
	if ( isset( $input[ 'enable_posts_home' ] ) ) {
		$input_validated[ 'enable_posts_home' ] = $input[ 'enable_posts_home' ];
	}	
    if ( isset( $input['exclude_slider_post'] ) ) {
        // Our checkbox value is either 0 or 1 
   		$input_validated[ 'exclude_slider_post' ] = $input[ 'exclude_slider_post' ];	
	
    }
	// Front page posts categories
    if( isset( $input['front_page_category' ] ) ) {
		$input_validated['front_page_category'] = $input['front_page_category'];
    }	

	// data validation for Slider Type
	if( isset( $input[ 'select_slider_type' ] ) ) {
		$input_validated[ 'select_slider_type' ] = $input[ 'select_slider_type' ];
	}
	// data validation for Enable Slider
	if( isset( $input[ 'enable_slider' ] ) ) {
		$input_validated[ 'enable_slider' ] = $input[ 'enable_slider' ];
	}	
    // data validation for number of slides
	if ( isset( $input[ 'slider_qty' ] ) ) {
		$input_validated[ 'slider_qty' ] = absint( $input[ 'slider_qty' ] ) ? $input [ 'slider_qty' ] : 4;
	}	
    // data validation for transition effect
    if( isset( $input[ 'transition_effect' ] ) ) {
        $input_validated['transition_effect'] = wp_filter_nohtml_kses( $input['transition_effect'] );
    }
    // data validation for transition delay
	if ( isset( $input[ 'transition_delay' ] ) ) {
		$input_validated[ 'transition_delay' ] = absint( $input[ 'transition_delay' ] ) ? $input [ 'transition_delay' ] : 4;
	}		
    // data validation for transition length
	if ( isset( $input[ 'transition_duration' ] ) ) {
		$input_validated[ 'transition_duration' ] = absint( $input[ 'transition_duration' ] ) ? $input [ 'transition_duration' ] : 1;
	}		
	
	// data validation for Featured Post Slider
	if ( isset( $input[ 'featured_slider' ] ) ) {
		$input_validated[ 'featured_slider' ] = array();
	}	
 	if ( isset( $input[ 'slider_qty' ] ) )	{	
		for ( $i = 1; $i <= $input [ 'slider_qty' ]; $i++ ) {
			if ( !empty( $input[ 'featured_slider' ][ $i ] ) && intval( $input[ 'featured_slider' ][ $i ] ) ) {
				$input_validated[ 'featured_slider' ][ $i ] = absint($input[ 'featured_slider' ][ $i ] );
			}		
		}
	}	
	
	//Featured Category Slider
	if ( isset( $input['slider_category'] ) ) {
		$input_validated[ 'slider_category' ] = $input[ 'slider_category' ];
	}		
	
	// data validation for Social Icons
	if( isset( $input[ 'social_facebook' ] ) ) {
		$input_validated[ 'social_facebook' ] = esc_url_raw( $input[ 'social_facebook' ] );
	}
	if( isset( $input[ 'social_twitter' ] ) ) {
		$input_validated[ 'social_twitter' ] = esc_url_raw( $input[ 'social_twitter' ] );
	}
	if( isset( $input[ 'social_googleplus' ] ) ) {
		$input_validated[ 'social_googleplus' ] = esc_url_raw( $input[ 'social_googleplus' ] );
	}
	if( isset( $input[ 'social_pinterest' ] ) ) {
		$input_validated[ 'social_pinterest' ] = esc_url_raw( $input[ 'social_pinterest' ] );
	}	
	if( isset( $input[ 'social_youtube' ] ) ) {
		$input_validated[ 'social_youtube' ] = esc_url_raw( $input[ 'social_youtube' ] );
	}
	if( isset( $input[ 'social_vimeo' ] ) ) {
		$input_validated[ 'social_vimeo' ] = esc_url_raw( $input[ 'social_vimeo' ] );
	}	
	if( isset( $input[ 'social_linkedin' ] ) ) {
		$input_validated[ 'social_linkedin' ] = esc_url_raw( $input[ 'social_linkedin' ] );
	}
	if( isset( $input[ 'social_slideshare' ] ) ) {
		$input_validated[ 'social_slideshare' ] = esc_url_raw( $input[ 'social_slideshare' ] );
	}	
	if( isset( $input[ 'social_foursquare' ] ) ) {
		$input_validated[ 'social_foursquare' ] = esc_url_raw( $input[ 'social_foursquare' ] );
	}
	if( isset( $input[ 'social_flickr' ] ) ) {
		$input_validated[ 'social_flickr' ] = esc_url_raw( $input[ 'social_flickr' ] );
	}
	if( isset( $input[ 'social_tumblr' ] ) ) {
		$input_validated[ 'social_tumblr' ] = esc_url_raw( $input[ 'social_tumblr' ] );
	}	
	if( isset( $input[ 'social_deviantart' ] ) ) {
		$input_validated[ 'social_deviantart' ] = esc_url_raw( $input[ 'social_deviantart' ] );
	}
	if( isset( $input[ 'social_dribbble' ] ) ) {
		$input_validated[ 'social_dribbble' ] = esc_url_raw( $input[ 'social_dribbble' ] );
	}	
	if( isset( $input[ 'social_myspace' ] ) ) {
		$input_validated[ 'social_myspace' ] = esc_url_raw( $input[ 'social_myspace' ] );
	}
	if( isset( $input[ 'social_wordpress' ] ) ) {
		$input_validated[ 'social_wordpress' ] = esc_url_raw( $input[ 'social_wordpress' ] );
	}	
	if( isset( $input[ 'social_rss' ] ) ) {
		$input_validated[ 'social_rss' ] = esc_url_raw( $input[ 'social_rss' ] );
	}
	if( isset( $input[ 'social_delicious' ] ) ) {
		$input_validated[ 'social_delicious' ] = esc_url_raw( $input[ 'social_delicious' ] );
	}	
	if( isset( $input[ 'social_lastfm' ] ) ) {
		$input_validated[ 'social_lastfm' ] = esc_url_raw( $input[ 'social_lastfm' ] );
	}
	if( isset( $input[ 'social_instagram' ] ) ) {
		$input_validated[ 'social_instagram' ] = esc_url_raw( $input[ 'social_instagram' ] );
	}	
	if( isset( $input[ 'social_github' ] ) ) {
		$input_validated[ 'social_github' ] = esc_url_raw( $input[ 'social_github' ] );
	}
	if( isset( $input[ 'social_vkontakte' ] ) ) {
		$input_validated[ 'social_vkontakte' ] = esc_url_raw( $input[ 'social_vkontakte' ] );
	}	
	if( isset( $input[ 'social_myworld' ] ) ) {
		$input_validated[ 'social_myworld' ] = esc_url_raw( $input[ 'social_myworld' ] );
	}
	if( isset( $input[ 'social_odnoklassniki' ] ) ) {
		$input_validated[ 'social_odnoklassniki' ] = esc_url_raw( $input[ 'social_odnoklassniki' ] );
	}	
	if( isset( $input[ 'social_goodreads' ] ) ) {
		$input_validated[ 'social_goodreads' ] = esc_url_raw( $input[ 'social_goodreads' ] );
	}	
	if( isset( $input[ 'social_skype' ] ) ) {
		$input_validated[ 'social_skype' ] = sanitize_text_field( $input[ 'social_skype' ] );
	}
	if( isset( $input[ 'social_soundcloud' ] ) ) {
		$input_validated[ 'social_soundcloud' ] = esc_url_raw( $input[ 'social_soundcloud' ] );
	}		

	
    // Layout settings verification
	if( isset( $input[ 'sidebar_layout' ] ) ) {
		$input_validated[ 'sidebar_layout' ] = $input[ 'sidebar_layout' ];
	}
	if( isset( $input[ 'content_layout' ] ) ) {
		$input_validated[ 'content_layout' ] = $input[ 'content_layout' ];
	}
	
	//data validation for more text
    if( isset( $input[ 'more_tag_text' ] ) ) {
        $input_validated[ 'more_tag_text' ] = htmlentities( sanitize_text_field ( $input[ 'more_tag_text' ] ), ENT_QUOTES, 'UTF-8' );
    }
    //data validation for excerpt length
    if ( isset( $input[ 'excerpt_length' ] ) ) {
        $input_validated[ 'excerpt_length' ] = absint( $input[ 'excerpt_length' ] ) ? $input [ 'excerpt_length' ] : $defaults[ 'excerpt_length' ];
    }
	if ( isset( $input['reset_moretag'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'reset_moretag' ] = $input[ 'reset_moretag' ];
	}	
	
	//Reset More Tag
	if( $input[ 'reset_moretag' ] == 1 ) {
		$input_validated[ 'more_tag_text' ] = $defaults[ 'more_tag_text' ];
		$input_validated[ 'excerpt_length' ] = $defaults[ 'excerpt_length' ];
	}			
	
	
    if( isset( $input[ 'search_display_text' ] ) ) {
        $input_validated[ 'search_display_text' ] = sanitize_text_field( $input[ 'search_display_text' ] ) ? $input [ 'search_display_text' ] : $defaults[ 'search_display_text' ];
    }
	
	// Data Validation for Featured Image
	if ( isset( $input['featured_image'] ) ) {
		$input_validated[ 'featured_image' ] = $input[ 'featured_image' ];
	}
	
	if ( isset( $input['reset_layout'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'reset_layout' ] = $input[ 'reset_layout' ];
	}	
	
	//Reset Layout
	if( $input[ 'reset_layout' ] == 1 ) {
		$input_validated[ 'sidebar_layout' ] = $defaults[ 'sidebar_layout' ];
		$input_validated[ 'content_layout' ] = $defaults[ 'content_layout' ];
		$input_validated[ 'featured_image' ] = $defaults[ 'featured_image' ];
	}		
	
	//Reset Footer
	if ( $input[ 'reset_footer' ] == 1 ) {
		$input_validated[ 'footer_code' ] = $defaults[ 'footer_code' ];
	}	
	
	//Clearing the theme option cache
	if( function_exists( 'adventurous_themeoption_invalidate_caches' ) ) adventurous_themeoption_invalidate_caches();
	
	return $input_validated;
}


/*
 * Clearing the cache if any changes in Admin Theme Option
 */
function adventurous_themeoption_invalidate_caches() {
	delete_transient( 'adventurous_favicon' );	 // favicon on cpanel/ backend and frontend
	delete_transient( 'adventurous_featured_image' ); // featured header image	
	delete_transient( 'adventurous_inline_css' ); // Custom Inline CSS
	delete_transient( 'adventurous_post_sliders' ); // featured post slider
	delete_transient( 'adventurous_category_sliders' ); // featured category slider
	delete_transient( 'adventurous_default_sliders' ); //Default slider
	delete_transient( 'adventurous_homepage_headline' ); // Homepage Headline Message
	delete_transient( 'adventurous_default_featured_content' ); // Homepage Default Featured Content
	delete_transient( 'adventurous_homepage_featured_content' ); // Homepage Featured Content
	delete_transient( 'adventurous_footer_content' ); // Footer Content
	delete_transient( 'adventurous_social_networks' ); // Social Networks
	delete_transient( 'adventurous_web_clip' ); // web clip icons
}


/*
 * Clearing the cache if any changes in post or page
 */
function adventurous_post_invalidate_caches(){
	delete_transient( 'adventurous_post_sliders' ); // featured post slider
	delete_transient( 'adventurous_category_sliders' ); // featured category slider
}
//Add action hook here save post
add_action( 'save_post', 'adventurous_post_invalidate_caches' );


/**
 * Creates new shortcodes for use in any shortcode-ready area.  This function uses the add_shortcode() 
 * function to register new shortcodes with WordPress.
 *
 * @uses add_shortcode() to create new shortcodes.
 */
function adventurous_add_shortcodes() {
	/* Add theme-specific shortcodes. */
	add_shortcode( 'footer-image', 'adventurous_footer_image_shortcode' );
	add_shortcode( 'the-year', 'adventurous_the_year_shortcode' );
	add_shortcode( 'site-link', 'adventurous_site_link_shortcode' );
	add_shortcode( 'wp-link', 'adventurous_wp_link_shortcode' );
	add_shortcode( 'theme-link', 'adventurous_theme_link_shortcode' );
	
}
/* Register shortcodes. */
add_action( 'init', 'adventurous_add_shortcodes' );


/**
 * Shortcode to display Footer Image.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function adventurous_footer_image_shortcode() {
	if( function_exists( 'adventurous_footerlogo' ) ) :
    	return adventurous_footerlogo(); 
    endif;
}


/**
 * Shortcode to display the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function adventurous_the_year_shortcode() {
	return date( __( 'Y', 'adventurous' ) );
}


/**
 * Shortcode to display a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function adventurous_site_link_shortcode() {
	return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}


/**
 * Shortcode to display a link to WordPress.org.
 *
 * @return string
 */
function adventurous_wp_link_shortcode() {
	return '<a href="http://wordpress.org" target="_blank" title="' . esc_attr__( 'WordPress', 'adventurous' ) . '"><span>' . __( 'WordPress', 'adventurous' ) . '</span></a>';
}


/**
 * Shortcode to display a link to Theme Link.
 *
 * @return string
 */
function adventurous_theme_link_shortcode() {
	return '<a href="http://catchthemes.com/themes/adventurous" target="_blank" title="' . esc_attr__( 'Adventurous', 'adventurous' ) . '"><span>' . __( 'Adventurous', 'adventurous' ) . '</span></a>';
}