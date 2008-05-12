<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Main WordPress functions
*/

global $wp_ozh_cl;

// Add fun stuff on profile.php
function wp_ozh_cl_profilejs() {
	global $wp_ozh_cl;
	wp_enqueue_script('ozhcolourlovers_lib', $wp_ozh_cl['plugin_url'].'/js/ozh_cl_lib.js', array('jquery'));
	wp_enqueue_script('ozhcolourlovers_profile', $wp_ozh_cl['plugin_url'].'/js/ozh_cl_profile.js', array('jquery'));
}

// Add random CSS + saved CSS
function wp_ozh_cl() {
	global $wp_ozh_cl, $is_IE;
	
	wp_ozh_cl_defaults();

	$rcol = array();
	for ($i=0;$i<5;$i++) {
		$rcol[] = wp_ozh_cl_rndcolor();
	}
	
	$dobg = $wp_ozh_cl['dobg']; // do background: true/false
	$dobg = ($dobg ? 'true' : 'false');
	
	// Add the main CSS with randomized colors
	wp_admin_css_color(
		'ozhcl_randomcolourlovers',
		'Random CSS + Designer Tools <em>from</em> <a href="http://planetozh.com/blog/">Ozh</a> &amp; <a href="http://www.colourlovers.com/">COLOURlovers</a>',
		$wp_ozh_cl['plugin_url'] . "/css/ozh_cl_css_main.css.php?dobg=$dobg&loc=".$wp_ozh_cl['plugin_url'],
		$rcol
	);

	// Add saved CSS
	wp_ozh_cl_savedcss('list');

	// If the current stylesheet is the random one, add a "few" things:
	if (get_user_option('admin_color') == 'ozhcl_randomcolourlovers') {
		wp_enqueue_script('dimensions');
		wp_enqueue_script('ozhcolourlovers_random', $wp_ozh_cl['plugin_url'].'/js/ozh_cl_randomcss.js', array('jquery'));
		wp_enqueue_script('ozhcolourlovers_lib', $wp_ozh_cl['plugin_url'].'/js/ozh_cl_lib.js', array('jquery'));
		wp_enqueue_script('ui.base', $wp_ozh_cl['plugin_url'].'/js/jq.ui.base.js', array('jquery'));
		wp_enqueue_script('ui.sortable', $wp_ozh_cl['plugin_url'].'/js/jq.ui.sortable.js', array('jquery'));
		wp_enqueue_script('jqdrag', $wp_ozh_cl['plugin_url'].'/js/jq.dragnresize.js', array('jquery'));
		wp_enqueue_script('jqcookie', $wp_ozh_cl['plugin_url'].'/js/jq.cookie.js', array('jquery'));
		if ($is_IE)
			wp_enqueue_script('jqiesucks', $wp_ozh_cl['plugin_url'].'/js/jq.pngfix.js', array('jquery'));
		wp_enqueue_script('CLCP', 'http://colourlovers.com.s3.amazonaws.com/COLOURloversColorPicker/js/COLOURloversColorPicker.js');
		add_action('admin_head', 'wp_randomclcss_head', 99);
	}
}

// Display saved CSS
function wp_ozh_cl_savedcss($action = 'list') {
	global $wp_ozh_cl;
	foreach (glob($wp_ozh_cl['plugin_path']."/savedcss/*.desc") as $filename) {
		// check we have .desc & .css
		if (!file_exists(preg_replace('/desc$/', 'css', $filename)))
			continue;
		
		$palette_infos = wp_ozh_cl_desc2array($filename);
		$desc = 'By '.$palette_infos['author'];
		if ($palette_infos['desc']) $desc .= ': '.$palette_infos['desc'];
		
		if ($action == 'list') {
			wp_admin_css_color(
				'ozhcl_'.str_replace('.'.end(explode('.',basename($filename))), '', basename($filename)), // 123.ext -> 123 & 123.456.ext -> 123.456
				'<span class="ozhcl_palettedesc" title="'.$desc.'">&nbsp;</span> <strong>'.$palette_infos['title'].'</strong> (a <a href="http://www.colourlovers.com/palette/'.$palette_infos['id'].'">COLOURlovers</a> palette )',
				$wp_ozh_cl['plugin_url'] . '/savedcss/'.$palette_infos['id'].'.css',
				$palette_infos['colors']
			);
		}
	}
}


// Set default options
function wp_ozh_cl_defaults() {
	global $wp_ozh_cl;
	$wp_ozh_cl = array_merge($wp_ozh_cl, (array)get_option('ozh_colourlovers'));
	if (!isset($wp_ozh_cl['dobg'])) $wp_ozh_cl['dobg'] = false;
	if (!isset($wp_ozh_cl['dashboard'])) $wp_ozh_cl['dashboard'] = true;
}


// Read .desc files and return an array
function wp_ozh_cl_desc2array($filename) {
	$palette_infos = file($filename);
	foreach ($palette_infos as $i=>$item) {
		list($key,$val) = (explode(':',$item,2));
		$palette_infos[$key]=stripslashes(html_entity_decode(trim($val)));
		unset($palette_infos[$i]);
	}
	$palette_infos['colors'] = explode(',',$palette_infos['colors']);
	return $palette_infos;
}


