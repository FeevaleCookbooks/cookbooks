<?
class Output {
	var $is_ajax;
	
	function Output() {
		log_message("[output] é instanciado.");
		
		$this->is_ajax = false;
	}
	
	function ajaxHeader() {
		header("Content-Type: text/html; charset=iso-8859-1");
		$this->is_ajax = true;
	}
}
?>