<?php
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
?>