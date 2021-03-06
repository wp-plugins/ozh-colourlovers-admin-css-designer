<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
Template file for the admin color scheme
*/

/*****************************************************************************
/*	EDITING NOTES
/*  Random colors are rcol1 to rcol5
/*	To use a palette color, replace color code with: $rcolX; /* rcolX */
/*	(where X is in 1,2,3,4,5)
/*  All path are relative to wp-content/plugins/[plugin_dir]/css/
/****************************************************************************/

echo <<<CSS
a.page-numbers:hover {
	border-color: $rcol1; /* rcol1 */
}

body	{
	background: $dobg_bg
	color: $dobg_color
}

body > #upload-menu {
	border-bottom-color: $dobg_bg;
}

div#current-widgets, #postcustomstuff table, #your-profile fieldset, a.page-numbers, #rightnow, div.dashboard-widget, .widefat {
	border-color: $rcol5; /* rcol5 */
}

div.dashboard-widget-error {
	background-color: $rcol5; /* rcol5 */
}

div.dashboard-widget-notice {
	background-color: $rcol4; /* rcol4 */
}

div.dashboard-widget-submit, ul.widget-control-list div.widget-control-actions {
	border-top-color: $rcol5; /* rcol5 */
}

input.disabled, textarea.disabled {
	background-color: $rcol4; /* rcol4 */
}

#user_info a:hover, li.widget-list-control-item h4.widget-title a:hover, .submit a, #dashmenu a:hover, #footer a, #upload-menu li a.upload-tab-link, li.widget-list-control-item h4.widget-title a,
#dragHelper li.widget-list-control-item h4.widget-title a,
#draghelper li.widget-list-control-item h4.widget-title a:visited, .login #backtoblog a:hover {
	color: $rcol4; /* rcol4 */
}

ul#category-tabs li.ui-tabs-selected, li.widget-list-control-item, div.nav, .tablenav, .submitbox, h3.dashboard-widget-title, h3.dashboard-widget-title span, h3.dashboard-widget-title small, ul.view-switch li.current, .form-table tr, #poststuff h3, .login form {
	background-color:$rcol3; /* rcol3 */
	color:$rcol1; /* rcol1 */
}

div.ui-tabs-panel {
	border-color: $rcol3; /* rcol3 */
}

select {
	background-color: $dobg_bg
	border-color: $rcol5; /* rcol5 */
}

strong .post-com-count span {
	background-color: #2583ad;
}

.button-secondary, #login form .submit input {
	background-color: $rcol1; /* rcol1 */
}

ul#widget-list li.widget-list-item h4.widget-title {
	background-color: $rcol5; /* rcol5 */
	color: $dobg_color
}

ul.widget-control-list .sorthelper {
	background-color: $rcol5; /* rcol5 */
}

.ac_match, .subsubsub a.current, h2 {
	color: $dobg_color
}

.ac_over {
	background-color: $rcol4; /* rcol4 */
}

.ac_results {
	background-color: $dobg_bg
	border-color: $rcol5; /* rcol5 */
}

.ac_results li {
	color: $dobg_color
}

.alternate {
	background-color: $rcol4; /* rcol4 */
}

.available-theme a.screenshot {
	background-color: $rcol4; /* rcol4 */
	border-color: $rcol5; /* rcol5 */
}

.bar {
	background-color: $rcol5; /* rcol5 */
	border-right-color: $rcol4; /* rcol4 */
}

.describe {
	border-top-color: $rcol5; /* rcol5 */
}

.error, #login #login_error {
	background-color: #ffebe8;
	border-color: #c00;
}

.error a {
	color: #c00;
}

.form-invalid {
	background-color: #ffebe8 !important;
}

.form-invalid input {
	border-color: #c00 !important;
}

.form-table input, .form-table textarea {
	border-color: $rcol5; /* rcol5 */
}

.form-table td, .form-table th {
	border-bottom-color: $dobg_bg
}

.highlight {
	background-color: $rcol3; /* rcol3 */
	color: $rcol2; /* rcol2 */
}

.howto, .nonessential, #sidemenu, #edit-slug-box, .form-input-tip, #dashboard_primary span.rss-date, .subsubsub, #dashboard_secondary div.dashboard-widget-content ul li a cite {
	color: $rcol5; /* rcol5 */
}

