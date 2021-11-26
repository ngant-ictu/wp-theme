<?php
/***** Active Plugin ********/
require_once( get_template_directory().'/lib/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'kontruk_register_required_plugins' );
function kontruk_register_required_plugins() {
    $plugins = array(

        array(
            'name'               => esc_html__( 'WooCommerce', 'kontruk' ), 
            'slug'               => 'woocommerce', 
            'required'           => true, 
            'version'            => '5.6.0'
        ),

        array(
            'name'               => esc_html__( 'Revslider', 'kontruk' ), 
            'slug'               => 'revslider', 
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/revslider.zip' ), 
            'required'           => true,
            'version'            => '6.5.8'
        ),

        array(
            'name'               => esc_html__( 'Slider Revolution Before/After Add-On', 'kontruk' ), 
            'slug'               => 'revslider-beforeafter-addon', 
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/revslider-beforeafter-addon.zip' ), 
            'required'           => true,
            'version'            => '3.0.4'
        ),
		
		array(
            'name'               => esc_html__( 'Elementor', 'kontruk' ), 
            'slug'               => 'elementor',
            'required'           => true,
        ),

        array(
            'name'               => esc_html__( 'Elementor Pro', 'kontruk' ), 
            'slug'               => 'elementor-pro', 
            'source'             => get_template_directory() . '/lib/plugins/elementor-pro.zip', 
            'required'           => true, 
            'version'            => '3.4.1'
         ), 

       	array(
            'name'     			 => esc_html__( 'SW Core', 'kontruk' ),
            'slug'      		 => 'sw_core',
			'source'         	 => esc_url( get_template_directory_uri() . '/lib/plugins/sw_core.zip' ), 
            'required'  		 => true,   
			'version'			 => '1.8.2'
		),
 	
        array(
            'name'               => esc_html__( 'SW WooCommerce', 'kontruk' ),
            'slug'               => 'sw_woocommerce',
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/sw_woocommerce.zip' ), 
            'required'           => true,
            'version'            => '1.8.6'
        ),

        array(
            'name'               => esc_html__( 'SW Ajax Woocommerce Search', 'kontruk' ),
            'slug'               => 'sw_ajax_woocommerce_search',
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/sw_ajax_woocommerce_search.zip' ), 
            'required'           => true,
            'version'            => '1.2.2'
        ),

        array(
            'name'               => esc_html__( 'Sw Woocommerce Swatches', 'kontruk' ),
            'slug'               => 'sw_wooswatches',
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/sw_wooswatches.zip' ), 
            'required'           => true,
            'version'            => '1.0.17'
        ),
        
		array(
            'name'               => esc_html__( 'One Click Install', 'kontruk' ), 
            'slug'               => 'one-click-demo-import', 
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/one-click-demo-import.zip' ), 
            'required'           => true,
            'version'            => '9.9.10'
        ),

		array(
            'name'      		 => esc_html__( 'MailChimp for WordPress Lite', 'kontruk' ),
            'slug'     			 => 'mailchimp-for-wp',
            'required' 			 => false,
        ),

		array(
            'name'      		 => esc_html__( 'Contact Form 7', 'kontruk' ),
            'slug'     			 => 'contact-form-7',
            'required' 			 => false,
        ),

        array(
            'name'               => esc_html__( 'YITH WooCommerce Wishlist', 'kontruk' ),
            'slug'               => 'yith-woocommerce-wishlist',
            'required'           => false
        ),

        array(
            'name'               => esc_html__( 'Smash Balloon Instagram Feed', 'kontruk' ),
            'slug'               => 'instagram-feed',
            'required'           => false,
        ),


    );		
    $config = array();

    tgmpa( $plugins, $config );

}
add_action( 'vc_before_init', 'kontruk_vcSetAsTheme' );
function kontruk_vcSetAsTheme() {
    vc_set_as_theme();
}