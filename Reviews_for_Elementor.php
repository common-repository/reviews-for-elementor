<?php
/*
Plugin Name: Reviews for Elementor by Nahiro.net
Plugin URI: http://wordpress.org/plugins
Description: This plugin will create a testimonial Reviews from Google API for Elementor.
Version: 1.1.1
Author: Nahiro.net - Wordpress Hilfe & Support
Author URI: https://nahiro.net/
License: GPLv2 or later
*/

define( 'RFE_PLG_URL', plugin_dir_url( __FILE__ ));

if ( is_admin() ) {
	require_once dirname( __FILE__ ) . '/admin/Reviews_for_Elementor_Admin.php';
	$Google_Reviews_Admin = new Reviews_for_Elementor_Admin();
	$Google_Reviews_Admin -> init();
	
}

function load_styles_rfe_scripts($hook) {
 
    wp_enqueue_script( 'widgets-js', RFE_PLG_URL . 'assets/js/widgets.js', ['jquery', 'elementor-frontend'] );
    wp_enqueue_style( 'widgets-css',    RFE_PLG_URL . 'assets/css/widgets.css', false);
 
}

function load_rfe_styles($hook) {
	wp_enqueue_style('style-reviews', RFE_PLG_URL . 'assets/css/style_reviews.css'); 
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/5.4.0/css/font-awesome.min.css'); 
}

add_action('wp_enqueue_scripts', 'load_rfe_styles');
add_action( 'elementor/frontend/before_enqueue_scripts', 'load_styles_rfe_scripts');

function register_rfe_site_scripts() {
	wp_enqueue_script( 'bdt-uikit', RFE_PLG_URL . 'assets/js/bdt-uikit.js', ['jquery'] );
		wp_register_script( 'bdt-uikit-icons', RFE_PLG_URL . 'assets/js/bdt-uikit-icons.js', ['jquery', 'bdt-uikit'], '3.0.3', true );
}
add_action( 'elementor/frontend/before_register_scripts','register_rfe_site_scripts');

function add_google_rfe_reviews_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'nahiro-elements',
		[
			'title' => __( 'Nahiro.net Reviews for Elementor', 'testimonials-plugin' ),
			'icon' => 'fa fa-plug',
		]
	);

}
add_action( 'elementor/elements/categories_registered', 'add_google_rfe_reviews_widget_categories' );

class ElementorCustomElement {

   private static $instance = null;

   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }

   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_rfe_registered' ) );
   }

   public function widgets_rfe_registered() {

      if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){
	 	$widget_file = 'plugins/elementor/testimonial-grid-widget.php';
         $template_file = locate_template($widget_file);
         if ( !$template_file || !is_readable( $template_file ) ) {
            $template_file = plugin_dir_path(__FILE__).'/elementor-modules/testimonial-grid-widget.php';
         }
         if ( $template_file && is_readable( $template_file ) ) {
            require_once $template_file;
         }
      }
   }
}

ElementorCustomElement::get_instance()->init();

function register_rfe_types() {  

	$testimonial_slug = get_theme_mod('testimonial_slug');

	if(isset($testimonial_slug) && $testimonial_slug != ''){
		$testimonial_slug = $testimonial_slug;
	} else {
		$testimonial_slug = 'testimonial';
	}
	
	$labels = array(
		'name'               => esc_html__( 'Testimonials', 'testimonials-plugin' ),
		'singular_name'      => esc_html__( 'Testimonial', 'testimonials-plugin' ),
		'add_new'            => esc_html__( 'Add New', 'testimonials-plugin' ),
		'add_new_item'       => esc_html__( 'Add New Testimonial', 'testimonials-plugin' ),
		'all_items'          => esc_html__( 'All Testimonials', 'testimonials-plugin' ),
		'edit_item'          => esc_html__( 'Edit Testimonial', 'testimonials-plugin' ),
		'new_item'           => esc_html__( 'Add New Testimonial', 'testimonials-plugin' ),
		'view_item'          => esc_html__( 'View Item', 'testimonials-plugin' ),
		'search_items'       => esc_html__( 'Search Testimonial', 'testimonials-plugin' ),
		'not_found'          => esc_html__( 'No testimonial(s) found', 'testimonials-plugin' ),
		'not_found_in_trash' => esc_html__( 'No testimonial(s) found in trash', 'testimonials-plugin' )
	);
	
    $args = array(  
		'labels'          => $labels,
		'public'          => false,  
		'show_ui'         => false,  
		'capability_type' => 'post',  
		'hierarchical'    => false,  
		'menu_icon'       => 'dashicons-testimonial',
		'rewrite'         => array('slug' => $testimonial_slug), // Permalinks format
		'supports'        => array('title', 'editor', 'thumbnail')  
       );

    
    register_post_type( 'testimonial' , $args );  

$post_type = array(
	    'labels' => array(
	        'name' 			=> esc_html__( 'Location', 'testimonials-plugin' ),	        
	        'add_new' 		=> esc_html__( 'Add Location', 'testimonials-plugin' ),
	        'add_new_item'  	=> esc_html__( 'Edit Location', 'testimonials-plugin' ),
                'edit_item'             => esc_html__( 'Edit Location','testimonials-plugin'),                
	    ),
      	'public' 		=> false,
      	'has_archive' 		=> false,
      	'exclude_from_search'	=> true,
    	'publicly_queryable'	=> false,               
        'show_ui'               => false,
		'show_in_nav_menus'     => false,			
        'show_admin_column'     => true,        
		'rewrite'               => false,        
    );
        
    register_post_type( 'location', $post_type );  
}
add_action('init', 'register_rfe_types', 1);