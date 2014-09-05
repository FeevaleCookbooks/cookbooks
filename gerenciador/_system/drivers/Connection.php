<?
class DBConnection {
	function DBConnection() {
		log_message("[db] é instanciado.");
	}
	
	function connect($tmp_cfg, $tmp_microtime_ini = 0,$position = 0) {
		log_message("Conectado ao servidor <b>" . $tmp_cfg["database_server"][$position] . "</b>(" . $tmp_cfg["database_type"][$position] . ")", $tmp_microtime_ini);
	}
	
	function execute($tmp_sql, $tmp_microtime_ini = 0, $position = 0) {
		log_sql($tmp_sql, $tmp_microtime_ini);
	}
}
?>