#dashmenu a, #user_info a {
	color: $rcol3; /* rcol3 */
}

.media-item {
	border-bottom-color: $rcol5; /* rcol5 */
}

.media-upload-form label.form-help, td.help {
	color: $rcol2; /* rcol2 */
}

.page-numbers {
	background-color: $dobg_bg
	border-color: $dobg_bg
}

.page-numbers.current {
	background-color: $rcol2; /* rcol2 */
	border-color: $rcol2; /* rcol2 */
	color: $dobg_bg
}

.post-com-count {
	background-image: url($wpadmin/images/bubble_bg.gif);
	color: #fff;
}

.post-com-count span {
	background-color: #bbb;
	color: #fff;
}

.post-com-count:hover span {
	background-color: #d54e21;
}

.quicktags, .search {
	background-color: $rcol2; /* rcol2 */
	color: $dobg_color
}

.side-info h5, .bordertitle {
	border-bottom-color: $rcol5; /* rcol5 */
}

.side-info ul, .widget-description {
	color: $rcol2; /* rcol2 */
}

.submit input, .button, .button-secondary, #login form .submit input, div.dashboard-widget-submit input, #edit-slug-buttons a.save {
	background-color: $rcol4; /* rcol4 */
	color: $rcol2; /* rcol2 */
	border-color: $rcol3; /* rcol3 */
}

.tablenav .button-secondary {
	border-color: $rcol2; /* rcol2 */
}

.submit input:hover, .button:hover, #edit-slug-buttons a.save:hover {
	border-color: $rcol3; /* rcol3 */
}

.submit input:hover, .button:hover, .button-secondary:hover, #wphead #viewsite a:hover, #submenu a.current, #submenu a:hover, .submitbox #previewview a:hover, #the-comment-list .comment a:hover, #rightnow a:hover, a:hover, .subsubsub a:hover, .subsubsub a.current:hover, #login form .submit input:hover, div.dashboard-widget-submit input:hover, #edit-slug-buttons a.save:hover {
	color: $rcol1; /* rcol1 */
}

#adminmenu a:hover, #sidemenu a:hover {
	color: $rcol4; /* rcol4 */
}

.button-secondary:hover, #login form .submit input:hover {
	border-color: $rcol2; /* rcol2 */
	background-color: $rcol4; /* rcol4 */
}

.submitbox #autosave .error, ul.view-switch li.current a {
	color: $rcol5; /* rcol5 */
}

.submitbox #previewview {
	background-color:$rcol2; /* rcol2 */
}

.submitbox #previewview a, #rightnow .rbutton {
	background-color: $rcol5; /* rcol5 */
	color: $rcol3; /* rcol3 */
}

.submitbox .submit {
	background-color: $rcol5; /* rcol5 */
	color: $rcol3; /* rcol3 */
}

.submitbox .submitdelete {
	border-bottom-color: $rcol5; /* rcol5 */
}

.submitbox .submitdelete:hover {
	color: #fff;
	background-color: #f00;
	border-bottom-color: #f00;
}

.tablenav .dots {
	background-color: $rcol3; /* rcol3 */
	border-color: $rcol3; /* rcol3 */
}

.tablenav .next, .tablenav .prev{
	background-color: $rcol3; /* rcol3 */
	border-bottom-color: $rcol3; /* rcol3 */
	border-color: $rcol3; /* rcol3 */
	color: $rcol2; /* rcol2 */
}

.tablenav .next:hover, .tablenav .prev:hover {
	border-bottom-color: #d54e21;
	border-color: $rcol3; /* rcol3 */
	color: #d54e21;
}

.updated, .login #login_error, .login .message {
	background-color:$rcol2; /* rcol2 */
	border-color:$rcol1; /* rcol1 */
}

.updated a {
	border-bottom-color: $rcol3; /* rcol3 */
}

.widefat td, .widefat th, div#available-widgets-filter, ul#widget-list li.widget-list-item, .commentlist li {
	border-bottom-color: $rcol5; /* rcol5 */
}

.widefat thead, .thead {
	background-color:$rcol5; /* rcol5 */
	color: $rcol2; /* rcol2 */
}

