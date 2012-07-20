<?php
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
?>