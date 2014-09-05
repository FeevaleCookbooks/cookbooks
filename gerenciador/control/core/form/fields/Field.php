<?php
class Field {
	//Config
	var $type;
	var $validation;
	var $config_type;
	var $filter_type;

	//Value
	var $value;
	var $value_initial;
	var $value_static;

	//Style
	var $label;
	var $size_cols;
	var $size_rows;
	var $list_width;
	var $maxlength;
	var $show_maxlength;
	var $minlength;
	var $input_extra;
	var $list_align;
	var $comment;

	//Flags
	var $is_required;
	var $is_static;
	var $is_sql_affect;
	var $is_html;
	var $is_formated;
	var $in_filter;

	//Flags
	var $flags;
	var $flags_accept;

	//Indexes
	var $index_list;
	var $index_filter;
	var $index_form;

	//Lists
	var $elements;
	var $element_key;

	function Field($tmp_type, $tmp_name = "") {
		$this->type = $tmp_type;
		$this->name = $tmp_name;
		$this->config_type = "";
		$this->input_type = "";

		$this->validation = "";
		$this->value = "";
		$this->value_initial = "";
		$this->value_static = "";

		$this->label = "";
		$this->size_cols = 0;
		$this->size_rows = 0;
		$this->list_width = 0;
		$this->maxlength = "";
		$this->show_maxlength = true;
		$this->minlength = "";
		$this->input_extra = "";
		$this->comment = "";

		$this->is_required = true;
		$this->is_static = false;
		$this->is_sql_affect = true;
		$this->is_html = false;
		$this->is_formated = false;
		$this->in_filter = false;

		$this->flags = "LOFIU";
		$this->flags_accept = "LOFIU";

		$this->index_list = 0;
		$this->index_filter = 0;
		$this->index_form = 0;

		$this->elements = array();
		$this->element_key = "";

		//Set value
		global $form;
		if (is_object($form)) {
			$this->value = $form->fields($this->name);
			$this->formatValue();
			$this->value_static = $this->value;
		}
	}

	//Sets
	function setValidation($tmp_value) { $this->validation = $tmp_value; }
	function setInitialValue($tmp_value) { $this->value_initial = $tmp_value; }
	function setStaticValue($tmp_value) { $this->value_static = $tmp_value; }
	function setLabel($tmp_value) { $this->label = $tmp_value; }
	function setSize($tmp_cols, $tmp_rows = 1) {
		$this->size_cols = $tmp_cols;
		$this->size_rows = $tmp_rows;
	}
	function setRequired($tmp_value) { $this->is_required = $tmp_value; }
	function setStatic($tmp_value) { $this->is_required = $tmp_value; }
	function setMaxLength($tmp_value) { $this->maxlength = $tmp_value; }
	function setMinLength($tmp_value) { $this->minlength = $tmp_value; }

	//Elements functions
	function addElementsByTable($tmp_table, $tmp_field_value = "id", $tmp_field_label = "nome", $tmp_order_by = "[label]") {
		global $db;

		if ($tmp_order_by == "[label]") {
			$tmp_order_by = $tmp_field_label . " asc";
		}

		$sql = "select " . $tmp_field_value . " as id, " . $tmp_field_label . " as nome from " . $tmp_table . " order by " . $tmp_order_by;
		$this->addElementsBySql($sql);
	}

	function addElementsBySql($tmp_sql, $tmp_field_value = "id", $tmp_field_label = "nome") {
		global $db;

		$rs = $db->execute($tmp_sql);

		while (!$rs->EOF) {
			$this->elements[$rs->fields($tmp_field_value)] = $rs->fields($tmp_field_label);

			$rs->moveNext();
		}
	}

	function addElementsByArray($tmp_array) {
		foreach ($tmp_array as $k => $v) {
			$this->elements[$k] = $v;
		}
	}

	function addElement($tmp_value, $tmp_label) {
		$this->elements[$tmp_value] = $tmp_label;
	}

	//Private functions
	function testRequiredType($tmp_type) {
		if (IS_DEVELOP) {
			global $form;
			if (is_object($form)) {
				if (!is_array($tmp_type)) {
					$tmp_type = array($tmp_type);
				}

				$infos = $form->fields_info;
				$type = "";
				foreach ($infos as $v) {
					if ($v["name"] == $this->name) {
						$type = $v["type"];
					}
				}

				if ($type) {
					$ok = false;
					foreach ($tmp_type as $v) {
						if (strpos($type, $v) !== false) {
							$ok = true;
						}
					}

					if (!$ok) {
						if ($type != "") {
							error(2, "Tipo '" . $type . "' não suportado. Utilize somente '" . implode(", ", $tmp_type) . "'.", "Field", "testRequiredType");
						} else {
							error(2, "Campo '" . $this->name . "' não existe na tabela.", "Field", "testRequiredType");
						}
					}
				}
			}
		}
	}

