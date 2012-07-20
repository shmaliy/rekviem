<?php
function _square_fit($src, $side){
	$w = imagesx($src);
	$h = imagesy($src);
	$new_h = $new_w = $side;
	$x = $y = 0;
	if($w >= $side or $h >= $side){
		if ($w > $h){ $new_h = $h*$side/$w; $y = ($new_w-$new_h)/2; }
		elseif($w < $h){ $new_w = $w*$side/$h; $x = ($new_h-$new_w)/2; }
	}else{
		$new_h = $h;
		$new_w = $w;
		$x = ($side-$w)/2;
		$y = ($side-$h)/2;
	}
	$out = imagecreatetruecolor($side, $side);
	$background = imagecolorallocate($out, 0xFE, 0xFE, 0xFE);
	imagefilledrectangle($out, 0, 0, $side-1, $side-1, $background);
	imagecopyresampled($out,$src,$x,$y,0,0,$new_w,$new_h,$w,$h);
	return $out;
}

function _fith($src, $nh){
	$w = imagesx($src);
	$h = imagesy($src);
	$new_h = $nh;
	$x = $y = 0;
	if($h >= $nh){
		$new_w = $w*$nh/$h;
	}else{
		$new_h = $h;
		$new_w = $w;
	}
	$out = imagecreatetruecolor($new_w, $new_h);
	$background = imagecolorallocate($out, 0xFE, 0xFE, 0xFE);
	imagefilledrectangle($out, 0, 0, $new_w-1, $new_h-1, $background);
	imagecopyresampled($out,$src,$x,$y,0,0,$new_w,$new_h,$w,$h);
	return $out;
}

if($_GET['image'])
{
	header("Content-type: image/png");
	$source = strtolower($_GET['image']);
	
	switch (substr(strtolower($source), -3)){
		case "jpg" : $im = imagecreatefromjpeg($source);
			break;
		case "gif" : $im = imagecreatefromgif($source);
			break;
		case "png" : $im = imagecreatefrompng($source);
			break;
	}
	
	if ($_GET['mode']){
		switch ($_GET['mode']){
			case "square_fit" : $out = _square_fit($im, $_GET['p1']);				
				break;
			case "fith" : $out = _fith($im, $_GET['p1']);				
				break;
		}
	}else{
		$out = $im;
	}
	
	imagepng($out);
	imagedestroy($out);
}
?>
