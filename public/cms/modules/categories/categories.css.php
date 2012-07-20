<?php
if (!defined(BASEDIR)){
	$bd = str_replace("\\", '/', getcwd());
	$bd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bd);
	define(BASEDIR, str_replace('/modules/categories', '', $bd));
}
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style media="screen">
.icon-16-categories { background-image: url('<?=BASEDIR;?>/modules/categories/icon-16-categories.png'); }
.icon-48-categories { background-image: url('<?=BASEDIR;?>/modules/categories/icon-48-categories.png'); }
</style>
