<?php 
$kontruk_header_style = swg_options('header_style');
?>
<?php do_action( 'before' ); ?>
<?php if ( class_exists( 'WooCommerce' ) ) { ?>
<?php global $woocommerce; ?>
<div class="top-login">
	<?php if ( ! is_user_logged_in() ) {  ?>
		<ul>
			<li>
			<span><?php esc_html_e('Hello, Sign in', 'kontruk'); ?></span>
			<?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#login_form">'.esc_html__('Login', 'kontruk').'</a>'; ?> /
			<a class="register" href="<?php echo esc_url( home_url('/my-account') ); ?>" title="<?php esc_attr_e( 'Register', 'kontruk' ) ?>"><?php esc_html_e('Register', 'kontruk'); ?></a>
			</li>
		</ul>
	<?php } else{?>
		<div class="div-logined">
			<ul>
				<li>
					<span><?php esc_html_e('Hello', 'kontruk'); ?></span>
					<?php 
						$user_id = get_current_user_id();
						$user_info = get_userdata( $user_id );	
					?>
					<a href="<?php echo wp_logout_url( home_url('/') ); ?>" title="<?php esc_attr_e( 'Logout', 'kontruk' ) ?>"><?php esc_html_e('Logout', 'kontruk'); ?></a>
				</li>
			</ul>
		</div>
	<?php } ?>
</div>
<?php } ?>