<?
class Error {
	var $threshold;
	var $_levels;
	
	function Error() {
		log_message("[error] é instanciado.");
		
		$this->_levels = array("Notice", "Warning", "Error");
		
		$this->threshold = 1;
	}

	function add($tmp_level, $tmp_message, $tmp_class = "", $tmp_function = "", $tmp_file = "", $tmp_line = 0) {
		if ($tmp_level >= $this->threshold) {
			echo "<div style='border: 1px solid #666666; font-family: Verdana; font-size: 10px; color: #333333; padding: 5px; line-height: 16px; margin: 5px;'>" . LF;
			
			echo "<h3 style='font-family: Arial; font-size: 18px; color: #990000; margin: 0 0 5 5px;'>" . $this->_levels[$tmp_level] . "</h3>" . LF;
			
			echo "<b>MESSAGE:</b> " . str_replace(DIR_ROOT, "/", $tmp_message) . "" . LF;
			
			if ($tmp_line > 0) {
				echo "<br><b>LINE:</b> " . $tmp_line . LF;
			}
			
			if ($tmp_file != "") {
				echo "<br><b>FILE:</b> " . str_replace(DIR_ROOT, "/", $tmp_file) . LF;
			}
			
			if ($tmp_class != "") {
				echo "<br><b>FUNCTION:</b> " . $tmp_class . "::" . $tmp_function . "()" . LF;
			} else if ($tmp_function != "") {
				echo "<br><b>FUNCTION:</b> " . $tmp_function . LF;
			}
			
			echo "</div>" . LF;
			
			if ($tmp_level == 2) {
				die();
			}
		}
	}
}
$error = new Error();

function error($tmp_level, $tmp_message, $tmp_class = "", $tmp_function = "", $tmp_file = "", $tmp_line = 0) {
	global $cfg;
	global $error;
	
	if ((IS_LOCAL) || ($cfg["develop"])) {
		$error->add($tmp_level, $tmp_message, $tmp_class, $tmp_function, $tmp_file, $tmp_line);
	}
}
?>