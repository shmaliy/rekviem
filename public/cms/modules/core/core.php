<?php
include 'core_fb.php';
function compile($name){
	if (is_dir('modules/'.$name) && $dir = opendir('modules/'.$name)){
		while (false !== ($file = readdir($dir))){
			if ($file == "." || $file == ".."){}
			elseif (is_dir('modules/'.$name.'/'.$file)){}
			elseif ($file == $name.'.php'){}
			elseif ($file == $name.'.php'){}
			elseif ($file == $name.'_c.php'){}
			elseif (substr(strtolower($file), -4) != '.php'){}
			elseif (substr(strtolower($file), -8) == '.css.php'){}
			else { $list[] = $file; }
		}
		closedir($dir);
	}
	if (count($list)>0){
		$f = fopen('modules/'.$name.'/'.$name.'_c.php', 'w+');
		$c[] = "<?php\nclass $name\n{";
		foreach ($list as $item){
			$s = @file_get_contents('modules/'.$name.'/'.$item);
			$s = str_replace("<?php",'',$s);
			$c[] = str_replace("?>",'',$s);
		}	
		$c[] = "}\n?>";
		fputs ($f, implode("\n", $c));
		fclose ($f);
	}
}
class core extends core_fb
{
	function __construct()
	{
		$this->tpl = new core_tpl();
		if (@fopen('db.php', 'r')){$this->_mod_init();}
	}
	
	function page(){
		if (!@fopen('db.php', 'r')){
			$p[] = 'width=500&height=365&title=Установка системы&close=false';
			$p[] = $this->tpl->assign(TPLDIR.'inst.tpl','{#basedir#}',BASEDIR);
			return array(array('call', 'modal.show', $p));
		}else{
			$users = new users2();
			if ($_SESSION['cms']['authorized'] != 1 and @fopen('db.php', 'r') or $users->get_logged($_COOKIE['cms_data']['user_id'])==false){
				$p[] = 'width=400&height=215&title=Авторизация&close=false';
				$p[] = $this->tpl->assign(TPLDIR.'auth.tpl','{#basedir#}',BASEDIR);
				return array(array('call', 'modal.show', $p));
			}else{return array(array('sleep', 1));}
		}
	}
	
	function calendar($reffield){
		$p[] = 'width=400&height=215&title=Выбор даты&close=true';
		$p[] = $this->tpl->assign(TPLDIR.'calendar.tpl');
		$return[] = array('call', 'modal.show', $p);
		$return[] = array('sleep', 10);
		$return[] = array('call', 'calendar.init', $reffield);
		return $return;
	}
	
	function timestamp_to_datetime($data){ return date('Y-m-d H:i:s', $data); }
	
	function datetime_to_timestamp($data){
		$datetime = explode(' ', $data);
		$date =  explode('-', $datetime[0]); $time =  explode(':', $datetime[1]);
		return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
	}
	
