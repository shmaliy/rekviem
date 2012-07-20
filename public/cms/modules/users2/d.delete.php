<?php
	function delete($id){
		if (@mysql_query("DELETE FROM `$this->mod_tablename` WHERE `id` = $id LIMIT 1")){return true;}
		else return false;
	}
?>