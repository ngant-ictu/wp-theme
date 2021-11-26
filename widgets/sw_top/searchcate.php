<?php if( !swg_options( 'disable_search' ) ) : ?>
	<div class="top-form top-search">
		<div class="topsearch-entry">
		<?php if ( class_exists( 'WooCommerce' ) ) { ?>
			<form method="get" id="searchform_special" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
				<div>
					<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_attr_e( 'Enter your keyword...', 'kontruk' ); ?>" />
					<button type="submit" title="<?php esc_attr_e( 'Search', 'kontruk' ) ?>" class="fa fa-search button-search-pro form-button"></button>
					<input type="hidden" name="search_posttype" value="product" />
				</div>
			</form>
			<?php }else{ ?>
				<?php get_template_part('templates/searchform'); ?>
			<?php } ?>
		</div>
	</div>
	<?php 
		$kontruk_psearch = swg_options('popular_search'); 
		if( $kontruk_psearch != '' ){
	?>
	<div class="popular-search-keyword">
		<div class="keyword-title"><?php esc_html_e( 'Popular Keywords', 'kontruk' ) ?>: </div>
		<?php 
			$kontruk_psearch = explode(',', $kontruk_psearch); 
			foreach( $kontruk_psearch as $key => $item ){
				echo sprintf( ( $key == 0 ) ? '' : '%s', ',' );
				echo '<a href="'. esc_url( home_url('/') ) .'?s='. esc_attr( $item ) .'">' . $item . '</a>';
			}
		?>		
	</div>
	<?php } ?>
<?php endif; ?>
