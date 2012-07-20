<?php
	function head(){
		$return  = '<link href="'.BASEDIR.'/modules/'.$this->name.'/'.$this->name.'.css.php" rel="stylesheet" type="text/css" />'."\n";
		global $url_query;
		if (count($url_query)>2){
			$return .= '<script type="text/javascript" src="'.BASEDIR.'/js/tiny_mce/tiny_mce.js"></script>'."\n";
			$return .= '<script type="text/javascript" src="'.BASEDIR.'/js/tiny_mce_init.js"></script>'."\n";
		}
		return $return;
	}
?>