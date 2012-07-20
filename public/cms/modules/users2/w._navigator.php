<?php
	function _navigator(){
		$rows = $GLOBALS['rownums'];
		$c = $_SESSION['cms']['mod'][$this->name]['page'];
		$r = $_SESSION['cms']['mod'][$this->name]['rnum'];
		$p = $_SESSION['cms']['mod'][$this->name]['parent'];
		$t = count($this->get_list($p));
		foreach($rows as $row){
			$n = ($row=='all') ? '0' : $row;
			$tx = ($row=='all') ? 'Все' : $row;
			$rn .= ($row=='all'&&$r=='0'||$row==$r)?'<option value="'.$n.'" selected="selected">'.$tx.'</option>':'<option value="'.$n.'">'.$tx.'</option>';
		}
		$pages = ($r != 0) ? ($t/$r > floor($t/$r)) ? floor($t/$r)+1 : $t/$r : 1;
		for($i=1; $i<=$pages; $i++){
			$pgs .= ($i == $c) ? '<a class="page_c">'.$i.'</a>' : '<a href="javascript:call(\''.$this->name.'\', \'_set_page\', '.$i.');" class="page_n">'.$i.'</a>';
		}
		$first = ($c==1) ? '<a class="page_l">Начало</a>' : '<a href="javascript:call(\''.$this->name.'\', \'_set_page\', 1);" class="page_l">Начало</a>';
		$last = ($c==$pages) ? '<a class="page_r">Конец</a>' : '<a href="javascript:call(\''.$this->name.'\', \'_set_page\', '.$pages.');" class="page_r">Конец</a>';
		$rows = '<select id="rnum" onChange="call(\''.$this->name.'\', \'_set_rnum\', this.value);">'.$rn.'</select>';
		return 'Количество строк:'.$rows.$first.$pgs.$last;
	}
?>