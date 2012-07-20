<?php
include 'core_mod.php';
class core_fb extends core_mod{
	function _listing($dir,$mode){
		if(is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
					if ($file != "." && $file != ".."){
						if(is_dir($dir."/".$file)) {$folders[] = $file;}
						else {$files[] = $file;}
					}
				}
				closedir($dh);
			}
		}
		if ($mode == 1){ if ($files){ return $files; }else{ return false; } }
		elseif ($mode == 0){ if ($folders){ return $folders; }else{ return false; } }
	}
	
	function fb_build(){
		$tpl = new core_tpl();
		$o['{#basedir#}'] = BASEDIR;
		$o['{#fb#}'] = $this->gen_filebrowser();
		$o['{#folders#}'] = '<option value="/contents">/</option>'.$this->gen_folders("../contents", $_SESSION['cms']['fb']['path']);
		$o['{#uppath#}'] = $this->gen_uppath();
		$o['{#path#}'] = $_SESSION['cms']['fb']['path'];
		$o['{#currpath#}'] = substr($_SESSION['cms']['fb']['path'],2,strlen($_SESSION['cms']['fb']['path']));
		return $tpl->assign(TPLDIR.'upload.tpl',$o);
	}
	
	function _file_icon($file,$mode){
		$ext = explode('.',$file);
		$ext = $ext[count($ext)-1];
		$fname = $ext."_".$mode;
		if (file_exists("images/fb/$fname.png")){ return BASEDIR."/images/fb/$fname.png"; }
		else { return BASEDIR."/images/fb/file_$mode.png"; }
	}
	
	function gen_filelist(){
		$tpl = new core_tpl();
		$dir = $_SESSION['cms']['fb']['path'];
		$mode = ($_SESSION['cms']['fb']['mode'] == 'filebrowser_i')?'92':'16';
		$folders = $this->_listing($dir,0);
		$files = $this->_listing($dir,1);
		if ($folders){
			foreach ($folders as $folder){
				$path = substr($dir,2,strlen($dir));
				$o['{#link#}'] = "javascript:call('core_fb','_fb_setpath','$path/$folder');";
				$name = ($_SESSION['cms']['fb']['mode'] == 'filebrowser_i')?substr($folder,0,17):$folder;
				$o['{#name#}'] = $name;
				$o['{#icon#}'] = BASEDIR."/images/fb/folder_$mode.png";
				$o['{#size#}'] = 'папка';
				$out .= $tpl->assign(TPLDIR.'fb_item.tpl',$o);
			}
		}
		if ($files){
			foreach ($files as $file){
				$path = substr($dir,2,strlen($dir));
				$o['{#link#}'] = "javascript:call('core_fb','_fb_setfile','$path/$file');";
				if (strlen($file)>17){
					$name = explode('.',$file);
					$ext = array_pop($name);
					$name = substr(implode('.',$name),0,13).'...'.$ext;
				}else{$name = $file;}
				$o['{#name#}'] = ($_SESSION['cms']['fb']['mode'] == 'filebrowser_i')?$name:$file;
				$o['{#icon#}'] = $this->_file_icon($file,$mode);
				$size = filesize("$dir/$file");
				if ($size > 1024 && $size < 1024*1024){
					$size = round($size/1024, 2)." кб";
				}
				elseif ($size > 1024*1024 && $size < 1024*1024*1024){
					$size = round($size/(1024*1024), 2)." Мб";
				}
				$o['{#size#}'] = $size;
				$out .= $tpl->assign(TPLDIR.'fb_item.tpl',$o);
			}
		}
		return $out;
	}
	
	function gen_fbmode(){
		$mode = $_SESSION['cms']['fb']['mode'];
		$icons .= '<option value="filebrowser_i"';
		$icons .= ($mode == 'filebrowser_i')?' selected="selected"':'';
		$icons .= '>Значки</option>';
		$list .= '<option value="filebrowser_l"';
		$list .= ($mode == 'filebrowser_l')?' selected="selected"':'';
		$list .= '>Список</option>';
		return $icons.$list;
	}
	
	function gen_folders($dir, $selected){
		$folders = $this->_listing($dir,0);
		if ($folders){
			foreach ($folders as $folder){
				if ($dir != '../contents'){$name = str_replace('../contents/','',$dir)."/".$folder;}
				else {$name = $folder;}
				$path = substr($dir,2,strlen($dir));
				$out .= '<option value="'."$path/$folder".'"';
				if ($selected == "$dir/$folder"){$out .= ' selected="selected"';}
				$out .= '>'.$name.'</option>';
				$childs = $this->gen_folders("$dir/$folder", $selected);
				if ($childs){$out .= $childs;}
			}
			return $out;
		}else return false;
	}
	
	function gen_filebrowser(){
		$tpl = new core_tpl();
		$out['{#basedir#}'] = BASEDIR;
		$out['{#fbmode#}'] = $this->gen_fbmode();
		$out['{#folders#}'] = '<option value="/contents">/</option>'.$this->gen_folders("../contents", $_SESSION['cms']['fb']['path']);
		$out['{#fbmode2#}'] = $_SESSION['cms']['fb']['mode'];
		$out['{#uppath#}'] = $this->gen_uppath();
		$out['{#currpath#}'] = substr($_SESSION['cms']['fb']['path'],2,strlen($_SESSION['cms']['fb']['path']));
		$out['{#items#}'] = $this->gen_filelist();
		return $tpl->assign(TPLDIR.'fb_body.tpl',$out);
	}
	
	function gen_uppath(){
		if ($_SESSION['cms']['fb']['path'] != '../contents'){
			$uppath = explode('/',$_SESSION['cms']['fb']['path']);
			array_pop($uppath);
			$uppath = implode('/',$uppath);
		}else{$uppath = $_SESSION['cms']['fb']['path'];}
		return substr($uppath,2,strlen($uppath));		
	}
	
	function _fb_setmode($mode){
		$_SESSION['cms']['fb']['mode'] = $mode;
		$return[] = array('assign','fb_mode','innerHTML',$this->gen_fbmode());
		$return[] = array('assign','filebrowser_items','className',$mode);
		$return[] = array('assign','filebrowser_items','innerHTML',$this->gen_filelist());
		return $return;	
	}
	
	function _fb_setpath($path){
		$_SESSION['cms']['fb']['path'] = "..".$path;
		$return[] = array('assign','fb_path','innerHTML','<option value="/contents">/</option>'.$this->gen_folders("../contents", $_SESSION['cms']['fb']['path']));
		$return[] = array('assign','fb_path2','innerHTML','<option value="/contents">/</option>'.$this->gen_folders("../contents", $_SESSION['cms']['fb']['path']));
		$return[] = array('assign','filebrowser_items','innerHTML',$this->gen_filelist());
		$return[] = array('assign','fb_uppath','href',"javascript:call('core_fb','_fb_setpath','".$this->gen_uppath()."');");
		$return[] = array('assign','fb_uppath2','href',"javascript:call('core_fb','_fb_setpath','".$this->gen_uppath()."');");
		$return[] = array('assign','fb_refresh','href',"javascript:call('core_fb','_fb_setpath','".$path."');");
		$return[] = array('assign','fb_refresh2','href',"javascript:call('core_fb','_fb_setpath','".$path."');");
		return $return;	
	}
	
	function _fb_setfile($file){
		$p[] = $_SESSION['cms']['fb']['return'];
		$p[] = $file;
		$return[] = array('call','core._fb_setfield',$p);
		$return[] = array('call','modal.hide');
		return $return;
	}
	
	function fb_editor($module, $data = NULL){
		$tpl = new core_tpl();
		$o['{#name#}'] = $module;
		$o['{#image#}'] = BASEDIR.'/images/blank.png';
		$o['{#imagepath#}'] = '';		
		$o['{#images#}'] = '';
		$o['{#path#}'] = '<option value="/contents">/</option>'.$this->gen_folders("../contents",'');
		$dir = "../contents";
		$files = $this->_listing($dir,1);
		if ($files){
			foreach ($files as $file){
				$path = substr($dir,2,strlen($dir));
				if (strlen($file)>17){
					$name = explode('.',$file);
					$ext = array_pop($name);
					$name = substr(implode('.',$name),0,13).'...'.$ext;
				}else{$name = $file;}
				$filelist .= '<option value="'.$path.'/'.$file.'">'.$name.'</option>';
			}
		}
		$o['{#files#}'] = $filelist;
		if (isset($data)){
			$o['{#image#}'] = ($data['image'] != '') ? BASEDIR."/image.php?image=../".substr($data['image'],1,strlen($data['image']))."&mode=square_fit&p1=64" : BASEDIR.'/images/blank.png';
			$o['{#imagepath#}'] = ($data['image'] != '') ? $data['image'] : '';			
			$images = explode('|', $data['images']);
			if (count($images)>0){
				foreach ($images as $i){
					$o['{#images#}'] .= '<option value="'.$i.'">'.array_pop(explode('/', $i)).'</option>';
				}
			}
		}
		
		return $tpl->assign(TPLDIR.'fb_editor.tpl', $o);
	}
	
	function _fb_ed_setpath($data){
		$p[] = $data[0];
		$dir = "..".$data[1];
		$files = $this->_listing($dir,1);
		if ($files){
			foreach ($files as $file){
				$path = substr($dir,2,strlen($dir));
				if (strlen($file)>17){
					$name = explode('.',$file);
					$ext = array_pop($name);
					$name = substr(implode('.',$name),0,13).'...'.$ext;
				}else{$name = $file;}
				$i[] = array($name, $path.'/'.$file);
			}
		}		
		$p[] = $i;
		$return[] = array('call', 'image_editor.upd_files', $p);
		return $return;
	}
	
	function gen_folders2($dir, $out){
		$folders = $this->_listing($dir,0);
		if (count($out)==0){ $out[] = array('/', "/contents"); }
		if ($folders){
			foreach ($folders as $folder){
				if ($dir != '../contents'){$name = str_replace('../contents/','',$dir)."/".$folder;}
				else {$name = $folder;}
				$path = substr($dir,2,strlen($dir));
				$out[] = array($name, "$path/$folder");
				$childs = $this->gen_folders2("$dir/$folder", $out);
				if ($childs){$out = $childs;}
			}
			return $out;
		}else return false;
	}
	
	function _fb_ed_updfolders($data){
		$p[] = $data;
		$p[] = $this->gen_folders2("../contents", array());
		$return[] = array('call', 'image_editor.upd_folders', $p);
		return $return;		
	}
}