<?php
class FieldDate extends Field {
	function FieldDate($tmp_params) {
		global $load;
		$load->setOverwrite(true);
		$load->system("functions/date.php");

		parent::Field("date", $tmp_params[0]);

		$this->label = $tmp_params[1];
		$this->setInputType("date");
	}

	function setFilterType($tmp_type) {
		//1 - interval of 2 fields
		//2 - combo of months
		$this->filter_type = $tmp_type;
	}

	function setInputType($tmp_type) {
		switch ($tmp_type) {
			default:
			case "date":
				$this->input_type = "date";
				$this->filter_type = 2;
				$this->testRequiredType(array("date"));
				$this->validation = "DAT";
				$this->size_cols = 10;
				$this->maxlength = 10;
				$this->minlength = 10;
				$this->list_width = 90;

				break;
			case "datetime":
				$this->input_type = "datetime";
				$this->testRequiredType(array("datetime"));
				$this->validation = "DAT";
				$this->maxlength = 19;
				$this->minlength = 19;
				$this->list_width = 100;

				break;
		}
	}

	//private functions
	function getHtmlList($tmp_extra) {
		$this->formatValue();

		if ($this->value == "") {
			$this->value = "<font color='silver'>(vazio)</font>";
		}

		$html = "<td " . $tmp_extra . " align='center'>" . $this->value . "</td>" . LF;

		return $html;
	}

	function getInput($tmp_n = 0) {
		if ($tmp_n == 0) {
			$tmp_n = "";
		}

		$v = $this->getValue();

		if ($this->input_type == "datetime") {
			$tmp = explode(" ", $v);
			$v = $tmp[0];

			if (sizeof($tmp) > 1) {
				$v2 = $tmp[1];
			} else {
				$v2 = "";
			}

			$this->maxlength = 10;
			$this->minlength = 10;
			$this->size_cols = 10;
		}

		$id = $this->_getFormatedId($tmp_n);

		$html = "<input ";
		$html .= "class='input' ";
		$html .= "type='text' ";
		$html .= "id='" . $id . "' ";
		$html .= "name='" . $this->name . "' ";
		$html .= "size='" . $this->size_cols . "' ";
		$html .= "maxlength='" . $this->maxlength . "' ";
		$html .= "value=\"" . $this->_escapeValue($v) . "\" ";
		$html .= " " . $this->input_extra;
		$html .= ">";



		if (($this->input_type == "datetime") && (!$this->in_filter)) {
			$this->validation = "HO2";
			$this->maxlength = 8;
			$this->minlength = 8;
			$this->size_cols = 8;

			$id2 = $this->_getFormatedId($tmp_n);
			$html .= "&nbsp;&nbsp;<input ";
			$html .= "class='input' ";
			$html .= "type='text' ";
			$html .= "id='" . $id2 . "' ";
			$html .= "name='" . $this->name . "_2' ";
			$html .= "size='" . $this->size_cols . "' ";
			$html .= "maxlength='" . $this->maxlength . "' ";
			$html .= "value=\"" . $this->_escapeValue($v2) . "\" ";
			$html .= " " . $this->input_extra;
			$html .= ">";
		}

		if (($this->input_type == "date") || ($this->input_type == "datetime")) {
			$html .= "<img title='Abrir calendário' align='top' onclick=\"javascript: objcalendario.open('" . $id . "');\" src='../img/buttons/bt-calendar.gif' style='cursor: pointer; margin: 1 2 0 3px; _margin: 2 2 0 3px;'>";
		}

		if (($this->input_type == "datetime") && (!$this->in_filter)) {
			$html .= "<img title='Data/Hora atual' align='top' onclick=\"javascript: { document.getElementById('" . $id . "').value = '" . date("d/m/Y") . "'; document.getElementById('" . $id2 . "').value = '" . date("H:i:s") . "'; }\" src='../img/icons/time_go.gif' style='cursor: pointer; margin: 1 2 0 3px; _margin: 2 2 0 3px;'>";
		} else {
			$html .= "<img title='Data atual' align='top' onclick=\"javascript: document.getElementById('" . $id . "').value = '" . date("d/m/Y") . "'; if(document.getElementById('" . $id . "')){ document.getElementById('" . $id . "').onkeyup();}\" src='../img/icons/time_go.gif' style='cursor: pointer; margin: 1 2 0 3px; _margin: 2 2 0 3px;'>";
		}

		return $html;
	}

