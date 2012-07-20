<?php
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
?>