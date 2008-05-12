/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Fun stuff that loads on profile.php
*/

var rcol_path = ''; // path of plugin

// load on profile.php
if (/\/wp-admin\/profile.php/.test(location)) {
	jQuery(document).ready(function() {
		var path = dirname(dirname(jQuery('script[src*=ozh_cl_profile.js]').attr('src')));
		
		jQuery('head').append('<style id="cl_preview"></style>');

		if (jQuery.browser.msie) return; // Fucking browser. I hate you.
	
		jQuery('.ozhcl_palettedesc')
			.css('background', 'transparent url('+path+'/img/color_swatch.png) center top no-repeat;')
			.css('padding','0 8px')
			.tTips();

		// Link love
		jQuery('table.form-table a[href^=http://www.colourlovers.com]').each(function(){
			var h = jQuery(this).html();
			jQuery(this).html('<span style="font-size:120%">&hearts;</span><span style="padding-right:1px;color:#ddd;font-size:90%">&hearts;</span>'+h)
		});
		
		// Cell styling
		jQuery('table.color-palette td[title^=ozhcl_]')
			.css('padding', '8px 3.1px')
			.css('border', '5px solid transparent');
		
		// Color rotation
		var el = 'table.color-palette td[title=ozhcl_randomcolourlovers]';
		jQuery(el)
			.parent().parent().parent().next()
			.find('a:first')
				.css('background', 'transparent url(http://planetozh.com/favicon.ico) left center no-repeat')
				.css('padding-left', '18px');
	
		var rotatecells_timer = 600;
		function ozh_cl_rotatecells() {
			jQuery(el).each(function(i){
				if (parseInt(Math.random()*3) == 1) {
					var rndcol = '#'+ozh_cl_array_RGBtoHex(parseInt(Math.random()*250+3),parseInt(Math.random()*250+3),parseInt(Math.random()*250+3));
					jQuery(this).css('border-color', rndcol).animate({backgroundColor: rndcol}, parseInt(rotatecells_timer*3/5));
				}
			});
			rotatecells_timer = parseInt(Math.random()*1000) + 800;
			setTimeout(function(){ozh_cl_rotatecells()},rotatecells_timer);
		}
		ozh_cl_rotatecells();
		
		// Saved CSS
		jQuery('div.color-option :input[id^=admin_color_ozhcl_]').each(function(){
			if (jQuery(this).attr('id') != 'admin_color_ozhcl_randomcolourlovers' && jQuery(this).attr('checked') != true) {
				jQuery(this).parent()
				.append('<span class="cl_profile_ctrl"><span class="cl_profile_preview">Preview</span><span class="cl_profile_delete">Delete</span></span>');
				//TODO: <span class="cl_profile_edit">Edit</span>
			}
		});
		jQuery('.cl_profile_ctrl span').css({'padding': '0 5px 0 16px', 'cursor': 'pointer'});
		jQuery('.cl_profile_preview').attr('preview', 'off');
		
		jQuery('.cl_profile_preview')
		.css('background', 'transparent url('+path+'/img/accept.png) center left no-repeat')
		.click(function(){
			var preview = jQuery(this).attr('preview');
			if (preview == 'off') {
				// Run preview
				ozh_cl_stoppreviews();
				var el = this;
				ozh_cl_miniloading(el);
				jQuery(this).html('Unpreview').attr('preview', 'on');
				var css = jQuery(this).parent().parent().find(':input').attr('id').replace('admin_color_ozhcl_','');
				jQuery('#cl_preview').load(path+'/savedcss/'+css+'.css',function(data){
					ozh_cl_miniloading(el, 'accept.png');
				});
			} else {
				// Stop preview
				ozh_cl_stoppreviews();
			}
		});
		
		function ozh_cl_stoppreviews() {
			jQuery('.cl_profile_preview').html('Preview').attr('preview', 'off');
			jQuery('#cl_preview').html('');
		}
		
		function ozh_cl_miniloading(el, bg) {
			if (bg == undefined) bg = 'miniloading.gif';
			jQuery(el).css('background', 'transparent url('+path+'/img/'+bg+') center left no-repeat')
		}
		
		jQuery('.cl_profile_edit').click(function(){
			// TODO
		});
		
		jQuery('.cl_profile_delete')
		.css('background', 'transparent url('+path+'/img/delete.png) center left no-repeat')
		.click(function(){
		var conf = confirm('Really delete? (no undo!)');
			if (conf) {
				if (jQuery(this).prev().attr('preview') == 'on') ozh_cl_stoppreviews();
				var el = this;
				ozh_cl_miniloading(el);
				var div = jQuery(this).parent().parent();
				var css = div.find(':input').attr('id').replace('admin_color_ozhcl_','');
				jQuery.post(path+'/lib/deletecss.php', {css: css}, function(data){
					ozh_cl_miniloading(el, 'delete.png');
					if (data == 'ok') {
						div.slideUp('slow');
					} else {
						div.append('<div id="cl_error" style="float:left;padding:5px 10px"></div>');
						jQuery('#cl_error').html(data).animate({backgroundColor:'#ff8',color:'red'}, 800);
					}
				});
			}
		});
	});
}
