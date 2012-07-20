<?php
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
?>