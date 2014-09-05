<?
class Load {
	var $_includes;
	var $_overwrite;
	
	function Load() {
		log_message("[load] é instanciado.");
		
		$this->_includes = array();
		$this->_overwrite = false;
	}
	
	function setOverwrite($tmp_value = false) {
		$this->_overwrite = $tmp_value;
	}
	
	function system($tmp_file, $tmp_verify_exists = false) {
		$this->_include(DIR_SYSTEM . $tmp_file, $tmp_verify_exists);
	}
	
	function config($tmp_file, $tmp_verify_exists = false) {
		$this->_include(DIR_CONFIG . $tmp_file, $tmp_verify_exists);
	}
	
	function manager($tmp_file, $tmp_verify_exists = false) {
		$this->_include(DIR_ROOT . DIR_MANAGER . $tmp_file, $tmp_verify_exists);
	}
	
	function database($tmp_position = 0) {
		global $cfg;
		
		$type = $cfg["database_type"][$tmp_position];
		
		//Load Classes
		$this->_include(DIR_SYSTEM . "drivers/Connection.php");
		$this->_include(DIR_SYSTEM . "drivers/" . $type . "/Connection.php");
		$this->_include(DIR_SYSTEM . "drivers/" . $type . "/Recordset.php");
		$this->_include(DIR_SYSTEM . "drivers/" . $type . "/Sql.php");
		
		//Return created connection class
		$class = ucfirst($type) . "_Connection";
		
		return  new $class();
	}
	
	function loadList() {
		echo "<div style='border: 1px solid #666666; margin: 10px; padding: 10px; font-family: Verdana; font-size: 10px; color: #666666;'>" . LF;
		
		echo "<h3 style='font-family: Arial; font-size: 18px; color: #666666; margin: 0 0 5 5px;'>Includes</h3>" . LF;
		
		foreach ($this->_includes as $v) {			
			echo $v . "<br>" . LF;
		}
		
		echo "</div>";
	}
	
	//Privates
	function _include($tmp_file, $tmp_verify_exists = true) {
		$r = false;
		
		if (array_search($tmp_file, $this->_includes) === false) {
			if (file_exists($tmp_file)) {
				$this->_includes[] = $tmp_file;
			
				$r = include($tmp_file);
			} else {
				$r = false;
				if ($tmp_verify_exists) {
					error(1, "Arquivo '" . $tmp_file . "' não existe.", "Load", "_include");
				}
			}
		} else {
			if (!$this->_overwrite) {
				error(0, "Arquivo '" . $tmp_file . "' já foi incluido.", "Load", "_include");
			} else {
				$this->setOverwrite(false);
			}
		}
		
		return $r;
	}
}
?>