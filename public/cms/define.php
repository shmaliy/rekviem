<?php
if (!defined(BASEDIR)){
	define(BASEDIR, str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace("\\", '/', getcwd())));
}
?>