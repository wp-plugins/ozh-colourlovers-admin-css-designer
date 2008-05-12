<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
This file generates the random admin CSS 
*/

// path is either passed to $_REQUEST (ajax load) or via PHP (first inclusion)
if (!isset($path)) {
	$path = $_REQUEST['loc'];
	// fallback: try to determine path ?
}

// Force a palette id ?
$paletteid = isset($_REQUEST['paletteid']) ? intval($_REQUEST['paletteid']) : 0 ;

// New palette, or rotate current ?
$newpalette = (isset($palette['colors']) ) ? false : true;

if ($newpalette) {
	// Erase previous data
	foreach(array('current.desc', 'palette.desc', 'palette.json') as $file) {
		@unlink (dirname(dirname(__FILE__))."/cache/$file");
	}
	// we want a new palette, either random or with a given id
	include (dirname(dirname(__FILE__)).'/lib/api-colourlovers.php');
	$palette = ozh_cl_get_random_palette($paletteid);
}

// get palette
$colors = $palette['colors'];
//list($rcol1, $rcol2, $rcol3, $rcol4, $rcol5) = $colors; // buggy ? wtf.
$rcol1 = strtoupper(array_shift($colors));
$rcol2 = strtoupper(array_shift($colors));
$rcol3 = strtoupper(array_shift($colors));
$rcol4 = strtoupper(array_shift($colors));
$rcol5 = strtoupper(array_shift($colors));

// dobg is either passed to $_REQUEST (ajax load) or via PHP (first inclusion)
if (!isset($dobg)) {
	if ( isset($_GET['dobg']) && $_GET['dobg'] == 'true' ) {
		$dobg = true;
	} else {
		$dobg = false;
	}
}

if ($dobg == true or $dobg == 'true') {
	$dobg_bg = "$rcol4; /* rcol4 */";
	$dobg_color = "$rcol1; /* rcol1 */";
} else {
	$dobg_bg = '#fff;';
	$dobg_color = '#333;';
}

$wpadmin = ((dirname(dirname(dirname($path))))).'/wp-admin';

// Debug info
if (true != true) {
	$debug = "/* debug:
	paletteid: ".print_r($paletteid,true)."
	path: $path
	rotate: ".$_REQUEST['rotate']."
	palette: ".print_r($palette,true)."
	newpalette: ".print_r($newpalette,true)."
	rcol1: $rcol1
	rcol2: $rcol2
	rcol3: $rcol3
	rcol4: $rcol4
	rcol5: $rcol5

*/";
}


//header('Content-type: text/css');

echo <<<CSS
/* Designer Tool */

$debug

#rcol1 { 
	color:$rcol1; /* rcol1 */
	background-color:$rcol1; /* rcol1 */
} 
#rcol2 { 
	color:$rcol2; /* rcol2 */
	background-color:$rcol2; /* rcol2 */
} 
#rcol3 { 
	color:$rcol3; /* rcol3 */
	background-color:$rcol3; /* rcol3 */
} 
#rcol4 { 
	color:$rcol4; /* rcol4 */
	background-color:$rcol4; /* rcol4 */
} 
#rcol5 {
	color:$rcol5; /* rcol5 */
	background-color:$rcol5; /* rcol5 */
}
#randomcss_div {
	position:fixed;
	_position:absolute;
	top:150px;
	right:30px;
	border:3px solid #0d0d0d;
	background:#404040;
	width:177px;
	overflow:hidden;
	z-index:99999;
	display:none;
}
#rcols_close {
	float:right;
	width:13px;
	height:13px;
	position:relative;
	margin:2px 3px 0 0;
	cursor:pointer;
	background: #0d0d0d url($path/img/close.png) top left no-repeat;
}
#rcols_name a {
	text-decoration:none;
	color:#eee;
	cursor:pointer;
}
#rcols_name a:hover {
	text-decoration:underline;
	color:#fff;
}
#rcols_name {
	background:#0d0d0d url($path/img/cl_logo.png) center top no-repeat;
	text-align:center;
	overflow:hidden;
	font-size:12px;
	color:#eee;
	padding-top:20px;
	margin-top:-5px;
	cursor:move;
}
#rcols {
	list-style-type:none;
	padding:0;
	margin:0;
	overflow:hidden;
	clear:both;
	border:1px solid #505051;
	background:#404040 url($path/img/rcol_bg.png) repeat;
}
#rcols li {
	cursor:w-resize;
	display:inline;
	width:35px;
	height:120px;
	float:left;
	margin:0;
	padding:0;
}
#rcols li:hover {
	border:1px solid white;
	width:33px;
	height:118px;
}
#rcols a.cl_pick {
	background:transparent url($path/img/color_wheel.png) center center no-repeat;
	width:16px;
	height:16px;
	margin:6px auto;
	cursor:pointer;
	display:none;
}
#rcols li:hover a.cl_pick {
	display:block;
}
#rcols_controls {
	height:20px;
	overflow:hidden;
	clear:both;
	background:#404040;
	padding-top:4px;
}
#rcols_controls span {
	display:block;
	float:left;
	width:22px;
	cursor:pointer;
}
#rcols_controls span:hover {

}
#rcols_rotate {
	background:transparent url($path/img/arrow_switch.png) center center no-repeat;
}
#rcols_controls #rcols_reload {
	display:none;
	background:transparent url($path/img/arrow_undo.png) center center no-repeat;
}
#rcols_dismiss {
	background:transparent url($path/img/color_swatch.png) center center no-repeat;
}
#rcols_save {
	background:transparent url($path/img/love.png) center center no-repeat;
}
#rcols_lock {
	background:transparent url($path/img/lock.png) 0 0 no-repeat;
}
#rcols_input {
	background:transparent url($path/img/palette.png) center center no-repeat;
}
#rcols_controls span#rcols_inputfield {
	width:100%;
	font-size:9px;
	color:#eee;
}
#rcols_controls span#rcols_inputfield span {
	padding:0 10px;
	display:inline;
	float:none;
}
#rcols_inputfield span.ok{
	background:transparent url($path/img/accept.png) center center no-repeat;
}
#rcols_inputfield span.cancel{
	background:transparent url($path/img/delete.png) center center no-repeat;
}
#rcols_controls span#rcols_more {
	background:transparent url($path/img/more.png) center center no-repeat;
	float:right;
}
#rcols_infos, #rcols_saveinfos {
	background:#404040;
	color:white;
	font-size:11px;
	padding:3px;
	text-align:left;
	display:none;
}
#rcols_infos a, #rcols_saveinfos a {
	color:white;
	text-decoration:none;
	border-bottom:1px solid #ccc;
}
#rcols_infos span#rcols_give, #rcols_infos span#rcols_description {
	display:block;
	font-size:12px;
}
#rcols_infos span#rcols_heart {
	color:#D4453D;
	font-size:12px;
}
#rcols_tip {
	background:#404040;
	color:#ccc;
	font-size:10px;
	padding:3px;
	text-align:left;
}
#rcols_tip b {
	color:#f33;
}
div#CLCP.CLCP {
	z-index:99999999 !important;
	height:300px !important;
}
#CLCPwarn {
	float: left;
	color: #ddd;
	margin:1px 0 0 1px;
	width: 168px;
	font-size:10px;
	text-align: left;
}


/* Begin WP CSS */
CSS;

include(dirname(__FILE__).'/template.css.php')



?>