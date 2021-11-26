<?php 
	/* 
	** Content Footer Mobile
	*/
	
?>
<footer id="footer" class="footer-mstyle1 theme-clearfix">
	<div class="footer-container">
		<div class="footer-menu clearfix">
			<div class="menu-item <?php if ( is_front_page() ) { echo esc_html_e( "active", "kontruk" ); } ?>">
				<div class="footer-home">
					<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php esc_attr_e( 'Home', 'kontruk' ) ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e( "Home", 'kontruk' )?></span>
					</a>
				</div>
			</div>
			<div class="menu-item <?php if ( is_account_page() ) { echo esc_html_e( "active", "kontruk" ); } ?>">
				<div class="footer-myaccount">
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr_e('My Account','kontruk'); ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e('Account','kontruk'); ?></span>
					</a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-cart">
					<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-search">
					<a href="javascript:void(0)" title="<?php echo esc_attr__( 'Search', 'kontruk' ) ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e( "Search", 'kontruk' )?></span>
					</a>
					<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-more">
					<a href="javascript:void(0)" title="<?php esc_attr_e('More','kontruk'); ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e('More','kontruk'); ?></span>
					</a>
				</div>
			</div>
			<div class="menu-item-hidden">
				<?php if ( has_nav_menu('mobile_menu') ) {?>
					<div class="wrapper_menu_footer">
						<?php wp_nav_menu(array('theme_location' => 'mobile_menu', 'menu_class' => 'menu-footer')); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</footer>