<?php
require('configuration.php');

function page(){
	global $url_query, $core, $xajax;
	
	ob_start();
	$xajax->printJavascript();
	$r['{#head#}'] = ob_get_contents();
	ob_end_clean();
	$users = new users2();
	
	$tpl = new core_tpl();
	$r['{#head#}'] .= $core->head();
	$r['{#basedir#}'] = BASEDIR;
	
	if ($_SESSION['cms']['authorized']==1 && @fopen('db.php', 'r') && $_COOKIE['cms_data']['sess_id'] == session_id() && $users->get_logged($_COOKIE['cms_data']['user_id'])){
		setcookie('cms_data[redirect]', '', time()+86400);
		if ($url_query[1]){
			$_SESSION['cms']['fp'] = 'false';
			$mod = new $url_query[1];
			$return['{#mainframe#}'] = $mod->page($url_query);
			$r['{#head#}'] .= $mod->head();
		}
		elseif (!$url_query[1]){
			$_SESSION['cms']['fp'] = 'true';
			$fp['{#fp#}'] = $core->fp_menu();
			$fp['{#users#}'] = $users->_list();
			$return['{#mainframe#}'] = $tpl->assign(TPLDIR.'fp.tpl', $fp);
		}
		$return['{#topmenu#}'] = $core->gen_top_menu($core->get_top_menu(), 0);
		$return['{#basedir#}'] = BASEDIR;
		$r['{#page#}'] = $tpl->assign(TPLDIR.'layout2.tpl', $return);
	}else{
		$_SESSION['cms']['redirect'] = '/'.implode('/', $url_query);
		setcookie('cms_data[redirect]', '/'.implode('/', $url_query), time()+86400);
		$r['{#page#}'] = '';
	}
	return $tpl->assign(TPLDIR.'layout.tpl', $r);
}

$xajax->register(XAJAX_FUNCTION,"exe");
function exe($module, $event, $data = NULL){
	$response = new xajaxResponse();
	$users = new users2();
	if ($_SESSION['cms']['authorized']==1 && @fopen('db.php', 'r') && $_COOKIE['cms_data']['sess_id'] == session_id() && $users->get_logged($_COOKIE['cms_data']['user_id'])){
		$mod = new $module;
		$return = ($data) ? $mod->$event($data) : $mod->$event();
	}else{
		if ($module != 'core'){
			$mod = new core();
			$return = $mod->page();
		}else{
			$mod = new $module;
			$return = ($data) ? $mod->$event($data) : $mod->$event();
		}
	}
	foreach ($return as $i){
		if     ($i[0]=='assign')   { $response->assign($i[1], $i[2], $i[3]); }
		elseif ($i[0]=='sleep')    { $response->sleep($i[1]); }
		elseif ($i[0]=='redirect') { $response->redirect($i[1]); }
		elseif ($i[0]=='alert')    { $response->alert($i[1]); }
		elseif ($i[0]=='call')     { ($i[2]) ? $response->call($i[1],$i[2]) : $response->call($i[1]); }
	}
	return $response;
}

$xajax->processRequest();
//echo '<pre>';print_r($_SESSION);echo '</pre>';
$ua = $_SERVER['HTTP_USER_AGENT'];
$tpl = new core_tpl();
if (stripos($ua, 'MSIE 6.0')!==false && stripos($ua, 'MSIE 8.0')===false && stripos($ua, 'MSIE 7.0')===false){
	echo $tpl->assign(TPLDIR.'ie6.tpl','{#basedir#}', BASEDIR);
}else{
	echo page();
}
?>