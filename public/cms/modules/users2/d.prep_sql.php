<?php
	function prep_sql($d){
		foreach ($d as $f => $v){
			if($f != 'id'){ $d2[] = "`$f` = '".@mysql_real_escape_string($v)."'"; }
		}
		return implode(', ', $d2);
	}
?>