.widget-control-save, .widget-control-remove {
	background-color: $rcol3; /* rcol3 */
	color: $rcol5; /* rcol5 */
}

.wrap h2 {
	border-bottom-color:$rcol3; /* rcol3 */
	color:$rcol2; /* rcol2 */
}

#poststuff #edButtonPreview, #poststuff #edButtonHTML, #the-comment-list p.comment-author strong a, a {
	color: $rcol2; /* rcol2 */
}

#adminmenu a {
	color: $rcol3; /* rcol3 */
}

#submenu a {
	color: $rcol2; /* rcol2 */
}
/* Because we don't want visited on these links */
#adminmenu a.current, #sidemenu a.current {
	background-color: $dobg_bg
	border-color: $rcol1; /* rcol1 */
	border-bottom-color: $dobg_bg
	color: $dobg_color
	font-weight: bold;
}

#adminmenu li a #awaiting-mod {
	background-image: url($wpadmin/images/comment-stalk-classic.gif);
}

#adminmenu li a #awaiting-mod span {
	background-color: #d54e21;
	color: #fff;
}

#rightnow .reallynow {
	background-color:$rcol2; /* rcol2 */
	color:$rcol4; /* rcol4 */
}

#rightnow .reallynow a {
	background-color:$rcol4; /* rcol4 */
	color:$rcol2; /* rcol2 */
}

#rightnow .reallynow a:hover {
	color:$rcol5; /* rcol5 */
}


#adminmenu li a:hover #awaiting-mod span {
	background-color: $rcol1; /* rcol1 */
}

#adminmenu, div#media-upload-header {
	background-color: $rcol2; /* rcol2 */
	border-bottom-color: $rcol1; /* rcol1 */
}

#currenttheme img {
	border-color: $rcol5; /* rcol5 */
}

#current-widgets .drop-widget-here {
	background-color: #ffc;
}

#dashboard_secondary div.dashboard-widget-content ul li a {
	background-color: $rcol4; /* rcol4 */
}

input.readonly {
	background-color: $rcol5; /* rcol5 */
}

#dashmenu a.current {
	background-color: $rcol2; /* rcol2 */
	color: $rcol3; /* rcol3 */
}

#dragHelper h4.widget-title, li.widget-list-control-item h4, #dragHelper li.widget-list-control-item h4 {
	background-color: $rcol2; /* rcol2 */
	color: $rcol4; /* rcol4 */
}

#ed_toolbar input {
	background: url( $wpadmin/images/fade-butt.png ) #fff repeat-x 0 -2px;
}

#editable-post-name {
	background-color: #fffbcc;
}

#edit-slug-box strong, .login #nav a {
	color: $rcol5; /* rcol5 */
}

#edit-slug-buttons a.save {
	background-color: $rcol5; /* rcol5 */
}

#footer {
	background-image: url($path/img/wplogo.png) !important;
	background-position:10px 10px;
	background-repeat: no-repeat;
	_background-image: url($path/img/wplogo.gif);
	background-color:$rcol5; /* rcol5 */
	color:$rcol1; /* rcol1 */
}

#media-items {
	border-color: $rcol5; /* rcol5 */
}

#pass-strength-result {
	background-color: $rcol5; /* rcol5 */
	border-color: $rcol4; /* rcol4 */
}

#pass-strength-result.bad {
	background-color: $rcol4; /* rcol4 */
	border-color: $rcol1; /* rcol1 */
}

#pass-strength-result.good {
	background-color: $rcol5; /* rcol5 */
	border-color: $rcol4; /* rcol4 */
}

#pass-strength-result.short {
	background-color: $rcol5; /* rcol5 */
}

#pass-strength-result.strong {
	background-color: $rcol2; /* rcol2 */
	border-color: $rcol4; /* rcol4 */
}

.checkbox, .side-info, #your-profile #rich_editing {
	background-color: $dobg_bg
}

#plugins .active {
	background-color:$rcol3; /* rcol3 */
	color:$rcol2; /* rcol2 */
}

#plugins .togl {
	border-right-color: $rcol4; /* rcol4 */
}

#the-comment-list .unapproved {
	background-color: #ffffe0;
}

