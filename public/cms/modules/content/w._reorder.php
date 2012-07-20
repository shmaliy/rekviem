<?php
	function _reorder($data){
		$categories = new categories();
		if ($data[0] == 'up'){
			$el = $this->get($data[1]);
			$list = $this->get_list($el['parent_id']);
			foreach ($list as $item){
				if ($item['ordering'] == $el['ordering']-1){
					$this->update_e('ordering', $item['ordering']+1, $item['id']);
				}
			}
			$this->update_e('ordering', $el['ordering']-1, $el['id']);
			$this->_reset_order($el['parent_id']);
		}
		elseif ($data[0] == 'down'){
			$el = $this->get($data[1]);
			$list = $this->get_list($el['parent_id']);
			foreach ($list as $item){
				if ($item['ordering'] == $el['ordering']+1){
					$this->update_e('ordering', $item['ordering']-1, $item['id']);
				}
			}
			$this->update_e('ordering', $el['ordering']+1, $el['id']);
			$this->_reset_order($el['parent_id']);
		}
		elseif ($data[0] == 'total'){
			foreach ($data[1] as $item){ $this->update_e('ordering', $item[1], $item[0]); }
			$this->_reset_order($_SESSION['cms']['mod'][$this->name]['parent']);
		}
		return array(array('assign', $this->name.'_table', 'innerHTML', $this->table()));
	}
?>