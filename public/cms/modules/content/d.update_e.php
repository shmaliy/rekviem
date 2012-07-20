<?php
	function update_e($f, $v, $id){
		if (@mysql_query("UPDATE `$this->tbl` SET `$f` = '".mysql_real_escape_string($v)."' WHERE `id` = $id LIMIT 1")){ return true; }
		else return false;
	}
?>