#plugins tr {
	background-color: $dobg_bg
}

#poststuff #editor-toolbar .active {
	background-color: $rcol4; /* rcol4 */
	color: $rcol2; /* rcol2 */
}

#poststuff .closed .togbox {
	background-color: $rcol3; /* rcol3 */
	background-image: url($wpadmin/images/toggle-arrow.gif);
}

#poststuff .postbox, #titlediv, #poststuff .postarea, #poststuff .stuffbox {
	border-color: $rcol5; /* rcol5 */
	border-right-color: $rcol3; /* rcol3 */
	border-bottom-color: $rcol3; /* rcol3 */
}

#poststuff .togbox {
	background-color:$rcol5; /* rcol5 */
	background-image: url($wpadmin/images/toggle-arrow.gif);
}

#quicktags #ed_link {
	color: $rcol2; /* rcol2 */
}

#rightnow .youhave {
	background-color: $rcol3; /* rcol3 */
}

#rightnow a {
	color: $rcol2; /* rcol2 */
}

#sidemenu a {
	background-color: $rcol2; /* rcol2 */
	border-bottom-color: $rcol1; /* rcol1 */
	border-top-color: $rcol2; /* rcol2 */
	color: $rcol3; /* rcol3 */
}

#tagchecklist span a {
	background: url($wpadmin/images/xit.gif) no-repeat;
}

#tagchecklist span a:hover {
	background: url($wpadmin/images/xit.gif) no-repeat -10px 0;
}

#the-comment-list .comment a {
	border-bottom-color: $rcol5; /* rcol5 */
	color: $rcol3; /* rcol3 */
}

#update-nag, .plugin-update {
	background-color: #fffeeb;
	border-bottom-color: #ccc;
	border-top-color: #ccc;
	color: #555;
}

#upload-files a.file-link {
	background-color: $rcol4; /* rcol4 */
}

#upload-file-view a img {
	border-bottom-color: $rcol2; /* rcol2 */
}

#upload-menu li #current-tab-nav, #upload-file {
	background-color: $rcol4; /* rcol4 */
}

#upload-menu li span a.page-numbers {
	color: $rcol1; /* rcol1 */
}

#upload-menu li.current {
	border-right-color: $rcol3; /* rcol3 */
	color: $dobg_color
}

#upload-menu li.current a.upload-tab-link, #upload-menu li a:hover {
	background-color: $rcol4; /* rcol4 */
	color: $dobg_color
}

#upload-menu, #upload-menu li {
	border-top-color: $rcol4; /* rcol4 */
}

#user_info, .login #backtoblog a {
	color: $rcol4; /* rcol4 */
}

#wphead {
	background-color:$rcol2; /* rcol2 */ 
	color:$rcol3; /* rcol3 */
}

#wphead, body.login {
	border-top-color:$rcol1; /* rcol1 */
	color:$rcol2; /* rcol2 */
}

#wphead #viewsite a {
	background-color: $rcol3; /* rcol3 */
	color: $rcol2; /* rcol2 */
	border-color: $rcol4; /* rcol4 */
}

#wphead #viewsite a:hover {
	color: $rcol1; /* rcol1 */
}

#wphead h1, #dashmenu a.current:hover {
	color:$rcol3; /* rcol3 */
}

div#media-upload-error, .file-error, abbr.required, .widget-control-remove:hover, .delete:hover {
	color: #f00;
}

#media-upload a.delete { 
	color: $rcol5; /* rcol5 */
}


/* TinyMCE */
.wp_themeSkin *,
.wp_themeSkin a:hover, 
.wp_themeSkin a:link, 
.wp_themeSkin a:visited, 
.wp_themeSkin a:active {
	 color: #000;
}

/* Containers */
.wp_themeSkin table {
	background: $rcol3; /* rcol3 */
}

.wp_themeSkin iframe {
	background: $dobg_bg
}

/* Layout */
.wp_themeSkin .mceStatusbar {
	 color:$dobg_color
	 background-color: $rcol4; /* rcol4 */
}

/* Button */
.wp_themeSkin .mceButton { 
	background-color: $rcol5; /* rcol5 */
	border-color: $rcol3; /* rcol3 */
}