	function get_top_menu(){
		$topmenu[] = array('text' => 'Главная', 'url' => BASEDIR, 'icon16' => 'icon-16-cpanel', 'level' => 30, 'childs' => '');
		$topmenu[] = array('name' => 'media', 'text' => 'Медиа менеджер', 'url' => 'javascript:tinyBrowserPopUp(\'file\',\'null\'); void(0);', 'icon16' => 'icon-16-cpanel', 'level' => 30, 'childs' => '');
		if ($modules = $this->_mod_get_installed()){
			foreach ($modules as $module){
				$m_info = $this->_mod_get_info($module);
				$g = 0;
				foreach ($modules as $m){
					$m_i = $this->_mod_get_info($m);
					if ($m_info['MODULE']['GROUP']['#val'] == $m_i['MODULE']['GROUP']['#val']){
						$g++;
					}
				}
				if ($g == 1){
					$topmenu[] = array(
						'name' => $module, 
						'text' => $m_info['MODULE']['SHORTNAME']['#val'], 
						'url' => BASEDIR.'/'.$module, 
						'icon16' => $m_info['MODULE']['ICON16']['#val'], 
						'icon48' => $m_info['MODULE']['ICON48']['#val'], 
						'order' => $m_info['MODULE']['ORDERING']['#val'],
						'level' => $m_info['MODULE']['ACESSLEVEL']['#val'],
						'childs' => ''
					);
				}else{
					$e=0; $k='';
					foreach ($topmenu as $key => $item){
						if ($m_info['MODULE']['GROUP']['#val'] == $item['url']){
							$e++; $k=$key;
						}
					}
					if ($e==0){
						$topmenu[] = array(
							'name' => $module, 
							'text' => $m_info['MODULE']['GROUPNAME']['#val'], 
							'url' => $m_info['MODULE']['GROUP']['#val'], 
							'icon16' => $m_info['MODULE']['GROUPICON16']['#val'], 
							'icon48' => $m_info['MODULE']['GROUPICON48']['#val'], 
							'order' => $m_info['MODULE']['ORDERING']['#val'],
							'level' => $m_info['MODULE']['ACESSLEVEL']['#val'],
							'childs' => array(
								0 => array(
									'name' => $module, 
									'text' => $m_info['MODULE']['SHORTNAME']['#val'], 
									'url' => BASEDIR.'/'.$module, 
									'icon16' => $m_info['MODULE']['ICON16']['#val'], 
									'icon48' => $m_info['MODULE']['ICON48']['#val'], 
									'order' => $m_info['MODULE']['ORDERING']['#val'],
									'level' => $m_info['MODULE']['ACESSLEVEL']['#val'],
									'childs' => ''
								)
							)
						);
					}elseif ($k != ''){
						$topmenu[$k]['childs'][] = array(
							'name' => $module, 
							'text' => $m_info['MODULE']['SHORTNAME']['#val'], 
							'url' => BASEDIR.'/'.$module, 
							'icon16' => $m_info['MODULE']['ICON16']['#val'], 
							'icon48' => $m_info['MODULE']['ICON48']['#val'], 
							'order' => $m_info['MODULE']['ORDERING']['#val'],
							'level' => $m_info['MODULE']['ACESSLEVEL']['#val'],
							'childs' => ''
						);
						uasort($topmenu[$k]['childs'], array($this, '_cmp'));
					}
				}
				uasort($topmenu, array($this, '_cmp'));
			}
		}
		$topmenu[] =  array('text' => 'Выход из системы', 'url' => "javascript:call('users2','_logout','".$_SESSION['cms']['user_id']."');", 'icon16' => 'icon-16-logout', 'level' => 30, 'childs' => '');

		return $topmenu;
	}
	
	function gen_top_menu($topmenu, $level){
		$class = ($_SESSION['cms']['menudisable'] == 0) ? '' : ' class="disabled"';
		$menu = ($level == 0) ? '<ul class="menu" id="menu">' : '<ul>';
		($level == 0) ? $last = array_pop($topmenu) : $topmenu;
		$m = $topmenu;
		array_pop($topmenu);
		$m2 = $topmenu;		
		
		foreach ($m as $v){
			if ($_SESSION['cms']['usertype'] < $v['level']){
				$menu .= '<li'.$class.'><a ';
				if (file_exists('images/menu/'.$v['icon16'].'.png')){
					$menu .= 'class="'.$v['icon16'].'"';
				}else{
					$menu .= 'style="background:url('.BASEDIR.'/modules/'.$v['name'].'/'.$v['icon16'].'.png);"';
				}
				if (!stristr($v['url'],'/') and $v['name'] != 'media' || $_SESSION['cms']['menudisable'] == 1){
					$menu .= '>'.$v['text'].'</a>';
				}else{
					$menu .= ' href="'.$v['url'].'">'.$v['text'].'</a>';
				}
				$menu .= ($v['childs'] != '') ? $this->gen_top_menu($v['childs'], $level+1) : '';
				$menu .= '</li>';
			}		
		}
		$menu .= '</ul>';
		
		if ($level == 0){
			$menu .= '<ul class="menu"><li'.$class.' style="float:right;"><a class="'.$last['icon16'].'"';
			if ($_SESSION['cms']['menudisable'] == 0){
				$menu .= ' href="'.$last['url'].'"';
			}
			$menu .= '>'.$last['text'].'</a></li></ul>';
		}
		return $menu;
	}
	
