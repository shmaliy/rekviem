<?php
include_once 'params_db.php';
class params_gen extends params_db
{
	function _toolbar(){
		$buttons = array(
			'icon' => $this->info['MODULE']['ICON48']['#val'],
			'title' => $this->info['MODULE']['NAME']['#val'],
		);
		return ($buttons) ? $this->core->toolbar($buttons) : false;
	}
	
	function head(){
		$return  = '<link href="'.BASEDIR.'/modules/'.$this->name.'/'.$this->name.'.css.php" rel="stylesheet" type="text/css" />'."\n";
		return $return;
	}
	
	function table(){
		$t['{#tabs_id#}'] = $this->name.'_tabs';
		$ref = array();
		foreach ($this->ref as $r){
			if (class_exists($r, false)){ $ref[] = $r; }
		}
		if (count($ref)>0){
			for ($i=0; $i<count($ref); $i++){
				$b['{#selected#}'] = ($i==0) ? ' class="selected"' : '';
				$b['{#tabs_id#}'] = $t['{#tabs_id#}'];
				$b['{#n#}'] = "$i";
				$m_info = $this->core->_mod_get_info($ref[$i]);		
				$b['{#title#}'] = $m_info['MODULE']['SHORTNAME']['#val'];			
				$t['{#buttons#}'] .= $this->tpl->assign(TPLDIR."tabs_i_btn.tpl", $b);			
				
				$c['{#selected#}'] = ($i==0) ? ' style="display:block;"' : '';
				$it['{#items#}'] = $this->_list($ref[$i]);
				$it['{#name#}'] = $this->name;
				$it['{#n#}'] = "$i";
				$c['{#inner#}'] = $this->tpl->assign("modules/$this->name/table.tpl", $it);
				$t['{#items#}'] .= $this->tpl->assign(TPLDIR."tabs_i_body.tpl", $c);			
			}
			$o['{#name#}'] = $this->name;
			$o['{#items#}'] .= $this->tpl->assign(TPLDIR."tabs_layout.tpl", $t);
			return $this->tpl->assign("modules/$this->name/editor.tpl", $o);
		}else return '';
	}
	
	function _list($ref){
		$list = $this->get_list($ref);
		if ($list){
			for($i=0; $i<count($list); $i++){
				$o['{#id#}'] = $list[$i]['id'];
				$o['{#refn#}'] = $list[$i]['ref_number'];
				$o['{#title#}'] = $list[$i]['ref_title'];
				$o['{#in_list#}'] = ($list[$i]['ref_in_list'] != 0) ? 'checked' : '';
				$o['{#name#}'] = $this->name.'_'.$list[$i]['ref_number'].'_'.$ref;
				$o['{#nm#}'] = $this->name;
				$o['{#ni#}'] = $list[$i]['ref_number'];
				$o['{#nr#}'] = $ref;
				$o['{#type#}'] = '';
				$o['{#basedir#}'] = BASEDIR;
				for ($j=0; $j<count($this->type); $j++){
					$o['{#type#}'] .= '<option value="'.$j.'"';
					if ($list[$i]['ref_type'] == $j){
						$o['{#type#}'] .= ' selected="selected"';
					}
					$o['{#type#}'] .= '>'.$this->type[$j].'</option>';
				}
				$o['{#src#}'] = '';
				for ($j=0; $j<count($this->src); $j++){
					if ($j == 0){
						$o['{#src#}'] .= '<option value="'.$j.'">'.$this->src[$j].'</option>';
					}else{
						if (class_exists($this->src[$j], false)){
							$o['{#src#}'] .= '<option value="'.$this->src[$j].'"';
							if ($list[$i]['ref_src'] == $this->src[$j]){
								$o['{#src#}'] .= ' selected="selected"';
							}
							$o['{#src#}'] .= '>'.$this->src[$j].'</option>';
						}
					}
				}
				$o['{#srcv#}'] = '';
				for ($j=0; $j<count($this->src); $j++){
					if ($this->src[$j] == 'categories' && $list[$i]['ref_srcv'] != 0){
						$m = new categories();						
						$o['{#srcv#}'] = $m->tree(0, 0, $list[$i]['ref_srcv']);						
					}
				}
				
				$out .= $this->tpl->assign("modules/$this->name/table_row.tpl", $o);
			}
			return $out;
		}
		else return '<tr><td colspan="30">Пусто</td></tr>';		
	}
	
	function adv_head($ref){
		$list = $this->get_list($ref);
		if ($list){
			foreach ($list as $item){
				if ($item['ref_in_list'] == 1 && $item['ref_type'] == 3 || $item['ref_in_list'] == 1 && $item['ref_type'] == 1 || $item['ref_in_list'] == 1 && $item['ref_type'] == 5){
					$out .= '<th>'.$item['ref_title'].'</th>';
				}
			}
			return $out;
		}return '';
	}
	
