<?
class Date {
	
	
	function getMicroTime() {
		$tmp = explode(" ", microtime());
		
		return (float)$tmp[0] + (float)$tmp[1];
	}
}
?>