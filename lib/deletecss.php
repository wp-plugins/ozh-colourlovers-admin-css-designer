<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
File that saves reusable & standalone CSS 
*/

if (!defined('ABSPATH')) require_once('../../../../wp-config.php');
global $wp_ozh_cl;
if (!current_user_can('read')) die('Error. Not enough privileges!');
if (!$wp_ozh_cl['plugin_url']) die('Error. You cannot do this');

if (!isset($_POST['css']))
	die('Error. No CSS specified.');

$css = preg_replace('/[^0123456789_]/', '', $_POST['css']);
unlink($wp_ozh_cl['plugin_path']."/savedcss/$css.css");
unlink($wp_ozh_cl['plugin_path']."/savedcss/$css.desc");
die('ok');

?>