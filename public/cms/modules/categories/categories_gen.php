<?php
include_once 'categories_db.php';
class categories_gen extends categories_db
{
	function _toolbar($mode, $id = NULL){
		if ($mode == 'list'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-publish.png', 'Показать', "call('$this->name', '_publish', ['true', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-unpublish.png', 'Скрыть', "call('$this->name', '_publish', ['false', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-move.png', 'Переместить', "call('$this->name', '_move', ['confirm', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-copy.png', 'Копировать', "call('$this->name', '_copy', ['confirm', getcheckbox('ctable_contents')]);", 12),
					array(BASEDIR.'/images/toolbar/icon-32-trash.png', 'Удалить', "call('$this->name', '_delete', ['confirm', getcheckbox('ctable_contents')]);", 12),
					array(BASEDIR.'/images/toolbar/icon-32-new.png', 'Создать', "call('$this->name', '_new');", 12)
				)
			);
		}
		elseif ($mode == 'new'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-save.png', 'Сохранить', "call('$this->name', '_save', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-apply.png', 'Применить', "call('$this->name', '_apply', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-cancel.png', 'Отмена', "call('$this->name', '_cancel', 'new');", 13)
				)
			);
		}
		elseif ($mode == 'edit'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-save.png', 'Сохранить', "call('$this->name', '_save', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-apply.png', 'Применить', "call('$this->name', '_apply', getform('$this->name'));", 13),
					array(BASEDIR.'/images/toolbar/icon-32-lock.png', 'Блокировать', "call('$this->name', '_lock');", 13),
					array(BASEDIR.'/images/toolbar/icon-32-cancel.png', 'Отмена', "call('$this->name', '_cancel', '$id');", 13)
				)
			);
		}
		return ($buttons) ? $this->core->toolbar($buttons) : false;
	}
	
	function head(){
		$return  = '<link href="'.BASEDIR.'/modules/'.$this->name.'/'.$this->name.'.css.php" rel="stylesheet" type="text/css" />'."\n";
		global $url_query;
		if (count($url_query)>2){
			$return .= '<script type="text/javascript" src="'.BASEDIR.'/js/tiny_mce/tiny_mce.js"></script>'."\n";
			$return .= '<script type="text/javascript" src="'.BASEDIR.'/js/tiny_mce_init.js"></script>'."\n";
		}
		return $return;
	}
	
	function table(){
		$params = (class_exists('params', false)) ? new params() : false;
		$_SESSION['cms']['menudisable']=0;
		$o['{#basedir#}'] =  BASEDIR;
		$o['{#name#}'] =  $this->name;
		$o['{#navigator#}'] = $this->core->navigator($this->name);
		$o['{#adv_fields#}'] = '<th>Подкатегорий</th>';
		$o['{#adv_fields#}'] .= (class_exists('content', false)) ? '<th>Элементов</th>' : '';
		$o['{#adv_fields#}'] .= ($params != false) ? $params->adv_head($this->name) : '';
		$o['{#items#}'] =  $this->_list();
		$o['{#tree#}'] = $this->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
		return $this->tpl->assign("modules/$this->name/table.tpl", $o);
	}
	
	function _list(){
		$params = (class_exists('params', false)) ? new params() : false;
		$content = (class_exists('content', false)) ? new content() : false;
		
		$m = $_SESSION['cms']['mod'][$this->name];
		$limit = ($m['rnum'] != 0) ? $m['rnum']*$m['page']-$m['rnum'].', '.$m['rnum']*$m['page'] : '';
		$list = ($m['parent'] == 0) ? $this->get_list(null, $limit) : $this->get_list($m['parent'], $limit);
		if ($list){
			for($i=0; $i<count($list); $i++){
				$o = array();
				$o['{#id#}'] = $list[$i]['id'];
				$o['{#title#}'] = ($list[$i]['title_alias'] != '') ? $list[$i]['title'].' ( '.$list[$i]['title_alias'].' ) ' : $list[$i]['title'];
				$o['{#image#}'] = $list[$i]['image'];
				$o['{#album#}'] = ($list[$i]['parent_id'] != 0) ? $this->get($list[$i]['parent_id'], 'title') : '- НЕТ -';
				$o['{#published#}'] = ($list[$i]['published'] == 1) ? '<img src="'.BASEDIR.'/images/adm/publish_g.png" />' : '<img src="'.BASEDIR.'/images/adm/publish_x.png" />';
				$categories = $this->get_list($list[$i]['id']);
				if ($categories){
					$categories = count($categories);
					$o['{#adv_fields#}'] = "<td>$categories</td>";
				}else{ $o['{#adv_fields#}'] = "<td>0</td>"; }
				if ($content){
					$childs = $content->get_list($list[$i]['id']);
					if ($childs){
						$childs = count($childs);
						$o['{#adv_fields#}'] .= "<td>$childs</td>";
					}else{ $o['{#adv_fields#}'] .= '<td>0</td>'; }					
				}
				
				if ($list[$i]['checked_out'] == 0){
					$o['{#checked_out#}'] = '<input name="'.$list[$i]['id'].'" type="checkbox"></td>';
					$o['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $list[$i]['id'] . '\');">'.$o['{#title#}'].'</a>';
					$o['{#published#}'] = '<a href="' . "javascript:call('$this->name', '_publish', '" . $list[$i]['id'] . '\');">'.$o['{#published#}'].'</a>';
				}else{
					$o['{#checked_out#}'] = '<img src="'.BASEDIR.'/images/adm/checked_out.png" />';
					if ($list[$i]['checked_out'] == $_SESSION['cms']['user_id']){
						$o['{#title#}'] = '<a href="' . "javascript:call('$this->name', '_edit', '" . $list[$i]['id'] . '\');">'.$o['{#title#}'].'</a>';
						$o['{#published#}'] = '<a href="' . "javascript:call('$this->name', '_publish', '" . $list[$i]['id'] . '\');">'.$o['{#published#}'].'</a>';
					}
				}
				$reorder['{#name#}'] = $this->name;
				$reorder['{#id#}'] = $list[$i]['id'];
				if (count($list) == 1 || $list[$i]['parent_id'] != $list[$i-1]['parent_id'] && $list[$i]['parent_id'] != $list[$i+1]['parent_id']){ $o['{#sort#}'] = $this->tpl->assign('tpl/sort.none.tpl', $reorder); }
				elseif ($i == 0 && $i < count($list)-1 || $list[$i]['parent_id'] != $list[$i-1]['parent_id'] && $list[$i]['parent_id'] == $list[$i+1]['parent_id']){ $o['{#sort#}'] = $this->tpl->assign('tpl/sort.top.tpl', $reorder); }
				elseif ($i == count($list)-1 || $list[$i]['parent_id'] == $list[$i-1]['parent_id'] && $list[$i]['parent_id'] != $list[$i+1]['parent_id']){ $o['{#sort#}'] = $this->tpl->assign('tpl/sort.bottom.tpl', $reorder); }
				else { $o['{#sort#}'] = $this->tpl->assign('tpl/sort.middle.tpl', $reorder); }
				$o['{#sort#}'] .= '<input name="'.$list[$i]['id'].'" size="5" value="'.$list[$i]['ordering'].'" class="order" />';
				$o['{#adv_fields#}'] .= ($params) ? $params->adv_row($this->name, $list[$i]) : '';
				$out .= $this->tpl->assign("modules/$this->name/table_row.tpl", $o);
			}
			return $out;
		}
		else return '<tr><td colspan="30">Пусто</td></tr>';		
	}
	
	function editor($id){
		$params = (class_exists('params', false)) ? new params() : false;
		$o['{#name#}'] = $this->name;
		$o['{#id#}'] = $id;
		if ($id == 'new'){
			$o['{#tree#}'] = $this->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
			$o['{#desc#}'] = '';
			$o['{#published#}'] = 'checked';
			$o['{#title#}'] = '';
			$o['{#alias#}'] = '';
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name) : '';
			$o['{#image_editor#}'] = $this->core->fb_editor($this->name);
		}else{
			$data = $this->get($id);
			$o['{#tree#}'] = $this->tree(0, 0, $data['parent_id']);
			$o['{#desc#}'] = $data['description'];
			$o['{#published#}'] = ($data['published'] == '1') ? 'checked' : '';
			$o['{#title#}'] = $data['title'];
			$o['{#alias#}'] = $data['title_alias'];
			$o['{#adv_right#}'] = ($params) ? $params->adv_right($this->name, $data) : '';
			$o['{#adv_bottom#}'] = ($params) ? $params->adv_bottom($this->name, $data) : '';
			$o['{#image_editor#}'] = $this->core->fb_editor($this->name, $data);
		}
		$_SESSION['cms']['menudisable']=1;
		return $this->tpl->assign("modules/$this->name/editor.tpl", $o);
	}
	
	function tree($parent, $level, $selected){
		$out .= ($level == 0) ? '<option value="0" class="tab_0">- НЕТ -</option>' : '';
		$list = $this->get_list($parent);
		if ($list){
			for($i=0; $i<count($list); $i++){
				$out .= '<option value="'.$list[$i]['id'].'" class="tab_'.$level.'"';
				$out .= ($selected == $list[$i]['id']) ? ' selected="selected"' : '';
				$out .= '>'.$list[$i]['title'].'</option>';
				
				$childs = $this->get_list($list[$i]['id']);
				if ($childs){ $out .= $this->tree($list[$i]['id'], $level+1, $selected); }
			}
		}
		return $out;
	}
}