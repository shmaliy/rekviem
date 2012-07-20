<?php
	function _cancel($id){
		if ($id != 'new'){ $this->_check_out($id, 'false'); }
		return array(array('redirect', BASEDIR."/".$this->name));
	}
?>