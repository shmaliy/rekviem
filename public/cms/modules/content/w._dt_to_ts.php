<?php
	function _dt_to_ts($data){
		$dt = explode(' ', $data);
		$d =  explode('-', $dt[0]); $t =  explode(':', $dt[1]);
		return mktime($t[0],$t[1],$t[2],$d[1],$d[2],$d[0]);
	}
?>