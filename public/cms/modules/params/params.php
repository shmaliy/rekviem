<?php
include_once 'params_gen.php';
class params extends params_gen
{
	/* ---NAVIGATION FUNCTIONS--- */
	function page(){
		return $this->_toolbar().$this->table();
	}
	/* ---/NAVIGATION FUNCTIONS--- */
	
	/* ---LIST FUNCTIONS--- */
	/* ---/LIST FUNCTIONS--- */
	
	/* ---EDITOR FUNCTIONS--- */
	function _save_p($data){
		$return = array();
		$f = $this->core->prepare_form_data($data[0]);		
		$m_info = $this->core->_mod_get_info($data[2]);
		$refn = $m_info['MODULE']['SHORTNAME']['#val'];			
		$error = array();
		$db = array();
		$prefix = 'params_'.$data[1].'_'.$data[2];
		$fdata = $f[$prefix];
		if ($fdata[$prefix.'_title'] != ''){
			if ($fdata[$prefix.'_type'] == 0){ $error[] = 'Выберите тип параметра <b>'.$refn.' параметр '.$data[1].'</b>'; }
			elseif ($fdata[$prefix.'_type'] == 4 || $fdata[$prefix.'_type'] == 5 || $fdata[$prefix.'_type'] == 6){
				if ($fdata[$prefix.'_src'] == '0'){
					$error[] = "Выберите исходные значения для <b>'.$refn.' параметр '.$data[1].'</b>'";
				}
			}
		}
		if (count($error) == 0){
			$id = $fdata[$prefix.'_db_id'];
			$sql['ref_title'] = $fdata[$prefix.'_title'];
			$sql['ref_type'] = $fdata[$prefix.'_type'];
			$sql['ref_in_list'] = ($fdata[$prefix.'_in_list']=='true') ? '1': '0';
			$sql['ref_src'] = $fdata[$prefix.'_src'];
			$sql['ref_srcv'] = $fdata[$prefix.'_srcv'];
			if ($this->update($sql, $id)){ $return[] = array('call', 'message', "Изменения сохранены");
			}else { $return[] = array('call', 'message', "Ошибка сохранения<br />".implode('<br />', $sql).$id); }			
		}else{
			$return[] = array('call', 'message', implode('<br />', $error));
		}
		return $return;
	}

	function adv_save($data, $sql, $module){
		$plist = $this->get_list($module, '');
		foreach ($data as $k => $param){
			if (substr($k, 0, 5) === 'param'){
				$type = 0;
				foreach ($plist as $p){
					if ('param'.$p['ref_number'] == $k){ $type = $p['ref_type']; }
				}
				if ($type != 0){
					if ($type == 3){ $sql[$k] = ($param == 'true') ? '1' : '0'; }
					elseif ($type == 6){ $sql[$k] = implode('|', $param); }
					else{ $sql[$k] = $param; }
				}
			}
		}
		return $sql;
	}
	
	function toggle($data){
		$mod = new $data[0];
		$param = $mod->get($data[1], $data[2]);
		if ($param == 0){ $mod->update_e($data[2], 1, $data[1]); }
		elseif ($param == 1){ $mod->update_e($data[2], 0, $data[1]); }
		$return[] = array('assign', $mod->name.'_table', 'innerHTML', $mod->table());
		return $return;		
	}
	
	function srcv_upd($data){
		if ($data[2] == 'categories'){
			$m = new categories();
			$return[] = array('assign', $this->name.'_'.$data[0].'_'.$data[1].'_srcv', 'innerHTML', '<select name="'.$this->name.'_'.$data[0].'_'.$data[1].'_srcv">'.$m->tree(0, 0, 0).'</select>');	
		}else{
			$return[] = array('assign', $this->name.'_'.$data[0].'_'.$data[1].'_srcv', 'innerHTML', '<select name="'.$this->name.'_'.$data[0].'_'.$data[1].'_srcv"></select>');
		}
		return $return;
	}
	
	function popup($data){
		$p[] = 'width=800&height=515&title=Выбор&close=true';
		$p[] = $this->adv_popup($data[0], substr($data[1],5,strlen($data[1])), $data[2]);
		$return[] = array('call', 'modal.show', $p);
		return $return;		
	}
	/* ---/EDITOR FUNCTIONS--- */
	
	/* ---SUB FUNCTIONS--- */
	/* ---/SUB FUNCTIONS--- */
}
?>