<?php
	function _prep_f($array){
		if (count($array)==2 && !is_array($array[0])){
			$a[$array[0]] = $this->_prep_f($array[1]);
		}else{
			foreach($array as $k=>$v){if(is_array($v)){$a[$v[0]] = $v[1];}}
		}
		return $a;
	}
?>