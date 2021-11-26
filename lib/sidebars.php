<?php 
/*
** Register Sidebar and Widgets
*/
function kontruk_widgets_init() {
	
	// Sidebars
	global $kontruk_widget_areas;
	$kontruk_widget_areas = kontruk_widget_setup_args();
	if ( count($kontruk_widget_areas) ){
		foreach( $kontruk_widget_areas as $sidebar ){
			$sidebar_params = apply_filters('kontruk_sidebar_params', $sidebar);
			register_sidebar($sidebar_params);
		}
	}
}
add_action('widgets_init', 'kontruk_widgets_init');