	function getValueFormated() {
		if (($this->value != "") and ($this->value != "0000-00-00") and ($this->value != "0000-00-00 00:00:00")) {
			$this->detectInputType();

			if ($this->input_type == "datetime") {
				$v = datetimeFromMysql($this->value);
			} else {
				$v = dateFromMysql($this->value);
			}
		} else {
			$v = "";
		}

		return $v;
	}
	function getValueUnformated() {
		if (($this->value != "") and ($this->value != "00/00/0000") and ($this->value != "0000-00-00 00:00:00")) {
			$this->detectInputType();

			if ($this->input_type == "datetime") {
				$tmp = explode(" ", $this->value);

				if (sizeof($tmp) <= 1) {
					global $input;

					$this->value = $this->value . " " . $input->request($this->name . "_2");
				}

				$v = datetimeToMysql($this->value);
			} else {
				$v = dateToMysql($this->value);
			}
		} else {
			$v = "";
		}

		return $v;
	}

	function detectInputType() {
		if ($this->input_type == "") {
			$tmp = explode(" ", $this->value);

			if (sizeof($tmp) > 1) {
				$this->input_type = "datetime";
			} else {
				$this->input_type = "date";
			}
		}
	}

	function getFilter() {
		global $input;

		$html = "";
		$sql = "";

		$filter_name = $this->_getFilterName();
		$filter_value = $this->_getFilterValue();
		$filter_chk = $this->_getFilterChecked();
		$old_name = $this->name;

		$html = "<tr class='fieldset'>" . LF;
		$html .= "	<td class='label'>" . $this->label . ":</td>" . LF;
		$html .= "	<td class='label' style='width: 30px; text-align: center;'><input type='checkbox' name='" . $filter_name . "-chk' id='" . $filter_name . "-chk' value='1' " . $filter_chk . "></td>" . LF;

		//crete filter input
		$this->is_required = false;
		$this->in_filter = true;

		$html .= "	<td class='input'>";

		if ($this->filter_type == 1) {
			//Field 2
			$filter_name2 = $this->_getFilterName(2);
			$filter_value2 = $this->_getFilterValue(2);

			//Field 1
			$this->name = $filter_name;
			$this->value = $filter_value;
			$this->input_extra = "onKeyUp=\"javascript: { if (this.value != '') { document.getElementById('" . $filter_name . "-chk').checked = true; } else { document.getElementById('" . $filter_name . "-chk').checked = false; } }\"";

			$html .= $this->getInput();


			//Field 2
			$this->name = $filter_name2;

			if ($filter_value != "") {
				$this->value = $filter_value2;
			} else {
				$this->value = "";
			}

			$html .= "&nbsp; à &nbsp;" . $this->getInput(2);


			if ($filter_value != "") {
				$v2 = dateToMysql($filter_value2);
				$v2 = strtotime($v2);
				$v2 += (24 * 60 * 60);
				$v2 = date("Y-m-d", $v2);

				$sql = " and " . $old_name . " >= '" . dateToMysql($filter_value) . "' and " . $old_name . " < '" . $v2 . "'";
			}
		} else {
			global $form;
			global $db;
			global $load;

			$sql_list = "
				select
					distinct(concat(month(" . $old_name . "), '/', year(" . $old_name . "))) as junto,
					" . $old_name . " as data,
					year(" . $old_name . ") as ano,
					month(" . $old_name . ") as mes
				from
					" . $form->table . "
				where
					" . $old_name . " != '' and
					" . $old_name . " != '0000-00-00'
				group by
					junto
				order by
					ano desc,
					mes asc
			";
			$rs = $db->execute($sql_list);

			$html .= "<select class='input' name='" . $filter_name . "' id='" . $this->label . "_CMB0' onclick=\"javascript: { if (this.value != '') { document.getElementById('" . $filter_name . "-chk').checked = true; } else { document.getElementById('" . $filter_name . "-chk').checked = false; } }\"";

			$html .= "<option value=''>Selecione</option>";
			$html .= "<option value=''>------</option>";

			while (!$rs->EOF) {
				$v = $rs->fields("ano") . "-" . substr("0" . $rs->fields("mes"), -2);
				if ($filter_value == $v) {
					$sql = " and month(" . $old_name . ") = '" . substr("0" . $rs->fields("mes"), -2) . "' and year(" . $old_name . ") > '" . substr("0" . $rs->fields("ano"), -2) . "'";
					$s = " selected";
				} else {
					$s = "";
				}

				$html .= "<option value='" . $v . "'" . $s . ">" . monthToBrName($rs->fields("mes")) . "</option>";

				$rs->moveNext();
			}

			$html .= "</select>";
		}

		$html .= "</td>" . LF;
		$html .= "</tr>" . LF;


		return array("html" => $html, "sql" => $sql);
	}
}
?>