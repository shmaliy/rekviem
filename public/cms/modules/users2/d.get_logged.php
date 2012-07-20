<?php
	function get_logged($id){
		$session = @mysql_query("SELECT * FROM `$this->tbl2` WHERE `user_id` = '$id' LIMIT 1");
		return (mysql_num_rows($session) != 0) ? true : false;
	}
?>