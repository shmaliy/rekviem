<?php
	function delete($id){
		if (@mysql_query("DELETE FROM `$this->tbl` WHERE `id` = $id LIMIT 1")){ return true; }
		else return false;
	}
?>