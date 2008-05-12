<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Dashboard widget
*/

// All this hacked from GamerZ's sample dashboard widget. Thanks!

// Register Dashboard Widget
function wp_ozh_cl_register_dashboard_widget() {
	wp_register_sidebar_widget(
		'dashboard_wp_ozh_cl', 'Color + Design Blog by COLOURlovers', 'dashboard_wp_ozh_cl',
		array(
		'all_link' => 'http://www.colourlovers.com/blog/',
		'width' => 'half', // OR 'fourth', 'third', 'half', 'full' (Default: 'half')
		'height' => 'single', // OR 'single', 'double' (Default: 'single')
		)
	);
}

// Add Dashboard Widget
function wp_ozh_cl_add_dashboard_widget($widgets) {
	global $wp_registered_widgets;
	if (!isset($wp_registered_widgets['dashboard_wp_ozh_cl'])) {
		return $widgets;
	}
	array_splice($widgets, sizeof($widgets)-1, 0, 'dashboard_wp_ozh_cl');
	return $widgets;
}

// Print Dashboard Widget
function dashboard_wp_ozh_cl($sidebar_args) {
	extract($sidebar_args, EXTR_SKIP);
	echo $before_widget;
	echo $before_title;
	echo $widget_name;
	echo $after_title;
	//echo 'YOUR CONTENT GOES IN HERE';
	wp_widget_rss_output(
	array('link'=>'http://www.colourlovers.com/blog/', 'url'=>'http://www.colourlovers.com/blog/feed/',
		'title'=>'Color + Design Blog by COLOURlovers', 'items'=>8, 'show_summary'=>0, 'show_date'=>1)
	);
	echo $after_widget;
}

// Array ( [link] => http://wordpress.org/development/ [url] => http://wordpress.org/development/feed/ [title] => WordPress Development Blog [items] => 2 [show_summary] => 1 [show_author] => 0 [show_date] => 1 )

add_action('wp_dashboard_setup', 'wp_ozh_cl_register_dashboard_widget');
add_filter('wp_dashboard_widgets', 'wp_ozh_cl_add_dashboard_widget');

?>