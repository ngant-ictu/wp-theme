<?php 
/*
	* Name: WooCommerce Hook
	* Develop: SmartAddons
*/

/*
** Add WooCommerce support
*/
add_theme_support( 'woocommerce' );

/*
** WooCommerce Compare Version
*/
if( !function_exists( 'swg_woocommerce_version_check' ) ) :
	function swg_woocommerce_version_check( $version = '3.0' ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}else{
			return false;
		}
	}
endif;


/*
** Check vendor user
*/
if( !function_exists( 'swg_woocommerce_vendor_check' ) ) :
	function swg_woocommerce_vendor_check(){
		$vendor_id = get_post_field( 'post_author', get_the_id() );
		$vendor = new WP_User($vendor_id);
		if ( in_array( 'vendor', (array) $vendor->roles ) || in_array( 'seller', (array) $vendor->roles ) || in_array( 'wcfm_vendor', (array) $vendor->roles ) || in_array( 'dc_vendor', (array) $vendor->roles ) ){
			return true;
		}else{
			return false;
		}
	}
endif;


add_filter( 'action_scheduler_retention_period', 'wpb_action_scheduler_purge' );
function wpb_action_scheduler_purge() {
 	return DAY_IN_SECONDS;
}

/*
** Sales label
*/
if( !function_exists( 'swg_label_sales' ) ){
	function swg_label_sales(){
		global $product, $post;
		$product_type = ( swg_woocommerce_version_check( '3.0' ) ) ? $product->get_type() : $product->product_type;
		echo swg_label_new();
		if( $product_type != 'variable' ) {
			$forginal_price 	= get_post_meta( $post->ID, '_regular_price', true );	
			$fsale_price 		= get_post_meta( $post->ID, '_sale_price', true );
			if( $fsale_price > 0 && $product->is_on_sale() ){ 
				$sale_off = 100 - ( ( $fsale_price/$forginal_price ) * 100 ); 
				$html = '<div class="sale-off ' . esc_attr( ( swg_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
				$html .= esc_html__( 'sale', 'kontruk' );
				$html .= '</div>';
				echo apply_filters( 'swg_label_sales', $html );
			} 
		}else{
			echo '<div class="' . esc_attr( ( swg_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
			wc_get_template( 'single-product/sale-flash.php' );
			echo '</div>';
		}
	}	
}

if( !function_exists( 'swg_label_stock' ) ){
	function swg_label_stock(){
		global $product;
		if( kontruk_mobile_check() ) :
	?>
			<div class="product-info">
				<?php $stock = ( $product->is_in_stock() )? 'in-stock' : 'out-stock' ; ?>
				<div class="product-stock <?php echo esc_attr( $stock ); ?>">
					<span><?php echo sprintf( ( $product->is_in_stock() )? '%s' : esc_html__( 'Out stock', 'kontruk' ), esc_html__( 'in stock', 'kontruk' ) ); ?></span>
				</div>
			</div>

			<?php endif; } 
}

function kontruk_quickview(){
	global $product;
	$html='';
	if( function_exists( 'swg_options' ) ){
		$quickview = swg_options( 'product_quickview' );
	}
	if( $quickview ):
		$html = '<a href="javascript:void(0)" data-product_id="'. esc_attr( $product->get_id() ) .'" class="sw-quickview group fancybox" data-type="quickview" data-ajax_url="' . WC_AJAX::get_endpoint( "%%endpoint%%" ) . '">'. esc_html__( 'Quick View ', 'kontruk' ) .'</a>';	
	endif;
	return $html;
}

/*
** Minicart via Ajax
*/
add_filter('woocommerce_add_to_cart_fragments', 'kontruk_add_to_cart_fragment_style2', 100);
add_filter('woocommerce_add_to_cart_fragments', 'kontruk_add_to_cart_fragment', 100);
add_filter('woocommerce_add_to_cart_fragments', 'kontruk_add_to_cart_fragment_mobile', 100);


function kontruk_add_to_cart_fragment_style2( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-style2' );
	$fragments['.kontruk-minicart2'] = ob_get_clean();
	return $fragments;		
}
	
function kontruk_add_to_cart_fragment( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax' );
	$fragments['.kontruk-minicart'] = ob_get_clean();
	return $fragments;		
}

function kontruk_add_to_cart_fragment_mobile( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-mobile' );
	$fragments['.kontruk-minicart-mobile'] = ob_get_clean();
	return $fragments;		
}
	
/*
** Remove WooCommerce breadcrumb
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/*
** Add second thumbnail loop product
*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'kontruk_woocommerce_template_loop_product_thumbnail', 10 );

function kontruk_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post;
	$html = '';
	$gallery = get_post_meta($post->ID, '_product_image_gallery', true);
	$attachment_image = '';
	if( !empty( $gallery ) ) {
		$gallery 					= explode( ',', $gallery );
		$first_image_id 	= $gallery[0];
		$attachment_image = wp_get_attachment_image( $first_image_id , $size, false, array('class' => 'hover-image back') );
	}
	
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
	if ( has_post_thumbnail( $post->ID ) ){
		$html .= '<a href="'.get_permalink( $post->ID ).'">' ;
		$html .= (get_the_post_thumbnail( $post->ID, $size )) ? get_the_post_thumbnail( $post->ID, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="'. esc_attr__( 'Placeholder', 'kontruk' ) .'">';
		$html .= '</a>';
	}else{
		$html .= '<a href="'.get_permalink( $post->ID ).'">' ;
		$html .= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="'. esc_attr__( 'Placeholder', 'kontruk' ) .'">';		
		$html .= '</a>';
	}
	return $html;
}

function kontruk_woocommerce_template_loop_product_thumbnail(){
	echo kontruk_product_thumbnail();
}

/*
** Product Category Listing
*/
add_filter( 'subcategory_archive_thumbnail_size', 'kontruk_category_thumb_size' );
function kontruk_category_thumb_size(){
	return 'shop_thumbnail';
}

/*
** Filter order
*/
function kontruk_addURLParameter($url, $paramName, $paramValue) {
     $url_data = parse_url($url);
     if(!isset($url_data["query"]))
         $url_data["query"]="";

     $params = array();
     parse_str($url_data['query'], $params);
     $params[$paramName] = $paramValue;
     $url_data['query'] = http_build_query($params);
     return kontruk_build_url( $url_data );
}

/*
** Build url 
*/
function kontruk_build_url($url_data) {
 $url="";
 if(isset($url_data['host']))
 {
	 $url .= $url_data['scheme'] . '://';
	 if (isset($url_data['user'])) {
		 $url .= $url_data['user'];
			 if (isset($url_data['pass'])) {
				 $url .= ':' . $url_data['pass'];
			 }
		 $url .= '@';
	 }
	 $url .= $url_data['host'];
	 if (isset($url_data['port'])) {
		 $url .= ':' . $url_data['port'];
	 }
 }
 if (isset($url_data['path'])) {
	$url .= $url_data['path'];
 }
 if (isset($url_data['query'])) {
	 $url .= '?' . $url_data['query'];
 }
 if (isset($url_data['fragment'])) {
	 $url .= '#' . $url_data['fragment'];
 }
 return $url;
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_filter( 'kontruk_custom_category', 'woocommerce_maybe_show_product_subcategories' );
add_action( 'woocommerce_before_shop_loop_item_title', 'swg_label_sales', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'kontruk_template_loop_price', 15 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_before_shop_loop', 'kontruk_viewmode_wrapper_start', 5 );
add_action( 'woocommerce_before_shop_loop', 'kontruk_viewmode_wrapper_end', 50 );
add_action( 'woocommerce_before_shop_loop','kontruk_woommerce_view_mode_wrap',15 );

if( swg_options( 'product_loadmore' ) && !kontruk_mobile_check() ){
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 35 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination_ajax', 10 );
}else{
	add_action( 'woocommerce_after_shop_loop', 'kontruk_viewmode_wrapper_start', 5 );
	add_action( 'woocommerce_after_shop_loop', 'kontruk_viewmode_wrapper_end', 50 );
	remove_action( 'woocommerce_after_shop_loop', 'kontruk_woommerce_view_mode_wrap', 6 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 35 );
}

remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action('woocommerce_message','wc_print_notices', 10);
add_filter( 'woocommerce_pagination_args', 'kontruk_custom_pagination_args' );

function woocommerce_pagination_ajax(){
	global $wp_query;
	$loadmore_style = ( swg_options( 'product_loadmore_style' ) ) ? swg_options( 'product_loadmore_style' ) : 0;
	$option_number 	= ( swg_options( 'product_number' ) ) ? swg_options( 'product_number' ) : 12;
	$posts_per_page = isset( $_GET['product_count'] ) ? $_GET['product_count'] : $option_number;
	$sw_loadmore = array(
		'nonce' => wp_create_nonce( 'sw_ajax_load_more' ),
		'url'   => admin_url( 'admin-ajax.php' ),
		'query' => $wp_query->query,
		'posts_per_page' => $posts_per_page
	);
	wp_enqueue_script( 'sw_loadmore', get_template_directory_uri() . '/js/product-loadmore.js', array(), null, true );
	wp_localize_script( 'sw_loadmore', 'loadmore', $sw_loadmore );
?>
	<div class="pagination-ajax"><button class="button-ajax" data-loadmore_style="<?php echo esc_attr( $loadmore_style ); ?>" data-maxpage="<?php echo esc_attr( $wp_query->max_num_pages ) ?>" data-title="<?php echo esc_attr__( 'Show More Results', 'kontruk' ); ?>" data-loaded="<?php echo esc_attr__( 'All Item Loaded', 'kontruk' ); ?>"></button></div>
<?php 
}

/*
** Pagination Size to Show
*/
function kontruk_custom_pagination_args( $args = array() ){
	$args['end_size'] = 2;
	$args['mid_size'] = 1;
	return $args;	
}

function kontruk_viewmode_wrapper_start(){
	global $wp_query;
	if ( ! woocommerce_products_will_display() || $wp_query->is_search() ) {
		return;
	}
	echo '<div class="products-nav clearfix">';
}
function kontruk_viewmode_wrapper_end(){
	global $wp_query;
	if ( ! woocommerce_products_will_display() || $wp_query->is_search() ) {
		return;
	}
	echo '</div>';
}
function kontruk_woommerce_view_mode_wrap () {
	global $wp_query;

	if ( ! woocommerce_products_will_display() || $wp_query->is_search() ) {
		return;
	}
	
	$html = '<div class="view-mode-wrap pull-right clearfix">
				<div class="view-mode">
						<a href="javascript:void(0)" class="grid-view active" title="'. esc_attr__('Grid view', 'kontruk').'"><span>'. esc_html__('Grid view', 'kontruk').'</span></a>
						<a href="javascript:void(0)" class="list-view" title="'. esc_attr__('List view', 'kontruk') .'"><span>'.esc_html__('List view', 'kontruk').'</span></a>
				</div>	
			</div>';
	echo sprintf( '%s', $html );
}
add_action( 'viewed_products', 'kontruk_template_loop_price', 0 );
function kontruk_template_loop_price(){
	global $product;
	?>
	<?php if ( $price_html = $product->get_price_html() ) : ?>
		<span class="item-price"><span><?php echo sprintf( '%s', $price_html ); ?></span></span>
	<?php endif;
}


add_action('woocommerce_get_catalog_ordering_args', 'kontruk_woocommerce_get_catalog_ordering_args', 20);
function kontruk_woocommerce_get_catalog_ordering_args($args)
{
	global $woocommerce;

	$url 		= home_url( add_query_arg( null, null ) );
	$query_str  = parse_url( $url );
	$query 		= isset( $query_str['query'] ) ? $query_str['query'] : '';
	parse_str( $query, $params );
	$orderby_value = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$pob = $orderby_value;

	$po = !empty($params['product_order'])  ? $params['product_order'] : 'desc';
	
	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'desc';
		break;
	}
	$args['order'] = $order;

	if( $pob == 'rating' ) {
		$args['order']    = $po == 'desc' ? 'desc' : 'asc';
		$args['order']	  = strtoupper( $args['order'] );
	}

	return $args;
}

add_filter('loop_shop_per_page', 'kontruk_loop_shop_per_page');
function kontruk_loop_shop_per_page() {
	$url 		= home_url( add_query_arg( null, null ) );
	$query_str  = parse_url( $url );
	$query 		= isset( $query_str['query'] ) ? $query_str['query'] : '';
	parse_str( $query, $params );
	$option_number =  swg_options( 'product_number' );
	
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 12;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;
	return $pc;
}

/* =====================================================================================================
** Product loop content 
	 ===================================================================================================== */
	 
/*
** attribute for product listing
*/
function kontruk_product_attribute(){
	global $woocommerce_loop;
	
	$col_lg = swg_options( 'product_col_large' );
	$col_md = swg_options( 'product_col_medium' );
	$col_sm = swg_options( 'product_col_sm' );
	$class_col= "item ";
	
	if( isset( get_queried_object()->term_id ) ) :
		$term_col_lg  = get_term_meta( get_queried_object()->term_id, 'term_col_lg', true );
		$term_col_md  = get_term_meta( get_queried_object()->term_id, 'term_col_md', true );
		$term_col_sm  = get_term_meta( get_queried_object()->term_id, 'term_col_sm', true );

		$col_lg = ( intval( $term_col_lg ) > 0 ) ? $term_col_lg : swg_options( 'product_col_large' );
		$col_md = ( intval( $term_col_md ) > 0 ) ? $term_col_md : swg_options( 'product_col_medium' );
		$col_sm = ( intval( $term_col_sm ) > 0 ) ? $term_col_sm : swg_options( 'product_col_sm' );
	endif;
	
	$col_large 	= ( $col_lg ) ? $col_lg : 4;
	$col_medium = ( $col_md ) ? $col_md : 4;
	$col_small	= ( $col_sm ) ? $col_sm : 4;
	
	$column1 = str_replace( '.', '' , floatval( 12 / $col_large ) );
	$column2 = str_replace( '.', '' , floatval( 12 / $col_medium ) );
	$column3 = str_replace( '.', '' , floatval( 12 / $col_small ) );

	$class_col .= ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.' col-xs-6';
	
	return esc_attr( $class_col );
}

/*
** Check sidebar 
*/
function kontruk_sidebar_product(){
	$kontruk_sidebar_product = swg_options('sidebar_product');
	if( isset( get_queried_object()->term_id ) ){
		$kontruk_sidebar_product = ( get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) : swg_options('sidebar_product');
	}	
	if( is_singular( 'product' ) ) {
		$kontruk_sidebar_product = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : swg_options('sidebar_product_detail');
	}
	return $kontruk_sidebar_product;
}
	 
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'kontruk_category_title', 2 );
add_action( 'woocommerce_shop_loop_item_title', 'kontruk_loop_product_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'kontruk_product_description', 11 );
add_action( 'woocommerce_after_shop_loop_item', 'kontruk_product_addcart_start', 1 );
add_action( 'woocommerce_after_shop_loop_item', 'kontruk_product_addcart_mid', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'kontruk_product_addcart_end', 99 );
if( swg_options( 'product_listing_countdown' ) ){
	add_action( 'woocommerce_shop_loop_item_title', 'kontruk_product_deal', 5 );
}

function kontruk_loop_product_title(){
	?>
		<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php kontruk_trim_words( get_the_title() ); ?></a></h4>
	<?php
}

function kontruk_category_title(){
	global $product, $post;
	$terms_id = get_the_terms( $post->ID, 'product_cat' );
	$term_str = '';
	if( count( $terms_id ) ) :
		$term_str .= '<a href="'. get_term_link( $terms_id[0]->term_id, 'product_cat' ) .'">'. esc_html( $terms_id[0]->name ) .'</a>';
	endif;
	?>
		<div class="categories-name"><?php echo '<a href="'. get_term_link( $terms_id[0]->term_id, 'product_cat' ) .'">'. esc_html( $terms_id[0]->name ) .'</a>'; ?></div>	
	<?php
}

function kontruk_product_description(){
	global $post;
	if ( ! $post->post_excerpt ) return;	
	echo '<div class="item-description">'.wp_trim_words( $post->post_excerpt, 20 ).'</div>';
}

function kontruk_product_addcart_start(){
	echo '<div class="item-bottom">';
}

function kontruk_product_addcart_end(){
	echo '</div>';
}

function kontruk_product_addcart_mid(){
	global $product, $post;
	$quickview = swg_options( 'product_quickview' );
	
	$html = '';
	$product_id = $post->ID;
	$html .= kontruk_quickview();
	/* compare & wishlist */
	if( class_exists( 'YITH_WCWL' ) && !kontruk_mobile_check() ){
		$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}
	if( class_exists( 'YITH_WOOCOMPARE' ) && !kontruk_mobile_check() ){		
		$html .= '<a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'kontruk' ) .'</a>';	
	}
	echo sprintf( '%s', $html );
}

/*
** Add page deal to listing
*/
add_shortcode('kontruk_single_deal', 'kontruk_product_deal');
function kontruk_product_deal(){
	if( ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( 'product' ) ) || is_singular( 'product' ) ) {
		global $product;
		$start_time 	= get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
		$countdown_time = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );	
		
		if( !empty ($countdown_time ) && $countdown_time > $start_time ) :
?>
		<div class="product-countdown" data-date="<?php echo esc_attr( $countdown_time ); ?>" data-starttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo esc_attr( 'product_' . $product->get_id() ); ?>"></div>
<?php 
		endif;
	}
}

/*
** Filter product category class
*/
add_filter( 'product_cat_class', 'kontruk_product_category_class', 2 );
function kontruk_product_category_class( $classes, $category = null ){
	global $woocommerce_loop;
	
	$col_lg = ( swg_options( 'product_colcat_large' ) )  ? swg_options( 'product_colcat_large' ) : 1;
	$col_md = ( swg_options( 'product_colcat_medium' ) ) ? swg_options( 'product_colcat_medium' ) : 1;
	$col_sm = ( swg_options( 'product_colcat_sm' ) )	   ? swg_options( 'product_colcat_sm' ) : 1;
	
	
	$column1 = str_replace( '.', '' , floatval( 12 / $col_lg ) );
	$column2 = str_replace( '.', '' , floatval( 12 / $col_md ) );
	$column3 = str_replace( '.', '' , floatval( 12 / $col_sm ) );

	$classes[] = ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.' col-xs-6';
	
	return $classes;
}

/* ==========================================================================================
	** Single Product
   ========================================================================================== */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 1 );
add_action( 'woocommerce_single_product_summary', 'kontruk_get_brand', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'kontruk_woocommerce_single_price', 18 );
add_action( 'woocommerce_single_product_summary', 'kontruk_woocommerce_sharing', 50 );
add_action( 'woocommerce_before_single_product_summary', 'swg_label_sales', 10 );
add_action( 'woocommerce_before_single_product_summary', 'swg_label_stock', 11 );
if( swg_options( 'product_single_countdown' ) ){
	add_action( 'woocommerce_single_product_summary', 'kontruk_product_deal', 25 );
}
add_filter( 'woocommerce_get_stock_html', 'kontruk_custom_stock_filter' );
function kontruk_custom_stock_filter( $html ){
	return;
}

add_shortcode('kontruk_single_sharing', 'kontruk_woocommerce_sharing');
function kontruk_woocommerce_sharing(){
	global $product;
?>
	<div class="item-meta">
		<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'kontruk' ) . ' ', '</span>' ); ?>
		<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'kontruk' ) . ' ', '</span>' ); ?>
	</div>
