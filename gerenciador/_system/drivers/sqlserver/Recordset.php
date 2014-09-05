<?
class Sqlserver_RecordSet {
	var $_connection;
	var $_database;
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

	function Sqlserver_RecordSet($tmp_sql, $tmp_connection,$tmp_database) {
		$this->_connection = $tmp_connection;
		$this->_database = $tmp_database;
		
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
			//Execute query
			if (!($this->rs = @mssql_query($this->sql, $this->_connection))) {
				@mssql_select_db($this->_database, $this->_connection);
				if (!($this->rs = @mssql_query($this->sql, $this->_connection))) {
					//$this->error = mssql_error();
					
					return false;
				}
			}
			
			$db->sql->sql = $this->sql;
						
			//If sql is 'select'
			if (strtolower(substr(trim($this->sql), 0, 6)) == "select") {
				$this->recordcount = mssql_num_rows($this->rs);
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
		
		if (!($this->fields = mssql_fetch_assoc($this->rs))) {
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
		
		$count = 1;
		while((!$this->EOF) && ($count < ($this->pagesize * $tmp_page-$this->pagesize))){
			$this->moveNext();
			$count++;
		}
		
		//$this->execute($this->sql);
	}

	function getInsertId() {
		return mssql_insert_id();
	}

	//Private
	function _formatSql($tmp_sql) {
		$r = trim($tmp_sql);
		
		$r = str_replace("day(", "dayofmonth(", $tmp_sql);
		$r = str_replace("DAY(", "dayofmonth(", $tmp_sql);
		
		return $r;
	}
}
?>