	function adv_row($ref, $data){
		$list = $this->get_list($ref);
		if ($list){
			foreach ($list as $item){
				if ($item['ref_in_list'] == 1 && $item['ref_type'] == 3){
					foreach ($data as $k => $v){
						if ('param'.$item['ref_number'] == $k){
							$img = '';							
							$img = ($v == 1) ? '<img src="'.BASEDIR.'/images/adm/tick.png" />' : '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
							if ($data['checked_out'] == $_SESSION['cms']['user_id'] || $data['checked_out'] == 0){
								$img = '<a href="javascript:call(\'params\', \'toggle\', [\''.$ref.'\','.$data['id'].', \''.$k.'\']);">'.$img.'</a>';
							}							
							$out .= '<td>'.$img.'</td>';							
						}
					}
				}elseif ($item['ref_in_list'] == 1 && $item['ref_type'] == 1){
					foreach ($data as $k => $v){
						if ('param'.$item['ref_number'] == $k){
							$out .= '<td>'.$v.'</td>';							
						}
					}
				}elseif ($item['ref_in_list'] == 1 && $item['ref_type'] == 5){
					foreach ($data as $k => $v){
						if ('param'.$item['ref_number'] == $k){
							$mod = new $item['ref_module'];
							$out .= '<td>'.$mod->get($v, 'title').'</td>';							
						}
					}
				}
			}
			return $out;
		}return '';
	}
	
	function adv_right($ref, $data = NULL){
		$list = $this->get_list($ref);
		if ($list){
			foreach ($list as $item){
				if ($item['ref_type'] != 2 && $item['ref_type'] != 0){ $list2[] = $item; }
			}
		}
		if ($list2){
			foreach ($list2 as $item){
				$type = $item['ref_type'];
				$o = array();
				$o['{#param_title#}'] = $item['ref_title'];
				$o['{#param_name#}'] = 'param'.$item['ref_number'];
				$o['{#param_val#}'] = '';
				if ($type == 1){ $o['{#param_val#}'] = (isset($data)) ? $data['param'.$item['ref_number']]:''; }				
				if ($type == 3){
					$o['{#param_val#}'] = (isset($data)) ? ($data['param'.$item['ref_number']]==1) ? 'checked':'':'';
				}
				if ($type == 4){ $o['{#param_val#}'] = (isset($data)) ? $data['param'.$item['ref_number']]:''; }				
				if ($type == 5){
					$o['{#param_val#}'] = '11';
					if ($item['ref_src'] == 'categories'){
						$mod = new $item['ref_module'];
						$m_list = $mod->get_list($item['ref_srcv']);
						if (!$m_list){
							$mod2 = new $item['ref_src'];
							$p_list = $mod2->get_list($item['ref_srcv']);
							if ($p_list){
								foreach ($p_list as $p_item){
									$p_list2 = $mod2->get_list($p_item['id']);
									if ($p_list2){
										foreach ($p_list2 as $p_item2){
											$p_m = $mod->get_list($p_item2['id']);
											if ($p_m){
												foreach ($p_m as $p_l){
													$m_list[] = $p_l;
												}
											}
										}
									}
								}
							}
						}
					}else{
						$mod = new $item['ref_src'];
						$m_list = $mod->get_list();							
					}
					if ($m_list){
						foreach ($m_list as $sd){
							$o['{#param_val#}'] .= '<option value="'.$sd['id'].'"';
							if (isset($data) && $data['param'.$item['ref_number']] == $sd['id']){
								$o['{#param_val#}'] .= ' selected="selected"';
							}
							$o['{#param_val#}'] .= '>'.$sd['title'].'</option>';
						}
					}
				}
				if ($type == 6){
					$o['{#param_val#}'] = '';
					if ($item['ref_src'] == 'categories'){
						$mod = new $item['ref_module'];
						$m_list = $mod->get_list($item['ref_srcv']);
					}else{
						$mod = new $item['ref_src'];
						$m_list = $mod->get_list();							
					}
					//$mod = new $item['ref_src'];
					//$m_list = $mod->get_list();
					if ($m_list){
						foreach ($m_list as $sd){
							$o['{#param_val#}'] .= '<option value="'.$sd['id'].'"';
							if (isset($data)){
								$d = explode('|', $data['param'.$item['ref_number']]);
								$selected = 0;
								foreach ($d as $sel){
									if ($sel == $sd['id']){ $selected++; }
								}
								if ($selected>0){
									$o['{#param_val#}'] .= ' selected="selected"';
								}
							}
							$o['{#param_val#}'] .= '>'.$sd['title'].'</option>';
						}
					}
				}
				$o['{#name#}'] = $ref;
				if ($type == 1){ $tpl = "modules/$this->name/".'param.text.tpl'; }
				if ($type == 3){ $tpl = "modules/$this->name/".'param.checkbox.tpl'; }
				if ($type == 4){ $tpl = "modules/$this->name/".'param.button.tpl'; }
				if ($type == 5){ $tpl = "modules/$this->name/".'param.select_one.tpl'; }
				if ($type == 6){ $tpl = "modules/$this->name/".'param.select_multiple.tpl'; }
				$out .= $this->tpl->assign($tpl, $o);
			}
			return $out;
		}else return '<tr><td>Параметры не настроены</td></tr>';
	}
	
