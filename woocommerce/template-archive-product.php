<?php 
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.1
 */
 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$shop_categories  = swg_options( 'product_categories' );
	if( $shop_categories && kontruk_sidebar_product() == 'left' || $shop_categories && kontruk_sidebar_product() == 'right' ){
		$class = 'style1';
	}else{
		$class = '';
	}
?>
<?php get_header(); ?>

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

	<?php $maintaince_attr = ( swg_options('bg_breadcrumb') != '' ) ? 'style="background: url( '. esc_url( swg_options('bg_breadcrumb') ) .' )"' : ''; ?>
	<?php if( !swg_options('breadcrumb_active') ) : ?>
		<div class="kontruk_breadcrumbs" <?php echo $maintaince_attr?>>
			<div class="container">
				<?php
				if (!is_front_page() ) {
					if (function_exists('kontruk_breadcrumb')){
						kontruk_breadcrumb('<div class="breadcrumbs theme-clearfix">', '</div>');
					} 
				} 
				?>
				<div class="listing-title"><h2><?php esc_html_e( 'Shop', 'kontruk' ) ?></h2></div>
			</div>
		</div>	
	<?php endif; ?>

<?php endif; ?>
<div class="container archives">
	<div class="row sidebar-row">
	
	<!-- Left Sidebar -->
	<?php 	
	if ( is_active_sidebar('left-product') && kontruk_sidebar_product() != 'right' && kontruk_sidebar_product() != 'full' && kontruk_sidebar_product() != '' ):
		$kontruk_left_span_class = 'col-lg-'.swg_options('sidebar_left_expand');
		$kontruk_left_span_class .= ' col-md-'.swg_options('sidebar_left_expand_md');
		$kontruk_left_span_class .= ' col-sm-'.swg_options('sidebar_left_expand_sm');
	?>
	<aside id="left" class="sidebar <?php echo esc_attr($kontruk_left_span_class); ?>">
		<?php dynamic_sidebar('left-product'); ?>
	</aside>	
	<?php endif; ?>
	
	<div id="contents" <?php kontruk_content_product(); ?> role="main">
		<?php
			/**
			 * woocommerce_before_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			 global $post;
			do_action( 'woocommerce_before_main_content' );
		?>
		
		<!--  Shop Title -->
		<!-- Description --> 
		<?php do_action( 'woocommerce_archive_description' ); ?>
				
		<div class="products-wrapper">	
					
			<?php if ( have_posts() ) : ?>
				<?php do_action('woocommerce_message'); ?>
				
				<?php 					
								
					if( swg_woocommerce_version_check( '3.3' ) ){
						echo apply_filters( 'kontruk_custom_category', $html = '' );
					}else{
						woocommerce_product_subcategories(); 
					}
					woocommerce_product_loop_end(); 
				?>
				<?php if( kontruk_sidebar_product() == 'full' ){ ?>

					<div class="top-fill clearfix">
						<div class="button-filter"><span><i class="fa fa-sliders" aria-hidden="true"></i><?php esc_html_e( 'Filter', 'kontruk' ) ?></span></div>
						<?php
							/**
							 * woocommerce_before_shop_loop hook
							 *
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' );
						?>
					</div>

				<?php } else { 
				
					/**
					 * woocommerce_before_shop_loop hook
					 *
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );

				} ?>

				<?php if( kontruk_sidebar_product() == 'full' && is_active_sidebar('above-product') ){ ?>
				<div class="above-product-widget clearfix">
					<?php dynamic_sidebar( 'above-product' ); ?>
				</div>
				<?php } ?>
		
				<?php woocommerce_product_loop_start(); ?>				
										
					<?php while ( have_posts() ) : the_post(); ?>
		
					<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				<div class="clear"></div>			
				<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				?>
			<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

				<?php wc_get_template( 'loop/no-products-found.php' ); ?>

			<?php endif; ?>
		</div>
		<?php
			/**
			 * woocommerce_after_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action('woocommerce_after_main_content');
		?>
	</div>
	
	<!-- Right Sidebar -->
	<?php if ( is_active_sidebar('right-product') && kontruk_sidebar_product() != 'left' && kontruk_sidebar_product() != 'full' && kontruk_sidebar_product() != ''):
		$kontruk_right_span_class = 'col-lg-'.swg_options('sidebar_right_expand');
		$kontruk_right_span_class .= ' col-md-'.swg_options('sidebar_right_expand_md');
		$kontruk_right_span_class .= ' col-sm-'.swg_options('sidebar_right_expand_sm');
	?>
	<aside id="right" class="sidebar <?php echo esc_attr($kontruk_right_span_class); ?>">
		<?php dynamic_sidebar('right-product'); ?>
	</aside>
	<?php endif; ?>

	</div>
	<?php do_action( 'swg_bottom_detail_content' ); ?>
</div>
<?php get_footer(); ?>