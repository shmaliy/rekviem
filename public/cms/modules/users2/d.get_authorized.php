<?php
	function get_authorized($login, $password){
		$user = @mysql_query("SELECT * FROM `$this->tbl` WHERE `login` = '$login' AND `password` = '$password' LIMIT 1");
		if (@mysql_num_rows($user)>0){return mysql_fetch_assoc($user);}
		else return false;
	}
?>