<?php
class Form extends DBTable {
	var $flags; //Permission flags [IUD]

	var $default_order;
	var $page_size;
	var $show_list_init;

	var $is_unique; //If is a form only
	var $enable_update; //If buttom update is enabled

	var $_fieldset; //Fields loaded from config

	var $_fields_loaded; //Array of class fields
	var $_fields_index; //Index of fields for addField method

	var $_buttons; //Array of customized buttons

	function Form($tmp_table) {
		parent::DBTable($tmp_table);

		log_message("[form] é instanciado.");

		$this->_fieldset = array();
		$this->flags = "IUD";
		$this->_fields_index = 0;

		$this->is_unique = false;
		$this->enable_update = true;

		$this->default_order = "";
		$this->page_size = 50;
		$this->show_list_init = true;
		$this->show_filters_init = false;

		$this->_buttons = array();

		global $load;
		$load->manager("core/form/fields/Field.php");
		$this->_fields_loaded = array();
	}

	//sets
	function setDefaultOrder($tmp_value) { $this->default_order = $tmp_value; }
	function setPageSize($tmp_value) { $this->page_size = $tmp_value; }
	function setShowListInit($tmp_value) { $this->show_list_init = $tmp_value; }
	function setShowFiltersInit($tmp_value) { $this->show_filters_init = $tmp_value; }

	function testFlag($tmp_flag) {
		if (strpos($this->flags, $tmp_flag) !== false) {
			return true;
		} else {
			return false;
		}
	}

	//Buttons handle
	function addButton($tmp_function, $tmp_name, $tmp_label = "") {
		$arr = array();
		$arr["function"] = $tmp_function;
		$arr["name"] = $tmp_name;
		$arr["label"] = $tmp_label;

		$this->_buttons[] = $arr;
	}

	function execButton($tmp_name) {
		$func = "";

		foreach ($this->_buttons as $v) {
			if ($v["name"] == $tmp_name) {
				$func = $v["function"];
			}
		}

		if ($func) {
			$func();
		}
	}

	//Fields handle
	function getFieldSet() {
		if (count($this->_fieldset) == 0) {
			if (method_exists($this, "configFields")) {
				$this->configFields();
			} else {
				error(2, "Método extendido 'configFields' não existe", "Form", "getFields");
			}
		}

		return $this->_fieldset;
	}

	function resetFieldSet() {
		$this->_fieldset = array();
	}

	function newField($tmp_type, $tmp_params = array()) {
		$this->_fields_index++;

		if (!in_array($tmp_type, $this->_fields_loaded)) {
			global $load;
			$include = $load->manager("core/form/fields/Field" . ucfirst($tmp_type) . ".php", false);

			if (!$include) {
				$load->config("exceptions/fields/Field" . ucfirst($tmp_type) . ".php");
			}

			$this->_fields_loaded[] = $tmp_type;
		}

		if ($tmp_params == array()) {
			$tmp_params = array("", "");
		}

		$class = "Field" . $tmp_type;
		$f = new $class($tmp_params);

		$f->index_list = $this->_fields_index;
		$f->index_filter = $this->_fields_index;
		$f->index_form = $this->_fields_index;

		return $f;
	}

	function addField(&$tmp_field, $tmp_flags = "") {
		if (($tmp_field->is_html) && ($tmp_flags == "")) {
			$tmp_flags = "IU";
		}

		$tmp_field->flags = $tmp_flags;

		if ($tmp_field->is_static) {
			$tmp_field->is_required = false;

			if ($tmp_field->value_static == "") {
				$tmp_field->is_sql_affect = false;
			}
		}

		$this->_fieldset[] = $tmp_field;
	}

	function &getFieldByName($tmp_name) {
		$fields = $this->getFieldSet();

		foreach($fields as $k => $v) {
			if ($v->name == $tmp_name) {
				return $v;
			}
		}
	}

	//Headers
	function getHeaders() {
		$order = $this->_getOrderValue();
		$order_parsed = explode("#", $order);

		if (sizeof($order_parsed) > 1) {
			$order_name = $order_parsed[0];
			$order_direction = $order_parsed[1];
			$sql = " order by " . $order_name . " " . $order_direction;
		} else {
			$order_name = "";
			$order_direction = "";
			$sql = "";
		}

		$fields = $this->getFieldSet();

		$html = "";
		foreach($fields as $k => $v) {
			if ($v->testFlag("L")) {
				$css = "";
				$a = "";
				if ($v->testFlag("O")) {
					if ($v->name == $order_name) {
						if ($order_direction == "asc") {
							$css = "_down";
							$a = "onclick=\"javascript: listOrder('" . $v->name . "#desc');\" style='cursor: pointer;' title='Ordem decrescente'";
						} else {
							$css = "_up";
							$a = "onclick=\"javascript: listOrder('" . $v->name . "#asc');\" style='cursor: pointer;' title='Ordem crescente'";
						}
					} else {
						$a = "onclick=\"javascript: listOrder('" . $v->name . "#asc');\" style='cursor: pointer;' title='Ordem crescente'";
					}
				}

				if ($v->list_width > 0) {
					$a .= " width='" . $v->list_width . "'";
				}

				$html .= "<td class='header" . $css . "' " . $a . ">" . $v->label . "</td>" . LF;
			}
		}

		return array("html" => $html, "sql" => $sql);
	}

	//Filters
	function getFilters() {
		$fields = $this->getFieldSet();

		$html = "";
		$sql = "";
		foreach($fields as $k => $v) {
			if ($v->testFlag("F")) {
				$arr = $v->getFilter();
				$html .= $arr["html"];

				if ($arr["sql"] != "") {
					$sql .= $arr["sql"];
				}
			}
		}

		return array("html" => $html, "sql" => $sql);
	}