// Add into <head>
function wp_randomclcss_head() {
	global $wp_ozh_cl;
	
	$path = $wp_ozh_cl['plugin_url'];

	echo '<link rel="stylesheet" href="http://colourlovers.com.s3.amazonaws.com/COLOURloversColorPicker/COLOURloversColorPicker.css" type="text/css" media="all" />'."\n";
	
	$dobg = $wp_ozh_cl['dobg']; // do background: true/false
	$dobg = ($dobg ? true : false);
	
	if ($_COOKIE['ozh_colourlovers_locked'] == 'locked' ) {
		// load palette infos from .txt and colors from last saved state
		if (file_exists($wp_ozh_cl['plugin_path'].'/cache/current.desc')) {
			$palette = wp_ozh_cl_desc2array($wp_ozh_cl['plugin_path'].'/cache/current.desc');
		} elseif( file_exists($wp_ozh_cl['plugin_path'].'/cache/palette.desc')) {
			$palette = wp_ozh_cl_desc2array($wp_ozh_cl['plugin_path'].'/cache/palette.desc');
		} else {
			// Reset cookie (via JS, since output already started)
			echo "<script type='text/javascript'>jQuery.cookie('ozh_colourlovers_locked', 'unlocked', { expires: 365 });</script>\n";
		}
	}
	echo '<style id="randomstyle" type="text/css">'."\n";
	include($wp_ozh_cl['plugin_path'].'/css/wp-admin-random.css.php');
	echo "</style>\n";
}


// Add the designer tool
function wp_ozh_cl_footer() {
	echo <<<HTML
<div id="CLCP" class="CLCP"></div>
<div id="randomcss_div" style="display:none">
	<div id="rcols_close" class="cl_ttip" title="Collapse/Expand"></div>
	<div id="rcols_name" class="jqHandle jqDrag"></div>
	<ul id="rcols">
		<li class="cl_ttip" id="rcol1"></li>
		<li class="cl_ttip" id="rcol2"></li>
		<li class="cl_ttip" id="rcol3"></li>
		<li class="cl_ttip" id="rcol4"></li>
		<li class="cl_ttip" id="rcol5"></li>
	</ul>
	<div id="rcols_controls">
		<span id="rcols_dismiss" class="cl_ttip" title="Forget this palette. Load another one.">&nbsp;</span>
		<span id="rcols_rotate" class="cl_ttip" title="Play with this palette: rotate colors">&nbsp;</span>
		<span id="rcols_lock" class="cl_ttip" title="Lock palette: don't load another on next page load">&nbsp;</span>
		<span id="rcols_reload" class="cl_ttip" title="Reset changes and reload original palette">&nbsp;</span>
		<span id="rcols_save" class="cl_ttip" title="Love it! Save as stylesheet!">&nbsp;</span>
		<span id="rcols_inputfield" style="display:none"><label class="cl_ttip" title="Enter a palette ID">Palette ID: <input type="text" size="5"/></label><span title="Confirm" class="ok cl_ttip">&nbsp;</span><span title="Cancel" class="cancel cl_ttip">&nbsp;</span></span>
		<span id="rcols_input" class="cl_ttip" title="Enter a palette ID">&nbsp;</span>
		<span id="rcols_more" class="cl_ttip" title="More info about this palette">&nbsp;</span>
	</div>
	<div id="rcols_saveinfos"></div>
	<div id="rcols_infos">
		<a href="rcols_url" id="rcols_url">rcols_title</a> by <a href="" id="rcols_username"></a>
		<span id="rcols_description"></span>
		(ID: <span id="rcols_paletteid"></span>, ranking <span id="rcols_rank"></span> with <span id="rcols_numviews"></span> views, <span id="rcols_numvotes"></span> votes, <span id="rcols_numcomments"></span> comments and <span id="rcols_numhearts"></span> <span id="rcols_heart">&hearts;</span>)
		<span id="rcols_give" class="cl_ttip" title="View the palette on ColourLovers"><a href="">Give it some love!</a></span>
	</div>
	<div id="rcols_tip"></div>
</div>
	
HTML;

}

// Return a random color. Neato! From http://www.php.net/manual/en/function.dechex.php#39634
function wp_ozh_cl_rndcolor($min = 15, $max = 240) {
	return '#' . substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
}

function wp_ozh_cl_add_page() {
	$page = add_options_page('Ozh &amp; COLOURlovers\' Admin CSS Designer', '<span style="color:red">&hearts;</span><span style="font-size:80%">&hearts;</span>Admin CSS Designer', 'manage_options', 'ozh_colourlovers', 'wp_ozh_cl_adminpage');
}

function wp_ozh_cl_adminpage() {
	global $wp_ozh_cl;
	require($wp_ozh_cl['plugin_path'].'/wp/wp_optionpage.php');
	wp_ozh_cl_adminpage_print();
}

function wp_ozh_cl_dashboard() {
	global $wp_ozh_cl;
	if ($wp_ozh_cl['dashboard']) require($wp_ozh_cl['plugin_path'].'/wp/wp_dashboard.php');
}

add_action('admin_init','wp_ozh_cl');
add_action('load-profile.php', 'wp_ozh_cl_profilejs');
add_action('load-index.php', 'wp_ozh_cl_dashboard');
add_action('admin_footer', 'wp_ozh_cl_footer');
add_action('admin_menu', 'wp_ozh_cl_add_page');


?>