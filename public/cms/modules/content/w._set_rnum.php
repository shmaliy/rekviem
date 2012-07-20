<?php
	function _set_rnum($p){
		$_SESSION['cms']['mod'][$this->name]['rnum'] = $p;
		$_SESSION['cms']['mod'][$this->name]['page'] = 1;
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}
?>