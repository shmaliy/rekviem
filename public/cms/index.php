<?php 
if (!@fopen('bridge.php', 'r')){
	echo 'unpack cms files';
	$zip = zip_open(getcwd().'/cms.zip');
	if ($zip){
		while ($entry = zip_read($zip)){
			if (zip_entry_filesize($entry)==0){
				@mkdir(zip_entry_name($entry));
				//echo zip_entry_name($entry).'<br>';
			}else{
				$of = fopen(zip_entry_name($entry),'wb');
				$fileSize = zip_entry_filesize($entry);
				while ($fileSize>0) {
				    $readSize = min($fileSize,10240); // read/write only up to 10kb per step
				    $fileSize -= $readSize; // decrease the size of the remaining data to read
				    $content = zip_entry_read($entry, $readSize); // get the data
				    if ($content !== false){ fwrite($of,$content); } // write the data (if any)
				}
				fclose($of);
				zip_entry_close($entry);
			}
		}
		zip_close($zip);
	}else{echo 'cannot open zip file';}
	echo '<script>window.location.href="'.str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace("\\", '/', getcwd())).'";</script>';
}else{ require('bridge.php'); }
//var_export($_SESSION);
?>
