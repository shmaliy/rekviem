<?php
	function table(){
		$_SESSION['cms']['menudisable'] = 0;
		$params = (class_exists('params', false)) ? new params() : false;
		
		$m = $_SESSION['cms']['mod'][$this->name];
		$mr = $m['rnum'];
		$mp = $m['page'];
		$p = $m['parent'];
		$lim = ($mr != 0) ? $mr*$mp-$mr.', '.$mr : '';
		$list = ($p != 0) ? $this->get_list($p, $lim) : $this->get_list(NULL, $lim);
		if ($list){
			$c=0;
			foreach ($list as $i){
				foreach ($i as $f => $v){ $r["{#$f#}"] = $v; }
				$r['{#title#}'] = ($i['name'] != '') ? $i['name'].' ( '.$i['login'].' )' : $i['login'];
				$r['{#block#}'] = ($i['block']==0) ? '<img src="'.BASEDIR.'/images/adm/tick.png" />' : '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
				if ($i['checked_out'] == 0){
					$r['{#checked_out#}'] = '<input name="'.$i['id'].'" type="checkbox"></td>';
					$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
					$r['{#block#}'] = '<a href="' . "javascript:call('$this->name', '_block', '" . $i['id'] . '\');">'.$r['{#block#}'].'</a>';
				}else{
					$r['{#checked_out#}'] = '<img src="'.BASEDIR.'/images/adm/checked_out.png" />';
					if ($i['checked_out'] == $_SESSION['cms']['user_id']){
						$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
						$r['{#block#}'] = '<a href="' . "javascript:call('$this->name', '_block', '" . $i['id'] . '\');">'.$r['{#block#}'].'</a>';
					}
				}
				$r['{#usertype#}'] = $GLOBALS['usertypes'][$i['usertype']];
				$r['{#logged#}'] = ($this->get_logged($i['id'])) ? '<img src="'.BASEDIR.'/images/adm/tick.png" />' : '';
				$r['{#adv_fields#}'] = ($params) ? $params->adv_row($this->name, $i) : '';
				$o['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_row.tpl", $r);
				$c++;
			}
		}else { $o['{#items#}'] = '<tr><td colspan="30">Пусто</td></tr>'; }
		$o['{#basedir#}'] = BASEDIR;
		$o['{#name#}'] = $this->name;
		$o['{#navigator#}'] = $this->_navigator();
		$o['{#adv_fields#}'] = ($params != false) ? $params->adv_head($this->name) : '';
		$o['{#tree#}'] = $this->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
		return $this->core->tpl->assign("modules/$this->name/tpl/table.tpl", $o);
	}
?>