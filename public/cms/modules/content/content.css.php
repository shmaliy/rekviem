<?php
if (!defined(BASEDIR)){
	$bd = str_replace("\\", '/', getcwd());
	$bd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bd);
	define(BASEDIR, str_replace('/modules/content', '', $bd));
}
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style media="screen">
.icon-16-content { background-image: url('<?=BASEDIR;?>/modules/content/icon-16-content.png'); }
.icon-48-content { background-image: url('<?=BASEDIR;?>/modules/content/icon-48-content.png'); }
</style>
