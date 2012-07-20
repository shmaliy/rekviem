<?php
	function __construct(){
		$this->name = 'content';
		$this->core = new core();
		$this->info = $this->core->_mod_get_info($this->name);
		$this->tbl = $GLOBALS['cms_config_dbprefix'].'content';
		$this->c_db();
		if (!$_SESSION['cms']['mod'][$this->name] && $_SESSION['cms']['authorized'] == 1){
			$_SESSION['cms']['mod'][$this->name] = array('rnum' => 20, 'page' => 1, 'parent' => '0');
		}
	}
?>