<?php
	function editor($id){
		$categories = new categories();
		$params = (class_exists('params', false)) ? new params() : false;
		$users = (class_exists('users', false)) ? new users() : false;
		$o['{#name#}'] = $this->name;
		$o['{#id#}'] = $id;
		if ($id == 'new'){
			$o['{#tree#}'] = $categories->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
			$o['{#introtext#}'] = '';
			$o['{#fulltext#}'] = '';
			$o['{#published#}'] = 'checked';
			$o['{#title#}'] = '';
			$o['{#alias#}'] = '';
			$o['{#hits#}'] = '0';
			$o['{#created#}'] = date('Y-m-d H:i:s');
			$o['{#publish_up#}'] = date('Y-m-d H:i:s');
			$o['{#publish_down#}'] = '0000-00-00 00:00:00';
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name) : '';
			$o['{#image_editor#}'] = $this->core->fb_editor($this->name);
			$o['{#created_by#}'] = ($users) ? $users->tree($_SESSION['cms']['user_id']) : '';
		}else{
			$data = $this->get($id);
			$o['{#tree#}'] = $categories->tree(0, 0, $data['parent_id']);
			$o['{#introtext#}'] = $data['introtext'];
			$o['{#fulltext#}'] = $data['fulltext'];
			$o['{#published#}'] = ($data['published'] == '1') ? 'checked' : '';
			$o['{#title#}'] = htmlspecialchars($data['title']);
			$o['{#alias#}'] = htmlspecialchars($data['title_alias']);
			$o['{#hits#}'] = ($data['hits'] != '')? $data['hits'] : '0';
			$o['{#created#}'] = $this->_ts_to_dt($data['created']);
			$o['{#publish_up#}'] = $this->_ts_to_dt($data['publish_up']);
			$o['{#publish_down#}'] = $this->_ts_to_dt($data['publish_down']);
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name, $data) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name, $data) : '';
			$o['{#image_editor#}'] = $this->core->fb_editor($this->name, $data);
			$o['{#created_by#}'] = ($users) ? $users->tree($data['created_by']) : '';
		}
		$_SESSION['cms']['menudisable']=1;
		return $this->core->tpl->assign("modules/$this->name/tpl/editor.tpl", $o);
	}
?>