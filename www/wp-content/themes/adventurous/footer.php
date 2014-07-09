<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
?> 
			<?php 
            /** 
             * adventurous_content_sidebar_close hook
             *
             * HOOKED_FUNCTION_NAME PRIORITY
             *
             * adventurous_content_sidebar_wrapper_close 10
             */
            do_action( 'adventurous_content_sidebar_close' ); ?> 
            
		<?php 
        /** 
         * adventurous_main_close hook
         *
         * HOOKED_FUNCTION_NAME PRIORITY
         *
         * adventurous_main_wrapper_close 10
         */
        do_action( 'adventurous_main_close' ); ?>             
     
        <?php 
        /** 
         * adventurous_after_main hook
         */
        do_action( 'adventurous_after_main' ); ?> 
        
   	</div><!-- #main-wrapper -->
           
    <?php 
    /** 
     * adventurous_before_footer hook
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 * 
	 * adventurous_homepage_featured_display value before footer 20
     */
    do_action( 'adventurous_before_footer' );  ?>     
    
	<footer id="colophon" role="contentinfo">
    
		<?php
        /** 
         * adventurous_footer hook
         *
         * @hooked adventurous_footer_sidebar - 10
         */		 
        do_action( 'adventurous_footer' ); ?>
        
 		<?php
        /** 
         * adventurous_footer hook
         *
         * @hooked adventurous_site_generator_open - 10
		 * @hooked adventurous_footer_content - 20
		 * @hooked adventurous_site_generator_close - 100
         */		 
        do_action( 'adventurous_site_generator' ); ?>       
           
             
	</footer><!-- #colophon .site-footer -->
    
    <?php 
    /** 
     * adventurous_after_footer hook
     */
    do_action( 'adventurous_after_footer' );  ?> 
    
</div><!-- #page .hfeed .site -->

<?php 
/** 
 * adventurous_after hook
 */
do_action( 'adventurous_after' );

wp_footer(); ?>

</body>
</html>