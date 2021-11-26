<?php 
/* 
** Content Header
*/
$kontruk_page_header  = get_post_meta( get_the_ID(), 'page_header_style', true );
$kontruk_colorset  	= swg_options('scheme');
$kontruk_logo 		= swg_options('sitelogo');
$sticky_menu 			= swg_options( 'sticky_menu' );
$kontruk_menu_item 	= ( swg_options( 'menu_number_item' ) ) ? swg_options( 'menu_number_item' ) : 11;
$kontruk_more_text 	= ( swg_options( 'menu_more_text' ) ) ? swg_options( 'menu_more_text' ) : esc_html__( 'See More', 'kontruk' );
$kontruk_less_text 	= ( swg_options( 'menu_less_text' ) ) ? swg_options( 'menu_less_text' ) : esc_html__( 'See Less', 'kontruk' );
$kontruk_menu_text 	= ( swg_options( 'menu_title_text' ) )	 ? swg_options( 'menu_title_text' )	: esc_html__( 'All Categories', 'kontruk' );
$kontruk_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' && ( is_single() || is_page() ) ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : swg_options('header_style'); 
?>
<header id="header" class="header header-style1">
	<div class="container">
		<div class="boxed-left col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="kontruk-logo">
				<?php kontruk_logo(); ?>
			</div>
		</div>
		<div class="boxed-right col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<div class="header-top row clearfix">
				<?php if (is_active_sidebar('top')) {?>
					<?php dynamic_sidebar('top'); ?>
				<?php }?>
			</div>
			<div class="header-mid clearfix">
				<?php if ( has_nav_menu('primary_menu') ) { ?>
					<div id="main-menu" class="main-menu pull-left">
						<nav id="primary-menu" class="primary-menu">
							<div class="mid-header clearfix">
								<div class="navbar-inner navbar-inverse">
									<?php
									$kontruk_menu_class = 'nav nav-pills';
									if ( 'mega' == swg_options('menu_type') ){
										$kontruk_menu_class .= ' nav-mega';
									} else $kontruk_menu_class .= ' nav-css';
									?>
									<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $kontruk_menu_class)); ?>
								</div>
							</div>
						</nav>
					</div>
				<?php } ?>
				<?php if (is_active_sidebar('mid')) {?>
					<div class="header-right clearfix pull-right">
						<?php dynamic_sidebar('mid'); ?>
					</div>
				<?php }?>
			</div>
		</div>
	</div>
</header>