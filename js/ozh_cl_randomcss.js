/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Fun stuff that loads the "tool"
*/

// Environment stuff and their default values
var rcol_path = ''; // path of plugin
var rcol_cssurl = ''; // URL of real CSS
var rcol_dobg = false; // Painting body background ? true/false;
var rcol_locked = 'unlocked'; // Is palette locked ? 'locked' / 'unlocked'
var rcol_timer = {}; //

// Current palette
var rcols = {}; // array of colors
var rcols_data = {}; // object containing the json data of current palette

// vars for the ColourLovers Color Picker
ozh_CLCPsource = ''; // what element to change
ozh_CLCPsourcecolor = ''; // original color of element
ozh_CLCPdisplay = 'none'; // is the CLCP displayed? (block / none)


// Let's go
jQuery(document).ready(function() {
	// Get CSS and plugin path
	var ozh_cl_css=jQuery('head link[href*=ozh_cl_css_main.css.php]');
	rcol_cssurl=jQuery(ozh_cl_css).attr('href').replace('ozh_cl_css_main.css.php','wp-admin-random.css.php');
	rcol_dobg = /dobg=true/.test(rcol_cssurl);
	rcol_path = dirname(dirname(rcol_cssurl));
	// init some clicky behaviors:
	jQuery('#rcols_dismiss').click(function(){ozh_cl_injectCSS(0);});
	jQuery('#rcols_rotate').click(function(){ozh_cl_rotatecolors();});
	jQuery('#rcols_more').click(function(){ozh_cl_showmore();});
	jQuery('#rcols_save').click(function(){ozh_cl_savecss();});
	jQuery('#rcols_lock').click(function(){ozh_cl_lockpalette();});
	jQuery('#rcols_reload').click(function(){ozh_cl_reloadpalette();});
	jQuery('#rcols_input').click(function(){ozh_cl_pickpalette();});
	ozh_cl_pickpalette_return();
	jQuery('#rcols_close').click(function(){ozh_cl_toggletool();});
	// Get tool position and state (collapsed/expanded)
	var sz = ozh_cl_getscreensize();
	if (!jQuery.cookie('ozh_colourlovers_position')) {
		var divpos = [ '150px', parseInt(sz.width - 210) + 'px'];
	} else {
		var divpos = jQuery.cookie('ozh_colourlovers_position').split(',');
		if (parseInt(divpos[1].replace('px','')) > parseInt(sz.width - 210))
			divpos[1] = parseInt(sz.width - 210) + 'px';
	}
	var height = jQuery.cookie('ozh_colourlovers_height') || '';
	// Display the tool
	jQuery('#randomcss_div').css({'top':divpos[0], 'left':divpos[1], 'height': height}).show().jqDrag('.jqDrag');
	ozh_cl_toggletool_button(height);
	ozh_cl_makerounded();
	// Add the colorwheel divs
	jQuery('#rcols li').each(function(i,e) {
		i++;
		jQuery(this).html('<a class="cl_pick cl_ttip" title="Tweak this color"></a>');
	});
	// CLCP init
	_CLCPdisplay = "none"; // Values: "none", "block". Default "none"
	_CLCPisDraggable = true; // Values: true, false. Default true
	_CLCPposition = "absolute"; // Values: "absolute", "relative". Default "absolute"
	_CLCPinitHex = ""; // Values: Any valid hex value. Default "ffffff"
	jQuery('.cl_pick').click(function(){
		CLCPhidePicker(); // hide any other picker
		ozh_CLCPsource = jQuery(this).parent().attr('id'); // li
		ozh_CLCPsourcecolor = jQuery(this).parent().attr('tip'); // title is replaced with tip by tooltipize, and always contains color code in #ABC123 format
		_hex = ozh_CLCPsourcecolor.replace('#','');
		CLCPshowPicker({_hex: _hex});
		ozh_cl_adjustCLCPpos();
		ozh_cl_togglesortable();
	});
	CLCPinitPicker();
	// Bind custom functions to ColorPicker close
	jQuery('img[src$=closeBtn.png]').click(function(){
		ozh_cl_togglesortable();
		ozh_cl_savecolors();
	});
	// Add a msg on the CPCLP
	jQuery('#CLCPbasicV').after('<div id="CLCPwarn">(This color <em>may</em> or <em>may not</em> actually apply to elements on this page)</span>');
	// Init some stuff on the tool
	ozh_cl_colorwheels_togglesortable();
	ozh_cl_initswatch(true);
	ozh_cl_makesortable();
	// Get palette lock & reloadable state
	rcol_locked = jQuery.cookie('ozh_colourlovers_locked') || rcol_locked;
	ozh_cl_lockpalette( rcol_locked == 'locked' ? true : false );
	ozh_cl_can_reload(jQuery.cookie('ozh_colourlovers_reload') || false);
});


