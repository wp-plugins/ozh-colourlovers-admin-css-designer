<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
File that reset a palette
*/

// 1. Read JSON: palette description
$file = dirname(dirname(__FILE__)).'/cache/palette.json';
if (file_exists($file)) {
	$palette = trim(join('', file($file)));
}

// 2. Delete modified color scheme
@unlink(dirname(dirname(__FILE__)).'/cache/current.desc');

// Send
die($palette);

?>