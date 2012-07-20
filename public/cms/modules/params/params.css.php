<?php
if (!defined(BASEDIR)){
	$bd = str_replace("\\", '/', getcwd());
	$bd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bd);
	define(BASEDIR, str_replace('/modules/params', '', $bd));
}
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style media="screen">
.icon-16-params { background-image: url('<?=BASEDIR;?>/modules/params/icon-16-params.png'); }
.icon-48-params { background-image: url('<?=BASEDIR;?>/modules/params/icon-48-params.png'); }
.list { padding:0; }
.tab { padding:10px; }
.tab input { margin:0 0 0 -2px; padding:0; width:100%; }
.tab select { padding:0; min-width:100%; }
.editor { border-right:400px solid #fff; }
.editor .e_left textarea { width:100%; height:246px; }
.editor .e_right { float:right; width:360px; margin-right:-400px; text-align:right; }
.editor .e_right img { border:2px solid #0b55c4; }
.editor .tab { border:1px solid #eee; border-top:0 none; text-align:left; padding:5px; }
.editor .advanced { border:0 none; width:100%; }
.editor .advanced td { padding:5px; margin:0; }
.editor .advanced .a1, .advanced .a3 { width:1%; }
.editor .advanced .a1 { text-align:right; }
</style>
