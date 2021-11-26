<?php 
if ( !class_exists( 'WooCommerce' ) ) { 
	return false;
}
global $woocommerce; ?>
<div class="kontruk-minicart-mobile">
	<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart', 'kontruk' ); ?>">
	<span class="icon-menu"></span>
	<?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span>'; ?>
	<span class="menu-text"><?php echo esc_html__( 'Cart', 'kontruk' ); ?></span>
	</a>
</div>