<?php
class users2
{

	function __construct(){
		$this->name = 'users2';
		$this->core = new core();
		$this->info = $this->core->_mod_get_info($this->name);
		$this->tbl = $GLOBALS['cms_config_dbprefix'].'users';
		$this->tbl2 = $GLOBALS['cms_config_dbprefix'].'session';
		$this->c_db();
		if (!$_SESSION['cms']['mod'][$this->name] && $_SESSION['cms']['authorized'] == 1){
			$_SESSION['cms']['mod'][$this->name] = array('rnum' => 20, 'page' => 1, 'parent' => 0);
		}
	}


	function c_db($init = NULL){
		if (isset($GLOBALS['cms_config_dbprefix']) || isset($init) && $init == true){
			$query  = "CREATE TABLE IF NOT EXISTS `$this->tbl` ( ";
			$query .= "`id` INT NOT NULL AUTO_INCREMENT, ";
			$query .= "`checked_out` INT NOT NULL, ";
			$query .= "`checked_out_time` DATETIME NOT NULL, ";
			$query .= "`name` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`login` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`email` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`password` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`usertype` INT NOT NULL, ";
			$query .= "`block` INT NOT NULL, ";
			$query .= "`register_date` DATETIME NOT NULL, ";
			$query .= "`lastvizit_date` DATETIME NOT NULL, ";
			$query .= "`image` TEXT NOT NULL, ";
			$query .= "`param1` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param2` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param3` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param4` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param5` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param6` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param7` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param8` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param9` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param10` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param11` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param12` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param13` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param14` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param15` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param16` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param17` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param18` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param19` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param20` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "PRIMARY KEY (`id`)); ";
			if (!@mysql_query($query)){ /*core::set_error("$this->name::c_db");*/ }
			
			$query  = "CREATE TABLE IF NOT EXISTS `$this->tbl2` ( ";
			$query .= "`user_id` INT NOT NULL, ";
			$query .= "`session_id` VARCHAR( 200 ) NOT NULL, ";
			$query .= "PRIMARY KEY (`session_id`));";
			if (!@mysql_query($query)){ /*core::set_error("$this->name::c_db");*/ }
		}
	}


	function delete($id){
		if (@mysql_query("DELETE FROM `$this->mod_tablename` WHERE `id` = $id LIMIT 1")){return true;}
		else return false;
	}


	function get($id, $f = NULL){
		$q = "SELECT * FROM `$this->tbl` WHERE `id` = $id LIMIT 1";
		$r = @mysql_query($q);
		if ($r && @mysql_num_rows($r)>0){
			if (isset($f) && $f != ''){ $d = mysql_fetch_assoc($r); return $d[$f]; }
			else { return mysql_fetch_assoc($r); }
		}else return false;
	}


	function get_authorized($login, $password){
		$user = @mysql_query("SELECT * FROM `$this->tbl` WHERE `login` = '$login' AND `password` = '$password' LIMIT 1");
		if (@mysql_num_rows($user)>0){return mysql_fetch_assoc($user);}
		else return false;
	}


	function get_list($p = NULL, $lim = NULL, $advf = NULL){
		$q = "SELECT * FROM `$this->tbl`";
		if (isset($p)){
			$q .= " WHERE `usertype` = $p";
		}else{ $q .= ""; }
		if (isset($advf) && is_array($advf)){
			$q .= " AND ";
			foreach ($advf as $f => $v){
				$a[] = ($v/2 == 0) ? "`$f` = '$v'" : "`$f` = $v";
			}
			$q .= implode(" AND ", $a);
		}
		$q .= " ORDER BY `login` asc";
		$q .= (isset($lim) && $lim != '') ? " LIMIT $lim" : '';
		$r = @mysql_query($q);
		if ($r && @mysql_num_rows($r)>0){
			while ($row = mysql_fetch_assoc($r)){
				$d[] = $row;
			}
			return $d;
		}else return false;
	}


	function get_logged($id){
		$session = @mysql_query("SELECT * FROM `$this->tbl2` WHERE `user_id` = '$id' LIMIT 1");
		return (mysql_num_rows($session) != 0) ? true : false;
	}


	function insert($d){
		$d = $this->prep_sql($d);
		if (@mysql_query("INSERT INTO `$this->tbl` SET $d")){ return true; }
		else return false;
	}


	function prep_sql($d){
		foreach ($d as $f => $v){
			if($f != 'id'){ $d2[] = "`$f` = '".@mysql_real_escape_string($v)."'"; }
		}
		return implode(', ', $d2);
	}


	function set_logged($id){
		$session = @mysql_query("SELECT * FROM `$this->tbl2` WHERE `user_id` = $id");
		$session_id = session_id();
		if (mysql_num_rows($session)==0){
			if(@mysql_query("INSERT INTO `$this->tbl2` SET `session_id` = '$session_id', `user_id` = '$id'")){return true;}
			else return false;
		}
		elseif (mysql_num_rows($session)==1){
			if(@mysql_query("UPDATE `$this->tbl2` SET `session_id` = '$session_id' WHERE `user_id` = '$id'")){return true;}
			else return false;
		}
		elseif (mysql_num_rows($session)>1){
			if(@mysql_query("DELETE FROM `$this->tbl2` WHERE `user_id` = '$id'")){ $st = 1; }
			else $st = 0;
			if ($st == 1){
				if(@mysql_query("INSERT INTO `$this->tbl2` SET `session_id` = '$session_id', `user_id` = '$id'")){return true;}
				else return false;
			}else return false;			
		}else return false;
	}	


	function set_unlogged($id){
		if(@mysql_query("DELETE FROM `$this->tbl2` WHERE `user_id` = '$id'")){return true;}
		else return false;
	}	


	function update($d, $id){
		$d = $this->prep_sql($d);
		if (@mysql_query("UPDATE `$this->tbl` SET $d WHERE `id` = $id LIMIT 1")){
			return true;
		}else return false;
	}


	function update_e($f, $v, $id){
		if (@mysql_query("UPDATE `$this->tbl` SET `$f` = '".@mysql_real_escape_string($v)."' WHERE `id` = $id LIMIT 1")){ return true; }
		else return false;
	}


	function editor($id){
		$params = (class_exists('params', false)) ? new params() : false;
		$o['{#name#}'] = $this->name;
		$o['{#id#}'] = $id;
		if ($id != 'new'){
			$user = $this->get($id);
			$o['{#image#}'] = ($user['image'] != '') ? BASEDIR."/image.php?image=../".substr($user['image'],1,strlen($user['image']))."&mode=square_fit&p1=100" : BASEDIR.'/images/blank.png';
			$o['{#imagepath#}'] = $user['image'];
			$o['{#login#}'] = $user['login'];
			$o['{#username#}'] = $user['name'];
			$o['{#email#}'] = $user['email'];
			$o['{#block#}'] = ($user['block'] == 0) ? '' : ' checked';
			$o['{#usertype#}'] = $this->tree(0,0,$user['usertype']);
			$o['{#p#}'] = 'П';
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name, $user) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name, $user) : '';
		}else{
			$o['{#image#}'] = BASEDIR.'/images/blank.png';
			$o['{#imagepath#}'] = '';
			$o['{#login#}'] = '';
			$o['{#username#}'] = '';
			$o['{#email#}'] = '';
			$o['{#block#}'] = '';
			$o['{#usertype#}'] = $this->tree(0,0,0);
			$o['{#p#}'] = 'Новый п';
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name) : '';
		}
		$_SESSION['cms']['menudisable']=1;
		return $this->core->tpl->assign("modules/$this->name/tpl/editor.tpl", $o);
	}


	function head(){
		$return  = '<link href="'.BASEDIR.'/modules/'.$this->name.'/'.$this->name.'.css.php" rel="stylesheet" type="text/css" />'."\n";
		global $url_query;
		if (count($url_query)>2){
			$return .= '<script type="text/javascript" src="'.BASEDIR.'/js/tiny_mce/tiny_mce.js"></script>'."\n";
			$return .= '<script type="text/javascript" src="'.BASEDIR.'/js/tiny_mce_init.js"></script>'."\n";
		}
		return $return;
	}


	function table(){
		$_SESSION['cms']['menudisable'] = 0;
		$params = (class_exists('params', false)) ? new params() : false;
		
		$m = $_SESSION['cms']['mod'][$this->name];
		$mr = $m['rnum'];
		$mp = $m['page'];
		$p = $m['parent'];
		$lim = ($mr != 0) ? $mr*$mp-$mr.', '.$mr : '';
		$list = ($p != 0) ? $this->get_list($p, $lim) : $this->get_list(NULL, $lim);
		if ($list){
			$c=0;
			foreach ($list as $i){
				foreach ($i as $f => $v){ $r["{#$f#}"] = $v; }
				$r['{#title#}'] = ($i['name'] != '') ? $i['name'].' ( '.$i['login'].' )' : $i['login'];
				$r['{#block#}'] = ($i['block']==0) ? '<img src="'.BASEDIR.'/images/adm/tick.png" />' : '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
				if ($i['checked_out'] == 0){
					$r['{#checked_out#}'] = '<input name="'.$i['id'].'" type="checkbox"></td>';
					$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
					$r['{#block#}'] = '<a href="' . "javascript:call('$this->name', '_block', '" . $i['id'] . '\');">'.$r['{#block#}'].'</a>';
				}else{
					$r['{#checked_out#}'] = '<img src="'.BASEDIR.'/images/adm/checked_out.png" />';
					if ($i['checked_out'] == $_SESSION['cms']['user_id']){
						$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
						$r['{#block#}'] = '<a href="' . "javascript:call('$this->name', '_block', '" . $i['id'] . '\');">'.$r['{#block#}'].'</a>';
					}
				}
				$r['{#usertype#}'] = $GLOBALS['usertypes'][$i['usertype']];
				$r['{#logged#}'] = ($this->get_logged($i['id'])) ? '<img src="'.BASEDIR.'/images/adm/tick.png" />' : '';
				$r['{#adv_fields#}'] = ($params) ? $params->adv_row($this->name, $i) : '';
				$o['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_row.tpl", $r);
				$c++;
			}
		}else { $o['{#items#}'] = '<tr><td colspan="30">Пусто</td></tr>'; }
		$o['{#basedir#}'] = BASEDIR;
		$o['{#name#}'] = $this->name;
		$o['{#navigator#}'] = $this->_navigator();
		$o['{#adv_fields#}'] = ($params != false) ? $params->adv_head($this->name) : '';
		$o['{#tree#}'] = $this->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
		return $this->core->tpl->assign("modules/$this->name/tpl/table.tpl", $o);
	}


	function _toolbar($mode, $id = NULL){
		if ($mode == 'list'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-cancel.png', 'Разлогинить', "call('$this->name', '_logout', ['all', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-publish.png', 'Разблокировать', "call('$this->name', '_block', ['false', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-unpublish.png', 'Заблокировать', "call('$this->name', '_block', ['true', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-delete.png', 'Удалить', "call('$this->name', '_del', 'confirmed');", 12),
					array(BASEDIR.'/images/toolbar/icon-32-adduser.png', 'Создать', "call('$this->name', '_new');", 12)
				)
			);
		}
		elseif ($mode == 'new'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-save.png', 'Сохранить', "call('$this->name', '_save', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-apply.png', 'Применить', "call('$this->name', '_apply', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-cancel.png', 'Отмена', "call('$this->name', '_cancel', 'new');", 13)
				)
			);
		}
		elseif ($mode == 'edit'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-save.png', 'Сохранить', "call('$this->name', '_save', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-apply.png', 'Применить', "call('$this->name', '_apply', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-lock.png', 'Блокировать', "call('$this->name', '_lock');", 13),
					array(BASEDIR.'/images/toolbar/icon-32-cancel.png', 'Отмена', "call('$this->name', '_cancel', '$id');", 13)
				)
			);
		}
		return ($buttons) ? $this->core->toolbar($buttons) : false;
	}


	function tree($p, $l, $s){
		$list = $GLOBALS['usertypes'];
		if ($list){
			foreach ($list as $key => $item){
				$o .= '<option value="'.$key.'"';
				$o .= ($s == $key) ? ' selected="selected"' : '';
				$o .= '>'.$item.'</option>';
			}
		}
		return $o;
	}


	function _list(){
		$m = $_SESSION['cms']['mod'][$this->name];
		$limit = ($m['rnum'] != 0) ? $m['rnum']*$m['page']-$m['rnum'].', '.$m['rnum'] : '';
		$usertype = ($m['parent'] != 0) ? $m['parent'] : '';
		$list = $this->get_list();
		if ($list){
			foreach($list as $item){
				$o['{#id#}'] = $item['id'];
				$o['{#title#}'] = ($item['name'] != '')?$item['name'].' ( '.$item['login'].' )': $item['login'];
				$o['{#logout#}'] = '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
				
				if ($item['checked_out'] == 0){
					$o['{#checked_out#}'] = '<input name="'.$item['id'].'" type="checkbox"></td>';
					$o['{#title#}'] = ($_SESSION['cms']['fp'] == 'false')?'<a href="' . "javascript:call('$this->name', '_edit', '" . $item['id'] . '\');">'.$o['{#title#}'].'</a>':$o['{#title#}'];
					$o['{#logout#}'] = '<a href="' . "javascript:call('$this->name', '_logout', '" . $item['id'] . '\');">'.$o['{#logout#}'].'</a>';
				}else{
					$o['{#checked_out#}'] = '<img src="'.BASEDIR.'/images/adm/checked_out.png" />';
					if ($item['checked_out'] == $_SESSION['cms']['user_id']){
						$o['{#title#}'] = ($_SESSION['cms']['fp'] == 'false')?'<a href="' . "javascript:call('$this->name', '_edit', '" . $item['id'] . '\');">'.$o['{#title#}'].'</a>':$o['{#title#}'];
						$o['{#logout#}'] = '<a href="' . "javascript:call('$this->name', '_logout', '" . $item['id'] . '\');">'.$o['{#logout#}'].'</a>';
					}
				}
				$o['{#usertype#}'] = $GLOBALS['usertypes'][$item['usertype']];
				if ($_SESSION['cms']['fp'] == 'true' && $this->get_logged($item['id'])){
					$out .= $this->core->tpl->assign("modules/$this->name/tpl/table_fp.tpl", $o);
				}
			}
			return $out;
		}
		else return '<tr><td colspan="9">Пусто</td></tr>';		
	}


	function page(){
		global $url_query;
		if (count($url_query)==2){
			return $this->_toolbar('list').'<div class="list" id="'.$this->name.'_table">'.$this->table().'</div>';
		}
		elseif (count($url_query)==3 && $url_query[2] == 'new'){
			return $this->_toolbar('new').$this->editor($url_query[2]);
		}
		elseif (count($url_query)==3 && $url_query[2] != 'new'){
			return $this->_toolbar('edit', $url_query[2]).$this->editor($url_query[2]);
		}
	}


	function _apply($data){
		$data = $this->_prep_f($data);
		$return = $this->_save_data($data);
		if ($return == 'true'){
			$return = array();
			if ($data[$this->name]['db_id'] == 'new'){
				$_SESSION['cms']['message'] = 'Информация сохранена';
				$return[] = array('redirect', BASEDIR."/".$this->name."/".mysql_insert_id());
			}else{
				$return[] = array('call', 'message', "Информация сохранена");
			}
		}
		return $return;
	}


	function _block($id){
		if (is_array($id)){
			if ($id[1] == 'null'){return array(array('call', 'message', "Не выбран не один элемент"));}
			else{
				$errors = array();
				$to = ($id[0] == 'true') ? '1' : '0';
				$mes = ($id[0] == 'true') ? "Элементы заблокированы" : "Элементы разблокированы";
				foreach ($id[1] as $ids){
					if (!$this->update_e('block', $to, $ids)){$errors[] = $ids;}
				}
				if (count($errors)==0){
					$return[] = array('assign', $this->name.'_table', 'innerHTML', $this->table());
					$return[] = array('call', 'message', $mes);
					return $return;
				}
				else return array(array('call', 'message', "Ошибка обработки ID: ".implode(', ', $errors)));
			}
		}else{
			$published = $this->get($id, 'block');
			if ($published == '1'){ $this->update_e('block', '0', $id); }
			else{ $this->update_e('block', '1', $id); }
			return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
		}
	}


	function _cancel($id){
		if ($id != 'new'){ $this->_check_out($id, 'false'); }
		return array(array('redirect', BASEDIR."/".$this->name));
	}


	function _check_out($id, $toggle){
		if ($toggle == 'true'){	
			$c_out = $_SESSION['cms']['user_id'];
			$this->update_e('checked_out', $c_out, $id);
			$this->update_e('checked_out_time', date('Y-m-d H:i:s'), $id);
		}else{
			$this->update_e('checked_out', '0', $id);
			$this->update_e('checked_out_time', '0000-00-00 00:00:00', $id);
		}
	}


	function _edit($id){
		if ($id != 'new'){ $this->_check_out($id, 'true'); }
		return array(array('redirect', BASEDIR."/".$this->name."/$id"));
	}


	function _lock(){ return array(array('redirect', BASEDIR."/".$this->name)); }


	function _logout($id){
		if (is_array($id)){
			if ($id[1] == 'null'){return array(array('call', 'message', "Не выбран не один элемент"));}
			else{
				$errors = array();
				foreach ($id[1] as $ids){
					if ($this->set_unlogged($ids)){
						if ($_SESSION['cms']['user_id'] == $ids){
							$_SESSION['cms']['authorized'] = 0;
							session_destroy();							
							$redirect = true;
						}
					}
					else {$errors[] = $ids;}
				}
				if (count($errors)==0){
					$return[] = array('call', 'message', "Пользователи разлогинены");
					if ($redirect){
						$return[] = array('sleep', 10);
						$return[] = array('redirect', BASEDIR);
					}else{
						$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
					}
					return $return;
				}
				else return array(array('call', 'message', "Ошибка обработки пользователей ID: ".implode(', ', $errors)));
			}
		}
		else{
			if ($this->set_unlogged($id)){
				$username = ($this->get($id,'name') != '') ? $this->get($id,'name') : $this->get($id,'login');
				$return[] = array('call', 'message', "Пользователь $username разлогинен");
				if ($_SESSION['cms']['user_id'] == $id){
					$_SESSION['cms']['authorized'] = 0;
					session_destroy();
					$return[] = array('sleep', 10);
					$return[] = array('redirect', BASEDIR);
				}else{
					$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
				}				
				return $return;
			}
			else return array(array('call', 'message', "Ошибка"));
		}
	}


	function _navigator(){
		$rows = $GLOBALS['rownums'];
		$c = $_SESSION['cms']['mod'][$this->name]['page'];
		$r = $_SESSION['cms']['mod'][$this->name]['rnum'];
		$p = $_SESSION['cms']['mod'][$this->name]['parent'];
		$t = count($this->get_list($p));
		foreach($rows as $row){
			$n = ($row=='all') ? '0' : $row;
			$tx = ($row=='all') ? 'Все' : $row;
			$rn .= ($row=='all'&&$r=='0'||$row==$r)?'<option value="'.$n.'" selected="selected">'.$tx.'</option>':'<option value="'.$n.'">'.$tx.'</option>';
		}
		$pages = ($r != 0) ? ($t/$r > floor($t/$r)) ? floor($t/$r)+1 : $t/$r : 1;
		for($i=1; $i<=$pages; $i++){
			$pgs .= ($i == $c) ? '<a class="page_c">'.$i.'</a>' : '<a href="javascript:call(\''.$this->name.'\', \'_set_page\', '.$i.');" class="page_n">'.$i.'</a>';
		}
		$first = ($c==1) ? '<a class="page_l">Начало</a>' : '<a href="javascript:call(\''.$this->name.'\', \'_set_page\', 1);" class="page_l">Начало</a>';
		$last = ($c==$pages) ? '<a class="page_r">Конец</a>' : '<a href="javascript:call(\''.$this->name.'\', \'_set_page\', '.$pages.');" class="page_r">Конец</a>';
		$rows = '<select id="rnum" onChange="call(\''.$this->name.'\', \'_set_rnum\', this.value);">'.$rn.'</select>';
		return 'Количество строк:'.$rows.$first.$pgs.$last;
	}


	function _new(){ return array(array('redirect', BASEDIR."/".$this->name."/new")); }


	function _prep_f($array){
		if (count($array)==2 && !is_array($array[0])){
			$a[$array[0]] = $this->_prep_f($array[1]);
		}else{
			foreach($array as $k=>$v){if(is_array($v)){$a[$v[0]] = $v[1];}}
		}
		return $a;
	}


	function _save($data){
		$data = $this->_prep_f($data);
		$return = $this->_save_data($data);
		if ($return == 'true'){
			$return = array();
			if ($data[$this->name]['db_id'] == 'new'){
				$_SESSION['cms']['message'] = 'Элемент добавлен';
				$return[] = array('redirect', BASEDIR."/".$this->name);
			}elseif ($data[$this->name]['db_id'] != 'new'){
				$this->_check_out($data[$this->name]['db_id'], 'false');
				$_SESSION['cms']['message'] = 'Информация сохранена';
				$return[] = array('redirect', BASEDIR."/".$this->name);
			}
		}
		return $return;
	}


	function _save_data($data){
		$params = (class_exists('params', false)) ? new params() : false;
		$id = $data[$this->name]['db_id'];
		$sql['name'] = $data[$this->name]['username'];
		$sql['login'] = $data[$this->name]['login'];
		$sql['usertype'] = $data[$this->name]['usertype'];
		$sql['block'] = $data[$this->name]['block'];
		$sql['email'] = $data[$this->name]['email'];
		$sql['image'] = $data[$this->name]['image'];
		$sql = ($params) ? $params->adv_save($data[$this->name], $sql, $this->name) : $sql;
		
		if ($id == 'new'){
			$sql['password'] = md5($data[$this->name]['password']);
			$sql['register_date'] = date('Y-m-d H:i:s');
			if ($sql['login'] != '' && $sql['usertype'] != '0' && $sql['email'] != '' && $data[$this->name]['password'] != '' && $data[$this->name]['password2'] != ''){
				if ($data[$this->name]['password'] == $data[$this->name]['password2']){
					if ($this->insert($sql)){$return = 'true';}
					else { $return[] = array('call', 'message', "Ошибка добавления пользователя"); }
				}else{
					$return[] = array('call', 'message', "Пароли должны совпадать");
				}
			}else{
				$return[] = array('call', 'message', "Поля: '<b>Логин</b>', '<b>E-mail</b>', '<b>Категория</b>', '<b>Пароль</b>' должны быть корректно заполнены");
			} 
		}else{
			settype($id,"integer");
			if ($sql['login'] != '' && $sql['usertype'] != '0' && $sql['email'] != ''){
				if ($data[$this->name]['password'] == $data[$this->name]['password2']){
					if($data[$this->name]['password'] != ''){$sql['password'] = md5($data[$this->name]['password']);}
				}else{
					$return[] = array('call', 'message', "Пароли должны совпадать");
				}
				if ($this->update($sql, $id)){$return = 'true';}
				else { $return[] = array('call', 'message', "Ошибка редактирования пользователя"); }				
			}else{
				$return[] = array('call', 'message', "Поля: '<b>Логин</b>', '<b>E-mail</b>', '<b>Категория</b>' должны быть корректно заполнены");
			} 
		}
		return $return;
	}	


	function _set_page($p){
		$_SESSION['cms']['mod'][$this->name]['page'] = $p;
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}


	function _set_parent($p = null){
		$categories = new categories();
		$_SESSION['cms']['mod'][$this->name]['parent'] = ($p)?$p:0;
		$_SESSION['cms']['mod'][$this->name]['page'] = 1;
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}


	function _set_rnum($p){
		$_SESSION['cms']['mod'][$this->name]['rnum'] = $p;
		$_SESSION['cms']['mod'][$this->name]['page'] = 1;
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}

}
?>