<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php get_header(); ?>

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
	<?php kontruk_breadcrumb_title(); ?>
<?php endif; ?>

<?php 
	$kontruk_single_style = swg_options( 'product_single_style' );
	if( empty( $kontruk_single_style ) || $kontruk_single_style == 'default' ){ 
		get_template_part( 'woocommerce/content-single-product' );
	}
	else{
		get_template_part( 'woocommerce/content-single-product-' . $kontruk_single_style );
	}
?>

<?php get_footer(); ?>