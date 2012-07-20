<?php
class categories_db
{
	function __construct(){
		$this->name = 'categories';
		$this->core = new core();
		$this->tpl = new core_tpl();
		$this->info = $this->core->_mod_get_info($this->name);
		$this->mod_tablename = $GLOBALS['cms_config_dbprefix'].'categories';
		
		$query  = "CREATE TABLE IF NOT EXISTS `$this->mod_tablename` ( ";
		$query .= "`id` INT NOT NULL AUTO_INCREMENT, ";
		$query .= "`parent_id` INT NOT NULL, ";
		$query .= "`title` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`title_alias` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`description` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`published` INT NOT NULL, ";
		$query .= "`checked_out` INT NOT NULL, ";
		$query .= "`checked_out_time` DATETIME NOT NULL, ";
		$query .= "`ordering` INT NOT NULL, ";
		$query .= "`image` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`images` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param1` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param2` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param3` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param4` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param5` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param6` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param7` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param8` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param9` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param10` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param11` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param12` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param13` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param14` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param15` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param16` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param17` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param18` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param19` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`param20` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "PRIMARY KEY (`id`)); ";
		@mysql_query($query); 		
				
		if (!$_SESSION['cms']['mod'][$this->name] && $_SESSION['cms']['authorized'] == 1){
			$_SESSION['cms']['mod'][$this->name] = array('rnum' => 20, 'page' => 1, 'parent' => 0);
		}
	}
	
	function get($id, $field = NULL){
		$query = "SELECT * FROM `$this->mod_tablename` WHERE `id` = $id LIMIT 1";
		$req = @mysql_query($query);
		if ($req && mysql_num_rows($req)==1){
			$data = mysql_fetch_assoc($req);
			return ($field) ? $data[$field] : $data;
		}
		else return false;
	}
	
	function get_list($parent = NULL, $limit = NULL){
		$query = "SELECT * FROM `$this->mod_tablename`";
		$query .= (isset($parent)) ? " WHERE `parent_id` = $parent" : ''; 
		$query .= " ORDER BY `parent_id`, `ordering`"; 
		$query .= ($limit != '') ? " LIMIT $limit" : "";
		$req = @mysql_query($query);
		if ($req && mysql_num_rows($req)>0){
			while ($row = mysql_fetch_assoc($req)){
				$data[] = $row; 
			}
			return $data;
		}else return false;
	}
	
	function insert($data){
		if ($this->get_list($data['parent_id'],'')){
			$this->_increment_order($data['parent_id']);
		}
		$data = $this->core->prepare_sql_data($data);
		foreach ($data as $k=>$v){
			if ($k != 'id'){ $q[] = "`$k` = '$v'"; }
		}
		if (@mysql_query("INSERT INTO `$this->mod_tablename` SET ".implode(', ', $q))){
			return true;
		}else return false;
	}
	
	function update($data, $id){
		if (is_int($id)){
			$data = $this->core->prepare_sql_data($data);
			foreach ($data as $k=>$v){
				$q[] = "`$k` = '$v'";
			}
			if (@mysql_query("UPDATE `$this->mod_tablename` SET ".implode(', ', $q)." WHERE `id` = $id LIMIT 1")){
				return true;
			}else return false;
		}else return false;
	}
	
	function update_e($field, $val, $id){
		if (@mysql_query("UPDATE `$this->mod_tablename` SET `$field` = '$val' WHERE `id` = $id LIMIT 1")){return true;}
		else return false;
	}
	
	function delete($id){
		if (@mysql_query("DELETE FROM `$this->mod_tablename` WHERE `id` = $id LIMIT 1")){return true;}
		else return false;
	}

	function _increment_order($parent){
		$elems = $this->get_list($parent);
		if ($elems){
			$i=2;
			foreach ($elems as $item){
				$this->update_e('ordering', "$i", $item['id']);
				$i++;
			}
		}
	}
}
