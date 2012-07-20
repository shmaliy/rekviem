<?php
include_once 'categories_gen.php';
class categories extends categories_gen
{
	/* ---NAVIGATION FUNCTIONS--- */
	function page(){
		global $url_query;
		if (count($url_query)==2){
			return $this->_toolbar('list').$this->table();
		}
		elseif (count($url_query)==3 && $url_query[2] == 'new'){
			return $this->_toolbar('new').$this->editor($url_query[2]);
		}
		elseif (count($url_query)==3 && $url_query[2] != 'new'){
			return $this->_toolbar('edit', $url_query[2]).$this->editor($url_query[2]);
		}
	}
	
	function _new(){ return array(array('redirect', BASEDIR."/".$this->name."/new")); }
	
	function _lock(){ return array(array('redirect', BASEDIR."/".$this->name)); }
	
	function _cancel($id){
		if ($id != 'new'){ $this->_check_out($id, 'false'); }
		return array(array('redirect', BASEDIR."/".$this->name));
	}

	function _edit($id){
		if ($id != 'new'){ $this->_check_out($id, 'true'); }
		return array(array('redirect', BASEDIR."/".$this->name."/$id"));
	}
	
	function _setp($p){
		$_SESSION['cms']['mod'][$this->name]['page'] = $p;
		$return[] = array('assign', 'navigator', 'innerHTML', $this->core->navigator($this->name));
		$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
		return $return;
	}
	
	function _setr($p){
		$_SESSION['cms']['mod'][$this->name]['rnum'] = $p;
		$_SESSION['cms']['mod'][$this->name]['page'] = 1;
		$return[] = array('assign', 'navigator', 'innerHTML', $this->core->navigator($this->name));
		$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
		return $return;
	}
	
	function _setf($p = null){
		$_SESSION['cms']['mod'][$this->name]['parent'] = ($p)?$p:0;
		$_SESSION['cms']['mod'][$this->name]['page'] = 1;
		$return[] = array('assign', 'category', 'innerHTML', $this->tree(0, 0, $p));
		$return[] = array('assign', 'navigator', 'innerHTML', $this->core->navigator($this->name));
		$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
		return $return;
	}
	/* ---/NAVIGATION FUNCTIONS--- */
	
