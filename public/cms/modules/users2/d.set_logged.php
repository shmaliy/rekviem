<?php
	function set_logged($id){
		$session = @mysql_query("SELECT * FROM `$this->tbl2` WHERE `user_id` = $id");
		$session_id = session_id();
		if (mysql_num_rows($session)==0){
			if(@mysql_query("INSERT INTO `$this->tbl2` SET `session_id` = '$session_id', `user_id` = '$id'")){return true;}
			else return false;
		}
		elseif (mysql_num_rows($session)==1){
			if(@mysql_query("UPDATE `$this->tbl2` SET `session_id` = '$session_id' WHERE `user_id` = '$id'")){return true;}
			else return false;
		}
		elseif (mysql_num_rows($session)>1){
			if(@mysql_query("DELETE FROM `$this->tbl2` WHERE `user_id` = '$id'")){ $st = 1; }
			else $st = 0;
			if ($st == 1){
				if(@mysql_query("INSERT INTO `$this->tbl2` SET `session_id` = '$session_id', `user_id` = '$id'")){return true;}
				else return false;
			}else return false;			
		}else return false;
	}	
?>