.wp_themeSkin a.mceButtonEnabled:hover,
.wp_themeSkin a.mceButtonActive, 
.wp_themeSkin a.mceButtonSelected {
	background-color: #d6d8da;
	border-color: #7789ba !important;
}

.wp_themeSkin .mceButtonDisabled {
	border-color: #83B4D5 !important;
}

/* ListBox */
.wp_themeSkin .mceListBox .mceText,
.wp_themeSkin .mceListBox .mceOpen  {
	border-color: $rcol3; /* rcol3 */
	background-color: $rcol5; /* rcol5 */
}

.wp_themeSkin table.mceListBoxEnabled:hover .mceOpen, 
.wp_themeSkin .mceListBoxHover .mceOpen,
.wp_themeSkin .mceListBoxSelected .mceOpen,
.wp_themeSkin .mceListBoxSelected .mceText {
	border-color: #7789ba !important;
	background-color: #d6d8da;
}

.wp_themeSkin table.mceListBoxEnabled:hover .mceText, 
.wp_themeSkin .mceListBoxHover .mceText {
	border-color: #7789ba !important;
}

.wp_themeSkin select.mceListBox {
	border-color: $rcol4; /* rcol4 */
	background-color: $dobg_bg
}

/* SplitButton */
.wp_themeSkin .mceSplitButton a.mceAction, 
.wp_themeSkin .mceSplitButton a.mceOpen {
	background-color: $rcol5; /* rcol5 */
	border-color: $rcol3; /* rcol3 */
}

.wp_themeSkin .mceSplitButton a.mceOpen:hover,
.wp_themeSkin .mceSplitButtonSelected a.mceOpen,
.wp_themeSkin table.mceSplitButtonEnabled:hover a.mceAction,
.wp_themeSkin .mceSplitButton a.mceAction:hover {
	background-color: #d6d8da;
	border-color: #7789ba !important;
} 

.wp_themeSkin .mceSplitButtonActive {
	background-color: #d6d8da;
}

/* ColorSplitButton */
.wp_themeSkin div.mceColorSplitMenu table {
	background-color: #ebeaeb;
	border-color: #808080;
}

.wp_themeSkin .mceColorSplitMenu a {
	border-color: #808080;
}

.wp_themeSkin .mceColorSplitMenu a.mceMoreColors {
	border-color: #fff;
}

.wp_themeSkin .mceColorSplitMenu a.mceMoreColors:hover {
	border-color: #0A246A;
	background-color: #B6BDD2;
}

.wp_themeSkin a.mceMoreColors:hover {
	border-color: #0A246A;
}

/* Menu */
.wp_themeSkin .mceMenu {
	border-color: #ddd;
}

.wp_themeSkin .mceMenu table {
	background-color: #ebeaeb;
}

.wp_themeSkin .mceMenu .mceText {
	color: #000; 
}

.wp_themeSkin .mceMenu .mceMenuItemEnabled a:hover,
.wp_themeSkin .mceMenu .mceMenuItemActive, #quicktags {
	background-color:$rcol4; /* rcol4 */
}
.wp_themeSkin td.mceMenuItemSeparator {
	background-color: #aaa;
}
.wp_themeSkin .mceMenuItemTitle a {
	background-color: #ccc; 
	border-bottom-color: #aaa;
}
.wp_themeSkin .mceMenuItemTitle span.mceText {
	color: #000;
}
.wp_themeSkin .mceMenuItemDisabled .mceText {
	color: #888;
}

/* pop-up */
.clearlooks2 .mceTop .mceLeft, .clearlooks2 .mceTop .mceRight {
	background-color: $rcol4; /* rcol4 */
	border-color: $rcol3; /* rcol3 */
}

.clearlooks2 .mceFocus .mceTop .mceLeft, .clearlooks2 .mceFocus .mceTop .mceRight {
	background-color: $rcol3; /* rcol3 */
	border-color: $rcol5; /* rcol5 */
}

#editorcontainer {
	border-color: $rcol5; /* rcol5 */
}

#poststuff #titlewrap {
	border-color: $rcol5; /* rcol5 */
}

#tTips p#tTips_inside {
	background-color: #ddd;
	color: #333;
}


CSS;

?>