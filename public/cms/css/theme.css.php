<?php
if (!defined(BASEDIR)){
	$bd = str_replace("\\", '/', getcwd());
	$bd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bd);
	define(BASEDIR, str_replace('/css', '', $bd));
}
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style media="screen">
* { margin:0; padding:0; }
html, body { height:100%; margin:0; padding:0; font-family:Tahoma; background:#fff; }

/* ---MAIN LAYOUT--- */
img { border:0 none; }
select, input { font-size:11px; }
.wrapper { height:auto !important; height:100%; min-height:100%; margin:0 20px; border-width:0 1px; border-style:solid; border-color:#ccc; }
.wrapper_resize { }
.body { padding:0 10px; }
.fix { border:0; }
#header { width:100%; height:100px; background:#fff; position:absolute; z-index:100; left:0; }
.push1 { height:100px; }
.push { height:50px; }
.footer { height:50px; background:#fff; margin-top:-50px; }
.footer_border { margin:0 20px; height:10px; border-width:0 1px 1px; border-style:solid; border-color:#ccc; font-size:1px; }
.footer_logo { text-align:center; padding-top:10px; }
.clr { clear:both; padding:0; margin:0; }

.logo_and_info { height:74px; }
.logo { float:left; margin:20px 0 0 20px; }
* HTML .logo { margin-left:10px; }
.logo img { border:0; }
.version { float:left; margin:20px 0 0 10px; color:#999; font-size:12px; }
.info { float:right; margin:20px 20px 0 0; background:url('<?=BASEDIR;?>/images/info.png') no-repeat top right; height:50px; width:30px; }
* HTML .info { margin-right:10px; }
#info_float { position:absolute; display:block /*display block by script*/; right:23px; top:37px; z-index:1000; background:url('<?=BASEDIR;?>/images/selector.png') no-repeat top right; padding-top:10px; opacity:0; -moz-opacity:0; filter:alpha(opacity=0); }
* HTML #info_float { right:22px; }
#info_text { border:1px solid #dda; display:block; background:#ffc; padding:5px; display:block; border-top:0 none; z-index:1001; color:#333; font-family:Arial, Helvetica, sans-serif; font-size:14px; }
/* ---/MAIN LAYOUT--- */

/*@import url("{#module#}.css.php"); проверить возможность использования */

/* ---CONFIRM LIST--- */
.confirm_list { padding:10px; font-size:12px; }
.buttons { text-align:center; margin-top:10px; }
.buttons input { margin:0 5px; width:75px; font-size:10px; }
/* ---/CONFIRM LIST--- */

/* ---TABS LAYOUT--- */
.tab { display:none; }
.tabs_btn { background:url('<?=BASEDIR;?>/images/tab_bg.png') repeat-x top; padding:0 20px; margin-top:10px; }
.tabs_btn a { float:left; font-size:12px; display:inline-block; height:20px; background:url('<?=BASEDIR;?>/images/tab_l.png') no-repeat top left; text-decoration:none; color:#666; }
.tabs_btn a span { background:url('<?=BASEDIR;?>/images/tab_r.png') no-repeat top right; display:block; height:14px; padding:4px 10px 2px; }
.tabs_btn a.selected { background:url('<?=BASEDIR;?>/images/tab_lS.png') no-repeat top left; }
.tabs_btn a.selected span { background:url('<?=BASEDIR;?>/images/tab_rS.png') no-repeat top right; }
.tabs_btn a:hover { background:url('<?=BASEDIR;?>/images/tab_lH.png') no-repeat top left; }
.tabs_btn a:hover span { background:url('<?=BASEDIR;?>/images/tab_rH.png') no-repeat top right; }
/* ---/TABS LAYOUT--- */

/* ---LIST LAYOUT--- */
.list { border:1px solid #ccc; margin-top:10px; padding:10px; font-size:12px; }
.table_filter { height:25px; }
.table_filter .filter_left { float:left; padding-right:5px; }
.table_filter .filter_left select { margin:0 5px; }
.ctable				{ font-family:Tahoma; font-size:8pt; background:#e7e7e7; text-align:center; }
.ctable a 				{ text-decoration:none; color:#0b55c4; }
.ctable tfoot a:hover	{ text-decoration:underline; }
.ctable td 			{ color:#666; background-color:#FFFFFF; white-space:nowrap; padding:2px 5px; border:0; }
.ctable td a			{ color:#0b55c4; }
.ctable td a:hover 	{ text-decoration:underline; }
.ctable th 			{ color:#0b55c4; background-color:#F0F0F0; white-space:nowrap; padding:2px 5px; width:1%; }
.ctable th.title 		{ width:auto; white-space:normal; }
.ctable thead th 		{ border-bottom:1px solid #666; }
.ctable tfoot th 		{ border-top:1px solid #666; color:#000; }
.ctable td.title 		{ white-space:normal; text-align:left; }
.ctable td.title a		{ cursor:pointer; }
.ctable input			{ font-size:10px; margin:0 5px; padding:0; }
.ctable input.order	{ text-align:center; }
/* ---/LIST LAYOUT--- */

/* ---EDITOR LAYOUT--- */
.editor_wrapper { border:1px solid #ccc; margin-top:10px; font-size:12px; }
.editor_wrapper form { padding:0; margin:0; }
.editor { width:100%; }
.editor td { vertical-align:top; }
.e_left { border-collapse:collapse; }
.e_left td { border:10px solid #fff; }


.tab { border:1px solid #eee; border-top:0 none; text-align:left; padding:5px; }
.advanced img { border:2px solid #0b55c4; }
.advanced { border:0 none; width:100%; }
.advanced td { padding:5px; margin:0; }
.advanced .a1, .advanced .a3 { width:1%; }
.advanced .a1 { text-align:right; }
.textarea_title { padding:6px 0 2px; }
.b_300 { border-width:310px; width:300px; margin:-310px; }
.b_250 { border-width:260px; width:250px; margin:-260px; }
.b_200 { border-width:210px; width:200px; margin:-210px; }
.b_175 { border-width:185px; width:175px; margin:-185px; }
.b_150 { border-width:160px; width:150px; margin:-160px; }
.b_125 { border-width:135px; width:125px; margin:-135px; }
.b_100 { border-width:110px; width:100px; margin:-110px; }
.b_75 { border-width:85px; width:75px; margin:-85px; }
.b_50 { border-width:60px; width:50px; margin:-60px; }
.b_25 { border-width:35px; width:25px; margin:-35px; }
.w_175 { width:175px; }
.w_150 { width:150px; }
.w_125 { width:125px; }
.w_100 { width:100px; }
.w_75 { width:75px; }
.w_50 { width:50px; }
.w_25 { width:25px; }
.twocol_fl {
	border-left-color:#fff;
	border-left-style:solid;
	border-right-width:0px !important;
	border-top-width:0px !important;
	border-bottom-width:0px !important;
	font-size:13px;
	width:auto !important;
	margin:0 0 10px 0 !important;
}
.twocol_fl .twocol_fl { margin:0 !important; }
.twocol_fr {
	border-right-color:#fff;
	border-right-style:solid;
	border-left-width:0px !important;
	border-top-width:0px !important;
	border-bottom-width:0px !important;
	font-size:13px;
	width:auto !important;
	margin:0 0 10px 0 !important;
}
.twocol_fr .twocol_fr { margin:0 !important; }
.twocol_fl .f_left {
	float:left;
	margin-right:0 !important;
	margin-top:0 !important;
	margin-bottom:0 !important;
	padding:0;
	border-width:auto !important;
	text-align:left;
}
.twocol_fr .f_right {
	float:right;
	margin-left:0 !important;
	margin-top:0 !important;
	margin-bottom:0 !important;
	padding:0;
	border-width:auto !important;
	text-align:right !important;
}
input.text { width:100%; padding:0; height:14px; }
select.text { width:100%; padding:0; margin:0; }
select.textm { width:100%; padding:0; margin:0; }
input.button { padding:0; margin:0 !important; }
.onecol { margin:0 0 10px 0 !important; }
/* ---/EDITOR LAYOUT--- */

/* ---TOP MENU LAYOUT--- */
.topmenu					{ background:url('<?=BASEDIR;?>/images/topm_left.png') left no-repeat; height:26px; margin:0px 15px; padding-left:7px; }
.topmenu div				{ background:url('<?=BASEDIR;?>/images/topm_right.png') right no-repeat; height:26px; padding-right:7px; }
.topmenu div div			{ background:url('<?=BASEDIR;?>/images/topm_bg.png') repeat-x; height:26px; padding:0; }
.topmenu div div div		{ background:none; padding:3px 0px 0px 0px; height:23px; }
.menu, .menu ul, .menu li	{ margin:0; padding:0; border:0 none; font-family:Tahoma; font-size:10pt; }
.menu       				{ position:relative; z-index:100;}
.menu li    				{ float:left; position:relative; list-style:none; display:inline; padding:0px 2px; }
.menu li a  				{ display:block; white-space:nowrap; cursor:default; }
.menu li a:hover			{ color:#0B55C4; text-decoration:underline; }
.menu li.disabled a  		{ color:gray; }
.menu li.disabled a:hover	{ color:gray; text-decoration:none; }
.menu li li 				{ /*width: 100%;*/ clear: both;  /*FF 1.0.7 needs this */  }
.menu li ul					{ visibility:hidden; position:absolute; }
.menu li li ul				{ top:0; left:0; }
.menu li.hover ul			{ visibility:visible; }
.menu li.hover ul li ul		{ visibility:hidden; }
.menu li.hover li.hover ul	{ visibility:visible; left:100%; }
.menu li:hover ul			{ visibility:visible; }
.menu li:hover ul li ul		{ visibility:hidden; }
.menu li:hover li:hover ul	{ visibility:visible; left:100%; }
.menu li.disabled:hover ul			{ visibility:hidden; }
.menu li.disabled:hover ul li ul		{ visibility:hidden; }
.menu li.disabled:hover li:hover ul	{ visibility:hidden; left:100%; }
.menu li a { background-repeat:no-repeat !important; background-position:4px 50%; color:#333; padding-left:24px; padding-right:4px; text-decoration:none; }
.menu li					{ border-left: 1px solid #fff; border-right: 1px solid #ccc; padding:2px; }
.menu li li 				{ border:0; }
.menu ul    				{ border:1px solid #ccc; background:#fbfbfb; width:200px; }
.menu ul li.separator 		{ background:#ccc; height:1px; width:100%; padding:0; }
/* ---/TOP MENU LAYOUT--- */

/* ---FRONTPAGE MENU LAYOUT--- */
.fp_menu { float:left; margin-right:10px; margin-top:10px; position:relative; }
.fp_menu a { display:inline-block; border:1px solid; border-bottom-color:#ccc; border-top-color:#ddd; border-left-color:#ddd; border-right-color:#ccc; width:118px; height:118px; text-align:center; text-decoration:none; color:#666; padding:0px 1px 1px 0px; }
.fp_menu a:hover { border-bottom-color:#ddd; border-top-color:#eee; border-left-color:#eee; border-right-color:#ddd; color:#0B55C4; padding:1px 0px 0px 1px; }
.fp_menu a img { border:0; margin:20px 0 3px; }
.fp_menu a div { padding:0 20px; font-size:12px; }
.fp_menu div.childs { position:absolute; top:90px; left:50px; z-index:100; display:none; float:left; border:1px solid #ccc; background:#fbfbfb; padding:2px 10px 2px 2px; }
.fp_menu:hover div.childs { display:block; }
.fp_menu:hover div.childs a { display:block; background-repeat:no-repeat !important; background-position:left; width:auto; height:auto; border:none; padding:0 0 0 20px; margin:3px 0; font-size:12px; text-align:left; white-space:nowrap; height:16px; }
/* ---/FRONTPAGE MENU LAYOUT--- */

/* ---FRONTPAGE LAYOUT--- */
.container { border-right:400px solid #fff; }
.fp_info { float:right; width:400px; margin-right:-400px; padding-top:10px; }
* HTML .fp_info { margin-right:-200px; }
.fp_buttons { float:left; }
/* ---/FRONTPAGE LAYOUT--- */

/* ---TOOLBAR LAYOUT--- */
.toolbar { border:1px solid #ccc; text-align:right; margin-top:10px; padding:5px; min-height:52px; height:52px; }
.toolbar div { float:left; height:58px; padding-left:55px; background-repeat:no-repeat; background-position:left top; text-align:left; }
.toolbar div span { font-size:24px; padding-top:10px; }
.toolbar span { display:block; font-size:11px; }
.toolbar a img { border:0 none; }
.toolbar a { display:inline-block; border:1px solid #fff; text-align:center; padding:4px 6px; text-decoration:none; color:#666; }
.toolbar a:hover { border:1px solid #eee; background-color:#fdfdfd; }
/* ---/TOOLBAR LAYOUT--- */

/* ---PAGE NAVIGATOR LAYOUT--- */
#navigator select { font-size:10px; height:18px; margin:0 20px 0 5px; }
#navigator a { text-decoration:none; color:#0B55C4; display:inline-block; font-size:10px; padding:2px 2px 4px; }
#navigator a.page_l { background:url('<?=BASEDIR;?>/images/arrow_left.png') no-repeat left; padding:2px 5px 4px 20px; height:10px; }
#navigator a.page_r { background:url('<?=BASEDIR;?>/images/arrow_right.png') no-repeat right; padding:2px 20px 4px 5px; height:10px; }
#navigator a.page_c { text-decoration:underline; color:#000; }
#navigator a.page_n { text-decoration:none; }
#navigator a.page_n:hover { text-decoration:underline;  }
/* ---/PAGE NAVIGATOR LAYOUT--- */

/* ---MODAL WINDOW LAYOUT--- */
#overlay { position:absolute; background:#fff; opacity:0; -moz-opacity:0; filter:alpha(opacity=0); height:100%; width:100%; z-index:9999; padding:0; margin:0; }
#modal { position:absolute; z-index:10001; border:0px solid #ccc; display:block; opacity:0; -moz-opacity:0; filter:alpha(opacity=10); }
#modal div.title { height:30px; overflow:hidden; background:url('<?=BASEDIR;?>/images/modal/tlc.png') no-repeat 0% 0%; padding:0 0 0 17px; }
#modal div.title div.title { height:30px; background:url('<?=BASEDIR;?>/images/modal/trc.png') no-repeat 100% 0%; padding:0 17px 0 0;  }
#modal div.title div.title div.title { height:30px; background:url('<?=BASEDIR;?>/images/modal/top.png') repeat-x top; padding:0; }
#modal div.t { padding:0; text-align:center; font-weight:bold; padding-top:11px; height:auto; color:#666; font-size:14px; cursor:move; }
#modal div.i { padding:0; float:right; padding-top:11px; height:auto; }
#modal div.i img { cursor:pointer; }
#modal div.body { background:url('<?=BASEDIR;?>/images/modal/left.png') repeat-y left; padding:0 0 0 10px; }
#modal div.body div.body { background:url('<?=BASEDIR;?>/images/modal/right.png') repeat-y right; padding:0 10px 0 0; }
#modal div.body div.body div.body { background:#ffffff !important; padding:0; color:#000; overflow:auto; }
#modal div.bottom { height:15px; background:url('<?=BASEDIR;?>/images/modal/blc.png') no-repeat left bottom; padding:0 0 0 20px; font-size:1px; }
#modal div.bottom div.bottom { height:15px; background:url('<?=BASEDIR;?>/images/modal/brc.png') no-repeat right bottom; padding:0 20px 0 0; font-size:1px; }
#modal div.bottom div.bottom div.bottom { height:15px; background:url('<?=BASEDIR;?>/images/modal/btm.png') repeat-x bottom; padding:0; }
/* ---/MODAL WINDOW LAYOUT--- */

/* ---AUTHORIZATION LAYOUT--- */
.authoriz { background:url('<?=BASEDIR;?>/images/lock.png') no-repeat left center; height:128px; margin:20px 20px 0; padding:10px 0 0; text-align:right; }
.authoriz form { padding:0; margin:0; font-size:12px; text-align:right; overflow:hidden; }
.authoriz input { float:right; font-size:11px; width:150px; padding:0; color:#000; position:relative; margin-left:10px; }
.authoriz input.btn { height:auto; margin-right:5px; }
#auth_stat { padding-left:118px; padding-top:5px; font-size:12px; text-align:center; }
/* ---/AUTHORIZATION LAYOUT--- */

/* ---INSTALLATION LAYOUT--- */
.install { background:url('<?=BASEDIR;?>/images/database.png') no-repeat left center; height:278px; margin:20px 20px 0; padding:10px 0 0; text-align:right; }
.install form { padding:0; margin:0; font-size:12px; overflow:hidden; }
.install input { float:right; font-size:11px; width:150px; padding:0; color:#000; position:relative; margin-left:10px; }
.install input.btn { height:auto; margin-right:5px; }
#inst_stat { padding-left:118px; padding-top:5px; font-size:12px; text-align:center; }
/* ---/INSTALLATION LAYOUT--- */

/* ---FILEBROWSER LAYOUT (ICONS)--- */
.filebrowser_i { border-top:1px solid #ece9d8; overflow:auto; height:297px; }
.filebrowser_i div { float:left; text-align:center; margin:10px 3px 0; }
.filebrowser_i div a.icon { width:94px; height:94px; display:inline-block; border:1px solid #ece9d8; background-color:#fff; }
.filebrowser_i div a.icon:hover { background-color:#f6f9ff; }
.filebrowser_i div a.text { width:116px; height:30px; margin-top:5px; display:block; font-size:12px; color:#000; text-decoration:none; }
.filebrowser_i div a.text:hover { text-decoration:underline; }
.filebrowser_i span.size { display:none; font-size:12px; }
/* ---/FILEBROWSER LAYOUT (ICONS)--- */

/* ---FILEBROWSER LAYOUT (LIST)--- */
.filebrowser_l { border-top:1px solid #ece9d8; overflow:auto; height:297px; }
.filebrowser_l div { padding:2px 10px; background:url('<?=BASEDIR;?>/images/fb_bg.png'); }
.filebrowser_l div a.icon { float:left; margin-right:5px; }
.filebrowser_l div a.text { width:400px; display:inline-block; font-size:12px; color:#000; text-decoration:none; }
.filebrowser_l div a.text:hover { text-decoration:underline; }
.filebrowser_l span.size { float:right; display:block; font-size:12px; width:70px; background-color:#fefefe; text-align:right; }
/* ---/FILEBROWSER LAYOUT (LIST)--- */

/* ---FILEBROWSER FILTER LAYOUT--- */
.folders { border-left:60px solid #fff; border-right:160px solid #fff; margin:5px 0; height:22px; }
.folders .txt { float:left; margin-left:-60px; width:40px; padding:0 10px; font-size:14px; margin-top:3px; }
.folders .f_mode { float:right; margin-right:-160px; width:70px; text-align:right; padding:0 10px 0 60px; }
.folders .uppath { float:left; margin-left:-70px; }
.folders .refresh { float:left; margin-left:-40px; }
.folders select { width:100%; font-size:11px; padding:0; margin-top:3px; }
/* ---/FILEBROWSER FILTER LAYOUT--- */


/* ---<OPTION> TAG PADDING LEFT--- */
.tab_1 { padding-left:20px; }
.tab_2 { padding-left:40px; }
.tab_3 { padding-left:60px; }
.tab_4 { padding-left:80px; }
.tab_5 { padding-left:100px; }
.tab_6 { padding-left:120px; }
.tab_7 { padding-left:140px; }
/* ---/<OPTION> TAG PADDING LEFT--- */

.popup { padding:20px 0; }
.popup_tree_cat { font-size:11px; font-weight:bold; color:#333; padding:0 15px; margin:1px 2px; background:#f7f7f7; }
.popup_tree_cont { font-size:11px; color:#111; padding:0 15px; margin:1px 2px; }
.popup_tree_cont input { padding:0; margin:0 5px 0 0; float:left; }
.popup_tree_cat input { padding:0; margin:0 5px 0 0; float:left; }

/*****************************************************************************************************/
/** menu icons **/
.icon-16-archive 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-archive.png');}
.icon-16-article 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-article.png');}
.icon-16-category 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-category.png');}
.icon-16-checkin 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-checkin.png');}
.icon-16-component	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-component.png');}
.icon-16-config 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-config.png');}
.icon-16-cpanel 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-cpanel.png');}
.icon-16-default 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-default.png');}
.icon-16-frontpage 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-frontpage.png');}
.icon-16-help		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-help.png');}
.icon-16-info 		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-info.png'); }
.icon-16-install 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-install.png'); }
.icon-16-language 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-language.png'); }
.icon-16-logout 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-logout.png'); }
.icon-16-massmail 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-massmail.png'); }
.icon-16-media 		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-media.png'); }
.icon-16-menu 		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-menu.png'); }
.icon-16-menumgr 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-menumgr.png'); }
.icon-16-messages 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-messages.png'); }
.icon-16-module 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-module.png'); }
.icon-16-plugin 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-plugin.png'); }
.icon-16-section 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-section.png'); }
.icon-16-static 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-static.png'); }
.icon-16-stats 		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-stats.png'); }
.icon-16-themes 	{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-themes.png'); }
.icon-16-trash 		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-trash.png'); }
.icon-16-user 		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-user.png'); }
.icon-16-cash 		{ background-image: url('<?=BASEDIR;?>/images/menu/icon-16-cash.png'); }

/** toolbar icons **/
.icon-32-article-add 	{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-article-add.png'); }
.icon-32-article	 	{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-article.png'); }
.icon-32-category	 	{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-category.png'); }
.icon-32-static	 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-static.png'); }
.icon-32-frontpage	 	{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-frontpage.png'); }
.icon-32-send 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-send.png'); }
.icon-32-delete 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-delete.png'); }
.icon-32-help 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32-help.png'); }
.icon-32-cancel 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-322.png'); }
.icon-32-config 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-323.png'); }
.icon-32-apply 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-324.png'); }
.icon-32-back			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-325.png'); }
.icon-32-forward		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-325.png'); }
.icon-32-save 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-325.png'); }
.icon-32-edit 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-326.png'); }
.icon-32-copy 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-327.png'); }
.icon-32-move 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-328.png'); }
.icon-32-new 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-329.png'); }
.icon-32-upload 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32A.png'); }
.icon-32-assign 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32A.png'); }
.icon-32-html 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32B.png'); }
.icon-32-css 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32C.png'); }
.icon-32-menus 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32D.png'); }
.icon-32-publish 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32A.png'); }
.icon-32-unpublish 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32E.png'); }
.icon-32-restore		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32F.png'); }
.icon-32-trash 			{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32F.png'); }
.icon-32-archive 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32G.png'); }
.icon-32-unarchive 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32H.png'); }
.icon-32-preview 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32I.png'); }
.icon-32-default 		{ background-image: url('<?=BASEDIR;?>/images/toolbar/icon-32J.png'); }

/** header icons **/
.icon-48-article		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-article.png'); }
.icon-48-generic 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-generic.png'); }
.icon-48-checkin 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-checkin.png'); }
.icon-48-cpanel 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-cpanel.png'); }
.icon-48-config 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-config.png'); }
.icon-48-module 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-module.png'); }
.icon-48-menu 			{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-menu.png'); }
.icon-48-menumgr 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-menumgr.png'); }
.icon-48-trash 			{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-trash.png'); }
.icon-48-user	 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-user.png'); }
.icon-48-inbox 			{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-inbox.png'); }
.icon-48-msgconfig 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-msgconfig.png'); }
.icon-48-langmanager 	{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-langmanager.png'); }
.icon-48-mediamanager	{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-mediamanager.png'); }
.icon-48-plugin 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-plugin.png'); }
.icon-48-help_header 	{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-help_header.png'); }
.icon-48-impressions 	{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-impressions.png'); }
.icon-48-browser 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-browser.png'); }
.icon-48-searchtext 	{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-searchtext.png'); }
.icon-48-thememanager	{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-thememanager.png'); }
.icon-48-massemail 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-massemail.png'); }
.icon-48-frontpage 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-frontpage.png'); }
.icon-48-sections 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-sections.png'); }
.icon-48-addedit 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-addedit.png'); }
.icon-48-category 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-category.png'); }
.icon-48-install 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-install.png'); }
.icon-48-dbbackup		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-dbbackup.png'); }
.icon-48-dbrestore 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-dbrestore.png'); }
.icon-48-dbquery 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-dbquery.png'); }
.icon-48-systeminfo 	{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-systeminfo.png'); }
.icon-48-massemail 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-massemail.png'); }
.icon-48-component 		{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-component.png'); }
.icon-48-cash 			{ background-image: url('<?=BASEDIR;?>/images/header/icon-48-cash.png'); }
/*****************************************************************************************************/
</style>