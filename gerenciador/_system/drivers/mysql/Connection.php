<?
class Mysql_Connection extends DBConnection {
	var $_connection;
	var $_database;

	var $sql; //Object of sql template functions
	function Mysql_Connection() {
		parent::DBConnection();
		
		$this->sql = new Mysql_Sql();
		
		//register_shutdown_function("close"); 
	}
	
	function connect($tmp_cfg,$tmp_position = 0) {	
		$microtime_ini = microtime();
	
		$tmp_cfg["database_server"] = 	trim($tmp_cfg["database_server"][$tmp_position]);
		$tmp_cfg["database_user"] = 	trim($tmp_cfg["database_user"][$tmp_position]);
		$tmp_cfg["database_password"] = trim($tmp_cfg["database_password"][$tmp_position]);
		$tmp_cfg["database_database"] = trim($tmp_cfg["database_database"][$tmp_position]);
		
		if (!($this->_connection = @mysql_connect($tmp_cfg["database_server"], $tmp_cfg["database_user"], $tmp_cfg["database_password"]))) {
			error(2, "Não foi possível estabelecer uma conexão com o servidor. <i>(" . mysql_error() . ")</i>", "Mysql_Connection", "connect");
		}
		
		if (!(@mysql_select_db($tmp_cfg["database_database"], $this->_connection))) {
			error(2, "Não foi possível selecionar o banco '" . $tmp_cfg["database_database"] . "'.", "Mysql_Connection", "connect");
		}
		
		$this->_database = $tmp_cfg["database_database"];

		parent::connect($tmp_cfg, $microtime_ini);
	}
	
	function execute($tmp_sql, $tmp_return_type = 1) {	
		$microtime_ini = microtime();
		
		$r = new Mysql_RecordSet($tmp_sql, $this->_connection,$this->_database);
		
		parent::execute($tmp_sql, $microtime_ini);
				
		if ($r->error != "") {
			error(2, "Erro de sql: " . $r->sql . " <i>(" . $r->error . ")</i>.", "Mysql_Connection", "execute");
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
		mysql_close($this->_connection);
	}
}
?>