	function getValue() {
		global $routine;

		if (($this->is_static) && (($routine == "insert") || ($routine == "update"))) {
			return trim($this->value_static);
		} elseif (($this->value == "") && ($this->value_initial != "") && ($routine == "insert")) {
			return trim($this->value_initial);
		} else {
			if ($this->maxlength > 0) {
				$this->value = substr($this->value, 0, $this->maxlength);
			}

			return trim($this->value);
		}
	}

	function _escapeValue($tmp_value) {
		return str_replace("\"", "'", $tmp_value);
	}

	function testFlag($tmp_flag) {
		if (strpos($this->flags, $tmp_flag) !== false) {
			return true;
		} else {
			return false;
		}
	}

	function testAcceptFlags($tmp_flags) {
		$new_flags = "";
		for ($i = 0; $i < strlen($tmp_flags); $i++) {
			if (strpos($this->flags_accept, $tmp_flags{$i}) !== false) {
				$new_flags .= $tmp_flags{$i};
			}
		}

		$this->flags = $new_flags;
	}

	function _getFormatedId($tmp_n = "") {
		if ($tmp_n != "") {
			$tmp_n = "**" . $tmp_n;
		}

		$required = ($this->is_required) ? 1 : 0;

		$id = $this->label . $tmp_n . "_" . $this->validation . $required;

		if ($this->minlength > 0) {
			$id .= "_" . $this->minlength;
		}

		return $id;
	}

	function _getFilterName($tmp_extra = "") {
		if ($tmp_extra != "") {
			$tmp_extra = "-" . $tmp_extra;
		}

		return "f_" . $this->name . $tmp_extra;
	}

	function _getFilterValue($tmp_extra = "") {
		global $menu;
		global $input;

		$filter_name_parent = $this->_getFilterName();
		$filter_name = $this->_getFilterName($tmp_extra);
		$sub = $menu->index . "-" . $menu->index_sub;

		if ($input->request("sem_filtro") == 1) {
			$v = "";
		} elseif ((isset($_POST[$filter_name])) || (isset($_GET[$filter_name]))) {
			if ($input->request($filter_name_parent . "-chk") != "") {
				$v = $input->request($filter_name);
			} else {
				$v = "";
			}
		} else {
			$v = $input->session($sub . " - f_" . $filter_name);
		}

		$input->setSession($sub . " - f_" . $filter_name, $v);

		return $v;
	}

	function _getFilterChecked($tmp_extra = "") {
		global $input;
		global $menu;

		$filter_name = $this->_getFilterName($tmp_extra);
		$sub = $menu->index . "-" . $menu->index_sub;

		$v = $input->request($filter_name . "-chk");

		if ($input->session($sub . " - f_" . $filter_name) != '') {
			$v = "1";
		}

		if ($input->request("sem_filtro") == 1) {
			$v = "0";
		}

		if ($v == "1") {
			$v = "checked";
		} else {
			$v = "";
		}

		return $v;
	}

	//======================================
	//	Format/Unformat
	//======================================
	function formatValue() {
		global $load;
		$load->system('functions/text.php');

		$this->value = $this->getValue();

		if (!$this->is_formated) {
			$this->value = formatSpecialCaracter($this->value);

			$this->is_formated = true;

			$this->value = $this->getValueFormated();
		}
	}

	function unformatValue() {
		if ($this->is_formated) {
			$this->is_formated = false;

			$this->value = formatSpecialCaracter($this->value,false);

			$this->value = $this->getValueUnformated();
		}
	}

	//======================================
	//	Overwrite functons
	//======================================
	function getValueFormated() { return $this->value; }
	function getValueUnformated() { return $this->value; }
	function getHtmlList($tmp_extra) {
		global $rs_list;

		$this->formatValue();

		if ($this->value == "") {
			$this->value = "<font color='silver'>(vazio)</font>";
		}
		$align = "";
		if($this->list_align != "") {
			$align = " align='" . $this->list_align . "'";
		}

		$html = "<td " . $tmp_extra . " id='td_id_".$this->name."_".$rs_list->fields('id')."' $align>" . $this->value . "</td>" . LF;

		return $html;
	}
	function getFilter() { return array("html" => "", "sql" => ""); }
	function getHtml() {
		$html = "<tr>";

		if ($this->label != "") {
			$html .= "<td class='label'>";

			$html .= $this->label . ": ";

			if ($this->is_required) {
				$html .= "<font class='red'>*</font>";
			}

			$html .= "</td>" . LF;
		}

		$this->formatValue();

		$html .= "<td class='input'>";

		if ($this->comment) {
			$html .= "<table cellspacing='0' cellpadding='0' width='100%'><tr><td>";
		}

		if ($this->is_static) {
			$this->getInput();

			$html .= "<font color='#59748E'>" . $this->value . "</font>";
		} else {
			$html .= $this->getInput();
		}

		if ($this->comment) {
			$html .= "</td></tr><tr><td class='comment'>" . $this->comment . "</td></tr></table>";
		}

		$html .= "</td></tr>" . LF;

		return $html;
	}
	function loadInit() { }
	function loadJSPrePost() { }
	function onPrePost() { }
	function onPosPost() { }
	function onDelete() { }
}
?>