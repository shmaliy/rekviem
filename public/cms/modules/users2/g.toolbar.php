<?php
	function _toolbar($mode, $id = NULL){
		if ($mode == 'list'){
			$buttons = array(
				'icon' => $this->info['MODULE']['ICON48']['#val'],
				'title' => $this->info['MODULE']['NAME']['#val'],
				'buttons' => array(
					array(BASEDIR.'/images/toolbar/icon-32-cancel.png', 'Разлогинить', "call('$this->name', '_logout', ['all', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-publish.png', 'Разблокировать', "call('$this->name', '_block', ['false', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-unpublish.png', 'Заблокировать', "call('$this->name', '_block', ['true', getcheckbox('ctable_contents')]);", 13),
					array(BASEDIR.'/images/toolbar/icon-32-delete.png', 'Удалить', "call('$this->name', '_del', 'confirmed');", 12),
					array(BASEDIR.'/images/toolbar/icon-32-adduser.png', 'Создать', "call('$this->name', '_new');", 12)
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
?>