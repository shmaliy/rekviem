<?php
class params_db
{
	function __construct(){
		$this->name = 'params';
		$this->core = new core();
		$this->tpl = new core_tpl();
		$this->info = $this->core->_mod_get_info($this->name);
		$this->mod_tablename = $GLOBALS['cms_config_dbprefix'].'params';
		
		$this->ref = array('categories', 'content', 'users2','shop_goods');
		$this->type = array('- Выберите тип поля -','TEXT','TEXTAREA (tinyMCE)','CHECKBOX','POPUP','SELECT','MULTI SELECT');
		$this->src = array('- Выберите модуль -','tags','categories','content','users2');
		
		$query  = "CREATE TABLE IF NOT EXISTS `$this->mod_tablename` ( ";
		$query .= "`id` INT NOT NULL AUTO_INCREMENT, ";
		$query .= "`ref_number` INT NOT NULL, ";
		$query .= "`ref_module` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`ref_title` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`ref_type` INT NOT NULL, ";
		$query .= "`ref_src` TEXT CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, ";
		$query .= "`ref_srcv` INT NOT NULL, ";
		$query .= "`ref_in_list` INT NOT NULL, ";
		$query .= "PRIMARY KEY (`id`)); ";
		@mysql_query($query); 		
		
		foreach ($this->ref as $ref){
			if (@class_exists($ref, false)){
				$params = @mysql_query("SELECT * FROM `$this->mod_tablename` WHERE `ref_module` = '$ref';");
				if (@mysql_num_rows($params)<1){
					$fields = @mysql_query("SHOW COLUMNS FROM ".$GLOBALS['cms_config_dbprefix'].$ref);
					$f = array();
					if ($fields && mysql_num_rows($fields) > 0){
					    while ($row = mysql_fetch_assoc($fields)) {
					        $f[] = $row['field'];
					    }					
					}
					for ($j=1; $j<21; $j++){
						$ok = 0;
						foreach ($f as $field){
							if ($field == 'param'.$j){
								$ok++;
							}
						}
						if($ok == 0){						
							$q = "INSERT INTO `$this->mod_tablename` SET ";
							$q .= "`ref_number` = $j, ";
							$q .= "`ref_module` = '$ref', ";
							$q .= "`ref_title` = '', ";
							$q .= "`ref_type` = 0, ";
							$q .= "`ref_src` = '',";
							$q .= "`ref_in_list` = 0";
						@mysql_query($q);
						}
					}
				}
			}			
		}
		
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
		$query .= (isset($parent)) ? " WHERE `ref_module` = '$parent'" : ''; 
		$query .= " ORDER BY `ref_number` asc"; 
		$query .= ($limit != '') ? " LIMIT $limit" : "";
		$req = @mysql_query($query);
		if ($req && mysql_num_rows($req)>0){
			while ($row = mysql_fetch_assoc($req)){
				$data[] = $row; 
			}
			return $data;
		}else return false;
	}
	
	function get_item($ref, $num){
		$query = "SELECT * FROM `$this->mod_tablename` WHERE `ref_module` = '$ref' AND `ref_number` = '$num'"; 
		$req = @mysql_query($query);
		if ($req && mysql_num_rows($req)>0){
			return mysql_fetch_assoc($req);
		}else return false;
	}
	
	function update($data, $id){
		$data = $this->core->prepare_sql_data($data);
		foreach ($data as $k=>$v){ $q[] = "`$k` = '$v'"; }
		if (@mysql_query("UPDATE `$this->mod_tablename` SET ".implode(', ', $q)." WHERE `id` = $id LIMIT 1")){ return true; }
		else return false;
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
