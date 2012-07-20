<?php
	function inc_order($p){
		$l = $this->get_list($p);
		if ($l){
			$o = 2;
			foreach ($l as $i){ $this->update_e('ordering', "$o", $i['id']); $o++; }
		}
	}
?>