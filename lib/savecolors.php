<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Save current color palette to cache/current.desc
*/

// Something like:
// colors:#CAC88B,#CA9F8B,#E9E4AF,#7DC3CC,#859E74
$colors = 'colors:'.join(',',array_map('strtoupper', unserialize(str_replace('\\"','"',$_POST['colors']))));

if (true == wp_ozh_cl_writecolors($colors)) {
	die('ok');
} else {
	die('error');
}

// Write current.desc
function wp_ozh_cl_writecolors($content) {
	$file = dirname(dirname(__FILE__)).'/cache/current.desc';
	if (!$handle = fopen($file, 'w'))
		return false;
	if (fwrite($handle, $content) === FALSE)
		return false;
	fclose($handle);
	return $file;
}


?>