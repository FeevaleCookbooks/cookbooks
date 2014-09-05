<?
class Debug {
	var $_messages;
	var $_sqls;
	
	var $_time_ini;
	
	function Debug() {
		$this->_time_ini = $this->_getMicroTime();
		
		$this->_messages = array();
		$this->_sqls = array();
		
		$this->addMessage("[debug] é instanciado.");
	}
	
	function addMessage($tmp_message, $tmp_microtime_ini = 0) {
		if ($tmp_microtime_ini > 0) {
			//duration time
			$t = $this->_getMicroTime() - $this->_getMicroTime($tmp_microtime_ini);
			$instant_time = $this->_getMicroTime();
		} else {
			//instant time
			$t = $this->_getMicroTime();
			$instant_time = 0;
		}
		
		$this->_messages[] = array($t, $tmp_message, $instant_time);
	}
	
	function addSql($tmp_sql, $tmp_microtime_ini = 0) {
		if ($tmp_microtime_ini > 0) {
			//duration time
			$t = $this->_getMicroTime() - $this->_getMicroTime($tmp_microtime_ini);
			$instant_time = $this->_getMicroTime();
		} else {
			//instant time
			$t = $this->_getMicroTime();
			$instant_time = 0;
		}
		
		$this->_sqls[] = array($t, $tmp_sql, $instant_time);
	}
	
	function loadList() {
		if (IS_DEVELOP) {
			$this->addMessage("<strong>$" . "debug</strong>->loadList();");
		
			echo "<div style='border: 1px solid #666666; margin: 10px; padding: 10px; font-family: Verdana; font-size: 10px; color: #666666;'>" . LF;
			
			//Events
			echo "<h3 style='font-family: Arial; font-size: 18px; color: #666666; margin: 0 0 5 5px;'>Eventos</h3>" . LF;
			
			foreach ($this->_messages as $k => $v) {
				$message = str_replace("[", "<b>$", $v[1]);
				$message = str_replace("]", "</b>", $message);
				
				if ($v[2] > 0) {
					//duration time
					echo number_format(($v[2] - $this->_time_ini) * 1000, 2, ",", ".") . "ms - [" . number_format($v[0] * 1000, 2, ",", ".") . "ms] - " . $message . "<br>" . LF;
				} else {
					//instant time
					echo number_format(($v[0] - $this->_time_ini) * 1000, 2, ",", ".") . "ms - " . $message . "<br>" . LF;
				}
			}
			
			echo "<br><br>";
			
			//Sqls
			echo "<h3 style='font-family: Arial; font-size: 18px; color: #666666; margin: 0 0 5 5px;'>Sqls</h3>" . LF;
			
			foreach ($this->_sqls as $k => $v) {
				$sql = str_replace("[", "<b>$", $v[1]);
				$sql = str_replace("]", "</b>", $sql);
				
				if ($v[2] > 0) {
					//duration time
					echo number_format(($v[2] - $this->_time_ini) * 1000, 2, ",", ".") . "ms - [" . number_format($v[0] * 1000, 2, ",", ".") . "ms] - " . $sql . "<br>" . LF;
				} else {
					//instant time
					echo number_format(($v[0] - $this->_time_ini) * 1000, 2, ",", ".") . "ms - " . $sql . "<br>" . LF;
				}
			}
			
			echo "</div>";
		}
	}
	
	//private functions
	function _getMicroTime($tmp_microtime = 0) {
		if ($tmp_microtime == 0) { 
			$tmp_microtime = microtime(); 
		}
		
		$tmp = explode(" ", $tmp_microtime);
		
		return (float)$tmp[0] + (float)$tmp[1];
	}
}

function log_message($tmp_message, $tmp_microtime_ini = 0) {
	global $debug;
	
	$debug->addMessage($tmp_message, $tmp_microtime_ini);
}

function log_sql($tmp_sql, $tmp_microtime_ini = 0) {
	global $debug;
	
	$debug->addSql($tmp_sql, $tmp_microtime_ini);
}

$debug = new Debug();


?>