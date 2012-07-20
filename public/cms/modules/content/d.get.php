<?php
	function get($id, $f = NULL){
		$q = "SELECT * FROM `$this->tbl` WHERE `id` = $id LIMIT 1";
		$r = @mysql_query($q);
		if ($r && @mysql_num_rows($r)>0){
			if (isset($f) && $f != ''){ $d = mysql_fetch_assoc($r); return $d[$f]; }
			else { return mysql_fetch_assoc($r); }
		}else return false;
	}
?>