<?php
	function table(){
		$_SESSION['cms']['menudisable'] = 0;
		$categories = (class_exists('categories', false)) ? new categories() : false;
		$params = (class_exists('params', false)) ? new params() : false;
		$users = (class_exists('users', false)) ? new users() : false;
		
		$m = $_SESSION['cms']['mod'][$this->name];
		$mr = $m['rnum'];
		$mp = $m['page'];
		$p = $m['parent'];
		$lim = ($mr != 0) ? $mr*$mp-$mr.', '.$mr : '';
		$list = $this->get_list($p, $lim);
		if ($list){
			$c=0;
			foreach ($list as $i){
				foreach ($i as $f => $v){ $r["{#$f#}"] = $v; }
				$r['{#title#}'] = ($i['title_alias'] != '') ? $i['title'].' ( '.$i['title_alias'].' )' : $i['title'];
				$r['{#parent_id#}'] = ($i['parent_id'] != 0) ? $categories->get($i['parent_id'], 'title') : '- НЕТ -';
				$r['{#published#}'] = ($i['published'] == 1) ? '<img src="'.BASEDIR.'/images/adm/tick.png" />' : '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
				if ($i['checked_out'] == 0){
					$r['{#checked_out#}'] = '<input name="'.$i['id'].'" type="checkbox"></td>';
					$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
					$r['{#published#}'] = '<a href="' . "javascript:call('$this->name', '_publish', '" . $i['id'] . '\');">'.$r['{#published#}'].'</a>';
				}else{
					$r['{#checked_out#}'] = '<img src="'.BASEDIR.'/images/adm/checked_out.png" />';
					if ($i['checked_out'] == $_SESSION['cms']['user_id']){
						$r['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $i['id'] . '\');">'.$r['{#title#}'].'</a>';
						$r['{#published#}'] = '<a href="' . "javascript:call('$this->name', '_publish', '" . $i['id'] . '\');">'.$r['{#published#}'].'</a>';
					}
				}
				$reorder['{#name#}'] = $this->name;
				$reorder['{#id#}'] = $i['id'];
				if (count($list) == 1){ $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.none.tpl', $reorder); }
				elseif ($c == 0 && $c < count($list)-1){ $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.top.tpl', $reorder); }
				elseif ($c == count($list)-1){ $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.bottom.tpl', $reorder); }
				else { $r['{#sort#}'] = $this->core->tpl->assign('tpl/sort.middle.tpl', $reorder); }
				$r['{#sort#}'] .= '<input name="'.$i['id'].'" size="5" value="'.$i['ordering'].'" class="order" />';
				$r['{#adv_fields#}'] = ($params != false) ? $params->adv_row($this->name, $i) : '';
				$o['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_row.tpl", $r);
				$c++;
			}
		}else { $o['{#items#}'] = '<tr><td colspan="30">Пусто</td></tr>'; }
		$o['{#basedir#}'] = BASEDIR;
		$o['{#name#}'] = $this->name;
		$o['{#navigator#}'] = $this->_navigator();
		$o['{#adv_fields#}'] = ($params != false) ? $params->adv_head($this->name) : '';
		$o['{#tree#}'] = $categories->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
		return $this->core->tpl->assign("modules/$this->name/tpl/table.tpl", $o);
	}
?>