<?php 

}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'kontruk_product_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'kontruk_product_stock', 40 );
function kontruk_woocommerce_single_price(){
	wc_get_template( 'single-product/price.php' );
}

function kontruk_product_excerpt(){
	global $post;
	
	if ( ! $post->post_excerpt ) {
		return;
	}
	$html = '';
	$html .= '<div class="description" itemprop="description">';
	$html .= apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	$html .= '</div>';
	echo sprintf( '%s', $html );
}

function kontruk_product_stock(){
	global $product;
	
	if( !kontruk_mobile_check() ) :?>
		<?php $stock = ( $product->is_in_stock() )? 'in-stock' : 'out-stock' ;?>
		<div class="product-info <?php echo esc_attr( $stock ); ?>">
			<?php if( $product->is_in_stock() ) :?>
				<span><i class="fa fa-check-circle-o" aria-hidden="true"></i><?php echo esc_html__( 'In stock', 'kontruk' ); ?></span>
				<div class="shipping-text"><?php echo esc_html__( ' & Ready to Ship', 'kontruk' ); ?></div>
			<?php else: ?>
				<div class="subscribe-form-out-stock">
					<h4><?php echo esc_html__('Email when stock available','kontruk');?></h4>
					<?php echo do_shortcode( '[mc4wp_form]' ); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif;
}

