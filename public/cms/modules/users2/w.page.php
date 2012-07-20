<?php
	function page(){
		global $url_query;
		if (count($url_query)==2){
			return $this->_toolbar('list').'<div class="list" id="'.$this->name.'_table">'.$this->table().'</div>';
		}
		elseif (count($url_query)==3 && $url_query[2] == 'new'){
			return $this->_toolbar('new').$this->editor($url_query[2]);
		}
		elseif (count($url_query)==3 && $url_query[2] != 'new'){
			return $this->_toolbar('edit', $url_query[2]).$this->editor($url_query[2]);
		}
	}
?>