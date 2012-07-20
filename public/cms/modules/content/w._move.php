<?php
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
?>