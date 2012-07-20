<?

/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleImage {
 
	private $_cacheDirName;
	private $_cachePath;
	private $_image;
	private $_image_type;
	private $_filename;
	private $_compression = 100;
	private $_registeredMimes;
	
	public function __construct()
	{
		$this->_registeredMimes = array(
				'jpeg'	=> 'image/jpeg',
				'png'	=> 'image/png',
				'gif'	=> 'image/gif',
		);
	}
   
	public function setCacheDirName($dir = null)
	{
		$this->_cacheDirName = $dir;
		//TODO
		if (is_null($this->_cacheDirName)) {
			$this->_cachePath = $this->_filename;
		} else {
			$parts = explode('/', $this->_filename);
			$parts[count($parts)] = end($parts);
			$parts[count($parts)-2] = $this->_cacheDirName;
			
			$dir = $parts;
			unset ($dir[count($dir)-1]); 
			$dir = implode('/', $dir);
			
			if (!is_dir($dir)) {
				mkdir($dir, 0777);
			}
			
			$this->_cachePath = implode('/', $parts);
		}
	}
	
	public function setCompression($compression)
	{
		$this->_compression = $compression;
	}
   
	public function setImage($filename)
	{
		$this->_filename = trim($filename, '/');  	
		
		$image_info = getimagesize($this->_filename);
		$this->_image_type = $image_info[mime];
		
		if ($this->_image_type == $this->_registeredMimes['jpeg']) {
			$this->_image = imagecreatefromjpeg($this->_filename);
		} elseif ($this->_image_type == $this->_registeredMimes['gif']) {
			$this->_image = imagecreatefromgif($this->_filename);
		} elseif ($this->_image_type == $this->_registeredMimes['png']) {
			$this->_image = imagecreatefrompng($this->_filename);
		}
	}
   
	public function save () 
	{
 
		if (is_file($this->_cachePath)) {
			return $this->_cachePath;
		}
		if ($this->_image_type == $this->_registeredMimes['jpeg']) {
			imagejpeg($this->_image, $this->_cachePath, $this->_compression);

		} elseif ($this->_image_type == $this->_registeredMimes['gif']) {
 
			imagegif($this->_image, $this->_cachePath);
		} elseif ($this->_image_type == $this->_registeredMimes['png']) {
 
			imagepng($this->_image, $this->_cachePath, $this->_compression/100);
		}
		return $this->_cachePath;
	}
   
	private function getWidth() 
	{
 
		return imagesx($this->_image);
	}
   
	private function getHeight() 
	{
 
		return imagesy($this->_image);
	}
   
	public function resizeToHeight ($height) 
	{
		if (!is_file($this->_cachePath)) {
			$ratio = $height / $this->getHeight();
			$width = $this->getWidth() * $ratio;
			$this->resize($width, $height);
		}
	}
 
	public function resizeToWidth ($width) 
	{
		if (!is_file($this->_cachePath)) {
			$ratio = $width / $this->getWidth();
			$height = $this->getheight() * $ratio;
			$this->resize($width, $height);
		}
	}
 
	public function scale($scale) 
	{
		if (!is_file($this->_cachePath)) {
			$width = $this->getWidth() * $scale/100;
			$height = $this->getheight() * $scale/100;
			$this->resize($width, $height);
		}
	}
 
	public function resize($width, $height) 
	{
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->_image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->_image = $new_image;
   }      
 
}
?> 
