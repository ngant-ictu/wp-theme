<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version    3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="container">
	<div class="row sidebar-row">
		<!-- Left Sidebar -->
		<?php if ( is_active_sidebar('left-product-detail') && kontruk_sidebar_product() == 'left' ):
			$kontruk_left_span_class = 'col-lg-'.swg_options('sidebar_left_expand');
			$kontruk_left_span_class .= ' col-md-'.swg_options('sidebar_left_expand_md');
			$kontruk_left_span_class .= ' col-sm-'.swg_options('sidebar_left_expand_sm');
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($kontruk_left_span_class); ?>">
			<?php dynamic_sidebar('left-product-detail'); ?>
		</aside>
		<?php endif; ?>

		<div id="contents-detail" <?php kontruk_content_product_detail(); ?> role="main">
			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action('woocommerce_before_main_content');
			?>
			<div class="single-product clearfix">
			
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/**
						 * woocommerce_before_single_product hook
						 *
						 * @hooked woocommerce_show_messages - 10
						 */
						 do_action( 'woocommerce_before_single_product' );
						global $product;
						if ( post_password_required() ) {
							echo get_the_password_form();
							return;
						}
						$kontruk_featured_video   = get_post_meta( $post->ID, 'featured_video_product', true );
					?>
					<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="product_detail row">
							<div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 clear_xs">							
								<div class="woocommerce-product-gallery woocommerce-product-gallery--with-images images product-images" data-video="<?php echo sprintf( ( $kontruk_featured_video != '' ) ? '%s' : '', esc_url( 'https://www.youtube.com/embed/' . $kontruk_featured_video ) ); ?>">
									<figure class="woocommerce-product-gallery__wrapper">
									<?php
										$attachments 	   = array();										
										$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
										$attachments = ( swg_woocommerce_version_check( '3.0' ) ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();
										if( has_post_thumbnail() ){ 				
											$image_id 	 = get_post_thumbnail_id();
											array_unshift( $attachments, $image_id );
											$attachments = array_unique( $attachments );
										}
										if( count( $attachments ) ){
											foreach ( $attachments as $key => $attachment ) { 
											if( $key > 3 ){
												break;
											}
											$full_size_image  = wp_get_attachment_image_src( $attachment, 'full' );
											$thumbnail_post   = get_post( $attachment );

											$attributes = array(
												'class' => 'wp-post-image',
												'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
												'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
												'data-src'                => $full_size_image[0],
												'data-large_image'        => $full_size_image[0],
												'data-large_image_width'  => $full_size_image[1],
												'data-large_image_height' => $full_size_image[2],
											);
										?>
										<div data-thumb="<?php echo wp_get_attachment_image_url( $attachment, 'shop_thumbnail' ) ?>" class="woocommerce-product-gallery__image style-gall">	
											<a href="<?php echo wp_get_attachment_url( $attachment ) ?>"><?php echo wp_get_attachment_image( $attachment, 'shop_single', false, $attributes ); ?></a>
										</div>
										<?php }
										}
									?>
									</figure>
								</div>						
							</div>
							<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 clear_xs">
								<div class="content_product_detail">
									<!-- woocommerce_template_single_title - 5 -->
									<!-- woocommerce_template_single_rating - 10 -->
									<!-- woocommerce_template_single_price - 20 -->
									<!-- woocommerce_template_single_excerpt - 30 -->
									<!-- woocommerce_template_single_add_to_cart 40 -->
									<?php
										/**
										 * woocommerce_single_product_summary hook
										 *
										 * @hooked woocommerce_template_single_title - 5
										 * @hooked woocommerce_template_single_price - 10
										 * @hooked woocommerce_template_single_excerpt - 20
										 * @hooked woocommerce_template_single_add_to_cart - 30
										 * @hooked woocommerce_template_single_meta - 40
										 * @hooked woocommerce_template_single_sharing - 50
										 */
										do_action( 'woocommerce_single_product_summary' );
									?>				
								</div>
							</div>
						</div>
					</div>		
					<div class="tabs clearfix">
						<?php
							/**
							 * woocommerce_after_single_product_summary hook
							 *
							 * @hooked woocommerce_output_product_data_tabs - 10
							 * @hooked woocommerce_output_related_products - 20
							 */
							do_action( 'woocommerce_after_single_product_summary' );
						?>
					</div>

					<?php if (is_active_sidebar('bottom-detail-product')) { ?>
						<div class="bottom-single-product theme-clearfix">
							<?php dynamic_sidebar('bottom-detail-product'); ?>
						</div>
					<?php } ?>
						
					<?php do_action( 'woocommerce_after_single_product' ); ?>

				<?php endwhile; // end of the loop. ?>
			
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
		<?php if ( is_active_sidebar('right-product-detail') && kontruk_sidebar_product() == 'right' ):
			$kontruk_right_span_class = 'col-lg-'.swg_options('sidebar_right_expand');
			$kontruk_right_span_class .= ' col-md-'.swg_options('sidebar_right_expand_md');
			$kontruk_right_span_class .= ' col-sm-'.swg_options('sidebar_right_expand_sm');
		?>
		<aside id="right" class="sidebar <?php echo esc_attr($kontruk_right_span_class); ?>">
			<?php dynamic_sidebar('right-product-detail'); ?>
		</aside>
		<?php endif; ?>
		
	</div>
</div>