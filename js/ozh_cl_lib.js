/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Javascript functions
*/

// Functions
///////////////////////////////////////

// Toggle the sortable behavior: OFF when there's a color picker, ON otherwise
function ozh_cl_togglesortable() {
	ozh_CLCPdisplay = jQuery('#CLCP').css('display');
	if (ozh_CLCPdisplay == 'block') { // CLCP opened
		jQuery("#rcols").sortable('disable');
	} else { // CLCP has been closed
		jQuery("#rcols").sortable('enable');
		ozh_CLCPsource = ozh_CLCPsourcecolor = '';
	}
}

// Toggle tool height and set cookie
function ozh_cl_toggletool() {
	if (jQuery('#randomcss_div').css('height') == '16px') {
		jQuery('#randomcss_div').animate({height: 170}, function(){
			jQuery.cookie('ozh_colourlovers_height', '');
			jQuery('#randomcss_div').css('height', '');
			ozh_cl_toggletool_button('');
			ozh_cl_makerounded();
		});
	} else {
		jQuery('#randomcss_div').animate({height: '16px'}, function(){
			jQuery.cookie('ozh_colourlovers_height', '16px');
			ozh_cl_toggletool_button('16px');
		});
	}
}

// Modify close button to match tool state
function ozh_cl_toggletool_button(h) {
	if (h == '16px') {
		jQuery('#rcols_close').css('background-position', '-13px 0');
	} else {
		jQuery('#rcols_close').css('background-position', '0 0');
	}
}

// Adjust the CL Color Picker position so that it doesnt go offscreen
function ozh_cl_adjustCLCPpos() {
	var screensize = ozh_cl_getscreensize();
	var X = parseInt(jQuery('#CLCP').css('left').replace('px',''));
	if ( (X+270) > screensize['width']) {
		X -= 270;
	}
	jQuery('#CLCP').css('left', X+'px');
}

// What happens when a color is picker on the color picker
CLCPHandler = function(_hex) {
	if ( jQuery('#'+ozh_CLCPsource).attr('tip') == '#'+_hex ) return; // same color: nothing dragged on the CP
	if (!ozh_CLCPsource) return; // no source (ie nothing clicked to call CLCP)
	
	ozh_cl_tweakCSS(jQuery('#'+ozh_CLCPsource).attr('tip'), '#'+_hex, ozh_CLCPsource);
	var i = ozh_CLCPsource.replace('rcol','');
	rcols[i] = '#'+_hex;
}


// Change on the fly a CSS color. Var old & new = #123ABC. index = rcolX.
function ozh_cl_tweakCSS(oldcolor, newcolor, index) {
	oldcolor = oldcolor.toUpperCase();
	newcolor = newcolor.toUpperCase();
	if (oldcolor == newcolor) return;
	
	ozh_cl_can_reload(true);
	ozh_CLCPsourcecolor = newcolor;
	
	var css = jQuery('#randomstyle').html();
	var search = oldcolor + '; \\/\\* '+index+' \\*\\/';
	var replace = newcolor +'; /* '+index+' */';
	var regex = new RegExp(search , "g");
	css = css.replace(regex, replace);
	jQuery('#randomstyle').html(css);
	jQuery('#'+index).attr('tip', newcolor);
}

function ozh_cl_tweakCSS_all(oldcols, newcols) {
	for (var i = 1; i<=5; i++) {
		ozh_cl_tweakCSS (oldcols[i], newcols[i], 'rcol'+i);
		rcols[i] = newcols[i];
	}
	ozh_cl_savecolors();
}


// Display button "Reload" (boolean)
function ozh_cl_can_reload(reload) {
	if (reload == false || reload == 'false') {
		jQuery('#rcols_reload').css('display','none');
		jQuery.cookie('ozh_colourlovers_reload', 'false');
	} else {
		jQuery('#rcols_reload').css('display','inline');
		jQuery.cookie('ozh_colourlovers_reload', 'true');
	}
}

// Save new color palette to current.desc (called from tweakCSS_all or when closing CLCP)
function ozh_cl_savecolors() {
	var savecolors = ozh_cl_serialize_array(rcols);
	ozh_cl_loading_gif(true);
	jQuery.post(rcol_path+'/lib/savecolors.php', {colors: savecolors}, function(data){
		ozh_cl_loading_gif(false);
		if(data == 'error') {
			// something went wrong: couldnt save colors -> unlock palette :(
			ozh_cl_lockpalette(false);
			jQuery('#rcols_saveinfos').html('Could not save colors (impossible to write to plugin\'s cache directory?). Palette will be unlocked.')
				.show().css('background-color', '#ff8').animate({backgroundColor: '#404040'}, 800);
			setTimeout(function(){jQuery('#rcols_saveinfos').slideUp('slow')},3000);			
		}
	});


}


