<?php
	function set_unlogged($id){
		if(@mysql_query("DELETE FROM `$this->tbl2` WHERE `user_id` = '$id'")){return true;}
		else return false;
	}	
?>