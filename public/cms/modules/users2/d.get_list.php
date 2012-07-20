<?php
	function get_list($p = NULL, $lim = NULL, $advf = NULL){
		$q = "SELECT * FROM `$this->tbl`";
		if (isset($p)){
			$q .= " WHERE `usertype` = $p";
		}else{ $q .= ""; }
		if (isset($advf) && is_array($advf)){
			$q .= " AND ";
			foreach ($advf as $f => $v){
				$a[] = ($v/2 == 0) ? "`$f` = '$v'" : "`$f` = $v";
			}
			$q .= implode(" AND ", $a);
		}
		$q .= " ORDER BY `login` asc";
		$q .= (isset($lim) && $lim != '') ? " LIMIT $lim" : '';
		$r = @mysql_query($q);
		if ($r && @mysql_num_rows($r)>0){
			while ($row = mysql_fetch_assoc($r)){
				$d[] = $row;
			}
			return $d;
		}else return false;
	}
?>