// Lock current palette: don't load any other on next page load
// No argument: toggle. Boolean: force.
function ozh_cl_lockpalette(lock) {
	if (lock != undefined) {
		rcol_locked = (lock == true) ? 'unlocked' : 'locked' ;
	}
	if (rcol_locked == 'locked') {
		// unlock it
		rcol_locked = 'unlocked';
		var pos = '2px 0';
		var tip = 'Lock palette (currently <b>unlocked</b>: another one will load on next page load)';
	} else {
		// lock it
		rcol_locked = 'locked';
		var pos = '-39px 0';
		var tip = 'Unlock palete (currently <b>locked</b>: it won\'t change on next page load)';
	}
	var tiportitle = (jQuery('#rcols_lock').attr('title'))? 'title' : 'tip' ;
	jQuery('#rcols_lock').css('background-position', pos).attr(tiportitle,  tip);
	if (jQuery('#rcols_tip').html()) jQuery('#rcols_tip').html(tip);
	jQuery.cookie('ozh_colourlovers_locked', rcol_locked, { expires: 365 });

}

// Make the color li sortable
function ozh_cl_makesortable() {
	jQuery("#rcols").sortable({
		revert: true,
		axis: 'x',
		containment: '#rcols',
		stop: function(){
			ozh_cl_palettedrag();
		} 
	});
}

// Toggle sortable effect when hovering the color wheels
function ozh_cl_colorwheels_togglesortable() {
	jQuery(".cl_pick").hover(
		// mouse on: disable sortable
		function () {
			if (ozh_CLCPdisplay == 'block') return;
			jQuery("#rcols").sortable('disable');
		}, 
		// mouse away: enable sortable
		function () {
			if (ozh_CLCPdisplay == 'block') return;
			jQuery("#rcols").sortable('enable');
		}
	);
}


// Inject new CSS in current page
// pid: palette id, if any. If none: pick random id
// colors: color array, if any. (If any, ajaxed call will not load a random palette but will return a css with these colors)
function ozh_cl_injectCSS(pid) {
	var random = parseInt(Math.random()*1234);
	var newrandomcss = rcol_cssurl+'?&ozh='+random;
	pid = (pid == undefined) ? 0 : parseInt(pid);
	jQuery('head').append('<style type="text/css" id="randomstyle2"></style');
	ozh_cl_loading_gif(true);
	jQuery('#randomstyle2').load(newrandomcss,{loc: rcol_path, paletteid: pid},function(){
		// When loading new palette: unlock
		ozh_cl_can_reload(false);
		ozh_cl_lockpalette(false);
		jQuery('#randomstyle').remove();
		jQuery('#randomstyle2').attr('id','randomstyle');
		ozh_cl_initswatch(true);
		ozh_cl_loading_gif(false);
	});
}

// Start/Stop "loading" gif
function ozh_cl_loading_gif(load) {
	var opacity = (load == true) ? '0.5' : '1' ;
	var bg = (load == true) ? 'loading' : 'rcol_bg' ;
	jQuery('#rcols').css('background',"#404040 url("+rcol_path+"/img/"+bg+".gif) center center no-repeat");
	jQuery('#rcols li').css('opacity', opacity);
}

// Reorder the LI
function ozh_cl_reorder() {
	for (var i = 0; i<5; i++) {
		// Reorder the LIs
		jQuery(jQuery('#rcols li')[i]).attr('id', 'rcol'+(i+1)).attr('tip', rcols[i+1]);
	}
}

// Rotate current palette colors, and inject it into page
function ozh_cl_rotatecolors() {
	if (ozh_CLCPdisplay == 'block') return;
	var oldcolors = rcols;
	ozh_cl_shufflecolors();
	ozh_cl_tweakCSS_all(oldcolors, rcols);
	ozh_cl_can_reload(true);
}

// Show/Hide palette infos
function ozh_cl_showmore() {
	jQuery('#rcols_infos').slideToggle('fast', function() {
		ozh_cl_makerounded();
	});
}

// Save current palette info a reusable stylesheet
function ozh_cl_savecss() {
	if (ozh_CLCPdisplay == 'block') return;
	var colors = ozh_cl_serialize_array(rcols);
	ozh_cl_loading_gif(true);
	jQuery('#rcols_saveinfos').load(rcol_path+'/lib/savecss.php',
		{colors: colors, title: rcols_data.title, url: rcols_data.url, desc: rcols_data.description, author: rcols_data.username, dobg: rcol_dobg}
		,function(){
		jQuery(this).toggle();
		jQuery('#rcols_saveinfos').css('background-color', '#ff8').animate({backgroundColor: '#404040'}, 800);
		setTimeout(function(){jQuery('#rcols_saveinfos').slideUp('slow')},3000);
		ozh_cl_loading_gif(false);
	});
}

