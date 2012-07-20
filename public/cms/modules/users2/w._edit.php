<?php
	function _edit($id){
		if ($id != 'new'){ $this->_check_out($id, 'true'); }
		return array(array('redirect', BASEDIR."/".$this->name."/$id"));
	}
?>