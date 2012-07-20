<?php 
class xml
{
	var $parser;
	var $out;
	var $f;
	   
	function xml(){
		$this->parser = xml_parser_create();
		$this->out = array();
		$this->f = array();
		xml_set_object($this->parser, $this);
		xml_set_element_handler($this->parser, "tag_open", "tag_close");
		xml_set_character_data_handler($this->parser, "cdata");
	}
	
	function parse($data) 
	{
		xml_parse($this->parser, $data);
		$this->out = $this->iconv($this->out);
		$this->out = $this->optimize($this->out);
		return $this->out;
	}
	
	function tag_open($parser, $tag, $attributes) 
	{
		if (!$this->f[0] && !$this->f[1]){
			$this->out[][$tag] = $this->mark_attrs($attributes);
			array_push($this->f, count($this->out)-1, $tag);
		}
		elseif (!$this->f[2] && !$this->f[3]){
			$this->out[$this->f[0]][$this->f[1]][][$tag] = $this->mark_attrs($attributes);
			array_push($this->f, count($this->out[$this->f[0]][$this->f[1]])-1, $tag);
		}
		elseif (!$this->f[4] && !$this->f[5]){
			$this->out[$this->f[0]][$this->f[1]][$this->f[2]][$this->f[3]][][$tag] = $this->mark_attrs($attributes);
			array_push($this->f, count($this->out[$this->f[0]][$this->f[1]][$this->f[2]][$this->f[3]])-1, $tag);
		}
		elseif (!$this->f[6] && !$this->f[7]){
			$this->out[$this->f[0]][$this->f[1]][$this->f[2]][$this->f[3]][$this->f[4]][$this->f[5]][][$tag] = $this->mark_attrs($attributes);
			array_push($this->f, count($this->out[$this->f[0]][$this->f[1]][$this->f[2]][$this->f[3]][$this->f[4]][$this->f[5]])-1, $tag);
		}
	}
	
	function cdata($parser, $cdata) 
	{
		if (!$this->f[2] && !$this->f[3]){
			$this->out[$this->f[0]][$this->f[1]]['#val'] = $cdata;
		}
		elseif (!$this->f[4] && !$this->f[5]){
			$this->out[$this->f[0]][$this->f[1]][$this->f[2]][$this->f[3]]['#val'] = $cdata;
		}
		elseif (!$this->f[6] && !$this->f[7]){
			$this->out[$this->f[0]][$this->f[1]][$this->f[2]][$this->f[3]][$this->f[4]][$this->f[5]]['#val'] = $cdata;
		}
	}
	
	function tag_close($parser, $tag){
		array_pop($this->f);
		array_pop($this->f);
	}
	
	function optimize($a)//structure sensetive !!!!!!!!!!!
	{
		$array = $a[0]['MODULE'];
		while ($val = current($array)){
			if (!is_string(key($array))){
				$current_key = key($array);
				$current_subkeys = @array_keys($array[$current_key]);
				next($array);
				$next_key = key($array);
				$next_subkeys = @array_keys($array[$next_key]);
				if (is_array($array[$current_key]) && is_array($array[$next_key]) && $current_subkeys[0] == $next_subkeys[0]){
					$array2[$current_key] = array_merge_recursive($array[$current_key],$array[$next_key]);
				}
			}else{
				$array2[key($array)] = $array[key($array)];
				next($array);				
			}
		}
		foreach ($array2 as $k => $v){
			if (!is_string($k)){
				$subkeys = @array_keys($v);
				$array3[$subkeys[0]] = $v[$subkeys[0]];
			}else{
				$array3[$k] = $v;
			}
		}
		$o['MODULE'] = $array3;
		return $o;
	}
	
	function _op1($array)
	{
		if (count($array)==1)
		{
			
		}
	}
	
	function iconv($array)
	{
		foreach ($array as $key => $val)
		{
			if (is_string($val))
			{
				$array[$key] = iconv('UTF-8', 'windows-1251', $val);
			}
			elseif (is_array($val))
			{
				$array[$key] = $this->iconv($val);
			}
		}
		return $array;
	}
	
	function mark_attrs($array){
		foreach ($array as $key => $val){ $array2["@$key"] = $val; }
		return $array2;
	}
	
	function clear_empty($array)
	{
		foreach ($array as $key => $val){
			if (is_array($val) && $v = $this->clear_empty($val)){
				$array2[$key] = $v;
			}
			elseif ($val && !is_array($val)){
				$array2[$key] = $val;
			}
		}
		return $array2;
	}
}
?>