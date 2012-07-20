<?php
if (!defined(BASEDIR)){
	$bd = str_replace("\\", '/', getcwd());
	$bd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bd);
	define(BASEDIR, str_replace('/modules/menu', '', $bd));
}
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style media="screen">
.icon-16-menu { background-image: url('<?=BASEDIR;?>/modules/menu/icon-16-menu.png'); }
.icon-48-menu { background-image: url('<?=BASEDIR;?>/modules/menu/icon-48-menu.png'); }
</style>
