<?
class DBTable {
	var $table;

	var $fields;
	var $fields_info;

	var $key_field;

	function DBTable($tmp_table, $tmp_key_field = "id") {
		$this->table = trim($tmp_table);

		$this->key_field = trim($tmp_key_field);

		$this->_loadFieldsInfo();
	}

	function setValuesFromInput($tmp_function = "") {
		global $input;

		if ($tmp_function == "") {
			$tmp_function = "post";
		}

		switch ($tmp_function) {
			default:
			case "post":
				$arr = $_POST;
				$function = "post";

				break;
			case "get":
				$arr = $_GET;
				$function = "get";

				break;
		}

		foreach ($this->fields_info as $v) {
			$name = $v["name"];

			if (array_key_exists($name, $arr)) {
				eval("$" . "this->fields['".$name."'] = $" . "input->" . $function ."('".$name."');");
			}
		}
	}

	function setValuesFromRs($tmp_rs) {
		if ($tmp_rs) {
			foreach ($this->fields_info as $v) {
				$name = $v["name"];
				$value = $tmp_rs->fields($name);

				if ($value != "") {
					$this->fields[$name] = $value;
				}
			}
		}
	}

	function fields($tmp_name) {
		$r = "";

		if (isset($this->fields[$tmp_name])) {
			$r = $this->fields[$tmp_name];
		}

		return $r;
	}

	//======================================
	//	Sql functions
	//======================================
	function select($tmp_conditions = "[key]") {
		global $db;

		if ($tmp_conditions == "[key]") {
			if ($this->fields[$this->key_field] != "") {
				$tmp_conditions = "id = " . $db->sql->escape($this->fields[$this->key_field]) . " LIMIT 1";
			} else {
				error(1, "Campo '" . $this->key_field . "' não definido", "DBTable", "select");

				return false;
			}
		}

		$sql = "select * from " . $this->table . " where " . $tmp_conditions . ";";
		$rs = $db->execute($sql);

		if (!$rs->EOF) {
			$fields = $this->fields_info;
			$length = count($fields);

			for ($i = 0; $i < $length; $i++) {
				$this->fields[$fields[$i]["name"]] = $rs->fields($fields[$i]["name"]);
			}

			return true;
		} else {
			return false;
		}
	}

	function insert() {
		global $db;

		$fields = $this->fields_info;
		$length = count($fields);

		$arr = array();
		$arr2 = array();

		for ($i = 0; $i < $length; $i++) {
			$v = "";

			if (isset($this->fields[$fields[$i]["name"]])) {
				$v = $this->fields[$fields[$i]["name"]];
			}

			if ((($v != "") || ($v == "0")) && ($fields[$i]["name"] != $this->key_field)) {
				$arr[] = $fields[$i]["name"];
				$arr2[] = $db->sql->escape($v);
			}
		}

		$sql = "insert into " . $this->table . " (" . implode(", ", $arr) . ") values (" . implode(", ", $arr2) . ");";
		$rs = $db->execute($sql);

		$this->fields[$this->key_field] = $rs->getInsertId();
	}

	function update($tmp_conditions = "[key]") {
		global $db;

		if ($tmp_conditions == "[key]") {
			if ($this->fields[$this->key_field] != "") {
				$tmp_conditions = "id = " . $db->sql->escape($this->fields[$this->key_field]);
			} else {
				error(1, "Campo '" . $this->key_field . "' não definido", "DBTable", "update");

				return false;
			}
		}

		$fields = $this->fields_info;
		$length = count($fields);

		$arr = array();

		for ($i = 0; $i < $length; $i++) {
			$v = "";

			if (isset($this->fields[$fields[$i]["name"]])) {
				$v = $this->fields[$fields[$i]["name"]];
			}

			if ((($v != "") || ($v == "0") || ($v == "")) && ($fields[$i]["name"] != $this->key_field)) {
				$arr[] = $fields[$i]["name"] . " = " . $db->sql->escape($v);
			}
		}

		$sql = "update " . $this->table . " set " . implode(", ", $arr) . " where " . $tmp_conditions . ";";
		$db->execute($sql);
	}

	function delete($tmp_conditions = "[key]") {
		global $db;

		if ($tmp_conditions == "[key]") {
			if ($this->fields[$this->key_field] != "") {
				$tmp_conditions = "id = " . $db->sql->escape($this->fields[$this->key_field]);
			} else {
				error(1, "Campo '" . $this->key_field . "' não definido", "DBTable", "delete");

				return false;
			}
		}

		$sql = "delete from " . $this->table . " where " . $tmp_conditions . ";";
		$db->execute($sql);
	}
	
	function selectAll($tmp_conditions = "[key]", $order="[key] DESC") {
		global $db;

		if ($tmp_conditions == "[key]") {
			if ($this->fields[$this->key_field] != "") {
				$tmp_conditions = "id = " . $db->sql->escape($this->fields[$this->key_field]) . " LIMIT 1";
			} else {
				error(1, "Campo '" . $this->key_field . "' não definido", "DBTable", "select");
				return false;
			}
		}
		$order = str_replace('[key]',$this->key_field,$order);

		$this->_loadFieldsInfo();
		$sql = "select * from " . $this->table . " where " . $tmp_conditions . " order by " . $order;
		$rows = $db->execute($sql);
		$i=0;
		if (!$rows->EOF) {
			while(!$rows->EOF){
				for($t=0,$total=count($this->fields_info);$t<$total;$t++){
					$this->fields[$i][$this->fields_info[$t]["name"]] = $rows->fields($this->fields_info[$t]["name"]);
				}
				$i++;
				$rows->moveNext();
			}

			return true;
		} else {
			return false;
		}       
	}

	//Private functions
	function _loadFieldsInfo() {
		global $db;

		$this->fields_info = $db->sql->getFieldsInfo($this->table);
	}
}
?>