	/* ---LIST FUNCTIONS--- */
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
					$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
					$return[] = array('call', 'message', $mes);
					return $return;
				}
				else return array(array('call', 'message', "Ошибка обработки ID: ".implode(', ', $errors)));
			}
		}else{
			$published = $this->get($id, 'published');
			if ($published == '1'){
				$this->update_e('published', '0', $id);
			}else{
				$this->update_e('published', '1', $id);
			}
			return array(array('assign', 'ctable_contents', 'innerHTML', $this->_list()));
		}
	}
	
	function _reorder($data){
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
				if ($item['ordering'] == $el['ordering']-1){
					$this->update_e('ordering', $item['ordering']-1, $item['id']);
				}
			}
			$this->update_e('ordering', $el['ordering']+1, $el['id']);
			$this->_reset_order($el['parent_id']);
		}
		elseif ($data[0] == 'total'){
			foreach ($data[1] as $item){
				$this->update_e('ordering', $item[1], $item[0]);
			}
			if ($_SESSION['cms']['mod'][$this->name]['parent'] != 0){
				$this->_reset_order($_SESSION['cms']['mod'][$this->name]['parent']);
			}else{
				$this->_reset_order(0);
				$parents = $this->get_list();
				foreach ($parents as $parent){
					$this->_reset_order($parent['id']);
				}
			}
		}
		return array(array('assign', 'ctable_contents', 'innerHTML', $this->_list()));
	}
	
	function _copy($data){
		if ($data[0] != 'confirm'){
			if ($data[1] == 'null'){ return array(array('call', 'message', "Ошибка обработки")); }
			elseif($data[0] == 0){ return array(array('call', 'message', "Выберите категорию"));}
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
					$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
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
					$out['{#items#}'] .= $this->tpl->assign("modules/$this->name/table_confirm_row.tpl", $o);
				}
				$p[] = 'width=500&height=265&title=Копирование&close=true';
				$out['{#basedir#}'] =  BASEDIR;
				$out['{#name#}'] =  $this->name;
				$out['{#tree#}'] = $this->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
				$p[] = $this->tpl->assign("modules/$this->name/table_confirm_copy.tpl", $out);
				return array(array('call', 'modal.show', $p));				
			}
		}
	}
	
	function _move($data){
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
						$this->_reset_order($data[0]);
					}
				}
				if (count($errors)==0){
					$parents = $this->get_list();
					foreach ($parents as $parent){
						$this->_reset_order($parent['id']);
					}					
					$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
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
					$out['{#items#}'] .= $this->tpl->assign("modules/$this->name/table_confirm_row.tpl", $o);
				}
				$p[] = 'width=500&height=265&title=Перемещение&close=true';
				$out['{#basedir#}'] =  BASEDIR;
				$out['{#name#}'] =  $this->name;
				$out['{#tree#}'] = $this->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
				$p[] = $this->tpl->assign("modules/$this->name/table_confirm_move.tpl", $out);
				return array(array('call', 'modal.show', $p));				
			}
		}
	}
	
	function _delete($data){
		if ($data[0] != 'confirm'){
			if ($data[1] == 'null'){ return array(array('call', 'message', "Ошибка обработки")); }
			else{
				$errors = array();
				$content = (class_exists('content', false)) ? new content() : false;
				foreach ($data[1] as $item){
					$el = $this->get($item);
					if ($this->get_list($el['id'])){ $errors[] = $item.' (с подкатегориями нельзя удалить)'; }
					elseif ($el['checked_out'] != 0){ $errors[] = $item.' (элемент заблокирован)'; }
					elseif ($content->get_list($el['id'])){ $errors[] = $item.' (с сонтентом нельзя удалить)'; }
					elseif (!$this->delete($item)){ $errors[] = $item.' (ошибка удаления)'; }
				}
				if (count($errors)==0){
					$parents = $this->get_list();
					foreach ($parents as $parent){
						$this->_reset_order($parent['id']);
					}					
					$return[] = array('assign', 'ctable_contents', 'innerHTML', $this->_list());
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
					$out['{#items#}'] .= $this->tpl->assign("modules/$this->name/table_confirm_row.tpl", $o);
				}
				$p[] = 'width=500&height=265&title=Удаление&close=true';
				$out['{#basedir#}'] =  BASEDIR;
				$out['{#name#}'] =  $this->name;
				$p[] = $this->tpl->assign("modules/$this->name/table_confirm_del.tpl", $out);
				return array(array('call', 'modal.show', $p));				
			}
		}
	}
	
	/* ---/LIST FUNCTIONS--- */
	
	/* ---EDITOR FUNCTIONS--- */
	function _save($data){
		$data = $this->core->prepare_form_data($data);
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
	
	function _apply($data){
		$data = $this->core->prepare_form_data($data);
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
	
	function _save_data($data){
		$return = array();
		$params = (class_exists('params', false)) ? new params() : false;
				
		$id = $data[$this->name]['db_id'];
		$sql['title'] = $data[$this->name]['title'];
		$sql['title_alias'] = $data[$this->name]['title_alias'];
		$sql['published'] = ($data[$this->name]['published'] == 'true') ? '1' : '0';
		$sql['image'] = $data[$this->name]['image'];
		$sql['images'] = @implode('|', $data[$this->name]['images']);
		$sql['description'] = $data[$this->name]['description'];
		$sql['parent_id'] = $data[$this->name]['category'];
		$sql = ($params) ? $params->adv_save($data[$this->name], $sql, $this->name) : $sql;
		
		$error = array();
		if ($sql['title_alias'] == ''){ $error[] = 'Поле псевдоним не может быть пустым'; }
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
	/* ---/EDITOR FUNCTIONS--- */
	
	/* ---SUB FUNCTIONS--- */
	function _reset_order($parent){
		$elems = $this->get_list($parent);
		if ($elems){
			$i=1;
			foreach ($elems as $item){
				$this->update_e('ordering', "$i", $item['id']);
				$i++;
			}
		}
	}
	
	function _check_out($id, $toggle){
		if ($toggle == 'true'){	
			$checked_out = $_SESSION['cms']['user_id'];
			$d = getdate();
			$checked_out_time  = $d['year'].'-'.$d['mon'].'-'.$d['mday'].' ';
			$checked_out_time .= $d['hours'].':'.$d['minutes'].':'.$d['seconds'];
			$this->update_e('checked_out', $checked_out, $id);
			$this->update_e('checked_out_time', $checked_out_time, $id);
		}else{
			$this->update_e('checked_out', '0', $id);
			$this->update_e('checked_out_time', '0000-00-00 00:00:00', $id);
		}
	}
	/* ---/SUB FUNCTIONS--- */
}
?>