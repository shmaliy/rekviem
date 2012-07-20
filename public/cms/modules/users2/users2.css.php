<?php
if (!defined(BASEDIR)){
	$bd = str_replace("\\", '/', getcwd());
	$bd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bd);
	define(BASEDIR, str_replace('/modules/users2', '', $bd));
}
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style media="screen">
.icon-16-users { background-image: url('<?=BASEDIR;?>/modules/users2/icon-16-users.png'); }
.icon-48-users { background-image: url('<?=BASEDIR;?>/modules/users2/icon-48-users.png'); }
</style>
