<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
File that loads a palette from cached infos
*/

// 1. Read JSON: palette description
$file = dirname(dirname(__FILE__)).'/cache/palette.json';
if (file_exists($file)) {
	$palette = trim(join('', file($file)));
	// {"title":"WordPress 2.5 Admin","username":"Ozh","numviews":19,"numvotes":1,"numcomments":0,"numhearts":5,"rank":366183,"datecreated":"2008-05-06 12:07:54","colors":["#07273E","#14568A","#CFEBF6","#F0F6FB","#464646"],"description":"Palette taken from WordPress\' backend color scheme.","url":"http://www.colourlovers.com/palette/366287/WordPress_2.5_Admin","imageurl":"http://www.colourlovers.com/paletteImg/07273E/14568A/CFEBF6/F0F6FB/464646/WordPress_2.5_Admin.png","apiurl":"http://www.colourlovers.com/api/palette/366287"}
	// "colors":["#07273E","#14568A","#CFEBF6","#F0F6FB","#464646"]
}

// 2. Read CURRENT: current colors modifying this palette
$file = dirname(dirname(__FILE__)).'/cache/current.desc';
if (file_exists($file)) {
	$cur = join('', file($file));
	// colors:#797991,#9E5D69,#B16F7C,#C78592,#FF0000
	$cur = '"colors":["'.join('","',split(',',str_replace('colors:','', $cur))).'"]';
	
	$palette = preg_replace('/"colors":\[[^\]]+\]/', $cur, $palette);
}


// Send
die($palette);

?>