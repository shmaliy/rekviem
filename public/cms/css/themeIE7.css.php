<?php
if (!defined(BASEDIR)){
	define(BASEDIR, str_replace('/css', '', str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace("\\", '/', getcwd()))));
}
//header("Cache-Control: no-cache, must-revalidate");
header("Content-type: text/css"); 
?>
<style>
#modal .title { background-image:url('<?=BASEDIR;?>/images/modal/tlc.gif') !important; }
#modal .title div.title { background-image:url('<?=BASEDIR;?>/images/modal/trc.gif') !important;  }
#modal .title div.title div.title { background-image:url('<?=BASEDIR;?>/images/modal/top.gif') !important; }
#modal .body { background-image:url('<?=BASEDIR;?>/images/modal/left.gif') !important; }
#modal .body div.body { background-image:url('<?=BASEDIR;?>/images/modal/right.gif') !important; }
#modal .body div.body div.body { background:#fff; }
#modal .bottom { background-image:url('<?=BASEDIR;?>/images/modal/blc.gif') !important; }
#modal .bottom div.bottom { background-image:url('<?=BASEDIR;?>/images/modal/brc.gif') !important; }
#modal .bottom div.bottom div.bottom { background-image:url('<?=BASEDIR;?>/images/modal/btm.gif') !important; }
</style>