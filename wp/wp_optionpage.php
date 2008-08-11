<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Option page stuff
*/

global $wp_ozh_cl;

// Process POST vars
function wp_ozh_cl_processforms() {
	global $wp_ozh_cl;

	check_admin_referer('ozh-colourlovers');
	
	// Sanitize before store
	$wp_ozh_cl['dobg'] = ($_POST['ozh_cl_dobg'] == 'true' ? true : false );	
	//$wp_ozh_cl['minlevel'] = attribute_escape($_POST['ozh_cl_minlevel']);
	$wp_ozh_cl['dashboard'] = ($_POST['ozh_cl_dashboard'] == 'true' ? true : false );	
	
	// Store
	update_option('ozh_colourlovers',$wp_ozh_cl);
	
	echo '
	<div class="updated fade" id="message"><p>Options <strong>saved</strong>.</p></div>
	';
}


// Print admin page
function wp_ozh_cl_adminpage_print() {

	if (isset($_POST['ozh_colourlovers']) && ($_POST['ozh_colourlovers'] == 1) ) wp_ozh_cl_processforms();

	global $wp_ozh_cl;
	
	wp_ozh_cl_adminpage_css();
	
	if (!function_exists('ozh_cl_get_random_palette'))
		include_once($wp_ozh_cl['plugin_path'].'/lib/api-colourlovers.php');
	$palette = ozh_cl_get_random_palette(366287, false);
	$url = $palette['url'];
	$imageurl = $palette['imageurl'];
	$blog = get_option('siteurl');
	
	$dobg = $wp_ozh_cl['dobg'];
	//$minlevel = $wp_ozh_cl['minlevel'];
	$dashboard = $wp_ozh_cl['dashboard'];
	foreach (array('dobg', 'dashboard') as $wtf) {
		${"checked_${wtf}_on"} = ($$wtf ? ' checked="checked"' : '' );
		${"checked_${wtf}_off"} = ($$wtf ? '' : ' checked="checked"' ) ;
	}
		
	echo <<<HTML
    <div class="wrap">
    <h2>Ozh &amp; COLOURlovers' Admin CSS Designer Options</h2>
    <form method="post" action="" id="ozh_cl">
HTML;
	wp_nonce_field('ozh-colourlovers');
	echo <<<HTML
	<table class="form-table"><tbody>
	<input type="hidden" name="ozh_colourlovers" value="1"/>
    <input type="hidden" name="action" value="update">
    
	<tr><th scope="row">Colourize Background</th>
	<td><div style="float:left;margin-right:3em;"><input name="ozh_cl_dobg" id="ozh_cl_dobg_on" value="true" $checked_dobg_on type="radio"><label for="ozh_cl_dobg_on">Yes</label><br/>
	<input name="ozh_cl_dobg" id="ozh_cl_dobg_off" value="false" $checked_dobg_off type="radio"><label for="ozh_cl_dobg_off">No</label><br/></div>
	By default, the page background remains white<br/>(this option might need a <a href="options-general.php?page=ozh_colourlovers">page refresh</a> right after you've changed it)
	</td></tr>
	
	<tr><th scope="row">Dashboard Widget</th>
	<td><div style="float:left;margin-right:3em;"><input name="ozh_cl_dashboard" id="ozh_cl_dashboard_on" value="true" $checked_dashboard_on type="radio"><label for="ozh_cl_dashboard_on">Enable</label><br/>
	<input name="ozh_cl_dashboard" id="ozh_cl_dashboard_off" value="false" $checked_dashboard_off type="radio"><label for="ozh_cl_dashboard_off">Disable</label><br/></div>
	<a href="http://www.colourlovers.com/">COLOURlovers</a> is also a fantastic blog with inspirational and informative articles.<br/>You can fetch their headlines right into your <a href="index.php">Dashboard</a> and never miss them.
	</td></tr>
	
	<tr><th scope="row">Connection Test</th>
	<td>
	<a class="palette" href="$url"><img src="$imageurl"/></a><br/>
	If the connection between <a href="$blog">your blog</a>'s server and <a href="http://www.colourlovers.com/">COLOURlovers</a>' API server is fine, you should see a colorful palette here.
	</td></tr>

	<tr><th scope="row">Bookmarklet</th>
	<td><a href="javascript:document.location='$blog/wp-admin/index.php?paletteid='+location.href.split('/')[4]">Stylesheet This!</a><br/>
	Bookmark this link, or drag it to your toolbar. Whenever you're viewing a tasty <a href="http://www.colourlovers.com/palettes">palette</a>, make it a stylesheet for your blog!
	</td></tr>

	<tr><th scope="row">Give Some Love</th>
	<td>
	This colorful plugin was made by <a href="http://planetozh.com/blog/">Ozh</a> using the awesome <a href="http://www.colourlovers.com/">COLOURlovers</a>' API. Visit Us!<br/>
	I also wrote a number of very cool <a href="http://planetozh.com/blog/my-projects">WordPress plugins</a>, there is more than probably something that you will like there :)
	</td></tr>


	</tbody></table>
	
	<p class="submit"><input type="submit" value="Update Options &raquo;" /></p>

	</form>
	</div>
HTML;


	//wp_ozh_cl_adminpage_js();

}

function wp_ozh_cl_adminpage_css() {
	echo <<<CSS
<style type="text/css">
.palette {
	background:#fff;
	display:block;
	float:left;
	height:161px;
	margin-right:20px;
	padding:9px 10px 12px 12px;
	width:228px;
}	
</style>
	
	
CSS;


}

function wp_ozh_cl_adminpage_js() {
	echo <<<JS
	<script type="text/javascript">
	</script>
JS;

}




?>