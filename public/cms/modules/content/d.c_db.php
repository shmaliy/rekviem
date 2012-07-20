<?php
	function c_db(){
		$query  = "CREATE TABLE IF NOT EXISTS `$this->tbl` ( ";
		$query .= "`id` INT NOT NULL AUTO_INCREMENT, ";
		$query .= "`parent_id` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`title` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`title_alias` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`introtext` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`fulltext` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`created` BIGINT NOT NULL, ";
		$query .= "`created_by` INT NOT NULL, ";
		$query .= "`published` INT NOT NULL, ";
		$query .= "`publish_up` BIGINT NOT NULL, ";
		$query .= "`publish_down` BIGINT NOT NULL, ";
		$query .= "`checked_out` INT NOT NULL, ";
		$query .= "`checked_out_time` DATETIME NOT NULL, ";
		$query .= "`ordering` INT NOT NULL, ";
		$query .= "`image` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`images` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`hits` INT NOT NULL, ";
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
	}
?>