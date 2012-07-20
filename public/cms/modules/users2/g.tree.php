<?php
	function tree($p, $l, $s){
		$list = $GLOBALS['usertypes'];
		if ($list){
			foreach ($list as $key => $item){
				$o .= '<option value="'.$key.'"';
				$o .= ($s == $key) ? ' selected="selected"' : '';
				$o .= '>'.$item.'</option>';
			}
		}
		return $o;
	}
?>