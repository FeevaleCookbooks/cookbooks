<?
class Oracle_RecordSet {
	var $_connection;
	var $rs;
	
	var $sql;
	var $error;
	
	var $recordcount;
	var $pagesize;
	var $pagecount;
	var $absolutepage;
	var $BOF;
	var $EOF;
	
	var $fields;

	function Oracle_RecordSet($tmp_sql, $tmp_connection) {
		$this->_connection = $tmp_connection;
		
		$this->sql = $this->_formatSql($tmp_sql);
		
		$this->pagesize = 0;
		$this->pagecount = 1;
		$this->absolutepage = 1;
		
		$this->error = "";
		$this->execute($tmp_sql);
	}
	
	function execute($tmp_sql) {
		global $db;

		$this->BOF = true;
		$this->EOF = true;
		
		if ($tmp_sql == "") {
			$this->error = "Sql vazia";
			
			return false;
		}
		
		if (is_resource($this->_connection)) {
			//Page handle
			if ($this->pagesize > 0) {
			
				if (substr($this->sql, -1) == ";") {
					$this->sql = substr($this->sql, 0, (strlen($this->sql) - 1));
				}
				
				$tmp = explode("LIMIT", $this->sql);
				$ini = ($this->absolutepage - 1) * $this->pagesize;
				$this->sql = $tmp[0] . " LIMIT " . $ini . "," . $this->pagesize;
			}
			
			$this->rs = ociparse($this->_connection,$this->sql);
			
			//Execute query
			if (!(@ociexecute($this->rs))) {
				$this->error = ocierror();
				
				return false;
			}
			
			$db->sql->sql = $this->sql;			
			
			//If sql is 'select'
			if (strtolower(substr(trim($this->sql), 0, 6)) == "select") {
				$this->recordcount = oci_num_rows($this->rs);
				$this->movenext(true);
			} else {
				$this->EOF = true;
			}
		}
	}

	function recordCount() {
		return $this->recordcount;
	}
	
	function moveFirst() {
		$this->execute($this->sql);
	}
	
	function moveNext($tmp_is_first = false) {
		$this->BOF = $tmp_is_first;
		
		if (!($this->fields = oci_fetch_assoc($this->rs))) {
			$this->EOF = true;
		} else {
			$this->EOF = false;
		}
	}

	function fields($tmp_name) {
		if (array_key_exists($tmp_name, $this->fields)) {
			$r = $this->fields[$tmp_name];
		} else {
			$r = NULL;
		}
		
		return $r;
	}

	function page($tmp_page = 1) {
		if ($tmp_page < 1) {
			$tmp_page = 1;
		}
		
		$this->pagecount = $this->recordcount / $this->pagesize;
		if ($this->pagecount > (int)($this->pagecount)) {
			$this->pagecount = (int)($this->pagecount)+1;
		}
		
		$this->absolutepage = $tmp_page;
		
		$this->execute($this->sql);
	}

//	function getInsertId() {
//		return mysql_insert_id();
//	}

	//Private
	function _formatSql($tmp_sql) {
		$r = trim($tmp_sql);
		
		$r = str_replace("day(", "dayofmonth(", $tmp_sql);
		$r = str_replace("DAY(", "dayofmonth(", $tmp_sql);
		
		return $r;
	}
}
?>