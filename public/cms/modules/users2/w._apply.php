<?php
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
?>