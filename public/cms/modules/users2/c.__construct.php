<?php
	function __construct(){
		$this->name = 'users2';
		$this->core = new core();
		$this->info = $this->core->_mod_get_info($this->name);
		$this->tbl = $GLOBALS['cms_config_dbprefix'].'users';
		$this->tbl2 = $GLOBALS['cms_config_dbprefix'].'session';
		$this->c_db();
		if (!$_SESSION['cms']['mod'][$this->name] && $_SESSION['cms']['authorized'] == 1){
			$_SESSION['cms']['mod'][$this->name] = array('rnum' => 20, 'page' => 1, 'parent' => 0);
		}
	}
?>