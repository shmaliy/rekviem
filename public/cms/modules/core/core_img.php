<?php
class core_img
{
	function get($file){
		if ($fc = file_get_contents($file)){
			$rows = explode('<br />', nl2br($fc));
			if (count($rows)>0){
				foreach ($rows as $row){
					$columns = explode(' = ', $row);
					if ($columns[0] != '' && $columns[1] != ''){
						$key = strtoupper($columns[0]);
						$val = iconv('UTF-8', 'windows-1251', $columns[1]);
						$out[$key] = substr($val, 0, strlen($val)-1);
					}
				}				
			}
			return $out;
		}
		else return false;
	}
}
//print_r(core_ini::get('modules/content/content.ini'));

?>