	function _cmp($a, $b){ return (strcmp (strtolower($a['order']), strtolower($b['order']))); }
	
	function fp_menu(){
		$tpl = new core_tpl();
		if ($modules = $this->_mod_get_installed()){
			foreach ($modules as $module){
				$m_info = $this->_mod_get_info($module);
				$topmenu[] = array(
					'name' => $module, 
					'text' => $m_info['MODULE']['SHORTNAME']['#val'], 
					'url' => BASEDIR.'/'.$module, 
					'icon16' => $m_info['MODULE']['ICON16']['#val'], 
					'icon48' => $m_info['MODULE']['ICON48']['#val'], 
					'order' => $m_info['MODULE']['ORDERING']['#val'],
					'level' => $m_info['MODULE']['ACESSLEVEL']['#val'],
					'childs' => ''
				);
			}
		}
		uasort($topmenu, array($this, '_cmp'));
		if ($topmenu){
			foreach ($topmenu as $item){
				$i = array();
				$i['{#link#}'] = 'href="'.$item['url'].'"';
				$i['{#text#}'] = $item['text'];
				if (file_exists('images/header/'.$item['icon48'].'.png')){
					$i['{#image#}'] = BASEDIR.'/images/header/'.$item['icon48'].'.png';
				}elseif (file_exists('modules/'.$item['name'].'/'.$item['icon48'].'.png')){
					$i['{#image#}'] = BASEDIR.'/modules/'.$item['name'].'/'.$item['icon48'].'.png';
				}
				$i['{#childs#}'] = '';
				$return .= $tpl->assign(TPLDIR.'fp_menu_i.tpl', $i);
			}
		}
		return $return;
	}
	
	function toolbar($array){
		if (is_array($array)){
			$bar['{#title#}'] = $array['title'];
			$bar['{#icon#}'] = $array['icon'];
			if (is_array($array['buttons'])){
				foreach ($array['buttons'] as $button){
					if ($_SESSION['cms']['usertype'] < $button[3]){
						$b['{#icon#}'] = $button[0];
						$b['{#title#}'] = $button[1];
						$b['{#func#}'] = (stripos($button[2], '/') != 0) ? $button[2] : 'javascript:'.$button[2];
						$bar['{#items#}'] .= $this->tpl->assign(TPLDIR.'toolbar_btn.tpl', $b);
					}
				}
			}else{
				$bar['{#items#}'] = '';
			}
			return $this->tpl->assign(TPLDIR.'toolbar.tpl',$bar);
		}else{
			return false;
		}
	}
	
	function head(){
		$head = '<script src="'.BASEDIR.'/js/bridge.js" language="javascript"></script>'."\n";
		$head .= '<link href="'.BASEDIR.'/css/theme.css.php" rel="stylesheet" type="text/css" />'."\n";
		$head .= '<script language="javascript" type="text/javascript" src="'.BASEDIR.'/js/tiny_mce/plugins/tinybrowser/tb_standalone.js.php"></script>';
		$head .= '<script type="text/javascript" src="'.BASEDIR.'/js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>';
		$head .= '<script type="text/javascript" src="'.BASEDIR.'/swf/swfupload/swfupload.js"></script>'."\n";
		$head .= '<script type="text/javascript" src="'.BASEDIR.'/swf/swfupload/swfupload.swfobject.js"></script>'."\n";
		$head .= '<script type="text/javascript" src="'.BASEDIR.'/swf/swfupload/swfupload.queue.js"></script>'."\n";
		$head .= '<script type="text/javascript" src="'.BASEDIR.'/swf/swfupload/fileprogress.js"></script>'."\n";
		$head .= '<script type="text/javascript" src="'.BASEDIR.'/swf/swfupload/handlers.js"></script>'."\n";
		$head .= '<link href="'.BASEDIR.'/swf/swfupload/default.css" rel="stylesheet" type="text/css" />';
		return $head;
	}
	
