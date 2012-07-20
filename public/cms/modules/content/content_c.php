<?php
class content
{

	function __construct(){
		$this->name = 'content';
		$this->core = new core();
		$this->info = $this->core->_mod_get_info($this->name);
		$this->tbl = $GLOBALS['cms_config_dbprefix'].'content';
		$this->c_db();
		if (!$_SESSION['cms']['mod'][$this->name] && $_SESSION['cms']['authorized'] == 1){
			$_SESSION['cms']['mod'][$this->name] = array('rnum' => 20, 'page' => 1, 'parent' => '0');
		}
	}


	function c_db(){
		$query  = "CREATE TABLE IF NOT EXISTS `$this->tbl` ( ";
		$query .= "`id` INT NOT NULL AUTO_INCREMENT, ";
		$query .= "`parent_id` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`title` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`title_alias` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`introtext` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`fulltext` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`created` BIGINT NOT NULL, ";
		$query .= "`created_by` INT NOT NULL, ";
		$query .= "`published` INT NOT NULL, ";
		$query .= "`publish_up` BIGINT NOT NULL, ";
		$query .= "`publish_down` BIGINT NOT NULL, ";
		$query .= "`checked_out` INT NOT NULL, ";
		$query .= "`checked_out_time` DATETIME NOT NULL, ";
		$query .= "`ordering` INT NOT NULL, ";
		$query .= "`image` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`images` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`hits` INT NOT NULL, ";
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
	}


	function delete($id){
		if (@mysql_query("DELETE FROM `$this->tbl` WHERE `id` = $id LIMIT 1")){ return true; }
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


	function get_list($p, $lim = NULL, $advf = NULL){
		$q = "SELECT * FROM `$this->tbl` WHERE `parent_id` = $p";
		if (isset($advf) && is_array($advf)){
			$q .= " AND ";
			foreach ($advf as $f => $v){
				$a[] = ($v/2 == 0) ? "`$f` = '$v'" : "`$f` = $v";
			}
			$q .= implode(" AND ", $a);
		}
		$q .= " ORDER BY `ordering` asc";
		$q .= (isset($lim) && $lim != '') ? " LIMIT $lim" : '';
		$r = @mysql_query($q);
		if ($r && @mysql_num_rows($r)>0){
			while ($row = mysql_fetch_assoc($r)){
				$d[] = $row;
			}
			return $d;
		}else return false;
	}


	function inc_order($p){
		$l = $this->get_list($p);
		if ($l){
			$o = 2;
			foreach ($l as $i){ $this->update_e('ordering', "$o", $i['id']); $o++; }
		}
	}


	function insert($d){
		$this->inc_order($d['parent_id']);
		$d = $this->prep_sql($d);
		if (@mysql_query("INSERT INTO `$this->tbl` SET $d")){ return true; }
		else return false;
	}


	function prep_sql($d){
		foreach ($d as $f => $v){
			if($f != 'id'){ $d2[] = "`$f` = '".mysql_real_escape_string($v)."'"; }
		}
		return implode(', ', $d2);
	}


	function update($d, $id){
		$d = $this->prep_sql($d);
		if (@mysql_query("UPDATE `$this->tbl` SET $d WHERE `id` = $id LIMIT 1")){
			return true;
		}else return false;
	}


	function update_e($f, $v, $id){
		if (@mysql_query("UPDATE `$this->tbl` SET `$f` = '".mysql_real_escape_string($v)."' WHERE `id` = $id LIMIT 1")){ return true; }
		else return false;
	}


	function editor($id){
		$categories = new categories();
		$params = (class_exists('params', false)) ? new params() : false;
		$users = (class_exists('users', false)) ? new users() : false;
		$o['{#name#}'] = $this->name;
		$o['{#id#}'] = $id;
		if ($id == 'new'){
			$o['{#tree#}'] = $categories->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
			$o['{#introtext#}'] = '';
			$o['{#fulltext#}'] = '';
			$o['{#published#}'] = 'checked';
			$o['{#title#}'] = '';
			$o['{#alias#}'] = '';
			$o['{#hits#}'] = '0';
			$o['{#created#}'] = date('Y-m-d H:i:s');
			$o['{#publish_up#}'] = date('Y-m-d H:i:s');
			$o['{#publish_down#}'] = '0000-00-00 00:00:00';
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name) : '';
			$o['{#image_editor#}'] = $this->core->fb_editor($this->name);
			$o['{#created_by#}'] = ($users) ? $users->tree($_SESSION['cms']['user_id']) : '';
		}else{
			$data = $this->get($id);
			$o['{#tree#}'] = $categories->tree(0, 0, $data['parent_id']);
			$o['{#introtext#}'] = $data['introtext'];
			$o['{#fulltext#}'] = $data['fulltext'];
			$o['{#published#}'] = ($data['published'] == '1') ? 'checked' : '';
			$o['{#title#}'] = htmlspecialchars($data['title']);
			$o['{#alias#}'] = htmlspecialchars($data['title_alias']);
			$o['{#hits#}'] = ($data['hits'] != '')? $data['hits'] : '0';
			$o['{#created#}'] = $this->_ts_to_dt($data['created']);
			$o['{#publish_up#}'] = $this->_ts_to_dt($data['publish_up']);
			$o['{#publish_down#}'] = $this->_ts_to_dt($data['publish_down']);
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name, $data) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name, $data) : '';
			$o['{#image_editor#}'] = $this->core->fb_editor($this->name, $data);
			$o['{#created_by#}'] = ($users) ? $users->tree($data['created_by']) : '';
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
		$categories = (class_exists('categories', false)) ? new categories() : false;
		$params = (class_exists('params', false)) ? new params() : false;
		$users = (class_exists('users', false)) ? new users() : false;
		
