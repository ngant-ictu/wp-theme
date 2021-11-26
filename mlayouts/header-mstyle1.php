<?php 
	/* 
	** Content Header
	*/
	$sticky_mobile	= swg_options( 'sticky_menu' );
?>
<?php if( is_front_page() || get_post_meta( get_the_ID(), 'page_mobile_enable', true ) || is_search() || swg_options( 'mobile_header_inside' ) ) { ?>
<header id="header" class="header header-mobile-style1">
	<div class="header-wrrapper clearfix">
		<div class="header-top-mobile clearfix">
			<div class="kontruk-logo pull-left">
				<?php kontruk_logo(); ?>
			</div>
			<?php if( !swg_options( 'disable_cart' ) ) : ?>
			<div class="header-cart pull-right">
				<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
			</div>
			<?php endif; ?>
			<div class="header-wishlist pull-right">
				<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','kontruk'); ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
			</div>
		</div>
		<div class="header-mid-mobile clearfix">				
			<div class="header-menu-categories pull-left">
				<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
				<?php } ?>
			</div>
			<?php if( !swg_options( 'disable_search' ) ) : ?>
			<div class="mobile-search pull-left">
				<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
					<?php dynamic_sidebar( 'search' ); ?>
				<?php else : ?>
					<div class="widget revo_top non-margin">
						<div class="widget-inner">
							<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php get_template_part( 'widgets/sw_top/login' ); ?>
		</div>
	</div>
</header>
<?php } elseif ( is_shop() || is_tax( 'product_cat' ) ) { ?>
<header id="header" class="header header-mobile-style1 category-product">
	<div class="header-wrrapper clearfix">
		<div class="header-product-mobile clearfix">
			<div class="back-history pull-left"></div>			
			<div class="header-menu-categories pull-left">
				<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
				<?php } ?>
			</div>
			<div class="search-log pull-left">
				<?php if( !swg_options( 'disable_search' ) ) : ?>
				<div class="mobile-search pull-left">
					<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
						<?php dynamic_sidebar( 'search' ); ?>
					<?php else : ?>
						<div class="widget revo_top non-margin">
							<div class="widget-inner">
								<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<?php get_template_part( 'widgets/sw_top/login' ); ?>
			</div>
			<?php if( !swg_options( 'disable_cart' ) ) : ?>
			<div class="header-cart pull-right">
				<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
			</div>
			<?php endif; ?>
			<div class="header-wishlist pull-right">
				<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','kontruk'); ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
			</div>
			<div class="breadcrumb-home clearfix">
				<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php esc_attr_e( 'Home', 'kontruk' ) ?>">
					<span class="icon-menu"></span>
				</a>
				<span class="title-text"><?php esc_html_e( "Shop", 'kontruk' )?></span>
			</div>
		</div>
	</div>
</header>
<?php } elseif ( is_singular( 'product' ) ) { ?>
<header id="header" class="header header-mobile-style1 single-product">
	<div class="header-wrrapper clearfix">
		<div class="header-product-mobile clearfix">
			<div class="back-history pull-left"></div>			
			<div class="header-menu-categories pull-right">
				<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
				<?php } ?>
			</div>
			<?php if( !swg_options( 'disable_cart' ) ) : ?>
			<div class="header-cart pull-right">
				<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
			</div>
			<?php endif; ?>
			<?php if( !swg_options( 'disable_search' ) ) : ?>
			<div class="mobile-search pull-right">
				<div class="icon-search"></div>
				<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
					<?php dynamic_sidebar( 'search' ); ?>
				<?php else : ?>
					<div class="widget revo_top non-margin">
						<div class="widget-inner">
							<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</header>
<?php } else { ?>
<!--  header page -->
<?php get_template_part( 'mlayouts/breadcrumb', 'mobile' ); ?>
<!-- End header -->
<?php } ?>