	//List page
	function getListPage() {
		global $menu;
		global $input;

		$p = 1;
		$sub = $menu->index . "-" . $menu->index_sub;

		if (isset($_POST["page"])) {
			$p = $input->request("page");

			$_SESSION[$sub . " - page"] = $p;
		} else if ($input->session($sub . " - page") != "") {
				$p = $input->session($sub . " - page");
		}

		return $p;
	}

	//Run form and fields initialize functions
	function loadInitAll($tmp_flag) {
		//Init class
		$this->loadInit($tmp_flag);

		//Init fields
		$fields = $this->getFieldSet();

		foreach($fields as $k => $v) {
			if ($v->testFlag($tmp_flag)) {
				$v->loadInit();
			}
		}
	}

	//Form
	function postInsert() {
		global $input;
		global $log;

		$fields = $this->getFieldSet();

		foreach ($fields as $k => $v) {
			if (($v->testFlag("I")) && ($v->is_sql_affect) && (($input->keyExists("request", $v->name)) || (($v->is_static) && ($v->value_static != "")))) {
				$v->is_formated = true;
				$v->value = $input->request($v->name);
				$v->unformatValue();

				if ($v->is_static) {
					$v->value = $v->value_static;
				}

				$ok = true;

				if ($v->type == "password") {
					if ($v->value == "") {
						$ok = false;
					}
				}

				if ($ok) {
					$this->fields[$v->name] = $v->value;
				}
			}
		}

		//die();


		$this->onPrePost("I");

		$this->_onPrePostFields("I");

		$this->insert();

		/*******  INSERE O LOG  ********/
		$log->fields = $this->fields;
		$log->insertLog("insert");
		/******* / INSERE O LOG  ********/

		$this->_onPosPostFields("I");

		$this->onPosPost("I");
	}

	function postUpdate() {
		global $input;
		global $cfg;
		global $log;

		$fields = $this->getFieldSet();

		$log->fieldsold = $this->fields; // Para o log saber quais campos foram alterados

		foreach ($fields as $k => $v) {
			if (($v->testFlag("U")) && ($v->is_sql_affect) && (($input->keyExists("request", $v->name)) || (($v->is_static) && ($v->value_static != "")))) {
				$v->is_formated = true;
				$v->value = $input->request($v->name);
				$v->unformatValue();

				if ($v->is_static) {
					$v->value = $v->value_static;
				}

				$ok = true;

				if ($v->type == "password") {
					if ($v->value == "") {
						$ok = false;
					}
				}

				if ($ok) {
					$this->fields[$v->name] = $v->value;
				}
			}
		}

		//die();

		$this->onPrePost("U");

		$this->_onPrePostFields("U");

		$this->update();

		/*******  INSERE O LOG  ********/
		$log->fields = $this->fields;
		$log->idregister = $this->fields('id');
		$log->insertLog("update");
		/******* / INSERE O LOG  ********/

		$this->_onPosPostFields("U");

		$this->onPosPost("U");
	}

	function postDelete() {
		global $log;

		$this->onDelete();

		$this->_onDeleteFields();

		$this->delete();

		/*******  INSERE O LOG  ********/
		$log->fields = $this->fields;
		$log->idregister = $this->fields('id');
		$log->insertLog("delete");
		/******* / INSERE O LOG  ********/	}

	//Private functions
	function _getOrderValue() {
		global $input;
		global $menu;

		$sub = $menu->index . "-" . $menu->index_sub;

		if ($input->post("order") != "") {
			$r = $input->post("order");
		} elseif ($input->session($sub . " order") != "") {
			$r = $input->session($sub . " order");
		} elseif ($this->default_order != "") {
			$r = $this->default_order;
		} else {
			$r = "";
		}

		$input->setSession($sub . " order", $r);

		return $r;
	}

	function _loadJSPrePost($tmp_flag) {
		$this->loadJSPrePost($tmp_flag);

		$fields = $this->getFieldSet();

		foreach($fields as $k => $v) {
			if ($v->testFlag($tmp_flag)) {
				$v->loadJSPrePost($tmp_flag);
			}
		}
	}

	function _onPrePostFields($tmp_flag) {
		$fields = $this->getFieldSet();

		foreach ($fields as $k => $v) {
			if ($v->testFlag($tmp_flag)) {
				$v->onPrePost();
			}
		}
	}

	function _onPosPostFields($tmp_flag) {
		$fields = $this->getFieldSet();

		foreach ($fields as $k => $v) {
			if (($v->testFlag($tmp_flag)) || ($v->type == "order")) {
				$v->onPosPost();
			}
		}
	}

	function _onDeleteFields() {
		$fields = $this->getFieldSet();

		foreach ($fields as $k => $v) {
			if (($v->testFlag("I")) || ($v->testFlag("U"))) {
				$v->onDelete();
			}
		}
	}

	//Extended functions
	function getListSql($tmp_sql_filter, $tmp_sql_order) {
		return "select * from " . $this->table . " where 1=1 " . $tmp_sql_filter . " " . $tmp_sql_order;
	}
	function loadInit($tmp_flag) { }
	function loadJSPrePost($tmp_flag) { }
	function onPrePost($tmp_flag) { }
	function onPosPost($tmp_flag) { }
	function onDelete() { }
	function onPreList() { } /* Handled in the list.php*/
	function onPosList() { }
}
?>