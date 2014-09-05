<?
class Mysql_Sql {
	var $sql;
	
	function Mysql_Sql() {
		$this->sql = '';
	}
	
	function getFieldsInfo($tmp_table) {
		global $db;
		
		$sql = "SHOW COLUMNS FROM " . $tmp_table . ";";
		$rs = $db->execute($sql, 2);
		
		while ($d = mysql_fetch_assoc($rs)) {
			$info = array();
			
			$info["name"] = $d["Field"];
			$info["null_accept"] = ($d["Null"] == "YES");
			$info["key_type"] = $d["Key"];
			$info["default"] = $d["Default"];
			$info["auto_increment"] = (strpos($d["Extra"], "auto_increment") !== false);
			$info["type"] = $d["Type"];
			
			$r[] = $info;
		}
		
		return $r;
	}
	
	function escape($tmp_string) {
		if (is_string($tmp_string)) {
			return "'" . str_replace("'", "`", $tmp_string) . "'";
		} elseif (is_numeric($tmp_string)) {
			return $tmp_string;
		} elseif (is_null($tmp_string)) {
			return "NULL";
		}
	}

	/**
	Checking the directive for automatic backslashing of query string.
	*/
	public static function gpc_mysql_real_escape_string($str) {
		return (get_magic_quotes_gpc() ? $str : mysql_real_escape_string($str));
	}
}
?>
