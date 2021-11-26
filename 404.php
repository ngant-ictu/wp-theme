<?php get_header(); ?>
<div class="wrapper_404">
	<div class="container">
		<div class="row">
			<?php $kontruk_404page = swg_options( 'page_404' ); ?>
			<?php if( $kontruk_404page != '' ) : ?>
				<?php echo swg_get_the_content_by_id( $kontruk_404page ); ?>
			<?php else: ?>
				<div class="content_404">
					<div class="erro-image">
						<img class="img_logo" alt="<?php echo esc_attr__( '404', 'kontruk' ) ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/img-404.png">
					</div>
					<div class="block-top">
						<h2><?php esc_html_e( 'Ooops... Page is under construction', 'kontruk' ) ?></h2>
					</div>
					<div class="block-bottom">
						<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="<?php esc_attr_e( 'Go back home', 'kontruk' ) ?>"><?php esc_html_e( "Go back home", 'kontruk' )?></a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>