	function navigator($m){
		$rows = $GLOBALS['rownums'];
		$c = $_SESSION['cms']['mod'][$m]['page'];
		$r = $_SESSION['cms']['mod'][$m]['rnum'];
		$p = $_SESSION['cms']['mod'][$m]['parent'];
		$mod = new $m;
		$t = ($p == 0) ? count($mod->get_list()) : count($mod->get_list($p));
		foreach($rows as $row){
			$n = ($row=='all') ? '0' : $row;
			$tx = ($row=='all') ? 'Все' : $row;
			$rn .= ($row=='all'&&$r=='0'||$row==$r)?'<option value="'.$n.'" selected="selected">'.$tx.'</option>':'<option value="'.$n.'">'.$tx.'</option>';
		}
		$pages = ($r != 0) ? ($t/$r > floor($t/$r)) ? floor($t/$r)+1 : $t/$r : 1;
		for($i=1; $i<=$pages; $i++){
			$pgs .= ($i == $c) ? '<a class="page_c">'.$i.'</a>' : '<a href="javascript:call(\''.$m.'\', \'_setp\', '.$i.');" class="page_n">'.$i.'</a>';
		}
		$first = ($c==1) ? '<a class="page_l">Начало</a>' : '<a href="javascript:call(\''.$m.'\', \'_setp\', 1);" class="page_l">Начало</a>';
		$last = ($c==$pages) ? '<a class="page_r">Конец</a>' : '<a href="javascript:call(\''.$m.'\', \'_setp\', '.$pages.');" class="page_r">Конец</a>';
		$rows = '<select id="rnum" onChange="call(\''.$m.'\', \'_setr\', this.value);">'.$rn.'</select>';
		return 'Количество строк:'.$rows.$first.$pgs.$last;
	}
	
	function installation($data){
		$data = $this->prepare_form_data($data);
		$return = array();
		$connect = @mysql_connect($data['inst']['dbhost'],$data['inst']['dbuser'],$data['inst']['dbpassword']);
		if (!$connect){
			$return[] = array('assign', 'inst_stat', 'innerHTML', '<font color="#FF0000">Невозможно подключится к серверу MySQL</font>');
		}else{
			$file = fopen("db.php","w+");
			$str  = "<?php \n";
			$str .='$cms_config_host = \''.$data['inst']['dbhost']."';\n"; 
			$str .='$cms_config_user = \''.$data['inst']['dbuser']."';\n"; 
			$str .='$cms_config_password = \''.$data['inst']['dbpassword']."';\n"; 
			$str .='$cms_config_db = \''.$data['inst']['dbname']."';\n"; 
			$str .='$cms_config_dbprefix = \''.$data['inst']['dbprefix']."';\n";
			$str .='?>';
		    fputs ($file, $str);
		  	fclose ($file);
			
			$return[] = array('assign', 'inst_stat', 'innerHTML', '<font color="#0066FF">Конфигурация сохранена</font>');
			$return[] = array('sleep', '10');
			
		  	if (!@mysql_select_db($data['inst']['dbname'])){
				$return[] = array('assign', 'inst_stat', 'innerHTML', '<font color="#FF0000">БД нет подключения</font>');
			}else{
				$users = new users2();
				$users->tbl = $data['inst']['dbprefix'].'users';
				$users->tbl2 = $data['inst']['dbprefix'].'session';
				$users->c_db(true);
				$sql['login'] = $data['inst']['login'];
				$sql['usertype'] = 10;
				$sql['block'] = 0;
				$sql['password'] = md5($data['inst']['password']);
				$sql['email'] = $data['inst']['email'];
				$sql['register_date'] = date('Y-m-d H:i:s');
				if ($users->insert($sql)){				        
					$return[] = array('assign', 'inst_stat', 'innerHTML', '<font color="#0066FF">Установка прошла успешно</font>');
					$return[] = array('sleep', '10');
					$return[] = array('redirect', BASEDIR."/");
				}else{
					$return[] = array('assign', 'inst_stat', 'innerHTML', '<font color="#FF0000">Ошибка инициализации</font>');
				}
			}
		}
		return $return;		
	}
	
