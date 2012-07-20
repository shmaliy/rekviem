<?php
	function _reset_order($p){
		$elems = $this->get_list($p);
		if ($elems){
			$i=1;
			foreach ($elems as $item){ $this->update_e('ordering', "$i", $item['id']); $i++; }
			return true;
		}return false;
	}
?>