		$m = $_SESSION['cms']['mod'][$this->name];
		$mr = $m['rnum'];
		$mp = $m['page'];
		$p = $m['parent'];
		$lim = ($mr != 0) ? $mr*$mp-$mr.', '.$mr : '';
		$list = $this->get_list($p, $lim);
		if ($list){
			$c=0;
			foreach ($list as $i){
				foreach ($i as $f => $v){ $r["{#$f#}"] = $v; }
				$r['{#title#}'] = ($i['title_alias'] != '') ? $i['title'].' ( '.$i['title_alias'].' )' : $i['title'];
				$r['{#parent_id#}'] = ($i['parent_id'] != 0) ? $categories->get($i['parent_id'], 'title') : '- НЕТ -';
				$r['{#published#}'] = ($i['published'] == 1) ? '<img src="'.BASEDIR.'/images/adm/tick.png" />' : '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
				if ($i['checked_out'] == 0){
					$r['{#checked_out#}'] = '<input name="'.$i['id'].'" type="checkbox"></td>';
					$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
					$r['{#published#}'] = '<a href="' . "javascript:call('$this->name', '_publish', '" . $i['id'] . '\');">'.$r['{#published#}'].'</a>';
				}else{
					$r['{#checked_out#}'] = '<img src="'.BASEDIR.'/images/adm/checked_out.png" />';
					if ($i['checked_out'] == $_SESSION['cms']['user_id']){
						$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
						$r['{#published#}'] = '<a href="' . "javascript:call('$this->name', '_publish', '" . $i['id'] . '\');">'.$r['{#published#}'].'</a>';
					}
				}
				$reorder['{#name#}'] = $this->name;
				$reorder['{#id#}'] = $i['id'];
				if (count($list) == 1){ $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.none.tpl', $reorder); }
				elseif ($c == 0 && $c < count($list)-1){ $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.top.tpl', $reorder); }
				elseif ($c == count($list)-1){ $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.bottom.tpl', $reorder); }
				else { $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.middle.tpl', $reorder); }
				$r['{#sort#}'] .= '<input name="'.$i['id'].'" size="5" value="'.$i['ordering'].'" class="order" />';
				$r['{#adv_fields#}'] = ($params != false) ? $params->adv_row($this->name, $i) : '';
				$o['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_row.tpl", $r);
				$c++;
			}
		}else { $o['{#items#}'] = '<tr><td colspan="30">Пусто</td></tr>'; }
		$o['{#basedir#}'] = BASEDIR;
		$o['{#name#}'] = $this->name;
		$o['{#navigator#}'] = $this->_navigator();
		$o['{#adv_fields#}'] = ($params != false) ? $params->adv_head($this->name) : '';
		$o['{#tree#}'] = $categories->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
		return $this->core->tpl->assign("modules/$this->name/tpl/table.tpl", $o);
	}


	function _toolbar($mode, $id = NULL){
		if ($mode == 'list'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-publish.png', 'Показать', "call('$this->name', '_publish', ['true', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-unpublish.png', 'Скрыть', "call('$this->name', '_publish', ['false', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-move.png', 'Переместить', "call('$this->name', '_move', ['confirm', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-copy.png', 'Копировать', "call('$this->name', '_copy', ['confirm', getcheckbox('ctable_contents')]);", 12),
					array(BASEDIR.'/images/toolbar/icon-32-trash.png', 'Удалить', "call('$this->name', '_delete', ['confirm', getcheckbox('ctable_contents')]);", 12),
					array(BASEDIR.'/images/toolbar/icon-32-new.png', 'Создать', "call('$this->name', '_new');", 12)
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


	function _copy($data){
		$categories = new categories();
		if ($data[0] != 'confirm'){
			if ($data[1] == 'null'){ return array(array('call', 'message', "Ошибка обработки")); }
			else{
				$errors = array();
				foreach ($data[1] as $item){
					$elem = $this->get($item);
					$elem['parent_id'] = $data[0];
					$elem['checked_out'] = '0';
					$elem['checked_out_time'] = '0000-00-00 00:00:00';
					$elem['ordering'] = 1;
					if (!$this->insert($elem)){ $errors[] = $item.' (ошибка копирования)'; }
				}
				if (count($errors)==0){
					$return[] = array('assign', $this->name.'_table', 'innerHTML', $this->table());
					$return[] = array('call', 'modal.hide');
					$return[] = array('sleep', 10);
					$return[] = array('call', 'message', 'Элемент(ы) скопированы');
					return $return;
				}else return array(array('call', 'message', "Ошибка обработки ID:<br />&nbsp;&nbsp;&nbsp;".implode(';<br />', $errors)));
			}
		}else{
			if ($data[1] == 'null'){ return array(array('call', 'message', "Не выбран не один элемент")); }
			else{
				foreach ($data[1] as $item){
					$elem = $this->get($item); 
					$o['{#id#}'] = "$item";
					$o['{#title#}'] = ($elem['title_alias'] != '') ? $elem['title'].' ( '.$elem['title_alias'].' ) ' : $elem['title'];
					$out['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_row.tpl", $o);
				}
				$p[] = 'width=500&height=265&title=Копирование&close=true';
				$out['{#basedir#}'] =  BASEDIR;
				$out['{#name#}'] =  $this->name;
				$out['{#tree#}'] = $categories->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
				$p[] = $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_copy.tpl", $out);
				return array(array('call', 'modal.show', $p));				
			}
		}
	}


	function _delete($data){
		$categories = new categories();
		if ($data[0] != 'confirm'){
			if ($data[1] == 'null'){ return array(array('call', 'message', "Ошибка обработки")); }
			else{
				$errors = array();
				$content = (class_exists('content', false)) ? new content() : false;
				foreach ($data[1] as $item){
					$el = $this->get($item);
					if ($el['checked_out'] != 0){ $errors[] = $item.' (элемент заблокирован)'; }
					elseif (!$this->delete($item)){ $errors[] = $item.' (ошибка удаления)'; }
				}
				if (count($errors)==0){
					$parents = $categories->get_list();
					foreach ($parents as $parent){ $this->_reset_order($parent['id']); }					
					$this->_reset_order(0);
					$return[] = array('assign', $this->name.'_table', 'innerHTML', $this->table());
					$return[] = array('call', 'modal.hide');
					$return[] = array('sleep', 10);
					$return[] = array('call', 'message', 'Элемент(ы) удалены');
					return $return;
				}else return array(array('call', 'message', "Ошибка обработки ID:<br />&nbsp;&nbsp;&nbsp;".implode(';<br />', $errors)));
			}
		}else{
			if ($data[1] == 'null'){ return array(array('call', 'message', "Не выбран не один элемент")); }
			else{
				foreach ($data[1] as $item){
					$elem = $this->get($item); 
					$o['{#id#}'] = "$item";
					$o['{#title#}'] = ($elem['title_alias'] != '') ? $elem['title'].' ( '.$elem['title_alias'].' ) ' : $elem['title'];
					$out['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_row.tpl", $o);
				}
				$p[] = 'width=500&height=265&title=Удаление&close=true';
				$out['{#basedir#}'] =  BASEDIR;
				$out['{#name#}'] =  $this->name;
				$p[] = $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_del.tpl", $out);
				return array(array('call', 'modal.show', $p));				
			}
		}
	}


	function _dt_to_ts($data){
		$dt = explode(' ', $data);
		$d =  explode('-', $dt[0]); $t =  explode(':', $dt[1]);
		return mktime($t[0],$t[1],$t[2],$d[1],$d[2],$d[0]);
	}


	function _edit($id){
		if ($id != 'new'){ $this->_check_out($id, 'true'); }
		return array(array('redirect', BASEDIR."/".$this->name."/$id"));
	}


	function _lock(){ return array(array('redirect', BASEDIR."/".$this->name)); }


	function _move($data){
		$categories = new categories();
		if ($data[0] != 'confirm'){
			if ($data[1] == 'null'){ return array(array('call', 'message', "Ошибка обработки")); }
			else{
				$errors = array();
				foreach ($data[1] as $item){
					$el = $this->get($item);
					if ($el['checked_out'] != 0){ $errors[] = $item.' (элемент заблокирован)'; }
					else {
						$this->update_e('parent_id', $data[0], $item);
						$this->update_e('ordering', 0, $item);
					}
				}
				if (count($errors)==0){
					$parents = $categories->get_list();
					foreach ($parents as $parent){ $this->_reset_order($parent['id']); }					
					$this->_reset_order(0);
					$return[] = array('assign', $this->name.'_table', 'innerHTML', $this->table());
					$return[] = array('call', 'modal.hide');
					$return[] = array('sleep', 10);
					$return[] = array('call', 'message', 'Элемент(ы) перемещены');
					return $return;
				}else return array(array('call', 'message', "Ошибка обработки ID:<br />&nbsp;&nbsp;&nbsp;".implode(';<br />', $errors)));
			}
		}else{
			if ($data[1] == 'null'){ return array(array('call', 'message', "Не выбран не один элемент")); }
			else{
				foreach ($data[1] as $item){
					$elem = $this->get($item); 
					$o['{#id#}'] = "$item";
					$o['{#title#}'] = ($elem['title_alias'] != '') ? $elem['title'].' ( '.$elem['title_alias'].' ) ' : $elem['title'];
					$out['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_row.tpl", $o);
				}
				$p[] = 'width=500&height=265&title=Перемещение&close=true';
				$out['{#basedir#}'] =  BASEDIR;
				$out['{#name#}'] =  $this->name;
				$out['{#tree#}'] = $categories->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
				$p[] = $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_move.tpl", $out);
				return array(array('call', 'modal.show', $p));				
			}
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


	function _publish($id){
		if (is_array($id)){
			if ($id[1] == 'null'){return array(array('call', 'message', "Не выбран не один элемент"));}
			else{
				$errors = array();
				$to = ($id[0] == 'true') ? '1' : '0';
				$mes = ($id[0] == 'false') ? "Элементы заблокированы" : "Элементы разблокированы";
				foreach ($id[1] as $ids){
					if (!$this->update_e('published', $to, $ids)){$errors[] = $ids;}
				}
				if (count($errors)==0){
					$return[] = array('assign', $this->name.'_table', 'innerHTML', $this->table());
					$return[] = array('call', 'message', $mes);
					return $return;
				}
				else return array(array('call', 'message', "Ошибка обработки ID: ".implode(', ', $errors)));
			}
		}else{
			$published = $this->get($id, 'published');
			if ($published == '1'){ $this->update_e('published', '0', $id); }
			else{ $this->update_e('published', '1', $id); }
			return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
		}
	}


	function _reorder($data){
		$categories = new categories();
		if ($data[0] == 'up'){
			$el = $this->get($data[1]);
			$list = $this->get_list($el['parent_id']);
			foreach ($list as $item){
				if ($item['ordering'] == $el['ordering']-1){
					$this->update_e('ordering', $item['ordering']+1, $item['id']);
				}
			}
			$this->update_e('ordering', $el['ordering']-1, $el['id']);
			$this->_reset_order($el['parent_id']);
		}
		elseif ($data[0] == 'down'){
			$el = $this->get($data[1]);
			$list = $this->get_list($el['parent_id']);
			foreach ($list as $item){
				if ($item['ordering'] == $el['ordering']+1){
					$this->update_e('ordering', $item['ordering']-1, $item['id']);
				}
			}
			$this->update_e('ordering', $el['ordering']+1, $el['id']);
			$this->_reset_order($el['parent_id']);
		}
		elseif ($data[0] == 'total'){
			foreach ($data[1] as $item){ $this->update_e('ordering', $item[1], $item[0]); }
			$this->_reset_order($_SESSION['cms']['mod'][$this->name]['parent']);
		}
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}


	function _reset_order($p){
		$elems = $this->get_list($p);
		if ($elems){
			$i=1;
			foreach ($elems as $item){ $this->update_e('ordering', "$i", $item['id']); $i++; }
			return true;
		}return false;
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
		$return = array();
		$params = (class_exists('params', false)) ? new params() : false;
		
		$id = $data[$this->name]['db_id'];
		$sql['title'] = $data[$this->name]['title'];
		$sql['title_alias'] = $data[$this->name]['title_alias'];
		$sql['published'] = ($data[$this->name]['published'] == 'true') ? '1' : '0';
		$sql['image'] = $data[$this->name]['image'];
		$sql['images'] = @implode('|', $data[$this->name]['images']);
		$sql['introtext'] = $data[$this->name]['introtext'];
		$sql['fulltext'] = $data[$this->name]['fulltext'];
		$sql['created_by'] = $data[$this->name]['created_by'];
		$sql['created'] = $this->_dt_to_ts($data[$this->name]['created']);
		$sql['publish_up'] = $this->_dt_to_ts($data[$this->name]['publish_up']);
		$sql['publish_down'] = $this->_dt_to_ts($data[$this->name]['publish_down']);
		$sql['parent_id'] = $data[$this->name]['category'];
		$sql = ($params) ? $params->adv_save($data[$this->name], $sql, $this->name) : $sql;
		
		$error = array();
		if ($sql['title'] == ''){ $error[] = 'Поле заголовок не может быть пустым'; }
		
		if (count($error) == 0){
			if ($id == "new"){
				$sql['ordering'] = 1;
				if ($this->insert($sql)){$return = 'true';}
				else { $return[] = array('call', 'message', "Ошибка добавления"); }
			}else{
				settype($id,"integer");
				$element = $this->get($id);
				if ($element['parent_id'] != $sql['parent_id']){
					$sql['ordering'] = 1;
					$this->update_e('ordering', 0, $element['id']);
					$list = $this->get_list($element['parent_id']);
					for ($j=1; $j<=count($list); $j++){
						$this->update_e('ordering', "$j", $list[$j]['id']);
					}
					$this->_increment_order($sql['parent_id']);
				}
				if ($this->update($sql, $id)){$return = 'true';}
				else { $return[] = array('call', 'message', "Ошибка сохранения"); }
			}
		}else{
			$return[] = array('call', 'message', implode('<br />', $error));
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


	function _ts_to_dt($data){ return date('Y-m-d H:i:s', $data); }

}
?>