/**
* Get brand on the product single
**/
add_shortcode('kontruk_brand', 'kontruk_get_brand');
function kontruk_get_brand(){
	global $post, $product;
	$terms = wp_get_object_terms( $post->ID, 'product_brand' );?>
<?php	
	if( !isset( $terms->errors ) && $terms ){
?>
		<div class="item-brand">
			<span><?php echo esc_html__( 'Brand', 'kontruk' ) . ': '; ?></span>
			<?php 
				foreach( $terms as $key => $term ){
					$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_bid', true ) );
					if( $thumbnail_id && swg_options( 'product_brand' ) ){
			?>
				<a href="<?php echo get_term_link( $term->term_id, 'product_brand' ); ?>"><?php echo esc_html( $term->name ); ?></a>
				<?php echo( ( $key + 1 ) === count( $terms ) ) ? '' : ', '; ?>			
			<?php 
					}else{
			?>
				<a href="<?php echo get_term_link( $term->term_id, 'product_brand' ); ?>"><img src="<?php echo wp_get_attachment_thumb_url( $thumbnail_id ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" title="<?php echo esc_attr( $term->name ); ?>"/></a>		
			<?php 
					}					
				}
			?>
		</div>
<?php 
	}
	?>
	<div class="product_meta">
	<div class="quick"><?php esc_html_e( 'Quick info', 'kontruk' ); ?></div>
	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
	<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'kontruk' ); ?> <span class="sku" itemprop="sku"><?php echo sprintf( ( $sku = $product->get_sku() ) ? '%s' : esc_html__( 'N/A', 'kontruk' ), $sku ); ?></span></span>

	<?php endif; ?>
	</div>
