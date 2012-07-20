<?php
	function _list(){
		$m = $_SESSION['cms']['mod'][$this->name];
		$limit = ($m['rnum'] != 0) ? $m['rnum']*$m['page']-$m['rnum'].', '.$m['rnum'] : '';
		$usertype = ($m['parent'] != 0) ? $m['parent'] : '';
		$list = $this->get_list();
		if ($list){
			foreach($list as $item){
				$o['{#id#}'] = $item['id'];
				$o['{#title#}'] = ($item['name'] != '')?$item['name'].' ( '.$item['login'].' )': $item['login'];
				$o['{#logout#}'] = '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
				
				if ($item['checked_out'] == 0){
					$o['{#checked_out#}'] = '<input name="'.$item['id'].'" type="checkbox"></td>';
					$o['{#title#}'] = ($_SESSION['cms']['fp'] == 'false')?'<a href="' . "javascript:call('$this->name', '_edit', '" . $item['id'] . '\');">'.$o['{#title#}'].'</a>':$o['{#title#}'];
					$o['{#logout#}'] = '<a href="' . "javascript:call('$this->name', '_logout', '" . $item['id'] . '\');">'.$o['{#logout#}'].'</a>';
				}else{
					$o['{#checked_out#}'] = '<img src="'.BASEDIR.'/images/adm/checked_out.png" />';
					if ($item['checked_out'] == $_SESSION['cms']['user_id']){
						$o['{#title#}'] = ($_SESSION['cms']['fp'] == 'false')?'<a href="' . "javascript:call('$this->name', '_edit', '" . $item['id'] . '\');">'.$o['{#title#}'].'</a>':$o['{#title#}'];
						$o['{#logout#}'] = '<a href="' . "javascript:call('$this->name', '_logout', '" . $item['id'] . '\');">'.$o['{#logout#}'].'</a>';
					}
				}
				$o['{#usertype#}'] = $GLOBALS['usertypes'][$item['usertype']];
				if ($_SESSION['cms']['fp'] == 'true' && $this->get_logged($item['id'])){
					$out .= $this->core->tpl->assign("modules/$this->name/tpl/table_fp.tpl", $o);
				}
			}
			return $out;
		}
		else return '<tr><td colspan="9">Пусто</td></tr>';		
	}
?>