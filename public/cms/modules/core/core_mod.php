<?php
class core_mod
{
	function _mod_init(){
		/*$this->mod_tablename = $GLOBALS['cms_config_dbprefix'].'modules';
		
		// CREATE MODULES TABLE
		$q =  "CREATE TABLE IF NOT EXISTS `$this->mod_tablename` (";
		$q .= "`id` INT NOT NULL AUTO_INCREMENT ,";
		$q .= "`name` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL ,";
		$q .= "`allowed` INT DEFAULT '0' ,";
		$q .= "PRIMARY KEY ( `id` ));";
		@mysql_query($q);
		
		// CHECK MODULES
		if (is_dir('modules') && $dir = opendir('modules')){
			while (false !== ($file = readdir($dir))){
				if ($file != "." && $file != ".." && is_dir("modules/$file")){
					if (file_exists("modules/$file/$file.php") && file_exists("modules/$file/$file.xml")){
						$m[] = $file;
					}
				}
			}
			closedir($dir);
		}
		
		// COMPARE WITH DATABASE
		if ($m){
			$q = @mysql_query("SELECT * FROM `$this->mod_tablename`");
			if (mysql_num_rows($q)==0){
				foreach ($m as $v){
					@mysql_query("INSERT INTO `$this->mod_tablename` VALUES ( '' , '".$v."' , '0' )");
				}
			}	
			elseif (mysql_num_rows($q)>0){
				while ($row = mysql_fetch_assoc($q)){
					$db_m[] = $row;
				}
				if ($db_m){
					$add = false;
					foreach ($m as $v){
						$c = 0;
						foreach ($db_m as $db_v){
							if ($v == $db_v['name']){ $c++; }
						}
						if ($c == 0){ $add[] = $v; }
					}
					if ($add){
						foreach ($add as $v)
						{
							@mysql_query("INSERT INTO `$this->mod_tablename` VALUES ( '' , '".$v."' , '0' )");
						}
					}
				}
			}
		}
		*/
		// CREATE INCLUDES FILE
		//$q = @mysql_query("SELECT * FROM `$this->mod_tablename`");
		if (is_dir('modules') && $dir = opendir('modules')){
			$f = fopen('includes.php', 'w+');
			while (false !== ($file = readdir($dir))){
				if ($file != "." && $file != ".." && is_dir("modules/$file")){
					if (file_exists("modules/$file/$file.php") && file_exists("modules/$file/$file.xml")){
						$m[] = $file;
					}
				}
			}
			closedir($dir);
			/*while ($row = mysql_fetch_assoc($q)){
				$db_m2[] = $row;
			}*/
			$str = "<?php\n";
			foreach ($m as $v){
				if ($v['name'] != 'core'){
					if (file_exists("modules/".$v."/".$v.".php") && file_exists("modules/".$v."/".$v.".xml")){
						$str .= "include_once 'modules/".$v."/".$v.".php';\n";
					}
				}
			}
			$str .= "?>";
		    fputs ($f, $str);
		  	fclose ($f);
		}
	}
	
	function _mod_get_installed(){
		if (is_dir('modules') && $dir = opendir('modules')){
			while (false !== ($file = readdir($dir))){
				if ($file != "." && $file != ".." && is_dir("modules/".$file) && $file != 'core'){
					if (file_exists("modules/$file/$file.php") && file_exists("modules/$file/$file.xml")){
						$m[] = $file;
					}
				}
			}
			closedir($dir);
			return $m;
		}
		else return false;
	}
	
	public function _mod_get_info($module){		
		$xml = new xml();
		return $xml->parse(file_get_contents("modules/$module/$module.xml"));
	}
}
?>