<?php
class myHelpers
{
	//public $img;
	
	function __construct()
	{
		//$this->img = new img();
	}
	
	function makeGet($array)
	{
		if(!empty($array) && is_array($array)){
			foreach($array as $key=>$item){
				$new[] = $key . '=' . $item;
			}
			return '?' . implode('&', $new);
		} else {
			return false;
		}
	}
	
	function parseGet($array)
	{
		if(!empty($array)){
			foreach($array as $key=>$value){
				$new[] = "'_GET_" . $key . "':'" . $value . "'";
			}
			return ', ' . implode(',', $new);
		} else {
			return false;
		}
	}
	
	function changeGetParam($array)
	{
		if(!empty($array) && is_array($array)){	
			foreach($_GET as $key=>&$item){
				foreach($array as $akey=>$aitem){
					if($key == $akey){
						$item = $aitem;
					}
				}	
				$new[] = $key . '=' . $item;
			}
			return '?' . implode('&', $new);
		} else {
			return false;
		}
	}
	
	function addGetParam($array)
	{
		if(!empty($array) && is_array($array)){	
			foreach($array as $key=>$item){
				$_GET[$key] = $item;
			}
			foreach($_GET as $gkey=>$gitem){
				$new[] = $gkey . '=' . $gitem;
			}
			return '?' . implode('&', $new);
		} else {
			return false;
		}
	}
	
	function removeGetParam($array)
	{
		if(!empty($array) && is_array($array)){
			foreach($array as $item){
				unset($_GET[$item]);
			}
			foreach($_GET as $gkey=>$gitem){
				$new[] = $gkey . '=' . $gitem;
			}
			return '?' . implode('&', $new);
		} else {
			return false;
		}
	}
	
	function arrayTrans($array)
	{
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
	
	function createJson($tree)
	{
		if (is_array($tree) && !empty($tree)) {
			$json = array();
			foreach ($tree as $rown => $row) {
				$r = array();
				foreach ($row as $cellName => $cell) {
					$r[] = "'$cellName':'" . $cell . "'";
				}
				$trees[] = '{' . implode(', ', $r) . '}';
			}
			$trees = '[' . implode(', ', $trees) . ']';
			return $trees;
		} else {
			return '[{}]';
		}
	}
	
	public function toFrontend(&$string, $key = null)
	{
		$string = iconv('UTF-8', 'windows-1251', $string);
	}
	
	public function toServer(&$string, $key = null)
	{
		$string = iconv('windows-1251', 'UTF-8', $string);
	}
	
	public function encToFrontend($array)
	{
		array_walk_recursive($array, array($this, 'toFrontend'));
		return $array;
	}
	
	public function encToServer($array)
	{
		array_walk_recursive($array, array($this, 'toServer'));
		return $array;
	}
	
	public function returnPosition()
	{
		$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
		unset($url[count($url)-1]);
		return '/' . implode('/', $url);
	}
	
	public function createTimestamp($str)
	{
		if(empty($str)){
			return false;
		}
		
		$date = explode(' ', $str);
		$day = explode('-', $date[0]);
		if(!isset($date[1])){
			$date[1] = '00:00:00';
		}
		$time = explode(':', $date[1]);
		
		if($time[0] > 24 || $time[1]> 59 || $time[2]> 59  || $day[1] > 12 || $day[2]> 31){
			return false;
		}
		
		return mktime($time[0], $time[1], $time[2], $day[1], $day[2], $day[0]);
	}
	
	public function validateEmail($data)
	{
		if(empty($data)) return false;
		if(preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $data))
		{
			return true;
		}else{return false;
		}
	}
	
