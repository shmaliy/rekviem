<?php 
class core_tpl
{
	function assign($tpl_name, $arr_data = null, $val = null){
		$tpl = file_get_contents($tpl_name);

		if(is_array($arr_data)){
			foreach ($arr_data as $k => $v){
				$tpl = str_replace($k, $v, $tpl);
			}
		}elseif(is_string($arr_data)){
			$tpl = str_replace($arr_data, $val, $tpl);
		}
		else{}

		return $tpl;
	}
	
	function tbl_row(){
		
	}
	
	function tbl_cell($data){
		$out = '<td';
		$inner = false;
		foreach ($data as $param => $value){
			if ($param != 'innerHTML'){
				$out .= " $param=\"$value\"";
			}else{
				$inner = "$value";
			}
		}
		if ($inner){ $out .= ">$inner</td>"; }
		else { $out .= ">&nbsp;</td>"; }
		return $out;
	}
	
	function tbl_Hcell($data){
		$out = '<th';
		$inner = false;
		foreach ($data as $param => $value){
			if ($param != 'innerHTML'){
				$out .= " $param=\"$value\"";
			}else{
				$inner = "$value";
			}
		}
		if ($inner){ $out .= ">$inner</th>"; }
		else { $out .= ">&nbsp;</th>"; }
		return $out;
	}
}
?>