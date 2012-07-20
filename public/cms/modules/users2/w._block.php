<?php
	function _block($id){
		if (is_array($id)){
			if ($id[1] == 'null'){return array(array('call', 'message', "Не выбран не один элемент"));}
			else{
				$errors = array();
				$to = ($id[0] == 'true') ? '1' : '0';
				$mes = ($id[0] == 'true') ? "Элементы заблокированы" : "Элементы разблокированы";
				foreach ($id[1] as $ids){
					if (!$this->update_e('block', $to, $ids)){$errors[] = $ids;}
				}
				if (count($errors)==0){
					$return[] = array('assign', $this->name.'_table', 'innerHTML', $this->table());
					$return[] = array('call', 'message', $mes);
					return $return;
				}
				else return array(array('call', 'message', "Ошибка обработки ID: ".implode(', ', $errors)));
			}
		}else{
			$published = $this->get($id, 'block');
			if ($published == '1'){ $this->update_e('block', '0', $id); }
			else{ $this->update_e('block', '1', $id); }
			return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
		}
	}
?>