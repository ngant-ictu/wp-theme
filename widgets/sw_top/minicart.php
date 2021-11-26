<?php if ( class_exists( 'WooCommerce' ) && !swg_options( 'disable_cart' ) ) { ?>
<?php
	$kontruk_page_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : swg_options('header_style');
	if( $kontruk_page_header == 'style2' ){
		get_template_part( 'woocommerce/minicart-ajax-style2' ); 
	}else{
		get_template_part( 'woocommerce/minicart-ajax' ); 
	}	
?>
<?php } ?>