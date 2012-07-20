<?php
if (!defined(BASEDIR)){
	$bd = str_replace("\\", '/', getcwd());
	$bd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bd);
	define(BASEDIR, str_replace('/css', '', $bd));
}
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style>
@charset "utf-8";
body, html { margin:0; padding:0; height:100%; font-family:Tahoma; background:#fff; }
img { border:0 none; }
#header { height:80px !important; background:#fff; z-index:100; }
.logo_and_info { height:74px; }
.logo { float:left; margin:20px 0 0 20px; }
* HTML .logo { margin-left:10px; }
.logo img { border:0; }
.version { float:left; margin:20px 0 0 10px; color:#999 !important; font-size:12px; }

#modal { position:absolute; z-index:10001; border:0px solid #ccc; display:block; width:800px; height:550px; top:50%; left:50%; margin-left:-400px; margin-top:-275px; }
#modal .title { height:30px; overflow:hidden; background:url('<?=BASEDIR;?>/images/modal/tlc.png') no-repeat 0% 0%; padding:0 0 0 17px; }
#modal .title div { height:30px; background:url('<?=BASEDIR;?>/images/modal/trc.png') no-repeat 100% 0%; padding:0 17px 0 0;  }
#modal .title div div { height:30px; background:url('<?=BASEDIR;?>/images/modal/top.png') repeat-x top; padding:0; }
#modal .t { padding:0; background:none !important; text-align:center; font-weight:bold; padding-top:11px !important; height:auto; color:#666; font-size:14px; cursor:move; }
#modal .i { padding:0; background:none !important;; float:right; padding-top:11px !important; height:auto; }
#modal .i img { cursor:pointer; }
#modal .body { background:url('<?=BASEDIR;?>/images/modal/left.png') repeat-y left; padding:0 0 0 10px; }
#modal .body div { background:url('<?=BASEDIR;?>/images/modal/right.png') repeat-y right; padding:0 10px 0 0; }
#modal .body div div { height:505px; background:none; background:#fff !important; padding:0; color:#000; overflow:auto; }
#modal .body div div div { height:auto; background:none; color:#000; display:block; }
#modal .bottom { height:15px; background:url('<?=BASEDIR;?>/images/modal/blc.png') no-repeat left bottom; padding:0 0 0 20px; font-size:1px; }
#modal .bottom div { height:15px; background:url('<?=BASEDIR;?>/images/modal/brc.png') no-repeat right bottom; padding:0 20px 0 0; font-size:1px; }
#modal .bottom div div { height:15px; background:url('<?=BASEDIR;?>/images/modal/btm.png') repeat-x bottom; padding:0; }

.h1 { font-size:17px !important; color:#F3801F !important; padding:0 20px 10px !important; }
.txt { font-size:14px !important; padding:0 20px 10px !important; }
.txt a { color:#005987; }
.brows { width:100%; margin:10px 0; }
.brows td { text-align:center; padding:0 20px 10px; }
.brows td a { font-size:14px; color:#005987; }
</style>