// Stuff to pick a particular palette id
function ozh_cl_pickpalette() {
	var spanwidth = jQuery('#rcols_rotate').css('width');
	var spans = ['dismiss', 'rotate', 'lock', 'reload', 'save', 'more', 'input']; // spans to hide
	var reload = jQuery('#rcols_reload').css('display');
	jQuery(spans).each(function(i,el){
		jQuery('#rcols_'+el).animate({width: 0},'fast',function(){
			// on last item, the textfield & stuff appears
			if (el == 'input') {
				jQuery('#rcols_inputfield').css('display','block');
				jQuery('#rcols_inputfield input').focus();
			}
		});
	})
	// click on "OK"
	jQuery('#rcols_inputfield span.ok').click(function(){
		var pid = jQuery('#rcols_inputfield input').val();
		ozh_cl_injectCSS(pid);
		jQuery('#rcols_inputfield span.cancel').click();
	});
	// click on "Cancel"
	jQuery('#rcols_inputfield span.cancel').click(function(){
		jQuery('#rcols_inputfield').css('display','none');
		jQuery(spans).each(function(i,el){
			jQuery('#rcols_'+el).animate({width: spanwidth},'fast', function(){
				jQuery('#rcols_reload').css('display', reload);
			});
		})
	});
}

// submit if "return" pressed
function ozh_cl_pickpalette_return() {
	jQuery('#rcols_inputfield input').keyup(function(e){
		if (e.which == 13) jQuery('#rcols_inputfield span.ok').click(); 
	});
}

// Handle when a color is dragged
function ozh_cl_palettedrag() {
	var order = jQuery('#rcols').sortable('toArray'); // ["rcol1", "rcol5", "rcol2", "rcol3", "rcol4"]
	var newcols = {};
	var index;
	for (var i=0; i<5; i++) {
		index = order[i].replace('rcol','');
		newcols[(i+1)] = rcols[index];
	}
	if (!ozh_cl_sameobjects(rcols, newcols)) {
		ozh_cl_tweakCSS_all(rcols, newcols);
		rcols = newcols;
		ozh_cl_reorder();
		ozh_cl_can_reload(true);
	}
}


// Get new palette order after dragging
function ozh_cl_palettedrag_ori() {
	oldcols = {};
	jQuery('#rcols li').each(function(i){
		if (i<5) {
			oldcols[i+1] = rcols[i+1];
			rcols[i+1] = ozh_cl_RGBtoHex(jQuery(this).css('color'));
		}
	});
	if (!ozh_cl_sameobjects(oldcols, rcols)) {
		ozh_cl_tweakCSS_all(oldcols, rcols);
		ozh_cl_reorder();
	}
}

// Compare two objects, return true if identical
function ozh_cl_sameobjects(obj1, obj2) {
	var result = true;
	for (var i in obj1) {
		if (obj1[i] != obj2[i]) {
			result = false;
		}
	}
	return result;
}


// Shuffle the rcols object with preserved key order 1..5
function ozh_cl_shufflecolors() {
	var ozh = ozh_cl_shuffle_array([1,2,3,4,5]);
	var ozhouf = {}
	jQuery(ozh).each(function(i,e){
	    ozhouf[i+1] = rcols[e];
	})
	rcols = ozhouf;
}

// Set cookie to remember position of #randomcss_div (called by js.dragnresize.js : stop)
function ozh_cl_getposition() {
	var top = jQuery('#randomcss_div').css('top');
	var left = jQuery('#randomcss_div').css('left');
	jQuery.cookie('ozh_colourlovers_position', [top,left], { expires: 365 });
}


// Refresh the swatch. Boolean 'refresh' to tell if we need to update info via JSON call
function ozh_cl_initswatch(refresh) {
	if (refresh == true) {
		ozh_cl_readpaletteJSON();
	}
	var c = 0;
	jQuery('#rcols li').each(function(i) {
		c++;
		if (c <=5 ) {
			var color = jQuery(this).css('background-color'); 
			color = ozh_cl_RGBtoHex(color);
			jQuery(this).attr('tip',color);
			// rename rcol in order
			//jQuery(this).attr('id', 'rcol'+c);
			rcols[c] = color;
		}
	});
}

