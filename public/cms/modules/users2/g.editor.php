<?php
	function editor($id){
		$params = (class_exists('params', false)) ? new params() : false;
		$o['{#name#}'] = $this->name;
		$o['{#id#}'] = $id;
		if ($id != 'new'){
			$user = $this->get($id);
			$o['{#image#}'] = ($user['image'] != '') ? BASEDIR."/image.php?image=../".substr($user['image'],1,strlen($user['image']))."&mode=square_fit&p1=100" : BASEDIR.'/images/blank.png';
			$o['{#imagepath#}'] = $user['image'];
			$o['{#login#}'] = $user['login'];
			$o['{#username#}'] = $user['name'];
			$o['{#email#}'] = $user['email'];
			$o['{#block#}'] = ($user['block'] == 0) ? '' : ' checked';
			$o['{#usertype#}'] = $this->tree(0,0,$user['usertype']);
			$o['{#p#}'] = 'П';
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name, $user) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name, $user) : '';
		}else{
			$o['{#image#}'] = BASEDIR.'/images/blank.png';
			$o['{#imagepath#}'] = '';
			$o['{#login#}'] = '';
			$o['{#username#}'] = '';
			$o['{#email#}'] = '';
			$o['{#block#}'] = '';
			$o['{#usertype#}'] = $this->tree(0,0,0);
			$o['{#p#}'] = 'Новый п';
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name) : '';
		}
		$_SESSION['cms']['menudisable']=1;
		return $this->core->tpl->assign("modules/$this->name/tpl/editor.tpl", $o);
	}
?>