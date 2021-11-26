<?php 	
	$kontruk_page_footer   	 = ( get_post_meta( get_the_ID(), 'page_footer_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_footer_style', true ) : swg_options( 'footer_style' );
	$kontruk_copyright_footer = get_post_meta( get_the_ID(), 'copyright_footer_style', true );
	$kontruk_copyright_footer  = ( get_post_meta( get_the_ID(), 'copyright_footer_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'copyright_footer_style', true ) : swg_options('copyright_style');
?>
<footer id="footer" class="footer default theme-clearfix">
	<!-- Content footer -->
	<div class="container">
		<?php 
			if( $kontruk_page_footer != '' ) :
				echo swg_get_the_content_by_id( $kontruk_page_footer ); 
			endif;
		?>
	</div>
	<div class="footer-copyright <?php echo esc_attr( $kontruk_copyright_footer ); ?>">
		<div class="container">
			<!-- Copyright text -->
			<div class="copyright-text">
				<p>&copy;<?php echo date_i18n('Y') .' '. esc_html__('WordPress Theme SW Kontruk. All Rights Reserved. Designed by ','kontruk'); ?><a class="mysite" href="<?php echo esc_url( 'http://wpthemego.com/' ); ?>"><?php esc_html_e('WPThemeGo.Com','kontruk');?></a>.</p>
			</div>
		</div>
	</div>
</footer>