<?php }


add_action( 'woocommerce_before_add_to_cart_button', 'kontruk_single_addcart_wrapper_start', 10 );
add_action( 'woocommerce_after_add_to_cart_button', 'kontruk_single_addcart_wrapper_end', 20 );
add_action( 'woocommerce_after_add_to_cart_button', 'kontruk_single_addcart', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

function kontruk_single_addcart_wrapper_start(){
	global $product;
	$class = ( swg_options( 'product_single_buynow' ) && !in_array( $product->get_type(), array( 'grouped', 'external' ) ) ) ? 'single-buynow' : '';
	echo '<div class="addcart-wrapper '. esc_attr( $class ) .' clearfix">';
	echo '<div class="qty">'.esc_html__( 'Quantity:','kontruk' ).'</div>';
}

function kontruk_single_addcart_wrapper_end(){
	echo "</div>";
}

function kontruk_single_addcart(){
	/* compare & wishlist */
	global $product, $post;
	$html = '';
	$product_id = $post->ID;
	$availability = $product->get_availability();

	if( swg_options( 'product_single_buynow' ) && $availability['class'] == 'in-stock' && !in_array( $product->get_type(), array( 'grouped', 'external' ) ) ){
		$args = array(
			'add-to-cart' => $product_id,
		);
		if( $product->get_type() == 'variable' ){
			$args['variation_id'] = '';
		}
		$html .= '<a class="button-buynow" href="'. add_query_arg( $args, get_permalink( get_option( 'woocommerce_checkout_page_id' ) ) ) .'" data-url="'. add_query_arg( $args, get_permalink( get_option( 'woocommerce_checkout_page_id' ) ) ) .'">'. esc_html__( 'Buy Now', 'kontruk' ) .'</a>';
		$html .= '<div class="clear"></div>';
	}

	/* compare & wishlist */
	if( ( class_exists( 'YITH_WCWL' ) || class_exists( 'YITH_WOOCOMPARE' ) ) && !kontruk_mobile_check() ){
		$html .= '<div class="item-bottom">';
		if( class_exists( 'YITH_WCWL' ) ) :
			$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		endif;
		$html .= '</div>';
	}

	echo sprintf( '%s', $html );
}

/* 
** Add Product Tag To Tabs 
*/
add_filter( 'woocommerce_product_tabs', 'kontruk_tab_tag' );
function kontruk_tab_tag($tabs){
	global $post;
	$tag_count = get_the_terms( $post->ID, 'product_tag' );
	if ( $tag_count ) {
		$tabs['product_tag'] = array(
			'title'    => esc_html__( 'Tags', 'kontruk' ),
			'priority' => 11,
			'callback' => 'kontruk_single_product_tab_tag'
		);
	}
	return $tabs;
}
function kontruk_single_product_tab_tag(){
	global $product;
	echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'kontruk' ) . ' ', '</span>' );
}

