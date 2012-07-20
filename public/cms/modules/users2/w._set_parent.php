<?php
	function _set_parent($p = null){
		$categories = new categories();
		$_SESSION['cms']['mod'][$this->name]['parent'] = ($p)?$p:0;
		$_SESSION['cms']['mod'][$this->name]['page'] = 1;
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}
?>