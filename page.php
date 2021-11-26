<?php get_header(); ?>
<?php 
	$kontruk_sidebar_template	= get_post_meta( get_the_ID(), 'page_sidebar_layout', true );
	$kontruk_sidebar 			= get_post_meta( get_the_ID(), 'page_sidebar_template', true );
	$preloader 		            = swg_options( 'preloader' );
?>
	<?php if ( !is_front_page() ) { ?>
		<?php kontruk_breadcrumb_title(); ?>
	<?php } ?>

	<?php if ( is_front_page() && $preloader ) { ?>
		<div class="loader1" style="display: block;">
			<div class="loader-inner">
				<div id="preloader">
					<div id="loader"></div>
				</div>
			</div>
		</div>
	<?php } ?>
	
	<div class="container">
		<div class="row">
		<?php 
			if ( is_active_sidebar( $kontruk_sidebar ) && $kontruk_sidebar_template != 'right' && $kontruk_sidebar_template !='full' ):
			$kontruk_left_span_class = 'col-lg-'.swg_options('sidebar_left_expand');
			$kontruk_left_span_class .= ' col-md-'.swg_options('sidebar_left_expand_md');
			$kontruk_left_span_class .= ' col-sm-'.swg_options('sidebar_left_expand_sm');
		?>
			<aside id="left" class="sidebar <?php echo esc_attr( $kontruk_left_span_class ); ?>">
				<?php dynamic_sidebar( $kontruk_sidebar ); ?>
			</aside>
		<?php endif; ?>
		
			<div id="contents" role="main" class="main-page <?php kontruk_content_page(); ?>">
				<?php
				get_template_part('templates/content', 'page')
				?>
			</div>
			<?php 
			if ( is_active_sidebar( $kontruk_sidebar ) && $kontruk_sidebar_template != 'left' && $kontruk_sidebar_template !='full' ):
				$kontruk_left_span_class = 'col-lg-'.swg_options('sidebar_left_expand');
				$kontruk_left_span_class .= ' col-md-'.swg_options('sidebar_left_expand_md');
				$kontruk_left_span_class .= ' col-sm-'.swg_options('sidebar_left_expand_sm');
			?>
				<aside id="right" class="sidebar <?php echo esc_attr($kontruk_left_span_class); ?>">
					<?php dynamic_sidebar( $kontruk_sidebar ); ?>
				</aside>
			<?php endif; ?>
		</div>		
	</div>
<?php get_footer(); ?>