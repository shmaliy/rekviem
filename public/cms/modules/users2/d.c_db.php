<?php
	function c_db($init = NULL){
		if (isset($GLOBALS['cms_config_dbprefix']) || isset($init) && $init == true){
			$query  = "CREATE TABLE IF NOT EXISTS `$this->tbl` ( ";
			$query .= "`id` INT NOT NULL AUTO_INCREMENT, ";
			$query .= "`checked_out` INT NOT NULL, ";
			$query .= "`checked_out_time` DATETIME NOT NULL, ";
			$query .= "`name` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`login` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`email` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`password` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`usertype` INT NOT NULL, ";
			$query .= "`block` INT NOT NULL, ";
			$query .= "`register_date` DATETIME NOT NULL, ";
			$query .= "`lastvizit_date` DATETIME NOT NULL, ";
			$query .= "`image` TEXT NOT NULL, ";
			$query .= "`param1` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param2` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param3` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param4` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param5` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param6` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param7` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param8` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param9` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param10` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param11` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param12` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param13` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param14` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param15` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param16` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param17` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param18` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param19` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "`param20` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
			$query .= "PRIMARY KEY (`id`)); ";
			if (!@mysql_query($query)){ /*core::set_error("$this->name::c_db");*/ }
			
			$query  = "CREATE TABLE IF NOT EXISTS `$this->tbl2` ( ";
			$query .= "`user_id` INT NOT NULL, ";
			$query .= "`session_id` VARCHAR( 200 ) NOT NULL, ";
			$query .= "PRIMARY KEY (`session_id`));";
			if (!@mysql_query($query)){ /*core::set_error("$this->name::c_db");*/ }
		}
	}
?>