<?php require('CORE.php') ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title><? echo 'http://' . $_SERVER['HTTP_HOST'] . '/ - '?>Администратор</title>
	<link rel="stylesheet" href="/cms/css/administrator.css">
	<!-- TinyMCE -->
	<script type="text/javascript" src="/cms/js/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript" src="/cms/js/tiny_mce/plugins/tinybrowser/tb_standalone.js.php"></script>
	<script type="text/javascript" src="/cms/js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
	<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		skin_variant : "silver",
		file_browser_callback : "tinyBrowser",
		forced_root_block : false,
		force_br_newlines : true,
		force_p_newlines : false,
		
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "/designes/css/theme.css",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	</script>
	<!-- /TinyMCE -->
	<script language="javascript" src="/cms/js/administrator.js"></script>
    <link rel="stylesheet" type="text/css" href="/cms/js/calendar/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="/cms/js/calendar/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="/cms/js/calendar/css/gold/gold.css" />
    <script type="text/javascript" src="/cms/js/calendar/js/jscal2.js"></script>
    <script type="text/javascript" src="/cms/js/calendar/js/lang/ru.js"></script>
	<?php if ($_SESSION['authorize'] == 1){?><script language="javascript" src="/cms/js/menu.js"></script><? } ?>
	<script language="javascript" src="/cms/js/mos_image.js"></script>
	<?php $xajax->printJavascript(); ?>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" id="body">
<div style="position:absolute; width:100%; height:100%;">
<?php 
echo page();
?>
<?php //arrays view
//echo "<pre>"; print_r($url_query); echo "</pre>"; echo "<pre>"; print_r($_SESSION); echo "</pre>"; echo "<pre>"; print_r($_COOKIE); echo "</pre>";
echo $_SERVER["DOCUMENT_ROOT"];
?>
<div id="modal" style="position:absolute; width:100%; height:100%; display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center">
			<div id="modalcontents" style="padding:10px; border:1px solid #CCCCCC; background:#fbfbfb; display:inline-block;"></div>
		</td>
	</tr>
</table>
</div>
    <script type="text/javascript">//<![CDATA[
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("b_created", "created", "%Y-%m-%d %H:%M:%S");
      cal.manageFields("b_publish_up", "publish_up", "%Y-%m-%d %H:%M:%S");
      cal.manageFields("b_publish_down", "publish_down", "%Y-%m-%d %H:%M:%S");
    //]]></script>
</body>
</html>