<?php
session_start();

if (!defined(BASEDIR)){
	define(BASEDIR, str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace("\\", '/', getcwd())));
}
if (!defined(TPLDIR)){
	define(TPLDIR, 'tpl/');
}

date_default_timezone_set('Europe/Helsinki');

if (!$_SESSION['cms']['menudisable']){ $_SESSION['cms']['menudisable'] = 0; }
if (!$_SESSION['cms']['message']){ $_SESSION['cms']['message'] = ''; }
if (!$_SESSION['cms']['fp']){ $_SESSION['cms']['fp'] = 'true'; }
if (!$_SESSION['cms']['fb']['path']){ $_SESSION['cms']['fb']['path'] = '../contents'; }
if (!$_SESSION['cms']['fb']['mode']){ $_SESSION['cms']['fb']['mode'] = 'filebrowser_l'; }
if (!$_SESSION['cms']['fb']['return']){ $_SESSION['cms']['fb']['return'] = ''; }
$usertypes = array(
	0  => 'Все',
	10 => 'Супер администратор',
	11 => 'Администратор',
	12 => 'Менеджер',
	20 => 'Публикатор',
	21 => 'Редактор',
	22 => 'Автор',
	23 => 'Зарегестрированый'
);

$rownums = explode(',', '5,10,15,20,25,30,50,all');
$demo = false;
// XAJAX
require_once ("xajax/xajax_core/xajax.inc.php");
$xajax = new xajax("/cms/bridge.php");
//$xajax->configure('debug', true);
//$xajax->configure('responseQueueSize', 200000);
$xajax->configure('javascript URI','/cms/xajax');
$xajax->setCharEncoding('UTF-8'); 
$xajax->configure("decodeUTF8Input", true);

//  Подключение к БД
if (@fopen('db.php', 'r')){
	require ('db.php');
	@mysql_connect($cms_config_host, $cms_config_user, $cms_config_password);
	mysql_select_db($cms_config_db);
	mysql_query('SET NAMES utf8');
	//setlocale (LC_TIME, $cms_config_locale);
}
//	Раздел управления РНР
Error_Reporting(E_ALL & ~E_NOTICE);
//Error_Reporting(E_ALL);

//	Парсинг URL
$url = $_SERVER['REQUEST_URI'];
// убираем слэши из начала и конца адреса
if(stripos($url, '/') == 0){$url = substr($url, 1, strlen($url));}
if(stripos($url, '/') == strlen($url)-1){$url = substr($url, 0, strlen($url)-1);}
$url_query = explode("/", $url);

include ('modules/core/core_tpl.php');
include ('modules/core/core_xml.php');
include ('modules/core/core.php');
?>