// Read current palette info from JSON file + current.desc that contains the modified color scheme
function ozh_cl_readpaletteJSON() {
	jQuery.getJSON(rcol_path+'/lib/loadpalette.php',
	function(data){
		if(data.length<30) return; // too small to be good, something must have fucked up. TODO: improve error handling
		rcols_data = data;
		var infos = ['rank', 'username', 'numviews', 'numvotes', 'numcomments', 'numhearts', 'description'];
		jQuery(infos).each(function(i,el){
			jQuery('#rcols_'+el).html(String(data[el]));
		});
		jQuery('#rcols_paletteid').html( data.url.replace('http://www.colourlovers.com/palette/', '').split('/')[0] );
		jQuery('#rcols_url').html(data.title).attr('href',data.url);
		jQuery('#rcols_username').attr('href','http://www.colourlovers.com/lover/'+data.username);
		jQuery('#rcols_give a').attr('href', data.url);
		jQuery('#rcols_name').html('<a class="cl_ttip" title="View this palette on ColourLovers" href="'+data.url+'">'+data.title+'</a>');
		ozh_cl_makerounded();
		ozh_cl_tooltipize();
	});

}

// Reload colours as stored in the JSON file.
function ozh_cl_reloadpalette() {
	jQuery.getJSON(rcol_path+'/lib/resetpalette.php',
	function(data){
		var orig={}
		for (var i = 0; i<5; i++) {
			orig[i+1] = data.colors[i];
		}
		ozh_cl_tweakCSS_all(rcols, orig);
		ozh_cl_can_reload(false);
	});
}

// Count items in objects. I'm not sure I'm not missing something built-in...
function ozh_cl_objectlength(obj) {
	var c = 0;
	for (var i in obj) {
	    c++;
	}
	return c;
}

// From: http://www.mail-archive.com/discuss@jquery.com/msg02537.html
function ozh_cl_getscreensize() {
     var dimensions = {width: 0, height: 0};
     if (document.documentElement) {
         dimensions.width = document.documentElement.offsetWidth;
         dimensions.height = document.documentElement.offsetHeight;
     } else if (window.innerWidth && window.innerHeight) {
         dimensions.width = window.innerWidth;
         dimensions.height = window.innerHeight;
     }
     return dimensions;
}


// Display tooltips (called in readpaletteJSON)
function ozh_cl_tooltipize() {
	jQuery('#randomcss_div .cl_ttip').each(function() {
		var TT = jQuery('#rcols_tip');
		var el = jQuery(this), txt;
		var fade = '';
		
		if ( txt = el.attr('title') ) el.attr('tip', txt).removeAttr('title');
		
		el.hover(
		function() {
			var tt = el.attr('tip');
			if (/#....../.test(tt)) {
				tt+= ' <div style="float:right;width:70px;border:1px solid #fff;height:12px;margin:-13px 0 0 60px; background:'+tt+'"></div>';
			}
			TT.html(tt);
			ozh_cl_makerounded();
		},
		function() {
			TT.html('');
			ozh_cl_makerounded();
		}
		
		);
	});
}

// Force refresh of -moz-border-radius to prevent small visual glitch
function ozh_cl_makerounded() {
	jQuery('#randomcss_div').css('-moz-border-radius', Math.random()+4+'px');
}

// From: http://jsfromhell.com/array/shuffle [v1.0]
ozh_cl_shuffle_array = function(o){ //v1.0
	for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
};

// rgb(1, 2, 3) -> #010203
function ozh_cl_RGBtoHex(color) {
	color = color.replace(/rgb\(|\)| /g,'').split(','); // ["1","2","3"]
	return '#' + ozh_cl_array_RGBtoHex(color[0],color[1],color[2]);
}

// From: http://www.linuxtopia.org/online_books/javascript_guides/javascript_faq/RGBtoHex.htm
function ozh_cl_array_RGBtoHex(R,G,B) {return ozh_cl_toHex(R)+ozh_cl_toHex(G)+ozh_cl_toHex(B)}
function ozh_cl_toHex(N) {
 if (N==null) return "00";
 N=parseInt(N); if (N==0 || isNaN(N)) return "00";
 N=Math.max(0,N); N=Math.min(N,255); N=Math.round(N);
 return "0123456789ABCDEF".charAt((N-N%16)/16)
      + "0123456789ABCDEF".charAt(N%16);
}

// From: http://planetozh.com/blog/2008/04/javascript-basename-and-dirname/
function basename(path) {
    return path.replace(/\\/g,'/').replace( /.*\//, "" );
}
function dirname(path) {
    return path.replace(/\\/g,'/').replace(/\/[^\/]*$/, '');
}

// Serialize object such as {1: "stuff", 2:"stuff} into what looks like a PHP serialize($array)
// Shit, forgot where I found it
function ozh_cl_serialize_array(a) {
	var a_php = "";
	var total = 0;
	for (var key in a) {
		++ total;
		a_php = a_php + "s:" +
		String(key).length + ":\"" + String(key) + "\";s:" +
		String(a[key]).length + ":\"" + String(a[key]) + "\";";
	}
	a_php = "a:" + total + ":{" + a_php + "}";
	return a_php;
}