	function RemoveDir($path)
	{
		if(file_exists($path) && is_dir($path)){
			$dirHandle = opendir($path);
			while (false !== ($file = readdir($dirHandle))){
				if ($file!='.' && $file!='..'){
					$tmpPath=$path.'/'.$file;
	
					if (is_dir($tmpPath)){
						// если папка
						$this->RemoveDir($tmpPath);
					} else {
						if(file_exists($tmpPath)) {
							// удаляем файл
							unlink($tmpPath);
						}
					}
				}
			}
			closedir($dirHandle);
	
			// удаляем текущую папку
			if(file_exists($path)){
				rmdir($path);
			}
		}
		else{}
	}
	
	public function imgarray($dir)
	{
		$img = array();
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if($file=='.' || $file =='..'){
					} else{$dirs[] = $file;
					}
				}
				closedir($dh);
			}
		} else {
			return $img;
		}
	
		if(is_array($dirs) && !empty($dirs)){
			foreach($dirs as $item){
				if(strstr($item, '.jpg') || strstr($item, '.jpeg')){
					$img[] = array(
									"small" => $dir . '/cache_100px/' . $item,
									"big" => $dir . '/' . $item
					);
				}
			}
			return $img;
		} else {
			return $img;
		}
	}
	
	public function copyImagesToPlace($images = null, $newdir = null, $olddir)
	{
		if(is_null($images) || is_null($newdir)){
			return false;
		}
		$files = array();
		foreach($images as $item){
			$filename = explode('/', ltrim($item['big'], '/'));
			list($width, $height, $type, $attr) = getimagesize(ltrim($item['big'], '/'));
			$filename = $filename[count($filename)-1];
			if($width >= 1000 || $height >= 1000){
				$files[] = '/' . $this->img->saveimage('/image.php?i=' . ltrim($item['big'], '/') . '&t=jpg&w=1000&h=1000&m=fit', $newdir, $filename);
			} else {
				if(!is_dir($newdir)){
					mkdir($newdir, 0777);
				}
				copy(ltrim($item['big'], '/'),  $newdir . '/' . $filename);
				$files[] = '/' . $newdir . '/' . $filename;
			}
			unlink(ltrim($item['big'], '/'));
			unlink(ltrim($item['small'], '/'));
		}
		rmdir('contents/tmp_load/' . $olddir . '/cache_100px/');
		rmdir('contents/tmp_load/' . $olddir);
		return $files;
	}
	
	public function isValidTitle($title)
	{
		if(empty($title) || !preg_match('/^[a-zA-Zа-яА-Я0-9\&\!\?\;\:\№\%\&\$\s\"\'\,\+\=\«\»\-\_\*\(\)]{3,}$/', $title)){
			return false;
		} else {
			return true;
		}
	}
	
	public function isValidTextStrong($text)
	{
		if(empty($text) || (!strstr($text, '<a href="') || !strstr($text, '">')  || !strstr($text, '</a>'))){
			return false;
		} else {
			return true;
		}
	}
	
	public function isValidTextSimple($text)
	{
		if(empty($text)){
			return false;
		} else {
			return true;
		}
	}
	
	public function ukrainianMonth($timestamp = null)
	{
		if(is_null($timestamp)){
			return false;
		}	
		$month = array(
			"01" => 'січня',
			"02" => 'лютого',
			"03" => 'березня',
			"04" => 'квітня',
			"05" => 'травня',
			"06" => 'червня',
			"07" => 'липня',
			"08" => 'серпня',
			"09" => 'вересня',
			"10" => 'жовтня',
			"11" => 'листопада',
			"12" => 'грудня'
		);
		
		return $month[date('m', $timestamp)];
	}
	
	public function russianMonth($timestamp = null)
	{
		if(is_null($timestamp)){
			return false;
		}
		$month = array(
				"01" => 'января',
				"02" => 'февраля',
				"03" => 'марта',
				"04" => 'апреля',
				"05" => 'мая',
				"06" => 'июня',
				"07" => 'июля',
				"08" => 'августа',
				"09" => 'сентября',
				"10" => 'октября',
				"11" => 'ноября',
				"12" => 'декабря'
		);
	
		return $month[date('m', $timestamp)];
	}
		
}
