<?php
/*
Plugin Name: Ozh & &hearts;COLOURlovers Admin CSS Designer
Plugin URI: http://planetozh.com/blog/my-projects/admin-css-designer-tool-colourlover-wordpress-plugin/
Description: Pull colorful palettes from <a href="http://www.colourlovers.com/">COLOURlovers</a> and make your own Admin Color Scheme. Edit, tweak and save real time! Check the <a href="options-general.php?page=ozh_colourlovers">Options</a> then head to your <a href="profile.php">Profile</a> to start playing.
Author: Ozh
Version: 1.0.1
Author URI: http://planetozh.com/
*/


// Minimal stuff so nothing is loaded in memory if not needed. Your readers and your webserver will thank you :)

global $wp_ozh_cl;
$wp_ozh_cl['plugin_url'] = get_option( 'siteurl' ) . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
$wp_ozh_cl['plugin_path'] = str_replace('\\','/',dirname(__FILE__));

if (is_admin()) {
	require_once($wp_ozh_cl['plugin_path'].'/wp/wp_core.php');
}
	
?>