<?
class Oracle_Connection extends DBConnection {
	var $_connection;

	var $sql; //Object of sql template functions
	function Oracle_Connection() {
		parent::DBConnection();
		
		$this->sql = new Oracle_Sql();
	}
	
	function connect($cfg,$tmp_position = 0) {	
		$microtime_ini = microtime();
	
		$tmp_cfg["database_server"] = 	trim($cfg["database_server"][$tmp_position]);
		$tmp_cfg["database_user"] = 	trim($cfg["database_user"][$tmp_position]);
		$tmp_cfg["database_password"] = trim($cfg["database_password"][$tmp_position]);
		$tmp_cfg["database_database"] = trim($cfg["database_database"][$tmp_position]);
		$tmp_cfg["database_port"] = trim($cfg["database_port"][$tmp_position]);
		
		if ($tmp_cfg["database_database"] != '') {
			$tns = " (DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$tmp_cfg["database_server"].")(PORT = ".$tmp_cfg["database_port"].")))(CONNECT_DATA = (SID = ".$tmp_cfg["database_database"].")))";
		} else {
			$tns = $tmp_cfg["database_server"];
		}			
			
		if (!($this->_connection = ocilogon($tmp_cfg["database_user"], $tmp_cfg["database_password"],$tns))) {			
			echo('<pre>');
			print_r(ocierror());
			echo('</pre>');
			die("Não foi possível estabelecer uma conexão com o servidor.");
		}
		
		parent::connect($cfg, $microtime_ini,$tmp_position);
	}
	
	function execute($tmp_sql, $tmp_return_type = 1) {	
		$microtime_ini = microtime();
		
		$r = new Oracle_RecordSet($tmp_sql, $this->_connection);
		
		parent::execute($tmp_sql, $microtime_ini);
				
		if ($r->error != "") {
			error(2, "Erro de sql: " . $r->sql . " <i>(" . $r->error . ")</i>.", "Oracle_Connection", "execute");
		}
		
		if ($tmp_return_type == 1) {
			//Object
			return $r;
		} elseif ($tmp_return_type == 2) {
			//Resource
			return $r->rs;
		}
	}
	
	function close() {
		ocilogoff($this->_connection);
	}
}
?>