	function adv_bottom($ref, $data = NULL){
		$list = $this->get_list($ref);
		if ($list){
			foreach ($list as $item){
				if ($item['ref_type'] == 2 && $item['ref_type'] != 0){
					$o['{#param_title#}'] = $item['ref_title'];
					$o['{#param_name#}'] = 'param'.$item['ref_number'];					
					if (isset($data)){
						$o['{#param_val#}'] = $data['param'.$item['ref_number']];
					}else{ $o['{#param_val#}'] = ''; }
					$out .= $this->tpl->assign("modules/$this->name/".'param.textarea.tpl', $o);
				}
			}
			return $out;
		}else return '';
	}
	
	function cat_tree($parent, $level, $data){
		$categories = new categories();
		$content = new content();
		//$out .= ($level == 0) ? '<option value="0" class="tab_0">- НЕТ -</option>' : '';
		$list = $categories->get_list($parent);
		if ($list){
			for($i=0; $i<count($list); $i++){
				$padding = $level*10 + 15;
				$out .= '<div class="popup_tree_cat" style="padding-left:'.$padding.'px;"';
				$out .= '>'.$list[$i]['title'].'</div>';
				
				$e = $content->get_list($list[$i]['id']);
				if ($e){
					foreach ($e as $item){
						$spadding = $padding+10;
						$out .= '<div class="popup_tree_cont" style="padding-left:'.$spadding.'px;">';
						$out .= '<input type="checkbox" name="'.$item['id'].'"';
						foreach ($data as $s){
							if ($item['id'] == $s){ $out .= ' checked'; }
						}
						$out .= '/>'.$item['title'].'<div class="clr"></div></div>';
						//$out .= $this->cont_tree($list[$i]['id'], $level+1);
					}
				}				
				
				$childs = $categories->get_list($list[$i]['id']);
				if ($childs){ $out .= $this->cat_tree($list[$i]['id'], $level+1, $data); }				
			}
		}
		return $out;		
	}
	
	function cat_tree2($parent, $level, $data){
		$categories = new categories();
		$content = new content();
		//$out .= ($level == 0) ? '<option value="0" class="tab_0">- НЕТ -</option>' : '';
		$list = $categories->get_list($parent);
		if ($list){
			for($i=0; $i<count($list); $i++){
				$padding = $level*10 + 15;
				$out .= '<div class="popup_tree_cat" style="padding-left:'.$padding.'px;">';
				$out .= '<input type="checkbox" name="'.$list[$i]['id'].'"';
				foreach ($data as $s){
					if ($list[$i]['id'] == $s){ $out .= ' checked'; }
				}
				$out .= '/>'.$list[$i]['title'].'<div class="clr"></div></div>';
				
				/*$e = $content->get_list($list[$i]['id']);
				if ($e){
					foreach ($e as $item){
						$spadding = $padding+10;
						$out .= '<div class="popup_tree_cont" style="padding-left:'.$spadding.'px;">';
						$out .= '<input type="checkbox"';
						foreach ($data as $s){
							if ($item['id'] == $s){ $out .= ' checked'; }
						}
						$out .= '/>'.$item['title'].'<div class="clr"></div></div>';
						$out .= $this->cont_tree($list[$i]['id'], $level+1);
					}
				}*/
				
				$childs = $categories->get_list($list[$i]['id']);
				if ($childs){ $out .= $this->cat_tree2($list[$i]['id'], $level+1, $data); }				
			}
		}
		return $out;		
	}
	
	function adv_popup($ref, $num, $data){
		$out['{#name#}'] = $ref;
		$out['{#param_name#}'] = 'param'.$num;
		$item = $this->get_item($ref, $num);
		$m = $item['ref_src'];
		if ($m == 'content'){
			$out['{#out#}'] = $this->cat_tree(0, 0, explode('|',$data));
		}
		elseif ($m == 'categories'){
			$out['{#out#}'] = $this->cat_tree2(0, 0, explode('|',$data));
		}
		return $this->tpl->assign("modules/$this->name/".'param.button.ctrl.tpl', $out);
	}
}