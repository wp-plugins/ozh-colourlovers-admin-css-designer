<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
File that saves reusable & standalone CSS 
*/

if (!defined('ABSPATH')) require_once('../../../../wp-config.php');
global $wp_ozh_cl;
if (!current_user_can('read')) die('Not enough privileges!');
if (!$wp_ozh_cl['plugin_url']) die('You cannot do this');

if (!isset($_POST['colors']))
	die('No CSS saved');

$colors = unserialize(str_replace('\\"','"',$_POST['colors']));
$infos = unserialize(utf8_decode(str_replace('\\"','"',$_POST['infos'])));
$dobg = $_POST['dobg'];

// Paths
$path = '..';
$wpadmin = '../../../../wp-admin';

// Colors:
$rcol1 = strtoupper(array_shift($colors)); // TODO: sanitize to make sure it's #123ABC ?
$rcol2 = strtoupper(array_shift($colors));
$rcol3 = strtoupper(array_shift($colors));
$rcol4 = strtoupper(array_shift($colors));
$rcol5 = strtoupper(array_shift($colors));
if ($dobg === true or $dobg === 'true') {
	$dobg_bg = "$rcol4; /* rcol4 */";
	$dobg_color = "$rcol1; /* rcol1 */";
} else {
	$dobg_bg = '#fff;';
	$dobg_color = '#333;';
}

// Palette infos:
$pal['title'] = ($_POST['title']);
$pal['colors'] = "$rcol1,$rcol2,$rcol3,$rcol4,$rcol5";
$pal['author'] = ($_POST['author']);
$pal['desc'] = ($_POST['desc']);
$pal['url'] = ($_POST['url']);
$pal['id'] = explode('/',str_replace('http://www.colourlovers.com/palette/', '',$pal['url']));
$pal['id']  = intval($pal['id'][0]); // palette id


// We're ready to save stuff.

// Save palette info
$file = dirname(dirname(__FILE__)).'/savedcss/'.$pal['id'].'.desc';
$content = '';
foreach ($pal as $k=>$v) {
	$content .= "$k:$v\n";
}
$nfofile = wp_ozh_cl_writeCSS($file,$content);
if ($nfofile == false)
	die('Failed: Could not save palette infos');


// Save CSS
ob_start();
include(dirname(dirname(__FILE__)).'/css/template.css.php');
$content = ob_get_contents();
ob_end_clean();
$file = dirname(dirname(__FILE__)).'/savedcss/'.$pal['id'].'.css';
$cssfile = wp_ozh_cl_writeCSS($file,$content);
if ($cssfile == false)
	die('Failed: Could not save CSS file');

// Last check: CSS and NFO filenames must match
if ( preg_replace('/desc$/', 'css', $nfofile) != $cssfile) {
	@unlink($nfofile);
	@unlink($cssfile);
	die('Something went wrong. Please try again.');
}

// Still here ? Fine:
die('CSS saved! You will now be able to load it via your <a href="profile.php">Profile</a> page');

/***********/
	
// Write CSS .css & .desc
function wp_ozh_cl_writeCSS($file, $content) {
	// dont overwrite
	if (file_exists($file)) {
		$filename = basename($file);
		$ext = end(explode('.',$filename));
		$filename = str_replace('.'.$ext, '', $filename);
		$filename = preg_replace('/_(\d+)$/', '', $filename) . '_' . date('U');
		$file = dirname($file)."/$filename.$ext";
	}
	if (!$handle = fopen($file, 'w'))
		return false;
	if (fwrite($handle, $content) === FALSE)
		return false;
	fclose($handle);
	return $file;
}



?>