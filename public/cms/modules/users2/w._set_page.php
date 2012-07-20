<?php
	function _set_page($p){
		$_SESSION['cms']['mod'][$this->name]['page'] = $p;
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}
?>