/*
**Hook into review for rick snippet
*/
add_action( 'woocommerce_review_before_comment_meta', 'kontruk_title_ricksnippet', 10 ) ;
function kontruk_title_ricksnippet(){
	global $post;
	echo '<span class="hidden" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
    <span itemprop="name">'. $post->post_title .'</span>
  </span>';
}

/*
** Cart cross sell
*/
add_action('woocommerce_cart_collaterals', 'kontruk_cart_collaterals_start', 1 );
add_action('woocommerce_cart_collaterals', 'kontruk_cart_collaterals_end', 11 );
function kontruk_cart_collaterals_start(){
	echo '<div class="products-wrapper">';
}

function kontruk_cart_collaterals_end(){
	echo '</div>';
}

/*
** Set default value for compare and wishlist 
*/
function kontruk_cpwl_init(){
	if( class_exists( 'YITH_WCWL' ) ){update_option( 'yith_wcwl_after_add_to_wishlist_behaviour', 'add' );
		update_option( 'yith_wcwl_button_position', 'shortcode' );
	}
	if( class_exists( 'YITH_WOOCOMPARE' ) ){
		update_option( 'yith_woocompare_compare_button_in_product_page', 'no' );
		update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
	}
}
add_action('admin_init','kontruk_cpwl_init');