	function prepare_form_data($array){
		if (count($array)==2 && !is_array($array[0])){
			$a[$array[0]] = $this->prepare_form_data($array[1]);
		}else{
			foreach($array as $k=>$v){if(is_array($v)){$a[$v[0]] = $v[1];}}
		}
		return $a;
	}
	
	function prepare_sql_data($array){
		foreach ($array as $k=>$v){
			$array[$k] = mysql_escape_string($v);
		}
		return $array;
	}
	
	function _mes(){
		if ($_SESSION['cms']['message'] != ''){
			$mes = $_SESSION['cms']['message'];
			$_SESSION['cms']['message'] = '';
			return array(array('call', 'message', $mes));
		}else{
			return array(array('sleep', 1));
		}
	}
	
	function _upload($field){
		$users = new users2();
		if ($_SESSION['cms']['authorized'] != 1 and @fopen('db.php', 'r') or $users->get_logged($_COOKIE['cms_data']['user_id'])==false){
			return $this->page();
		}else{
			$_SESSION['cms']['fb']['return'] = $field;
			$p[] = 'width=600&height=405&title=Менеджер файлов&close=true';
			$p[] = $this->fb_build();
			$return[] = array('call', 'modal.show', $p);
			$return[] = array('sleep', 10);
			$return[] = array('call', 'swfup');
			return $return;
		}
	}
	
	function authorization($data){
		$users = new users2();
		$data = $this->prepare_form_data($data);
		$login = $data['auth']['login'];
		$password = md5($data['auth']['password']);
		
		$user = $users->get_authorized("$login", "$password");
		if ($user){
			if ($user['usertype'] > 19){
				return array(array('assign', 'auth_stat', 'innerHTML', '<font color="#FF0000">Доступ запрещен</font>'));
			}
			elseif ($user['block'] == '0'){
	  			if (!$users->set_logged($user['id'])){
	  				return array(array('assign', 'auth_stat', 'innerHTML', '<font color="#FF0000">Ошибка установки статуса</font>'));
	  			}else{
					$_SESSION['cms']['authorized'] = 1;
					$_SESSION['cms']['usertype'] = $user['usertype'];
					$_SESSION['cms']['user_id'] = $user['id'];
				
					$d = getdate();
		  			$users->update_e('lastvizit_date', $d['year'].'-'.$d['mon'].'-'.$d['mday'].' '.$d['hours'].':'.$d['minutes'].':'.$d['seconds'],$user['id']);
	
		  			$stat = ($GLOBALS['demo'] == true) ? '<br />ДЕМО РЕЖИМ' : '';
		  			$stat = '<font color="#0066FF">Авторизация прошла успешно'.$stat.'</font>';
		  			$return[] = array('assign', 'auth_stat', 'innerHTML', $stat);
					$return[] = array('sleep', 10);
					$return[] = array('call', 'modal.hide');
		  			
					if ($_COOKIE['cms_data']['redirect'] != ''){				
						$return[] = array('sleep', 10);
						$return[] = array('redirect', $_COOKIE['cms_data']['redirect']);
					}
									
					setcookie('cms_data[user_id]', $user['id'], time()+86400);
			  		setcookie('cms_data[sess_id]', session_id(), time()+86400);
	  			}
			}
			elseif ($user['block'] == '1'){
				$_SESSION['cms']['authorized'] = 0;
				session_destroy();
				$return[] = array('assign', 'auth_stat', 'innerHTML', '<font color="#FF0000">Ваш акаунт заблокирован</font>');
			}
		}else{ 
			$_SESSION['cms']['authorized'] = 0;
			session_destroy();
			$return[] = array('assign', 'auth_stat', 'innerHTML', '<font color="#FF0000">Ошибка Авторизаци</font>');
		}
		return $return;
	}
}
$core = new core();
include_once 'includes.php';
?>