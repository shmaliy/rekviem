<?php
	function _check_out($id, $toggle){
		if ($toggle == 'true'){	
			$c_out = $_SESSION['cms']['user_id'];
			$this->update_e('checked_out', $c_out, $id);
			$this->update_e('checked_out_time', date('Y-m-d H:i:s'), $id);
		}else{
			$this->update_e('checked_out', '0', $id);
			$this->update_e('checked_out_time', '0000-00-00 00:00:00', $id);
		}
	}
?>