/*
** Quickview product
*/
add_action( 'wc_ajax_kontruk_quickviewproduct', 'kontruk_quickviewproduct' );
add_action( 'wc_ajax_nopriv_kontruk_quickviewproduct', 'kontruk_quickviewproduct' );
function kontruk_quickviewproduct(){
	
	$productid = ( isset( $_REQUEST["product_id"] ) && $_REQUEST["product_id"] > 0 ) ? $_REQUEST["product_id"] : 0;
	$query_args = array(
		'post_type'	=> 'product',
		'p'	=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query( $query_args );
	
	if($r->have_posts()){ 
		while ( $r->have_posts() ){ $r->the_post(); setup_postdata( $r->post );
			global $product;
			ob_start();
			wc_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace( array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw );
	echo sprintf( '%s', $output );
	exit();
}

/*
** Custom Login ajax
*/
add_action('wp_ajax_kontruk_custom_login_user', 'kontruk_custom_login_user_callback' );
add_action('wp_ajax_nopriv_kontruk_custom_login_user', 'kontruk_custom_login_user_callback' );
function kontruk_custom_login_user_callback(){
	// First check the nonce, if it fails the function will break
	/* check_ajax_referer( 'woocommerce-login', 'security' ); */

	// Nonce is checked, get the POST data and sign user on
	$info = array();
	$info['user_login'] = $_POST['username'];
	$info['user_password'] = $_POST['password'];
	$info['remember'] = true;

	$user_signon = wp_signon( $info );
	if ( is_wp_error($user_signon) ){
		echo json_encode(array('loggedin'=>false, 'message'=> $user_signon->get_error_message()));
	} else {
		$redirect_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		$user 		  = get_user_by( 'login', $info['user_login'] );
		wp_set_current_user( $user->ID, $info['user_login'] ); // Log the user in - set Cookie and let the browser remember it                
		wp_set_auth_cookie( $user->ID, TRUE );
		$user_role 	  = ( is_array( $user->roles ) ) ? $user->roles : array() ;
		if( in_array( 'vendor', $user_role ) ){
			$vendor_option = get_option( 'wc_prd_vendor_options' );
			$vendor_page   = ( array_key_exists( 'vendor_dashboard_page', $vendor_option ) ) ? $vendor_option['vendor_dashboard_page'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		elseif( in_array( 'seller', $user_role ) ){
			$vendor_option = get_option( 'dokan_pages' );
			$vendor_page   = ( array_key_exists( 'dashboard', $vendor_option ) ) ? $vendor_option['dashboard'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		elseif( in_array( 'dc_vendor', $user_role ) ){
			$vendor_option = get_option( 'wcmp_vendor_general_settings_name' );
			$vendor_page   = ( array_key_exists( 'wcmp_vendor', $vendor_option ) ) ? $vendor_option['wcmp_vendor'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Login Successful, redirecting...', 'kontruk'), 'redirect' => esc_url( $redirect_url ) ));
	}

	die();
}

remove_action( 'template_redirect', 'wc_track_product_view', 20 );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'template_redirect', 'kontruk_custom_track_product_view', 20 );
remove_action( 'woocommerce_after_cart', 'kontruk_recent_viewed_cart_page' );
add_action( 'woocommerce_cart_is_empty_after', 'kontruk_recent_viewed_cart_page', 20 );

function kontruk_custom_track_product_view(){
	global $post;
	$postid = isset( $post->ID ) ? $post->ID : 0;
	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
		$viewed_products = array();
	} else {
		$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
	}

	// Unset if already in viewed products list.
	$keys = array_flip( $viewed_products );

	if ( isset( $keys[ $postid ] ) ) {
		unset( $viewed_products[ $keys[ $postid ] ] );
	}

	$viewed_products[] = $postid;

	if ( count( $viewed_products ) > 15 ) {
		array_shift( $viewed_products );
	}

	// Store for session only.
	wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}
function kontruk_recent_viewed_cart_page(){
	$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array(); // @codingStandardsIgnoreLine
	$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
	if ( empty( $viewed_products ) ) {
		return;
	}

	$query_args = array(
		'posts_per_page' => 8,
		'no_found_rows'  => 1,
		'post_status'    => 'publish',
		'post_type'      => 'product',
		'post__in'       => $viewed_products,
		'orderby'        => 'post__in',
	);

	if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'outofstock',
				'operator' => 'NOT IN',
			),
		); // WPCS: slow query ok.
	}

	$r = new WP_Query( apply_filters( 'woocommerce_recently_viewed_products_widget_query_args', $query_args ) );

	if ( $r->have_posts() ) {
?>
	<div class="sw-recent-viewed ">
		<div class="container recent-viewed-container">
			
			<div class="resp-slider-container">
			<ul class=" products-loop">
			<?php while($r->have_posts()): $r->the_post();global $product, $post; ?>
				<li class="item col-lg-6 col-md-6 col-sm-6" >
					<div class="products-entry item-wrap clearfix">
						<div class="item-detail">
							<div class="item-img products-thumb">
								<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>							
							</div>
							<div class="item-content products-content">
								<?php do_action( 'viewed_products' );?>
							</div>
						</div>
					</div>
				</li>
			<?php endwhile;  ?>
			</ul>
			</div>
		</div>
	</div>
<?php 
	}

	wp_reset_postdata();

}

/*
** Add Label New and SoldOut
*/
if( !function_exists( 'swg_label_new' ) ){
	function swg_label_new(){
		global $product;
		$html = '';
		$soldout = ( swg_options( 'product_soldout' ) ) ? swg_options( 'product_soldout' ) : 0;
		$newtime = ( get_post_meta( $product->get_id(), 'newproduct', true ) != '' && get_post_meta( $product->get_id(), 'newproduct', true ) ) ? get_post_meta( $product->get_id(), 'newproduct', true ) : swg_options( 'newproduct_time' );
		$product_date = get_the_date( 'Y-m-d', $product->get_id() );
		$newdate = strtotime( $product_date ) + intval( $newtime ) * 24 * 3600;
		if( ! $product->is_in_stock() && $soldout ) :
			$html .= '<span class="sw-outstock">'. esc_html__( 'Out Stock', 'kontruk' ) .'</span>';		
		else:
			if( $newtime != '' && $newdate > time() ) :
				$html .= '<span class="sw-newlabel">'. esc_html__( 'New', 'kontruk' ) .'</span>';			
			endif;
		endif;
		return apply_filters( 'swg_label_new', $html );
	}
}

/*
** Check for mobile layout
*/
if( kontruk_mobile_check() ){
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 35 );
	remove_action( 'woocommerce_after_shop_loop', 'kontruk_viewmode_wrapper_start', 5 );
	remove_action( 'woocommerce_after_shop_loop', 'kontruk_viewmode_wrapper_end', 50 );
	remove_action( 'woocommerce_after_shop_loop', 'kontruk_woocommerce_catalog_ordering', 7 );
	add_action( 'woocommerce_single_product_summary', 'kontruk_mobile_woocommerce_sharing', 5 );
}

function kontruk_mobile_woocommerce_sharing(){
	echo '<div class="item-meta-mobile">';
		if( class_exists( 'YITH_WCWL' ) ) :
			echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		endif;
	echo '</div>';
}

add_action( 'woocommerce_account_content', 'kontruk_mydashboard_mobile', 9 );
function kontruk_mydashboard_mobile(){
	$current_user = get_user_by( 'id', get_current_user_id() );
	if( kontruk_mobile_check() ) : ?>
	<p class="avatar-user">
		<?php
			 echo get_avatar( $current_user->ID, 155 );
		?>
	</p>
	<?php endif;
}
/**
 * Add custom sorting options (discount)
 */
 
function discount_get_catalog_ordering_args( $args ) {
  
  $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
  
	if ( '_discount_amount' == $orderby_value ) {
		$args['meta_key'] = '_discount_amount';
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'desc';
	}
 
    return $args;
}

/**
 * Add custom sorting options (best sale)
 */
 
function bestsaler_get_catalog_ordering_args( $args ) {
  
  $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'best-sale' == $orderby_value ) {
 
      	$args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'desc';
 
    }

    return $args;
}
 
add_filter( 'woocommerce_get_catalog_ordering_args', 'bestsaler_get_catalog_ordering_args' );

function bestsaler_catalog_orderby( $catalog_orderby_options ) {
	$catalog_orderby_options['best-sale'] = __( 'Best sale', 'kontruk' );
 
	return $catalog_orderby_options;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'bestsaler_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'bestsaler_catalog_orderby' );
 
/**
 * Add custom sorting options (most viewed)
 */
 
function mostviewd_get_catalog_ordering_args( $args ) {
  
  $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'most-viewed' == $orderby_value ) {
 
      	$args['meta_key'] = 'post_views_count';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'desc';
 
    }
 
    return $args;
}
 
add_filter( 'woocommerce_get_catalog_ordering_args', 'mostviewd_get_catalog_ordering_args' );

function mostviewd_catalog_orderby( $catalog_orderby_options ) {
	$catalog_orderby_options['most-viewed'] = __( 'Most viewed', 'kontruk' );
 
	return $catalog_orderby_options;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'mostviewd_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'mostviewd_catalog_orderby' );

add_action( 'wp_ajax_sw_product_ajax_load_more', 'sw_product_ajax_load_more_callback' );
add_action( 'wp_ajax_nopriv_sw_product_ajax_load_more', 'sw_product_ajax_load_more_callback' );
function sw_product_ajax_load_more_callback(){ 
	$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'product';
	$args['post_status'] = 'publish';
	$args['posts_per_page'] = isset( $_POST['posts_per_page'] ) ? $_POST['posts_per_page'] : 12;
	$args['offset'] = $args['posts_per_page'] * ( $_POST['page'] - 1 );
	$category = isset( $args['product_cat'] ) ? $args['product_cat'] : '';
	if( $category != '' ) :
		$args['tax_query'] = array(
			'taxonomy'	=> 'product_cat',
			'field'     => 'slug',
			'terms'     => $category
		);
	endif; 
	ob_start();
	
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
		if( kontruk_mobile_check() ) {
			get_template_part( 'mlayouts/content', 'grid' );
		}else{
			 wc_get_template( 'content-product.php' );
		}	
	endwhile; endif; wp_reset_postdata();
	$data = ob_get_clean();
	wp_send_json_success( $data );
	exit;
}

?>