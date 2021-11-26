<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', get_template_directory() . '/lib/' ) );

if( !defined('KONTRUK_DIR') ){
	define( 'KONTRUK_DIR', $lib_dir );
}

if( !defined('KONTRUK_URL') ){
	define( 'KONTRUK_URL', trailingslashit( get_template_directory_uri() ) . 'lib' );
}

if (!isset($content_width)) { $content_width = 940; }

define("KONTRUK_PRODUCT_TYPE","product");
define("KONTRUK_PRODUCT_DETAIL_TYPE","product_detail");

if ( !defined('SWG_THEME') ){
	define( 'SWG_THEME', 'kontruk_theme' );
}

require_once( get_template_directory().'/lib/options.php' );

if( class_exists( 'SWG_Options' ) ) :
	function kontruk_Options_Setup(){
		global $swg_options, $options, $options_args;

		$options = array();
		$options[] = array(
			'title' => esc_html__('General', 'kontruk'),
			'desc' => wp_kses( __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Upload new logo and favicon or get their URL.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it kontruk for default.
			'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a kontruk section, no options just some intro text set above.
			'fields' => array(	

				array(
					'id' => 'sitelogo',
					'type' => 'upload',
					'title' => esc_html__('Logo Image', 'kontruk'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new logo and get URL of the logo', 'kontruk' ),
					'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),

				array(
					'id' => 'favicon',
					'type' => 'upload',
					'title' => esc_html__('Favicon', 'kontruk'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the custom favicon', 'kontruk' ),
					'std' => ''
				),

				array(
					'id' => 'tax_select',
					'type' => 'multi_select_taxonomy',
					'title' => esc_html__('Select Taxonomy', 'kontruk'),
					'sub_desc' => esc_html__( 'Select taxonomy to show custom term metabox', 'kontruk' ),
				),

				array(
					'id' => 'title_length',
					'type' => 'text',
					'title' => esc_html__('Title Length Of Item Listing Page', 'kontruk'),
					'sub_desc' => esc_html__( 'Choose title length if you want to trim word, leave 0 to not trim word', 'kontruk' ),
					'std' => 0
				),

				array(
					'id' => 'page_404',
					'type' => 'pages_select',
					'title' => esc_html__('404 Page Content', 'kontruk'),
					'sub_desc' => esc_html__('Select page 404 content', 'kontruk'),
					'std' => ''
				),

				array(
					'id' => 'bg_breadcrumb',
					'type' => 'upload',
					'title' => esc_html__('Breadcrumb Background', 'kontruk'),
					'sub_desc' => esc_html__( 'Use upload button to upload custom background for breadcrumb.', 'kontruk' ),
					'std' => ''
				),
				
			)
		);

		$options[] = array(
			'title' => esc_html__('Schemes', 'kontruk'),
			'desc' => wp_kses( __('<p class="description">Custom color scheme for theme. Unlimited color that you can choose.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it kontruk for default.
			'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a kontruk section, no options just some intro text set above.
			'fields' => array(
				array(
					'id' => 'scheme',
					'type' => 'radio_img',
					'title' => esc_html__('Color Scheme', 'kontruk'),
					'sub_desc' => esc_html__( 'Select one of 2 predefined schemes', 'kontruk' ),
					'desc' => '',
					'options' => array(
						'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
						'black' => array('title' => 'Black', 'img' => get_template_directory_uri().'/assets/img/black.png'),
						'yellow' => array('title' => 'Yellow', 'img' => get_template_directory_uri().'/assets/img/yellow.png'),
						'yellow2' => array('title' => 'Yellow2', 'img' => get_template_directory_uri().'/assets/img/yellow2.png'),
						), //Must provide key => value(array:title|img) pairs for radio options
					'std' => 'default'
				),
				
				array(
					'id' => 'custom_color',
					'title' => esc_html__( 'Enable Custom Color', 'kontruk' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this field to enable custom color and when you update your theme, custom color will not lose.', 'kontruk' ),
					'desc' => '',
					'std' => '0'
				),

				array(
					'id' => 'developer_mode',
					'title' => esc_html__( 'Developer Mode', 'kontruk' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off compile less to css and custom color', 'kontruk' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'scheme_color',
					'type' => 'color',
					'title' => esc_html__('Color', 'kontruk'),
					'sub_desc' => esc_html__('Select main custom color.', 'kontruk'),
					'std' => ''
				),

			)
		);

		$options[] = array(
			'title' => esc_html__('Layout', 'kontruk'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it kontruk for default.
			'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a kontruk section, no options just some intro text set above.
			'fields' => array(
				array(
					'id' => 'layout',
					'type' => 'select',
					'title' => esc_html__('Box Layout', 'kontruk'),
					'sub_desc' => esc_html__( 'Select Layout Box or Wide, Sidebar', 'kontruk' ),
					'options' => array(
						'full' => esc_html__( 'Wide', 'kontruk' ),
						'boxed' => esc_html__( 'Boxed', 'kontruk' ),
					),
					'std' => 'full'
				),
				
				array(
					'id' => 'sidebar_left_expand',
					'type' => 'select',
					'title' => esc_html__('Left Sidebar Expand', 'kontruk'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12', 
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '3',
					'sub_desc' => esc_html__( 'Select width of left sidebar.', 'kontruk' ),
				),

				array(
					'id' => 'sidebar_right_expand',
					'type' => 'select',
					'title' => esc_html__('Right Sidebar Expand', 'kontruk'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '3',
					'sub_desc' => esc_html__( 'Select width of right sidebar medium desktop.', 'kontruk' ),
				),
				array(
					'id' => 'sidebar_left_expand_md',
					'type' => 'select',
					'title' => esc_html__('Left Sidebar Medium Desktop Expand', 'kontruk'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of left sidebar medium desktop.', 'kontruk' ),
				),
				array(
					'id' => 'sidebar_right_expand_md',
					'type' => 'select',
					'title' => esc_html__('Right Sidebar Medium Desktop Expand', 'kontruk'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of right sidebar.', 'kontruk' ),
				),
				array(
					'id' => 'sidebar_left_expand_sm',
					'type' => 'select',
					'title' => esc_html__('Left Sidebar Tablet Expand', 'kontruk'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of left sidebar tablet.', 'kontruk' ),
				),
				array(
					'id' => 'sidebar_right_expand_sm',
					'type' => 'select',
					'title' => esc_html__('Right Sidebar Tablet Expand', 'kontruk'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of right sidebar tablet.', 'kontruk' ),
				),				
			)
		);

$options[] = array(
	'title' => esc_html__('Header', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a header and footer setting that allows you to build style header.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it kontruk for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a kontruk section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'header_style',
			'type' => 'select',
			'title' => esc_html__('Header Style', 'kontruk'),
			'sub_desc' => esc_html__('Select Header style', 'kontruk'),
			'options' => array(
				'style1'  => esc_html__( 'Header Style 1', 'kontruk' ),
			),
			'std' => 'style1'
		),

		array(
			'id' => 'disable_search',
			'title' => esc_html__( 'Disable Search', 'kontruk' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Check this to disable search on header', 'kontruk' ),
			'desc' => '',
			'std' => '0'
		),

		array(
			'id' => 'disable_boxsidebar',
			'title' => esc_html__( 'Disable Box Sdebar On Pages', 'kontruk' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Check this to disable box sidebar on pages', 'kontruk' ),
			'desc' => '',
			'std' => '0'
		),

	)
);
$options[] = array(
	'title' => esc_html__('Navbar Options', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it kontruk for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a kontruk section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'info_typon1',
			'type' => 'info',
			'title' => esc_html__( 'Navbar Menu General Config', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

		array(
			'id' => 'menu_type',
			'type' => 'select',
			'title' => esc_html__('Menu Type', 'kontruk'),
			'options' => array( 
				'dropdown' => esc_html__( 'Dropdown Menu', 'kontruk' ), 
				'mega' => esc_html__( 'Mega Menu', 'kontruk' ) 
			),
			'std' => 'mega'
		),	

		array(
			'id' => 'menu_location',
			'type' => 'menu_location_multi_select',
			'title' => esc_html__('Mega Menu Location', 'kontruk'),
			'sub_desc' => esc_html__( 'Select theme location to active mega menu.', 'kontruk' ),
			'std' => 'primary_menu'
		),		

		array(
			'id' => 'more_menu',
			'type' => 'checkbox',
			'title' => esc_html__('Active More Menu', 'kontruk'),
			'sub_desc' => esc_html__('Active more menu if your primary menu is too long', 'kontruk'),
			'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),

		array(
			'id' => 'menu_event',
			'type' => 'select',
			'title' => esc_html__('Menu Event', 'kontruk'),
			'options' => array( 
				'' 		=> esc_html__( 'Hover Event', 'kontruk' ), 
				'click' => esc_html__( 'Click Event', 'kontruk' ) 
			),
			'std' => ''
		),

		array(
			'id' => 'menu_number_item',
			'type' => 'text',
			'title' => esc_html__( 'Number Item Vertical', 'kontruk' ),
			'sub_desc' => esc_html__( 'Number item vertical to show', 'kontruk' ),
			'std' => 8
		),	

		array(
			'id' => 'menu_title_text',
			'type' => 'text',
			'title' => esc_html__('Vertical Title Text', 'kontruk'),
			'sub_desc' => esc_html__( 'Change title text on vertical menu', 'kontruk' ),
			'std' => ''
		),

		array(
			'id' => 'menu_more_text',
			'type' => 'text',
			'title' => esc_html__('Vertical More Text', 'kontruk'),
			'sub_desc' => esc_html__( 'Change more text on vertical menu', 'kontruk' ),
			'std' => ''
		),
		
		array(
			'id' => 'menu_less_text',
			'type' => 'text',
			'title' => esc_html__('Vertical Less Text', 'kontruk'),
			'sub_desc' => esc_html__( 'Change less text on vertical menu', 'kontruk' ),
			'std' => ''
		),


	)
);
$options[] = array(
	'title' => esc_html__('Blog Options', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">Select layout in blog listing page.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it kontruk for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_071_book.png',
		//Lets leave this as a kontruk section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'sidebar_blog',
			'type' => 'select',
			'title' => esc_html__('Sidebar Blog Layout', 'kontruk'),
			'options' => array(
				'full' 	=> esc_html__( 'Full Layout', 'kontruk' ),		
				'left'	=> esc_html__( 'Left Sidebar', 'kontruk' ),
				'right' => esc_html__( 'Right Sidebar', 'kontruk' ),
			),
			'std' => 'left',
			'sub_desc' => esc_html__( 'Select style sidebar blog', 'kontruk' ),
		),
		array(
			'id' => 'blog_layout',
			'type' => 'select',
			'title' => esc_html__('Layout blog', 'kontruk'),
			'options' => array(
				'list'	=>  esc_html__( 'List Layout', 'kontruk' ),
				'list2'	=>  esc_html__( 'List Layout2', 'kontruk' ),
				'grid' 	=>  esc_html__( 'Grid Layout', 'kontruk' )								
			),
			'std' => 'list',
			'sub_desc' => esc_html__( 'Select style layout blog', 'kontruk' ),
		),
		array(
			'id' => 'blog_column',
			'type' => 'select',
			'title' => esc_html__('Blog column', 'kontruk'),
			'options' => array(								
				'2' =>  esc_html__( '2 Columns', 'kontruk' ),
				'3' =>  esc_html__( '3 Columns', 'kontruk' ),
				'4' =>  esc_html__( '4 Columns', 'kontruk' )								
			),
			'std' => '2',
			'sub_desc' => esc_html__( 'Select style number column blog', 'kontruk' ),
		),
	)
);	
$options[] = array(
	'title' => esc_html__('Project Options', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">Select layout in project listing page.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it kontruk for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_033_luggage.png',
		//Lets leave this as a kontruk section, no options just some intro text set above.
	'fields' => array(
		
		array(
			'id' => 'project_single_style',
			'type' => 'select',
			'title' => esc_html__('Project Detail Style', 'kontruk'),
			'options' => array(
				'default'	=> esc_html__( 'Default', 'kontruk' ),
				'style1' 	=> esc_html__( 'Masonry', 'kontruk' ),		
			),
			'std' => 'default',
			'sub_desc' => esc_html__( 'Select style for project single', 'kontruk' ),
		),

	)
);
$options[] = array(
	'title' => esc_html__('Product Options', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">Select layout in product listing page.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it kontruk for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_202_shopping_cart.png',
		//Lets leave this as a kontruk section, no options just some intro text set above.
	'fields' => array(
		
		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Product General Config', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

				
		array(
			'id' => 'layout_product',
			'title' => esc_html__( 'Select Layout List/Grid For Product Listing', 'kontruk' ),
			'type' => 'select',
			'sub_desc' => '',
			'options' => array(
				'' 			=> esc_html__( 'Default', 'kontruk' ),
				'list' 	=> esc_html__( 'Layout List', 'kontruk' ),
				'grid' 	=> esc_html__( 'Layout Grid', 'kontruk' ),
				),
			'std' => '',
			),
		

		array(
			'id' => 'product_col_large',
			'type' => 'select',
			'title' => esc_html__('Product Listing column Desktop', 'kontruk'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',							
			),
			'std' => '3',
			'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'kontruk' ),
		),

		array(
			'id' => 'product_col_medium',
			'type' => 'select',
			'title' => esc_html__('Product Listing column Medium Desktop', 'kontruk'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',	
				'5' => '5',
				'6' => '6',
			),
			'std' => '2',
			'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'kontruk' ),
		),

		array(
			'id' => 'product_col_sm',
			'type' => 'select',
			'title' => esc_html__('Product Listing column Tablet', 'kontruk'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',	
				'5' => '5',
				'6' => '6'
			),
			'std' => '2',
			'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'kontruk' ),
		),

		array(
			'id' => 'sidebar_product',
			'type' => 'select',
			'title' => esc_html__('Sidebar Product Layout', 'kontruk'),
			'options' => array(
				''		=> esc_html__( 'Select Layout', 'kontruk' ),
				'left'	=> esc_html__( 'Left Sidebar', 'kontruk' ),
				'full' 	=> esc_html__( 'Full Layout', 'kontruk' ),		
				'right' => esc_html__( 'Right Sidebar', 'kontruk' )
			),
			'std' => 'left',
			'sub_desc' => esc_html__( 'Select style sidebar product', 'kontruk' ),
		),

		array(
			'id' => 'product_quickview',
			'title' => esc_html__( 'Quickview', 'kontruk' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => esc_html__( 'Turn On/Off Product Quickview', 'kontruk' ),
			'std' => '1'
		),

		array(
			'id' => 'product_number',
			'type' => 'text',
			'title' => esc_html__('Product Listing Number', 'kontruk'),
			'sub_desc' => esc_html__( 'Show number of product in listing product page.', 'kontruk' ),
			'std' => 12
		),

		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Product Single Config', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

		array(
			'id' => 'product_zoom',
			'title' => esc_html__( 'Product Zoom', 'kontruk' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => esc_html__( 'Turn On/Off image zoom when hover on single product', 'kontruk' ),
			'std' => '1'
		),
		
		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Config For Product Categories Widget', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

		array(
			'id' => 'product_number_item',
			'type' => 'text',
			'title' => esc_html__( 'Category Number Item Show', 'kontruk' ),
			'sub_desc' => esc_html__( 'Choose to number of item category that you want to show, leave 0 to show all category', 'kontruk' ),
			'std' => 8
		),	

		array(
			'id' => 'product_more_text',
			'type' => 'text',
			'title' => esc_html__( 'Category More Text', 'kontruk' ),
			'sub_desc' => esc_html__( 'Change more text on category product', 'kontruk' ),
			'std' => ''
		),

		array(
			'id' => 'product_less_text',
			'type' => 'text',
			'title' => esc_html__( 'Category Less Text', 'kontruk' ),
			'sub_desc' => esc_html__( 'Change less text on category product', 'kontruk' ),
			'std' => ''
		)	
	)
);
$options[] = array(
	'title' => esc_html__('Typography', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it kontruk for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a kontruk section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Global Typography', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

		array(
			'id' => 'google_webfonts',
			'type' => 'google_webfonts',
			'title' => esc_html__('Use Google Webfont', 'kontruk'),
			'sub_desc' => esc_html__( 'Insert font style that you actually need on your webpage.', 'kontruk' ), 
			'std' => ''
		),

		array(
			'id' => 'webfonts_weight',
			'type' => 'multi_select',
			'sub_desc' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'kontruk' ),
			'title' => esc_html__('Webfont Weight', 'kontruk'),
			'options' => array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900'
			),
			'std' => ''
		),

		array(
			'id' => 'info_typo2',
			'type' => 'info',
			'title' => esc_html__( 'Header Tag Typography', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

		array(
			'id' => 'header_tag_font',
			'type' => 'google_webfonts',
			'title' => esc_html__('Header Tag Font', 'kontruk'),
			'sub_desc' => esc_html__( 'Select custom font for header tag ( h1...h6 )', 'kontruk' ), 
			'std' => ''
		),

		array(
			'id' => 'info_typo2',
			'type' => 'info',
			'title' => esc_html__( 'Main Menu Typography', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

		array(
			'id' => 'menu_font',
			'type' => 'google_webfonts',
			'title' => esc_html__('Main Menu Font', 'kontruk'),
			'sub_desc' => esc_html__( 'Select custom font for main menu', 'kontruk' ), 
			'std' => ''
		),

		array(
			'id' => 'info_typo2',
			'type' => 'info',
			'title' => esc_html__( 'Custom Typography', 'kontruk' ),
			'desc' => '',
			'class' => 'kontruk-opt-info'
		),

		array(
			'id' => 'custom_font',
			'type' => 'google_webfonts',
			'title' => esc_html__('Custom Font', 'kontruk'),
			'sub_desc' => esc_html__( 'Select custom font for custom class', 'kontruk' ), 
			'std' => ''
		),

		array(
			'id' => 'custom_font_class',
			'title' => esc_html__( 'Custom Font Class', 'kontruk' ),
			'type' => 'text',
			'sub_desc' => esc_html__( 'Put custom class to this field. Each class separated by commas.', 'kontruk' ),
			'desc' => '',
			'std' => '',
		),

	)
);

$options[] = array(
	'title' => __('Social', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">This feature allow to you link to your social.</p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_222_share.png',
		//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'social-share-fb',
			'title' => esc_html__( 'Facebook', 'kontruk' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-tw',
			'title' => esc_html__( 'Twitter', 'kontruk' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-tumblr',
			'title' => esc_html__( 'Tumblr', 'kontruk' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-in',
			'title' => esc_html__( 'Linkedin', 'kontruk' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-instagram',
			'title' => esc_html__( 'Instagram', 'kontruk' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-pi',
			'title' => esc_html__( 'Pinterest', 'kontruk' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		)

	)
);

$options[] = array(
	'title' => esc_html__('Advanced', 'kontruk'),
	'desc' => wp_kses( __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'kontruk'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it kontruk for default.
	'icon' => KONTRUK_URL.'/admin/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a kontruk section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'show_cpanel',
			'title' => esc_html__( 'Show cPanel', 'kontruk' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn on/off Cpanel', 'kontruk' ),
			'desc' => '',
			'std' => ''
		),

		array(
			'id' => 'widget-advanced',
			'title' => esc_html__('Widget Advanced', 'kontruk'),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn on/off Widget Advanced', 'kontruk' ),
			'desc' => '',
			'std' => '1'
		),					

		array(
			'id' => 'social_share',
			'title' => esc_html__( 'Social Share', 'kontruk' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn on/off social share', 'kontruk' ),
			'desc' => '',
			'std' => '1'
		),

		array(
			'id' => 'breadcrumb_active',
			'title' => esc_html__( 'Turn Off Breadcrumb', 'kontruk' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn off breadcumb on all page', 'kontruk' ),
			'desc' => '',
			'std' => '0'
		),

		array(
			'id' => 'back_active',
			'type' => 'checkbox',
			'title' => esc_html__('Back to top', 'kontruk'),
			'sub_desc' => '',
			'desc' => '',
						'std' => '1'// 1 = on | 0 = off
			),

		array(
			'id' => 'preloader',
			'type' => 'checkbox',
			'title' => esc_html__('Preloader', 'kontruk'),
			'sub_desc' => '',
			'desc' => '',
			'std' => '0'// 1 = on | 0 = off
		),

	)
);

$options_args = array();

	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$options_args['opt_name'] = SWG_THEME;

	//Custom menu title for options page - default is "Options"
$options_args['menu_title'] = esc_html__('Theme Options', 'kontruk');

	//Custom Page Title for options page - default is "Options"
$options_args['page_title'] = esc_html__('Kontruk Options ', 'kontruk');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "kontruk_theme_options"
$options_args['page_slug'] = 'kontruk_theme_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
$options_args['page_type'] = 'submenu';

	//custom page location - default 100 - must be unique or will override other items
$options_args['page_position'] = 27;
$swg_options = new SWG_Options( $options, $options_args );

return $options;
}
add_action( 'init', 'kontruk_Options_Setup', 0 );
endif; 


/*
** Define widget
*/
function kontruk_widget_setup_args(){
	$kontruk_widget_areas = array(
		
		array(
			'name' => esc_html__('Sidebar Left Blog', 'kontruk'),
			'id'   => 'left-blog',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		array(
			'name' => esc_html__('Sidebar Right Blog', 'kontruk'),
			'id'   => 'right-blog',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),

		array(
			'name' => esc_html__('Header Top', 'kontruk'),
			'id'   => 'top',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),

		array(
			'name' => esc_html__('Header Mid', 'kontruk'),
			'id'   => 'mid',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),

		array(
			'name' => esc_html__('Sidebar Single Service', 'kontruk'),
			'id'   => 'left-service',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),

		array(
			'name' => esc_html__('Sidebar Above Product', 'kontruk'),
			'id'   => 'above-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Sidebar Left Product', 'kontruk'),
			'id'   => 'left-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Sidebar Right Product', 'kontruk'),
			'id'   => 'right-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Sidebar Bottom Detail Product', 'kontruk'),
			'id'   => 'bottom-detail-product',
			'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
		array(
			'name' => esc_html__('Widget Search', 'kontruk'),
			'id'   => 'search',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),

	);
return apply_filters( 'kontruk_widget_register', $kontruk_widget_areas );
}