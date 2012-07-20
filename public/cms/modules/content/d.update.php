<?php
	function update($d, $id){
		$d = $this->prep_sql($d);
		if (@mysql_query("UPDATE `$this->tbl` SET $d WHERE `id` = $id LIMIT 1")){
			return true;
		}else return false;
	}
?>